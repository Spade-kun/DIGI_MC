<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use App\Models\UserDocumentPrivilege;
use App\Models\UserFolderPrivilege;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        return view('user.user-dashboard', compact('user'));
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        
        // Get user's accessible document IDs from user_document_privileges
        $accessibleDocumentIds = UserDocumentPrivilege::where('user_id', $user->id)
            ->where('can_access', 1)
            ->where('can_view', 1)
            ->pluck('admin_document_id')
            ->toArray();

        // If user has no accessible documents, return empty result
        if (empty($accessibleDocumentIds)) {
            return response()->json([
                'success' => true,
                'message' => 'You do not have access to any documents yet. Please contact the administrator.',
                'documents' => [],
                'count' => 0
            ]);
        }

        // Start building the query - only accessible documents
        $query = AdminDocument::whereIn('id', $accessibleDocumentIds);

        // Filter by category (folder) if specified
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by title (accepts any text input - case insensitive partial match)
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by case number (accepts any text input - case insensitive partial match)
        if ($request->filled('case_no')) {
            $query->where('case_no', 'like', '%' . $request->case_no . '%');
        }

        // Filter by date issued (exact date match)
        if ($request->filled('date_issued')) {
            $query->whereDate('date_issued', $request->date_issued);
        }

        // Get results ordered by date
        $documents = $query->orderBy('date_issued', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // Return JSON response for AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'documents' => $documents,
                'count' => $documents->count()
            ]);
        }

        // Return view for regular requests
        return view('user.user-dashboard', compact('user', 'documents'));
    }
}