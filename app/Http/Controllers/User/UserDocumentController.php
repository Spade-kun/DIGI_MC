<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use App\Models\UserDocumentPrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
{
    /**
     * Display document categories as folders
     */
    public function index()
    {
        $user = Auth::user();
        $categories = AdminDocument::getCategories();
        
        // Get document count per category that user has access to
        $categoryCounts = [];
        foreach ($categories as $category) {
            $count = AdminDocument::where('category', $category)
                ->whereHas('privileges', function($query) use ($user) {
                    $query->where('user_id', $user->id)
                          ->where('can_access', true);
                })
                ->count();
            $categoryCounts[$category] = $count;
        }

        return view('user.my-documents.index', compact('categories', 'categoryCounts'));
    }

    /**
     * Show documents in a specific category
     */
    public function show($category)
    {
        $user = Auth::user();
        
        // Validate category
        if (!in_array($category, AdminDocument::getCategories())) {
            abort(404);
        }

        // Get documents in this category that user has access to
        $documents = AdminDocument::where('category', $category)
            ->whereHas('privileges', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->where('can_access', true);
            })
            ->with(['privileges' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderBy('date_issued', 'desc')
            ->get();

        // Get user privileges for these documents
        $documents = $documents->map(function($document) {
            $privilege = $document->privileges->first();
            $document->user_can_add = $privilege ? $privilege->can_add : false;
            $document->user_can_view = $privilege ? $privilege->can_view : false;
            $document->user_can_edit = $privilege ? $privilege->can_edit : false;
            return $document;
        });

        return view('user.my-documents.show', compact('category', 'documents'));
    }

    /**
     * Download document (if user has permission)
     */
    public function download($category, $id)
    {
        $user = Auth::user();
        $document = AdminDocument::findOrFail($id);

        // Check if user has access to this document
        $privilege = UserDocumentPrivilege::where('user_id', $user->id)
            ->where('admin_document_id', $document->id)
            ->where('can_access', true)
            ->first();

        if (!$privilege) {
            abort(403, 'You do not have permission to download this document.');
        }

        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }
}
