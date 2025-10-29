<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use App\Models\UserDocumentPrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display folders based on admin documents with access control
     */
    public function index()
    {
        $user = Auth::user();
        
        // Define categories (folders)
        $categories = ['Republic Act', 'Memorandum', 'Proclamations'];
        
        // Get all admin documents
        $allDocuments = AdminDocument::orderBy('category')->orderBy('created_at', 'desc')->get();
        
        // Get user's document privileges
        $userPrivileges = UserDocumentPrivilege::where('user_id', $user->id)
            ->where('can_access', true)
            ->get()
            ->keyBy('admin_document_id');
        
        // Build folders with access control
        $folders = [];
        foreach ($categories as $category) {
            $categoryDocuments = $allDocuments->where('category', $category);
            
            // Check if user has ANY permission for documents in this folder
            $hasAccess = false;
            $canAdd = false;
            $canView = false;
            $canEdit = false;
            $accessibleDocumentCount = 0;
            
            foreach ($categoryDocuments as $document) {
                $privilege = $userPrivileges->get($document->id);
                if ($privilege) {
                    $hasAccess = true;
                    $accessibleDocumentCount++;
                    if ($privilege->can_add) $canAdd = true;
                    if ($privilege->can_view) $canView = true;
                    if ($privilege->can_edit) $canEdit = true;
                }
            }
            
            $folders[] = [
                'category' => $category,
                'total_documents' => $categoryDocuments->count(),
                'accessible_documents' => $accessibleDocumentCount,
                'has_access' => $hasAccess,
                'can_add' => $canAdd,
                'can_view' => $canView,
                'can_edit' => $canEdit,
                'is_locked' => !$hasAccess,
            ];
        }
        
        return view('user.documents.index', compact('folders'));
    }
    
    /**
     * Display documents in a specific category with access control
     */
    public function showCategory($category)
    {
        $user = Auth::user();
        
        // Validate category
        $categories = ['Republic Act', 'Memorandum', 'Proclamations'];
        if (!in_array($category, $categories)) {
            abort(404);
        }
        
        // Get all documents in this category
        $documents = AdminDocument::where('category', $category)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // If no documents exist in this category, show empty state but check if user has permissions
        if ($documents->isEmpty()) {
            // Check if user has any privileges set for this category (even if no docs yet)
            $hasAnyPrivilege = UserDocumentPrivilege::whereHas('adminDocument', function($query) use ($category) {
                $query->where('category', $category);
            })
            ->where('user_id', $user->id)
            ->where('can_access', true)
            ->exists();
            
            // If no privileges at all, redirect
            if (!$hasAnyPrivilege) {
                return redirect()->route('user.documents.index')
                    ->with('error', 'You do not have access to this folder.');
            }
            
            // User has privileges but no documents yet
            return view('user.documents.category', [
                'category' => $category,
                'documents' => collect([]),
                'canAdd' => true,
                'canView' => true,
                'canEdit' => true,
            ]);
        }
        
        // Get user's document privileges for ANY document in this category
        $userPrivileges = UserDocumentPrivilege::where('user_id', $user->id)
            ->whereIn('admin_document_id', $documents->pluck('id'))
            ->where('can_access', true)
            ->get();
        
        // Check if user has ANY access to this folder
        if ($userPrivileges->isEmpty()) {
            return redirect()->route('user.documents.index')
                ->with('error', 'You do not have access to this folder.');
        }
        
        // Determine folder-level permissions (if ANY document has permission, user gets that permission for ALL)
        $canAdd = $userPrivileges->contains(fn($p) => $p->can_add);
        $canView = $userPrivileges->contains(fn($p) => $p->can_view);
        $canEdit = $userPrivileges->contains(fn($p) => $p->can_edit);
        
        // Apply folder-level permissions to ALL documents
        $documents = $documents->map(function ($document) use ($canAdd, $canView, $canEdit) {
            $document->can_add = $canAdd;
            $document->can_view = $canView;
            $document->can_edit = $canEdit;
            return $document;
        });
        
        return view('user.documents.category', compact('category', 'documents', 'canAdd', 'canView', 'canEdit'));
    }
    
    /**
     * View document (embedded PDF viewer)
     */
    public function view($id)
    {
        $user = Auth::user();
        $document = AdminDocument::findOrFail($id);
        
        // Check if user has ANY view permission for documents in this category
        $hasViewPermission = UserDocumentPrivilege::whereHas('adminDocument', function($query) use ($document) {
            $query->where('category', $document->category);
        })
        ->where('user_id', $user->id)
        ->where('can_access', true)
        ->where('can_view', true)
        ->exists();
        
        if (!$hasViewPermission) {
            abort(403, 'You do not have permission to view this document.');
        }
        
        // Get file path
        $filePath = storage_path('app/public/' . $document->file_path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Document file not found.');
        }
        
        return response()->file($filePath);
    }
    
    /**
     * Download document
     */
    public function download($id)
    {
        $user = Auth::user();
        $document = AdminDocument::findOrFail($id);
        
        // Check if user has ANY view permission for documents in this category
        $hasViewPermission = UserDocumentPrivilege::whereHas('adminDocument', function($query) use ($document) {
            $query->where('category', $document->category);
        })
        ->where('user_id', $user->id)
        ->where('can_access', true)
        ->where('can_view', true)
        ->exists();
        
        if (!$hasViewPermission) {
            abort(403, 'You do not have permission to download this document.');
        }
        
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }
        
        return back()->with('error', 'File not found.');
    }
    
    /**
     * Store a newly created document (if user has Add permission)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'title' => 'required|string|max:255',
            'case_no' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'category' => 'required|string|in:Republic Act,Memorandum,Proclamations',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);
        
        // Check if user has Add permission for this category
        $hasAddPermission = UserDocumentPrivilege::whereHas('adminDocument', function($query) use ($request) {
            $query->where('category', $request->category);
        })
        ->where('user_id', $user->id)
        ->where('can_access', true)
        ->where('can_add', true)
        ->exists();
        
        if (!$hasAddPermission) {
            return back()->with('error', 'You do not have permission to add documents to this folder.');
        }
        
        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('admin_documents', $fileName, 'public');
            
            // Create document
            $document = AdminDocument::create([
                'title' => $request->title,
                'case_no' => $request->case_no,
                'date_issued' => $request->date_issued,
                'category' => $request->category,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'uploaded_by' => $user->email,
            ]);
            
            // Try to upload to Google Drive
            try {
                $googleDriveId = $this->uploadToGoogleDrive($document);
                if ($googleDriveId) {
                    $document->google_drive_id = $googleDriveId;
                    $document->save();
                }
            } catch (\Exception $e) {
                // Continue even if Google Drive upload fails
                \Log::error('Google Drive upload failed: ' . $e->getMessage());
            }
            
            return redirect()->route('user.documents.category', $request->category)
                ->with('success', 'Document added successfully!');
        }
        
        return back()->with('error', 'File upload failed.');
    }
    
    /**
     * Update the specified document (if user has Edit permission)
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $document = AdminDocument::findOrFail($id);
        
        // Check if user has ANY edit permission for documents in this category
        $hasEditPermission = UserDocumentPrivilege::whereHas('adminDocument', function($query) use ($document) {
            $query->where('category', $document->category);
        })
        ->where('user_id', $user->id)
        ->where('can_access', true)
        ->where('can_edit', true)
        ->exists();
        
        if (!$hasEditPermission) {
            abort(403, 'You do not have permission to edit this document.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'case_no' => 'required|string|max:255',
            'date_issued' => 'required|date',
        ]);
        
        $document->update([
            'title' => $request->title,
            'case_no' => $request->case_no,
            'date_issued' => $request->date_issued,
        ]);
        
        return redirect()->route('user.documents.category', $document->category)
            ->with('success', 'Document updated successfully!');
    }
    
    /**
     * Upload file to Google Drive
     */
    private function uploadToGoogleDrive($document)
    {
        try {
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('app/google-drive-credentials.json'));
            $client->addScope(\Google_Service_Drive::DRIVE_FILE);
            
            $service = new \Google_Service_Drive($client);
            
            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => $document->file_name,
                'parents' => ['1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH']
            ]);
            
            $filePath = storage_path('app/public/' . $document->file_path);
            $content = file_get_contents($filePath);
            
            $file = $service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => 'application/pdf',
                'uploadType' => 'multipart',
                'fields' => 'id'
            ]);
            
            return $file->id;
        } catch (\Exception $e) {
            \Log::error('Google Drive upload error: ' . $e->getMessage());
            return null;
        }
    }
}