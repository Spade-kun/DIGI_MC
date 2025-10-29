<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return view('user.documents.index', compact('folders'));
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
