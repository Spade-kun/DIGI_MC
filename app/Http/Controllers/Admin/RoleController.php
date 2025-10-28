<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserFolderPrivilege;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected GoogleDriveService $driveService;

    public function __construct(GoogleDriveService $driveService)
    {
        $this->driveService = $driveService;
    }

    /**
     * Display list of approved users with roles and privileges
     */
    public function index()
    {
        $users = User::where('status', 'approved')
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', compact('users'));
    }

    /**
     * Show edit form for user role and privileges
     */
    public function edit(User $user)
    {
        // Get all available folders
        $folders = $this->driveService->listFolders();

        // Get user's current folder privileges
        $userPrivileges = $user->folderPrivileges()
            ->get()
            ->keyBy('folder_id');

        // Map folders with access status and CRUD permissions
        $foldersWithAccess = collect($folders)->map(function ($folder) use ($userPrivileges) {
            $privilege = $userPrivileges->get($folder['id']);
            
            return [
                'id' => $folder['id'],
                'name' => $folder['name'],
                'has_access' => $privilege ? $privilege->can_access : false,
                'can_add' => $privilege ? $privilege->can_add : false,
                'can_edit' => $privilege ? $privilege->can_edit : false,
                'can_view' => $privilege ? $privilege->can_view : false,
                'can_delete' => $privilege ? $privilege->can_delete : false,
            ];
        });

        $roles = [
            'Legal Assistant I',
            'City Legal Officer',
        ];

        return view('admin.roles.edit', compact('user', 'foldersWithAccess', 'roles'));
    }

    /**
     * Update user role and privileges
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string',
            'folders' => 'nullable|array',
            'folders.*' => 'string',
        ]);

        // Update role
        $user->role = $request->role;
        $user->save();

        // Get all available folders
        $allFolders = $this->driveService->listFolders();
        $selectedFolders = $request->folders ?? [];

        // Update folder privileges
        foreach ($allFolders as $folder) {
            $folderId = $folder['id'];
            $hasAccess = in_array($folderId, $selectedFolders);

            // Get CRUD permissions for this folder
            $canAdd = $hasAccess && $request->has("add_{$folderId}");
            $canEdit = $hasAccess && $request->has("edit_{$folderId}");
            $canView = $hasAccess && $request->has("view_{$folderId}");
            $canDelete = $hasAccess && $request->has("delete_{$folderId}");

            // Check if privilege exists
            $privilege = UserFolderPrivilege::where('user_id', $user->id)
                ->where('folder_id', $folderId)
                ->first();

            if ($privilege) {
                // Update existing privilege
                $privilege->can_access = $hasAccess;
                $privilege->can_add = $canAdd;
                $privilege->can_edit = $canEdit;
                $privilege->can_view = $canView;
                $privilege->can_delete = $canDelete;
                $privilege->save();
            } else {
                // Create new privilege
                UserFolderPrivilege::create([
                    'user_id' => $user->id,
                    'folder_id' => $folderId,
                    'folder_name' => $folder['name'],
                    'can_access' => $hasAccess,
                    'can_add' => $canAdd,
                    'can_edit' => $canEdit,
                    'can_view' => $canView,
                    'can_delete' => $canDelete,
                ]);
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'User role and privileges updated successfully!');
    }
}
