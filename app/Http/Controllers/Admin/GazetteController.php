<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gazette;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GazetteController extends Controller
{
    /**
     * Display a listing of gazettes
     */
    public function index()
    {
        $gazettes = Gazette::orderBy('created_at', 'desc')->get();
        return view('admin.gazette.index', compact('gazettes'));
    }

    /**
     * Store a newly created gazette
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('gazettes', $fileName, 'public');

            Gazette::create([
                'title' => $request->title,
                'category' => $request->category,
                'file_path' => $filePath,
                'file_name' => $fileName,
                'visibility' => 'public', // Default value for visibility
            ]);

            return redirect()->route('admin.gazette.index')
                ->with('success', 'Gazette added successfully!');
        }

        return back()->with('error', 'File upload failed.');
    }

    /**
     * Remove the specified gazette
     */
    public function destroy(Gazette $gazette)
    {
        // Delete file from storage
        if (Storage::disk('public')->exists($gazette->file_path)) {
            Storage::disk('public')->delete($gazette->file_path);
        }

        $gazette->delete();

        return redirect()->route('admin.gazette.index')
            ->with('success', 'Gazette deleted successfully!');
    }

    /**
     * Download the gazette file
     */
    public function download(Gazette $gazette)
    {
        if (Storage::disk('public')->exists($gazette->file_path)) {
            return Storage::disk('public')->download($gazette->file_path, $gazette->file_name);
        }

        return back()->with('error', 'File not found.');
    }
}
