<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Display user documents with two tables: pending and approved/rejected
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get pending documents grouped by category
        $pendingDocuments = UserDocument::where('user_id', $user->id)
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        // Get approved and rejected documents grouped by category
        $reviewedDocuments = UserDocument::where('user_id', $user->id)
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->get()
            ->groupBy('category');

        $categories = UserDocument::getCategories();

        return view('user.my-documents.index', compact('pendingDocuments', 'reviewedDocuments', 'categories'));
    }

    /**
     * Store a newly created document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:' . implode(',', UserDocument::getCategories()),
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('user-documents', $fileName, 'public');

            UserDocument::create([
                'user_id' => Auth::id(),
                'title' => $request->title,
                'category' => $request->category,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'status' => 'pending',
            ]);

            return redirect()->route('user.my-documents.index')
                ->with('success', 'Document submitted successfully! Waiting for admin approval.');
        }

        return back()->with('error', 'File upload failed.');
    }

    /**
     * Download user document
     */
    public function download(UserDocument $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Approve user's own document
     */
    public function approve(UserDocument $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow approval of pending documents
        if ($document->status !== 'pending') {
            return back()->with('error', 'Only pending documents can be approved.');
        }

        $document->status = 'approved';
        $document->reviewed_at = now();
        $document->reviewed_by = null; // User approved their own document
        $document->rejection_reason = null;
        $document->save();

        return redirect()->route('user.my-documents.index')
            ->with('success', 'Document approved successfully!');
    }

    /**
     * Reject user's own document
     */
    public function reject(Request $request, UserDocument $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow rejection of pending documents
        if ($document->status !== 'pending') {
            return back()->with('error', 'Only pending documents can be rejected.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $document->status = 'rejected';
        $document->reviewed_at = now();
        $document->reviewed_by = null; // User rejected their own document
        $document->rejection_reason = $request->rejection_reason;
        $document->save();

        return redirect()->route('user.my-documents.index')
            ->with('success', 'Document rejected successfully!');
    }

    /**
     * Delete user document (only if pending)
     */
    public function destroy(UserDocument $document)
    {
        // Check if user owns the document
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow deletion of pending documents
        if ($document->status !== 'pending') {
            return back()->with('error', 'Only pending documents can be deleted.');
        }

        // Delete file from storage
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('user.my-documents.index')
            ->with('success', 'Document deleted successfully!');
    }
}
