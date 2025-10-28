# How to Add Google Drive Folders

## Super Simple Setup - No API Needed!

### Step 1: Get Your Folder IDs from Google Drive

1. Open [Google Drive](https://drive.google.com/drive/)
2. Navigate to the folder you want to add
3. Look at the URL in your browser:
   ```
   https://drive.google.com/drive/folders/1a2b3c4d5e6f7g8h9i0j
                                          ^^^^^^^^^^^^^^^^^^^^
                                          This is your Folder ID
   ```
4. Copy the folder ID (everything after `/folders/`)

### Step 2: Add Folders to the Code

1. Open file: `app/Services/GoogleDriveService.php`
2. Find the `listFolders()` function
3. Add your folders to the array:

```php
public function listFolders(): array
{
    return [
        [
            'id' => 'YOUR_FOLDER_ID_HERE',      // Paste the folder ID
            'name' => 'My Documents',            // Name to display
            'drive_link' => 'https://drive.google.com/drive/folders/YOUR_FOLDER_ID_HERE',
        ],
        [
            'id' => 'ANOTHER_FOLDER_ID',
            'name' => 'Reports 2024',
            'drive_link' => 'https://drive.google.com/drive/folders/ANOTHER_FOLDER_ID',
        ],
        // Add more folders here...
    ];
}
```

### Step 3: Test It!

1. Save the file
2. Log in as a user
3. Click "Documents" in the sidebar
4. You'll see all the folders you added!
5. Click any folder to open it in Google Drive

## Example

If your folder URL is:
```
https://drive.google.com/drive/folders/1aBcDeFgHiJkLmNoPqRsTuVwXyZ
```

Add it like this:
```php
[
    'id' => '1aBcDeFgHiJkLmNoPqRsTuVwXyZ',
    'name' => 'My Folder Name',
    'drive_link' => 'https://drive.google.com/drive/folders/1aBcDeFgHiJkLmNoPqRsTuVwXyZ',
]
```

## That's It! 🎉

No API setup, no credentials, no complicated configuration. Just paste your folder IDs and they'll show up in the Documents page!

## Tips

✅ Make sure your folders are shared appropriately in Google Drive  
✅ Users will be redirected to Google Drive when they click a folder  
✅ Google Drive's own permissions control who can see what  
✅ Add as many folders as you want to the array  

## Need Help?

1. Can't find folder ID? It's in the URL when you open a folder
2. Folder not showing? Check if you saved the file
3. Still issues? Refresh the page in your browser
