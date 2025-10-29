<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Storage;
use Exception;

class GoogleDriveService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        try {
            $this->client = new Client();
            $credentialsPath = storage_path('app/google/credentials.json');
            
            if (!file_exists($credentialsPath)) {
                throw new Exception("Google credentials file not found at: {$credentialsPath}");
            }

            $this->client->setAuthConfig($credentialsPath);
            $this->client->addScope(Drive::DRIVE_FILE);
            $this->client->setAccessType('offline');
            
            $this->service = new Drive($this->client);
        } catch (Exception $e) {
            \Log::error('GoogleDriveService initialization failed: ' . $e->getMessage());
            $this->service = null;
        }
    }

    /**
     * Upload a file to Google Drive
     * 
     * @param string $filePath Local file path
     * @param string $fileName Name for the file in Google Drive
     * @param string $folderId Google Drive folder ID
     * @param string $mimeType File MIME type
     * @return string|null Google Drive file ID or null on failure
     */
    public function uploadFile($filePath, $fileName, $folderId, $mimeType = 'application/pdf')
    {
        if (!$this->service) {
            \Log::warning('Google Drive service not initialized. File will only be stored locally.');
            return null;
        }

        try {
            // Check if file exists
            if (!file_exists($filePath)) {
                throw new Exception("File not found: {$filePath}");
            }

            // Create file metadata
            $fileMetadata = new DriveFile([
                'name' => $fileName,
                'parents' => [$folderId]
            ]);

            // Upload file
            $content = file_get_contents($filePath);
            $file = $this->service->files->create(
                $fileMetadata,
                [
                    'data' => $content,
                    'mimeType' => $mimeType,
                    'uploadType' => 'multipart',
                    'fields' => 'id'
                ]
            );

            \Log::info('File uploaded to Google Drive successfully', [
                'file_name' => $fileName,
                'drive_file_id' => $file->id,
                'folder_id' => $folderId
            ]);

            return $file->id;

        } catch (Exception $e) {
            \Log::error('Google Drive upload failed: ' . $e->getMessage(), [
                'file_path' => $filePath,
                'file_name' => $fileName,
                'folder_id' => $folderId
            ]);
            return null;
        }
    }

    /**
     * Delete a file from Google Drive
     * 
     * @param string $fileId Google Drive file ID
     * @return bool Success status
     */
    public function deleteFile($fileId)
    {
        if (!$this->service || !$fileId) {
            return false;
        }

        try {
            $this->service->files->delete($fileId);
            \Log::info('File deleted from Google Drive', ['file_id' => $fileId]);
            return true;
        } catch (Exception $e) {
            \Log::error('Google Drive delete failed: ' . $e->getMessage(), ['file_id' => $fileId]);
            return false;
        }
    }

    /**
     * Check if Google Drive service is available
     * 
     * @return bool
     */
    public function isAvailable()
    {
        return $this->service !== null;
    }

    /**
     * Get file download URL
     * 
     * @param string $fileId Google Drive file ID
     * @return string|null
     */
    public function getFileUrl($fileId)
    {
        if (!$fileId) {
            return null;
        }

        return "https://drive.google.com/file/d/{$fileId}/view";
    }
}
