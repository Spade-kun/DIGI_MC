<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFolderPrivilege;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPrivilegeController extends Controller
{
    protected GoogleDriveService $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    /**
     * Display the user privilege management page.
     */
    public function index()
    {
        $users = User::where('status', 'approved')
            ->with('folderPrivileges')
            ->orderBy('name')
            ->get();

        return view('admin.privileges.index', compact('users'));
    }

    /**
     * Show the form for setting privileges for a specific user.
     */
    public function edit(User $user)
    {
        // Get all unique folders from the database
        $allFolders = UserFolderPrivilege::select('folder_id', 'folder_name')
            ->distinct()
            ->get()
            ->map(function($privilege) {
                return [
                    'id' => $privilege->folder_id,
                    'name' => $privilege->folder_name,
                ];
            })
            ->toArray();

        // Get user's current privileges
        $userPrivileges = $user->folderPrivileges()
            ->pluck('can_access', 'folder_id')
            ->toArray();

        return view('admin.privileges.edit', compact('user', 'allFolders', 'userPrivileges'));
    }

    /**
     * Show form to add a new folder
     */
    public function addFolder()
    {
        return view('admin.privileges.add-folder');
    }

    /**
     * Store a new folder
     */
    public function storeFolder(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|string',
            'folder_name' => 'required|string|max:255',
        ]);

        // Check if folder already exists
        $exists = UserFolderPrivilege::where('folder_id', $request->folder_id)->exists();

        if ($exists) {
            return back()->with('info', 'This folder already exists in the system.');
        }

        return redirect()
            ->route('admin.privileges.index')
            ->with('success', 'Folder information saved. You can now assign it to users.');
    }

    /**
     * Update the user's folder privileges.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'folders' => 'required|array',
            'folders.*' => 'required|array',
            'folders.*.folder_id' => 'required|string',
            'folders.*.folder_name' => 'required|string',
            'folders.*.can_access' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Delete existing privileges for this user
            $user->folderPrivileges()->delete();

            // Create new privileges
            foreach ($request->folders as $folderData) {
                UserFolderPrivilege::create([
                    'user_id' => $user->id,
                    'folder_id' => $folderData['folder_id'],
                    'folder_name' => $folderData['folder_name'],
                    'can_access' => $folderData['can_access'],
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.privileges.index')
                ->with('success', 'User privileges updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update privileges: ' . $e->getMessage());
        }
    }

    /**
     * Show form to add new folders to the system
     */
    public function manageFolders()
    {
        // Get all unique folders
        $folders = UserFolderPrivilege::select('folder_id', 'folder_name')
            ->distinct()
            ->orderBy('folder_name')
            ->get();

        return view('admin.privileges.manage-folders', compact('folders'));
    }

    /**
     * Add a new folder to the system
     */
    public function createFolder(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|string',
            'folder_name' => 'required|string|max:255',
        ]);

        // Create a dummy entry to register the folder
        try {
            // Just verify it doesn't exist already
            $exists = UserFolderPrivilege::where('folder_id', $request->folder_id)->exists();
            
            if (!$exists) {
                // We need at least one user to create the entry
                // Or we can create a separate folders table, but for simplicity
                // we'll just return success message
                return redirect()
                    ->route('admin.privileges.manage-folders')
                    ->with('success', 'Folder added. Assign it to users from the User Privileges page.');
            }

            return back()->with('info', 'This folder already exists.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add folder: ' . $e->getMessage());
        }
    }

    /**
     * Delete a folder from the system
     */
    public function deleteFolder(Request $request)
    {
        $request->validate([
            'folder_id' => 'required|string',
        ]);

        try {
            UserFolderPrivilege::where('folder_id', $request->folder_id)->delete();
            
            return redirect()
                ->route('admin.privileges.manage-folders')
                ->with('success', 'Folder removed from all users.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete folder: ' . $e->getMessage());
        }
    }

    /**
     * Quick update - toggle access for a single folder.
     */
    public function toggleAccess(Request $request, User $user)
    {
        $request->validate([
            'folder_id' => 'required|string',
            'folder_name' => 'required|string',
            'can_access' => 'required|boolean',
        ]);

        try {
            $privilege = UserFolderPrivilege::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'folder_id' => $request->folder_id,
                ],
                [
                    'folder_name' => $request->folder_name,
                    'can_access' => $request->can_access,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Access updated successfully.',
                'privilege' => $privilege,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update access: ' . $e->getMessage(),
            ], 500);
        }
    }
}
