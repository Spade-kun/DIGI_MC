<?php

namespace App\Http\Controllers;

use App\Models\AdminDocument;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin-dashboard');
    }

    public function getDocumentsData()
    {
        $documents = AdminDocument::query();
        
        return DataTables::of($documents)
            ->addColumn('actions', function ($document) {
                $view = '<a href="' . route('admin.documents.view', $document->id) . '" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye"></i></a>';
                $edit = '<a href="' . route('admin.documents.edit', $document->id) . '" class="btn btn-primary btn-sm mx-1" title="Edit"><i class="fas fa-edit"></i></a>';
                $download = '<a href="' . route('admin.documents.download', $document->id) . '" class="btn btn-success btn-sm" title="Download"><i class="fas fa-download"></i></a>';
                $delete = '<button type="button" data-id="' . $document->id . '" class="btn btn-danger btn-sm mx-1 delete-document" title="Delete"><i class="fas fa-trash"></i></button>';
                
                return '<div class="d-flex">' . $view . $edit . $download . $delete . '</div>';
            })
            ->addColumn('date', function ($document) {
                return $document->date_issued;
            })
            ->addColumn('category', function ($document) {
                return ucfirst($document->category ?? 'General');
            })
            ->editColumn('title', function ($document) {
                return '<div class="d-flex flex-column">
                    <h6 class="mb-0 text-sm">' . $document->title . '</h6>
                    <p class="text-xs text-secondary mb-0">Case No: ' . $document->case_no . '</p>
                </div>';
            })
            ->editColumn('created_at', function ($document) {
                return $document->created_at->format('Y-m-d H:i:s');
            })
            ->rawColumns(['actions', 'title'])
            ->make(true);
    }
}
