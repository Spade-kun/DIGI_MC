<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminDocument;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Google\Client;
use Google\Service\Drive;

class AdminDocumentController extends Controller
{
    protected $googleDriveService;
    
    public function __construct(GoogleDriveService $googleDriveService)
    {
        $this->googleDriveService = $googleDriveService;
    }

    /**
     * Display a listing of documents
     */
    public function index()
    {
        $documents = AdminDocument::orderBy('created_at', 'desc')->get();
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Store a newly created document
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'case_no' => 'required|string|max:255',
            'date_issued' => 'required|date',
            'file' => 'required|file|mimes:pdf|max:10240', // 10MB max, PDF only
        ]);

        try {
            // Handle file upload to local storage
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('admin_documents', $fileName, 'public');

                // Upload to Google Drive
                $googleDriveId = null;
                try {
                    $googleDriveId = $this->uploadToGoogleDrive($file, $fileName);
                } catch (\Exception $e) {
                    // Log the error but continue - file is saved locally
                    \Log::warning('Google Drive upload failed: ' . $e->getMessage());
                }

                AdminDocument::create([
                    'title' => $request->title,
                    'case_no' => $request->case_no,
                    'date_issued' => $request->date_issued,
                    'file_path' => $filePath,
                    'file_name' => $fileName,
                    'google_drive_id' => $googleDriveId,
                ]);

                return redirect()->route('admin.documents.index')
                    ->with('success', 'Document added successfully!');
            }

            return back()->with('error', 'File upload failed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Upload file to Google Drive
     */
    private function uploadToGoogleDrive($file, $fileName)
    {
        // Get Google credentials from config
        $credentialsPath = config('services.google.credentials_path');
        
        if (!$credentialsPath || !file_exists($credentialsPath)) {
            throw new \Exception('Google credentials not found');
        }

        // Initialize Google Client
        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessType('offline');

        // Create Drive service
        $driveService = new Drive($client);

        // The target folder ID from the request
        $folderId = '1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH';

        // Create file metadata
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$folderId]
        ]);

        // Upload file
        $content = file_get_contents($file->getRealPath());
        $uploadedFile = $driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $file->getMimeType(),
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);

        return $uploadedFile->id;
    }

    /**
     * Remove the specified document
     */
    public function destroy(AdminDocument $document)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            // Optionally delete from Google Drive
            if ($document->google_drive_id) {
                try {
                    $this->deleteFromGoogleDrive($document->google_drive_id);
                } catch (\Exception $e) {
                    \Log::warning('Google Drive deletion failed: ' . $e->getMessage());
                }
            }

            $document->delete();

            return redirect()->route('admin.documents.index')
                ->with('success', 'Document deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting document: ' . $e->getMessage());
        }
    }

    /**
     * Delete file from Google Drive
     */
    private function deleteFromGoogleDrive($fileId)
    {
        $credentialsPath = config('services.google.credentials_path');
        
        if (!$credentialsPath || !file_exists($credentialsPath)) {
            return;
        }

        $client = new Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope(Drive::DRIVE_FILE);
        $client->setAccessType('offline');

        $driveService = new Drive($client);
        $driveService->files->delete($fileId);
    }

    /**
     * Download the document file
     */
    public function download(AdminDocument $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            return Storage::disk('public')->download($document->file_path, $document->file_name);
        }

        return back()->with('error', 'File not found.');
    }
}
