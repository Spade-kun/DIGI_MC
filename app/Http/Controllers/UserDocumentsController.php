<?php

namespace App\Http\Controllers;

use App\Models\UserDocument;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDocumentsController extends Controller
{
    protected GoogleDriveService $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    /**
     * Display the user's documents page with folders.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all folders from Google Drive
        $driveFolders = $this->driveService->listFolders();

        // Check which folders user has access to
        $userPrivileges = $user->folderPrivileges()
            ->pluck('can_access', 'folder_id')
            ->toArray();

        $folders = collect($driveFolders)->map(function ($folder) use ($userPrivileges) {
            $folderId = $folder['id'];
            $hasAccess = $userPrivileges[$folderId] ?? false;

            return [
                'id' => $folderId,
                'name' => $folder['name'],
                'has_access' => $hasAccess,
                'drive_link' => $folder['drive_link'] ?? "https://drive.google.com/drive/folders/{$folderId}",
            ];
        })->toArray();

        // Get user's submitted documents
        $pendingDocuments = $user->userDocuments()
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $approvedDocuments = $user->userDocuments()
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category');

        $rejectedDocuments = $user->userDocuments()
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->get();

        $categories = UserDocument::getCategories();

        return view('user.documents.index', compact(
            'folders',
            'pendingDocuments',
            'approvedDocuments',
            'rejectedDocuments',
            'categories'
        ));
    }

    /**
     * Store a newly submitted document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
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

            return redirect()->route('user.documents.index')
                ->with('success', 'Document submitted successfully! It is now pending for review.');
        }

        return back()->with('error', 'File upload failed.');
    }

    /**
     * Redirect to Google Drive folder
     */
    public function show(Request $request, string $folderId)
    {
        $user = Auth::user();

        // Check if user has access to this folder
        if (!$user->hasAccessToFolder($folderId)) {
            return back()->with('error', 'You do not have permission to access this folder.');
        }

        // Redirect to Google Drive folder
        $driveLink = "https://drive.google.com/drive/folders/{$folderId}";
        return redirect()->away($driveLink);
    }

    /**
     * Download user document
     */
    public function download(UserDocument $document)
    {
        // Check if the document belongs to the authenticated user
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }

    /**
     * Attempt to access a folder (for unauthorized access alerts).
     */
    public function attemptAccess(Request $request, string $folderId)
    {
        $user = Auth::user();

        // Check if user has access
        if (!$user->hasAccessToFolder($folderId)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized: You do not have permission to access this folder.',
                'has_access' => false,
            ], 403);
        }

        // Get folder information
        $folder = $this->driveService->getFolder($folderId);
        $driveLink = "https://drive.google.com/drive/folders/{$folderId}";

        return response()->json([
            'success' => true,
            'message' => 'Access granted.',
            'has_access' => true,
            'folder' => $folder,
            'drive_link' => $driveLink,
        ]);
    }
}
