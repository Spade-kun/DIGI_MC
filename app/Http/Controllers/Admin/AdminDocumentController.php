<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminDocumentController extends Controller
{
    public function index()
    {
        $categories = ['Republic Act', 'Memorandum', 'Proclamations'];
        $folders = [];
        foreach ($categories as $category) {
            $count = AdminDocument::where('category', $category)->count();
            $folders[] = ['category' => $category, 'count' => $count];
        }
        return view('admin.documents.index', compact('folders'));
    }
    
    public function showCategory($category)
    {
        $categories = ['Republic Act', 'Memorandum', 'Proclamations'];
        if (!in_array($category, $categories)) { abort(404); }
        $documents = AdminDocument::where('category', $category)->orderBy('created_at', 'desc')->get();
        return view('admin.documents.category', compact('category', 'documents'));
    }
    
    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:255', 'case_no' => 'required|string|max:255', 'date_issued' => 'required|date', 'category' => 'required|string|in:Republic Act,Memorandum,Proclamations', 'file' => 'required|file|mimes:pdf|max:10240']);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('admin_documents', $fileName, 'public');
            $document = AdminDocument::create(['title' => $request->title, 'case_no' => $request->case_no, 'date_issued' => $request->date_issued, 'category' => $request->category, 'file_path' => $filePath, 'file_name' => $fileName, 'uploaded_by' => Auth::guard('admin')->user()->email]);
            try {
                $googleDriveId = $this->uploadToGoogleDrive($document);
                if ($googleDriveId) { $document->google_drive_id = $googleDriveId; $document->save(); }
            } catch (\Exception $e) { \Log::error('Google Drive upload failed: ' . $e->getMessage()); }
            return redirect()->route('admin.documents.category', $request->category)->with('success', 'Document uploaded successfully!');
        }
        return back()->with('error', 'File upload failed.');
    }
    
    public function update(Request $request, AdminDocument $document)
    {
        $request->validate(['title' => 'required|string|max:255', 'case_no' => 'required|string|max:255', 'date_issued' => 'required|date']);
        $document->update(['title' => $request->title, 'case_no' => $request->case_no, 'date_issued' => $request->date_issued]);
        return redirect()->route('admin.documents.category', $document->category)->with('success', 'Document updated successfully!');
    }
    
    public function destroy(AdminDocument $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) { Storage::disk('public')->delete($document->file_path); }
        if ($document->google_drive_id) { try { $this->deleteFromGoogleDrive($document->google_drive_id); } catch (\Exception $e) { \Log::error('Google Drive deletion failed: ' . $e->getMessage()); } }
        $category = $document->category;
        $document->delete();
        return redirect()->route('admin.documents.category', $category)->with('success', 'Document deleted successfully!');
    }
    
    public function download(AdminDocument $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) { return Storage::disk('public')->download($document->file_path, $document->file_name); }
        return back()->with('error', 'File not found.');
    }
    
    private function uploadToGoogleDrive($document)
    {
        try {
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('app/google-drive-credentials.json'));
            $client->addScope(\Google_Service_Drive::DRIVE_FILE);
            $service = new \Google_Service_Drive($client);
            $fileMetadata = new \Google_Service_Drive_DriveFile(['name' => $document->file_name, 'parents' => ['1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH']]);
            $filePath = storage_path('app/public/' . $document->file_path);
            $content = file_get_contents($filePath);
            $file = $service->files->create($fileMetadata, ['data' => $content, 'mimeType' => 'application/pdf', 'uploadType' => 'multipart', 'fields' => 'id']);
            return $file->id;
        } catch (\Exception $e) { \Log::error('Google Drive upload error: ' . $e->getMessage()); return null; }
    }
    
    private function deleteFromGoogleDrive($fileId)
    {
        try {
            $client = new \Google_Client();
            $client->setAuthConfig(storage_path('app/google-drive-credentials.json'));
            $client->addScope(\Google_Service_Drive::DRIVE_FILE);
            $service = new \Google_Service_Drive($client);
            $service->files->delete($fileId);
            return true;
        } catch (\Exception $e) { \Log::error('Google Drive deletion error: ' . $e->getMessage()); return false; }
    }
}
