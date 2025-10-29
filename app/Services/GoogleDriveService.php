<?php

namespace App\Services;

class GoogleDriveService
{
    /**
     * Simple Google Drive folder management
     * Just add your folder IDs and names here - no API needed!
     * 
     * To get folder ID from Google Drive:
     * 1. Open the folder in Google Drive
     * 2. Look at the URL: https://drive.google.com/drive/folders/YOUR_FOLDER_ID_HERE
     * 3. Copy the ID after "/folders/"
     */

    /**
     * Get all configured folders
     * 
     * @return array
     */
    public function listFolders(): array
    {
        // Add your folders here!
        // Get the folder ID from the URL when you open a folder in Google Drive
        return [
            [
                'id' => '1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH',  // Your actual folder ID
                'name' => 'Documents',
                'drive_link' => 'https://drive.google.com/drive/folders/1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH',
            ],
            // Add more folders below - just copy the pattern above
            // Example:
            [
                'id' => '1_bRejAWEKDXKTIRS3PywDWLoCjweBSYX',
                'name' => 'Records',
                'drive_link' => 'https://drive.google.com/drive/folders/1_bRejAWEKDXKTIRS3PywDWLoCjweBSYX',
            ],
        ];
    }

    /**
     * Get folder information
     */
    public function getFolder(string $folderId): ?array
    {
        $folders = $this->listFolders();
        
        foreach ($folders as $folder) {
            if ($folder['id'] === $folderId) {
                return $folder;
            }
        }
        
        return null;
    }

    /**
     * Build Google Drive folder link
     */
    public function getFolderLink(string $folderId): string
    {
        return "https://drive.google.com/drive/folders/{$folderId}";
    }
}
