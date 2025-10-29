# Documents Feature - Quick Reference

## Admin Sidebar
```
┌─────────────────────────────────┐
│ Dashboard                       │
│                                 │
│ USER MANAGEMENT                 │
│ ├─ Pending Users               │
│ ├─ Approved Users              │
│ ├─ Rejected Users              │
│ ├─ Role & Privilege            │
│ ├─ Gazette                     │
│ ├─ Documents          ⭐ NEW!  │
│ └─ User Documents              │
└─────────────────────────────────┘
```

## Documents Page Layout
```
┌─────────────────────────────────────────────────────────────┐
│ Documents Management                    [+ Add Document]     │
├─────────────────────────────────────────────────────────────┤
│ Official Documents                                          │
│ Manage official documents and upload to Google Drive        │
├───────┬────────┬────────────┬──────────┬──────────────────┤
│ Title │Case No.│Date Issued │Document  │Actions           │
├───────┼────────┼────────────┼──────────┼──────────────────┤
│ Doc A │ 2024-1 │ Jan 15,2024│ [View]   │ [⬇] [☁] [🗑]    │
│ Doc B │ 2024-2 │ Feb 20,2024│ [View]   │ [⬇] [☁] [🗑]    │
└───────┴────────┴────────────┴──────────┴──────────────────┘
```

## Add Document Modal
```
┌──────────────────────────────────────────────┐
│ ➕ Add New Document                    [✕]  │
├──────────────────────────────────────────────┤
│                                              │
│  Title *                                     │
│  ┌────────────────────────────────────────┐ │
│  │ Enter document title                   │ │
│  └────────────────────────────────────────┘ │
│                                              │
│  Case No. *          Date Issued *          │
│  ┌─────────────────┐ ┌──────────────────┐  │
│  │ Enter case no   │ │ [📅] MM/DD/YYYY  │  │
│  └─────────────────┘ └──────────────────┘  │
│                                              │
│  File *                                      │
│  ┌────────────────────────────────────────┐ │
│  │ [Choose File] No file chosen           │ │
│  └────────────────────────────────────────┘ │
│  ℹ️ Accepted format: PDF only (Max 10MB)    │
│     File will be uploaded to Google Drive   │
│                                              │
│  ℹ️ Note: This document will be              │
│     automatically uploaded to the           │
│     designated Google Drive folder.         │
│                                              │
├──────────────────────────────────────────────┤
│                   [Cancel] [💾 Save Document]│
└──────────────────────────────────────────────┘
```

## View Document Modal
```
┌─────────────────────────────────────────────────┐
│ 📄 Document Title                         [✕]  │
├─────────────────────────────────────────────────┤
│                                                 │
│  ┌───────────────────────────────────────────┐ │
│  │                                           │ │
│  │                                           │ │
│  │         PDF Document Embedded Here        │ │
│  │                                           │ │
│  │         (Full screen preview)             │ │
│  │                                           │ │
│  │                                           │ │
│  │                                           │ │
│  └───────────────────────────────────────────┘ │
│                                                 │
└─────────────────────────────────────────────────┘
```

## Workflow

### Adding a Document
```
Admin Login
    ↓
Navigate to Documents
    ↓
Click "Add Document"
    ↓
Fill Form:
  - Title: "Resolution 2024-001"
  - Case No.: "2024-001"
  - Date Issued: Select from calendar
  - File: Upload PDF
    ↓
Click "Save Document"
    ↓
System Process:
  1. Validate inputs
  2. Save file locally (storage/app/public/admin_documents/)
  3. Upload to Google Drive (folder: 1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH)
  4. Save record to database
    ↓
Success Message: "Document added successfully!"
    ↓
Document appears in table with cloud icon ☁
```

### Viewing a Document
```
Click [View] button on document row
    ↓
Modal opens with embedded PDF viewer
    ↓
View document in full screen
    ↓
Click [✕] or click outside to close
```

### Downloading a Document
```
Click [⬇] download button on document row
    ↓
Browser downloads PDF file
```

### Deleting a Document
```
Click [🗑] delete button on document row
    ↓
Confirmation: "Are you sure you want to delete?"
    ↓
Click OK
    ↓
System Process:
  1. Delete from local storage
  2. Delete from Google Drive (if uploaded)
  3. Remove from database
    ↓
Success Message: "Document deleted successfully!"
    ↓
Document removed from table
```

## Icons & Badges

- 📁 Folder Icon = Documents menu item
- ➕ Plus = Add new document
- 📄 File Icon = View document
- ⬇️ Download = Download document
- 🗑️ Trash = Delete document
- ☁️ Cloud = Uploaded to Google Drive
- ✕ Close = Close modal

## Field Requirements

| Field       | Required | Type | Max Length | Format          |
|-------------|----------|------|------------|-----------------|
| Title       | Yes      | Text | 255 chars  | Any text        |
| Case No.    | Yes      | Text | 255 chars  | Any text        |
| Date Issued | Yes      | Date | -          | MM/DD/YYYY      |
| File        | Yes      | File | 10 MB      | PDF only        |

## Google Drive Integration

### Status Indicators
- ☁️ Cloud icon = Successfully uploaded to Google Drive
- No icon = Not uploaded or upload failed

### Upload Process
1. File uploaded locally first (always succeeds)
2. Attempt upload to Google Drive
3. If successful: cloud icon displayed
4. If failed: logged, but user still sees success

### Requirements
- Google Cloud Project
- Service Account with Drive API access
- credentials.json file
- Shared folder access

## Storage Locations

### Local Storage
```
storage/app/public/admin_documents/
  └── [timestamp]_[filename].pdf
```

### Google Drive
```
Google Drive
  └── Documents Folder (1vLh0c7yQ4dF7jeXOFPWfshCPoH_NsyAH)
        └── [timestamp]_[filename].pdf
```

### Database
```
Table: admin_documents
Fields:
  - id
  - title
  - case_no
  - date_issued
  - file_path (local path)
  - file_name
  - google_drive_id (Drive file ID)
  - created_at
  - updated_at
```

## Access Control

- Route Group: `/admin/documents`
- Middleware: `auth:admin`
- Only admin users can access
- Redirects to admin login if not authenticated

## Error Handling

### Upload Errors
- File too large → "The file may not be greater than 10240 kilobytes."
- Wrong format → "The file must be a file of type: pdf."
- Google Drive fails → Logged, document still saved locally

### Display Errors
- File not found → "File not found" error message
- Permission denied → "Access denied" error

### User Feedback
- Success alerts (green) - Auto-dismiss after 5 seconds
- Error alerts (red) - Auto-dismiss after 5 seconds
- Confirmation dialogs for destructive actions

## Tips

1. **PDF Files Only**: Only PDF format is accepted
2. **File Size**: Keep files under 10MB
3. **Case Numbers**: Use consistent format (e.g., YYYY-NNN)
4. **Titles**: Be descriptive for easy searching
5. **Google Drive**: Set up credentials for automatic backup
6. **Preview**: Use View button before downloading
7. **Backup**: Documents stored in both local and cloud

---

**Quick Access**: Admin Dashboard → Documents (in sidebar)
**Route**: `/admin/documents`
**Permission**: Admin only
