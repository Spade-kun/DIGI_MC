# Documents Feature - Setup Checklist

## ✅ Completed Implementation

### Database
- [x] Migration created (`2025_10_29_104741_create_admin_documents_table.php`)
- [x] Migration run successfully
- [x] Table `admin_documents` created with all fields

### Backend
- [x] AdminDocument model created with fillable fields
- [x] AdminDocumentController created with all methods
- [x] Routes registered in web.php
- [x] Google API client installed (`composer require google/apiclient`)
- [x] Configuration added to config/services.php

### Frontend
- [x] Documents index view created
- [x] Add document modal implemented
- [x] View document modal implemented
- [x] Sidebar link added
- [x] Active state highlighting works
- [x] Success/error alerts implemented

### Google Drive
- [x] Google credentials directory created (`storage/app/google/`)
- [x] Environment variable added (`GOOGLE_CREDENTIALS_PATH`)
- [x] Gitignore updated to exclude credentials
- [x] Upload/download/delete logic implemented
- [x] Error handling for missing credentials

### Documentation
- [x] Setup guide created (`GOOGLE_DRIVE_SETUP.md`)
- [x] Feature summary created (`DOCUMENTS_FEATURE_SUMMARY.md`)
- [x] Quick reference created (`DOCUMENTS_QUICK_REFERENCE.md`)
- [x] This checklist created

## 🔧 Setup Required (User Action)

### Google Drive Integration (Optional but Recommended)

#### Step 1: Create Google Cloud Project
- [ ] Go to [Google Cloud Console](https://console.cloud.google.com/)
- [ ] Create new project or select existing one
- [ ] Note down Project ID

#### Step 2: Enable APIs
- [ ] Navigate to APIs & Services > Library
- [ ] Search for "Google Drive API"
- [ ] Click Enable

#### Step 3: Create Service Account
- [ ] Go to APIs & Services > Credentials
- [ ] Click Create Credentials > Service Account
- [ ] Name: "Document Upload Service"
- [ ] Click Create and Continue
- [ ] Skip optional steps
- [ ] Click Done

#### Step 4: Generate Credentials
- [ ] Click on service account email
- [ ] Go to Keys tab
- [ ] Click Add Key > Create new key
- [ ] Select JSON format
- [ ] Click Create
- [ ] File downloads automatically

#### Step 5: Install Credentials
- [ ] Rename downloaded file to `credentials.json`
- [ ] Move to `storage/app/google/credentials.json`
- [ ] Verify file exists and has proper permissions

#### Step 6: Share Drive Folder
- [ ] Open the credentials.json file
- [ ] Find and copy the `client_email` value
- [ ] Go to: https://drive.google.com/drive/folders/1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH
- [ ] Click Share button
- [ ] Add the service account email
- [ ] Set permission to "Editor"
- [ ] Uncheck "Notify people"
- [ ] Click Share

#### Step 7: Test
- [ ] Login to admin dashboard
- [ ] Navigate to Documents page
- [ ] Click Add Document
- [ ] Fill in form and upload PDF
- [ ] Submit
- [ ] Check if cloud icon (☁️) appears next to document
- [ ] Open Google Drive folder and verify file is there

## 🧪 Testing Checklist

### Page Access
- [ ] Navigate to `/admin/documents` as admin user
- [ ] Page loads without errors
- [ ] Sidebar shows Documents link
- [ ] Documents link is highlighted when on page

### Add Document
- [ ] Click "Add Document" button
- [ ] Modal opens correctly
- [ ] All form fields are present
- [ ] File input accepts only PDF files
- [ ] Form validation works (try submitting empty form)
- [ ] Fill in all fields and upload valid PDF
- [ ] Submit form
- [ ] Success message appears
- [ ] Document appears in table

### View Document
- [ ] Click "View" button on any document
- [ ] Modal opens with embedded PDF
- [ ] PDF displays correctly
- [ ] Modal closes when clicking X or outside

### Download Document
- [ ] Click download button
- [ ] File downloads correctly
- [ ] Downloaded file opens in PDF reader

### Delete Document
- [ ] Click delete button
- [ ] Confirmation dialog appears
- [ ] Cancel works (doesn't delete)
- [ ] Confirm works (deletes document)
- [ ] Success message appears
- [ ] Document removed from table

### Google Drive (If Set Up)
- [ ] Upload document
- [ ] Cloud icon appears next to document
- [ ] Check Google Drive folder - file is there
- [ ] Delete document
- [ ] Check Google Drive folder - file is removed

### Error Handling
- [ ] Try uploading non-PDF file (should show error)
- [ ] Try uploading file > 10MB (should show error)
- [ ] Try accessing without credentials (should work, no cloud icon)
- [ ] Submit form with missing fields (should show validation errors)

## 🚀 Ready to Use

Once Google Drive is set up (or if you're using local storage only):

1. **Access**: Admin Dashboard → Documents
2. **Add Document**: Click "+ Add Document" button
3. **Fill Form**:
   - Title: e.g., "Municipal Resolution 2024-001"
   - Case No.: e.g., "2024-001"
   - Date Issued: Select from calendar
   - File: Upload PDF file
4. **Submit**: Click "Save Document"
5. **View**: Click "View" to see embedded PDF
6. **Download**: Click download icon to get file
7. **Delete**: Click trash icon to remove

## 📝 Important Notes

### File Storage
- **Local**: `storage/app/public/admin_documents/`
- **Drive**: Folder ID `1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH`

### Permissions
- Only admin users can access
- Requires `auth:admin` middleware
- Google Drive uses service account

### Limitations
- PDF files only
- Maximum 10MB file size
- No bulk upload (add one at a time)

### Without Google Drive
The feature works perfectly without Google Drive setup:
- Documents saved locally
- All features work (add, view, download, delete)
- No cloud icon appears
- Errors logged but not shown to user

## 🔍 Troubleshooting

### "Google credentials not found"
- Check if `storage/app/google/credentials.json` exists
- Verify file has correct JSON format
- Check file permissions

### "Permission denied" on Drive upload
- Verify service account email is shared with folder
- Check if account has "Editor" permission
- Try re-sharing the folder

### PDF doesn't display in View modal
- Check if file exists in `storage/app/public/admin_documents/`
- Verify storage link exists: `php artisan storage:link`
- Check browser console for errors

### Upload fails
- Check file size (max 10MB)
- Verify file is PDF format
- Check storage directory permissions
- Review Laravel logs: `storage/logs/laravel.log`

### Route not found
- Clear route cache: `php artisan route:clear`
- Re-cache routes: `php artisan route:cache`
- Verify routes: `php artisan route:list --name=admin.documents`

## 📞 Support Resources

- Setup Guide: `GOOGLE_DRIVE_SETUP.md`
- Feature Summary: `DOCUMENTS_FEATURE_SUMMARY.md`
- Quick Reference: `DOCUMENTS_QUICK_REFERENCE.md`
- Laravel Logs: `storage/logs/laravel.log`

---

**Status**: Ready for use
**Local Storage**: ✅ Working
**Google Drive**: ⏳ Requires setup (optional)
**Testing**: Recommended before production use
