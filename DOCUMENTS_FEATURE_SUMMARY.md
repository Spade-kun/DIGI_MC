# Admin Documents Feature - Implementation Summary

## Overview
Added a new "Documents" page in the admin dashboard that allows administrators to:
- Add official documents with Title, Case No., Date Issued, and PDF file
- Automatically upload documents to Google Drive
- View documents as embedded PDFs
- Download documents
- Delete documents (from both local storage and Google Drive)

## Features Implemented

### 1. Database
- **Migration**: `2025_10_29_104741_create_admin_documents_table.php`
- **Table**: `admin_documents`
- **Fields**:
  - `id` - Auto-increment primary key
  - `title` - Document title
  - `case_no` - Case number
  - `date_issued` - Date the document was issued
  - `file_path` - Local storage path
  - `file_name` - Original filename
  - `google_drive_id` - Google Drive file ID (nullable)
  - `created_at`, `updated_at` - Timestamps

### 2. Model
- **File**: `app/Models/AdminDocument.php`
- **Fillable fields**: All document fields
- **Casts**: `date_issued` as date

### 3. Controller
- **File**: `app/Http/Controllers/Admin/AdminDocumentController.php`
- **Methods**:
  - `index()` - Display all documents
  - `store()` - Add new document (saves locally + uploads to Google Drive)
  - `destroy()` - Delete document (from local storage + Google Drive)
  - `download()` - Download document file
  - `uploadToGoogleDrive()` - Private method for Drive upload
  - `deleteFromGoogleDrive()` - Private method for Drive deletion

### 4. View
- **File**: `resources/views/admin/documents/index.blade.php`
- **Features**:
  - Responsive table displaying all documents
  - Modal form for adding new documents
  - Embedded PDF viewer modal
  - Success/error message alerts
  - Cloud icon badge for documents uploaded to Drive
  - Auto-dismiss alerts after 5 seconds

### 5. Routes
- **GET** `/admin/documents` - View all documents (route: `admin.documents.index`)
- **POST** `/admin/documents` - Add new document (route: `admin.documents.store`)
- **DELETE** `/admin/documents/{document}` - Delete document (route: `admin.documents.destroy`)
- **GET** `/admin/documents/{document}/download` - Download document (route: `admin.documents.download`)

### 6. Sidebar Navigation
- Added "Documents" link in the admin sidebar
- Icon: Folder icon (ni-folder-17) with warning color
- Active state highlighting when on documents page

## Google Drive Integration

### Setup Required
1. Create Google Cloud Project
2. Enable Google Drive API
3. Create Service Account
4. Download credentials.json
5. Place in `storage/app/google/credentials.json`
6. Share Drive folder with service account email
7. Install package: `composer require google/apiclient` ✅ (Already installed)

### Configuration
- **Folder ID**: `1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH` (hardcoded in controller)
- **Credentials Path**: Configured in `config/services.php`
- **Environment Variable**: `GOOGLE_CREDENTIALS_PATH`

### Error Handling
- If Google Drive upload fails, document is still saved locally
- Errors are logged for debugging
- User sees success message even if Drive upload fails
- Optional deletion from Drive if credentials are available

## File Specifications

### Upload Restrictions
- **Format**: PDF only
- **Max Size**: 10 MB
- **Storage**: `storage/app/public/admin_documents/`

### Validation Rules
- `title` - Required, string, max 255 characters
- `case_no` - Required, string, max 255 characters
- `date_issued` - Required, valid date
- `file` - Required, must be PDF, max 10240 KB (10 MB)

## User Interface

### Documents Table
- Title
- Case No.
- Date Issued
- View button (opens PDF in modal)
- Download button
- Delete button
- Cloud icon (if uploaded to Drive)

### Add Document Modal
- Form fields: Title, Case No., Date Issued, File
- File input accepts only PDFs
- Info alert about automatic Google Drive upload
- Validation error display

### View Document Modal
- Full-screen embedded PDF viewer
- Document title in header
- Responsive sizing (80vh height)

## Security

### Access Control
- Only authenticated admin users can access
- Protected by `auth:admin` middleware

### File Security
- Files stored in `storage/app/public/` (symlinked)
- Google credentials ignored in version control
- Service account for Drive access (no user OAuth)

### Gitignore Entries
```
/storage/app/google/credentials.json
/storage/app/dialogflow/credentials.json
```

## Dependencies

### New Packages
- ✅ `google/apiclient` v2.18.4 - Google API PHP client

### Existing Dependencies
- Laravel Storage facade
- Bootstrap modals
- Font Awesome icons

## Files Created/Modified

### Created
1. `app/Http/Controllers/Admin/AdminDocumentController.php`
2. `resources/views/admin/documents/index.blade.php`
3. `storage/app/google/README.md`
4. `GOOGLE_DRIVE_SETUP.md`
5. Database migration (already ran)

### Modified
1. `app/Models/AdminDocument.php`
2. `routes/web.php`
3. `resources/views/layouts/dashboard.blade.php`
4. `config/services.php`
5. `.env`
6. `.gitignore`
7. `database/migrations/2025_10_29_104741_create_admin_documents_table.php`

## Next Steps

### To Start Using
1. Follow the setup guide in `GOOGLE_DRIVE_SETUP.md`
2. Place `credentials.json` in `storage/app/google/`
3. Share the Google Drive folder with the service account
4. Navigate to Admin Dashboard > Documents
5. Click "Add Document" to upload

### Optional Enhancements
- Add document categories/types
- Add search and filter functionality
- Add pagination for large number of documents
- Add bulk upload feature
- Add document versioning
- Add audit trail for document changes
- Display Drive upload status in real-time
- Add document preview thumbnails

## Testing

### Manual Testing Steps
1. Login as admin
2. Navigate to Documents page
3. Click "Add Document"
4. Fill in all fields and upload PDF
5. Submit form
6. Verify document appears in table
7. Click "View" to see embedded PDF
8. Click download to get file
9. Check Google Drive folder for uploaded file
10. Delete document and verify removal

### Without Google Drive
The feature works without Google Drive setup:
- Documents save locally
- Warning logged in Laravel logs
- User still sees success message
- All other features work normally

## Support

For issues with:
- **Google Drive setup**: See `GOOGLE_DRIVE_SETUP.md`
- **Application errors**: Check `storage/logs/laravel.log`
- **Upload failures**: Verify file size and format
- **Permission issues**: Check folder permissions and middleware

---

**Status**: ✅ Implementation Complete
**Date**: October 29, 2025
**Version**: 1.0
