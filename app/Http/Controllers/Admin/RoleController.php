<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDocumentPrivilege;
use App\Models\AdminDocument;
use Illuminate\Http\Request;

class RoleController extends Controller
{
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
        // Define categories (folders)
        $categories = ['Republic Act', 'Memorandum', 'Proclamations'];

        // Get all available documents grouped by category
        $documents = AdminDocument::orderBy('category')->orderBy('created_at', 'desc')->get();

        // Get user's current document privileges
        $userPrivileges = $user->documentPrivileges()
            ->get()
            ->keyBy('admin_document_id');

        // Group documents by category with access status
        $foldersByCategory = [];
        foreach ($categories as $category) {
            $categoryDocuments = $documents->where('category', $category);
            
            // Check folder-level permissions (if ANY document in folder has permission)
            $hasAnyAccess = false;
            $hasAnyAdd = false;
            $hasAnyView = false;
            $hasAnyEdit = false;

            foreach ($categoryDocuments as $document) {
                $privilege = $userPrivileges->get($document->id);
                if ($privilege && $privilege->can_access) {
                    $hasAnyAccess = true;
                    if ($privilege->can_add) $hasAnyAdd = true;
                    if ($privilege->can_view) $hasAnyView = true;
                    if ($privilege->can_edit) $hasAnyEdit = true;
                }
            }

            $foldersByCategory[] = [
                'category' => $category,
                'document_count' => $categoryDocuments->count(),
                'documents' => $categoryDocuments,
                'has_access' => $hasAnyAccess,
                'can_add' => $hasAnyAdd,
                'can_view' => $hasAnyView,
                'can_edit' => $hasAnyEdit,
            ];
        }

        $roles = [
            'City Legal Officer',
            'Acting Assistant Legal Officer',
            'Administrative Officer V',
            'Legal Assistant II',
            'Community Affairs Assistant II',
        ];

        return view('admin.roles.edit', compact('user', 'foldersByCategory', 'roles'));
    }

    /**
     * Update user role and privileges
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string',
            'folders' => 'nullable|array',
        ]);

        // Update role
        $user->role = $request->role;
        $user->save();

        // Get all available documents
        $allDocuments = AdminDocument::all();
        $selectedFolders = $request->folders ?? [];

        // Update document privileges based on folder selection
        foreach ($allDocuments as $document) {
            $documentId = $document->id;
            $category = $document->category;
            $categorySlug = \Str::slug($category);
            
            // Check if folder is selected
            $hasAccess = in_array($category, $selectedFolders);

            // Get folder-level permissions using slugified field names
            $canAdd = $hasAccess && $request->input("add_{$categorySlug}") !== null;
            $canView = $hasAccess && $request->input("view_{$categorySlug}") !== null;
            $canEdit = $hasAccess && $request->input("edit_{$categorySlug}") !== null;

            // Check if privilege exists
            $privilege = UserDocumentPrivilege::where('user_id', $user->id)
                ->where('admin_document_id', $documentId)
                ->first();

            if ($privilege) {
                // Update existing privilege
                $privilege->can_access = $hasAccess;
                $privilege->can_add = $canAdd;
                $privilege->can_view = $canView;
                $privilege->can_edit = $canEdit;
                $privilege->save();
            } else {
                // Create new privilege
                UserDocumentPrivilege::create([
                    'user_id' => $user->id,
                    'admin_document_id' => $documentId,
                    'can_access' => $hasAccess,
                    'can_add' => $canAdd,
                    'can_view' => $canView,
                    'can_edit' => $canEdit,
                ]);
            }
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'User role and folder privileges updated successfully!');
    }
}
