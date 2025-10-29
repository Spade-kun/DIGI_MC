<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserDocumentController extends Controller
{
    /**
     * Display all pending user documents
     */
    public function index()
    {
        // Get all pending documents grouped by category
        $pendingDocuments = UserDocument::with('user')
            ->pending()
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        // Get all reviewed documents grouped by category
        $reviewedDocuments = UserDocument::with('user', 'reviewer')
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('reviewed_at', 'desc')
            ->get()
            ->groupBy('category');

        $categories = UserDocument::getCategories();

        return view('admin.user-documents.index', compact('pendingDocuments', 'reviewedDocuments', 'categories'));
    }

    /**
     * Approve a user document
     */
    public function approve(UserDocument $document)
    {
        $document->status = 'approved';
        $document->reviewed_at = now();
        $document->reviewed_by = Auth::guard('admin')->id();
        $document->rejection_reason = null;
        $document->save();

        return redirect()->route('admin.user-documents.index')
            ->with('success', 'Document approved successfully!');
    }

    /**
     * Show reject form
     */
    public function rejectForm(UserDocument $document)
    {
        return view('admin.user-documents.reject', compact('document'));
    }

    /**
     * Reject a user document
     */
    public function reject(Request $request, UserDocument $document)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $document->status = 'rejected';
        $document->reviewed_at = now();
        $document->reviewed_by = Auth::guard('admin')->id();
        $document->rejection_reason = $request->rejection_reason;
        $document->save();

        return redirect()->route('admin.user-documents.index')
            ->with('success', 'Document rejected successfully!');
    }

    /**
     * Download user document
     */
    public function download(UserDocument $document)
    {
        if (\Storage::disk('public')->exists($document->file_path)) {
            return \Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Delete user document
     */
    public function destroy(UserDocument $document)
    {
        // Delete file from storage
        if (\Storage::disk('public')->exists($document->file_path)) {
            \Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.user-documents.index')
            ->with('success', 'Document deleted successfully!');
    }
}
