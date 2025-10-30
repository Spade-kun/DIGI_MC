# User Dashboard Search Feature Documentation

## Overview
The user dashboard now includes a comprehensive document search functionality that allows users to search for documents from folders they have access to, with proper authorization checks.

## Features Implemented

### 1. User Profile Display
- **Name**: Displays the authenticated user's name
- **Email**: Shows the user's email address
- **Role**: Displays the user's role (Member, Admin, etc.)

### 2. Search Functionality

#### Search Filters
The search bar includes four filter options:

1. **Category (Folder)** - Dropdown
   - Shows only folders the user has access to
   - Populated from `user_folder_privileges` table
   - Only displays folders where `can_access = true` and `can_view = true`

2. **Title** - Text Input
   - Searches documents by title using partial matching
   - Case-insensitive search

3. **Case Number** - Text Input
   - Searches documents by case number
   - Supports partial matching

4. **Date Issued** - Date Picker
   - Filters documents by exact date issued
   - Uses HTML5 date input

#### Example Usage
```
Dropdown: Select "Republic Act"
Input: "Republic"
Result: Lists all Republic Act documents with "Republic" in the title
```

### 3. Authorization System

#### Folder-Based Access Control
- Users can only search and view documents from folders they have access to
- Access is determined by the `user_folder_privileges` table
- Required permissions:
  - `can_access = true`
  - `can_view = true`

#### Unauthorized Access Handling
- If a user tries to access a folder without permission:
  - Returns JSON response with error message
  - Displays "Unauthorized" message in UI
  - Shows lock icon

### 4. Search Results Display

#### Results Table Columns
1. **Title** - Document title
2. **Category** - Folder/Category name
3. **Case Number** - Document case number
4. **Date Issued** - Formatted date
5. **Actions** - View and Download buttons

#### Actions Available
- **View** - Opens document in new tab (PDF viewer)
- **Download** - Downloads the document file

#### Empty States
- **No Results**: Shows when search returns no documents
- **Unauthorized**: Shows when user lacks folder access

## Technical Implementation

### Backend (Laravel)

#### Controller: `DashboardController`
**File**: `app/Http/Controllers/User/DashboardController.php`

**Methods**:
1. `index()` - Displays the dashboard
2. `search(Request $request)` - Handles search requests

**Search Logic**:
```php
1. Get user's accessible folders from user_folder_privileges
2. Apply category filter (if specified)
3. Check if user has access to the selected category
4. If no access, return unauthorized response
5. Apply additional filters (title, case_no, date_issued)
6. Return filtered documents
```

#### Routes
**File**: `routes/web.php`

```php
Route::get('/user/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    
Route::get('/user/dashboard/search', [DashboardController::class, 'search'])
    ->name('user.dashboard.search');
```

### Frontend (Blade + JavaScript)

#### View File
**File**: `resources/views/user/user-dashboard.blade.php`

#### Features:
1. **Dynamic Folder Dropdown**
   - Populated from database query
   - Shows only accessible folders

2. **AJAX Search**
   - Prevents page reload
   - Real-time results
   - Loading indicators

3. **Responsive Design**
   - Mobile-friendly
   - Bootstrap grid system
   - Hover effects on cards

## Database Schema

### Tables Used

#### 1. `admin_documents`
Stores all documents uploaded by admins
```sql
- id (primary key)
- title
- category (folder name)
- case_no
- date_issued
- file_path
- file_name
- google_drive_id
- uploaded_by
- timestamps
```

#### 2. `user_folder_privileges`
Manages user access to folders
```sql
- id (primary key)
- user_id (foreign key -> users)
- folder_id
- folder_name
- can_access (boolean)
- can_add (boolean)
- can_edit (boolean)
- can_view (boolean)
- can_delete (boolean)
- timestamps
```

## Security Features

### 1. Authentication
- All routes require authentication (`auth` middleware)
- User must be logged in to access dashboard

### 2. Authorization
- Folder-level access control
- Permission checks before displaying results
- Prevents unauthorized file access

### 3. Input Validation
- Search parameters are validated
- SQL injection protection (Eloquent ORM)
- XSS protection (Blade escaping)

## Usage Flow

### User Journey
1. **Login** → User logs into the system
2. **Dashboard** → Navigates to dashboard
3. **Search** → Selects folder and enters search criteria
4. **Submit** → Clicks "Search" button
5. **Results** → Views filtered documents
6. **Action** → Views or downloads documents

### Example Scenarios

#### Scenario 1: Search by Category
```
User: John Doe
Accessible Folders: Republic Act, Proclamations
Action: Select "Republic Act" from dropdown
Result: Shows all Republic Act documents
```

#### Scenario 2: Search with Multiple Filters
```
Category: Republic Act
Title: "Education"
Date: 2024-01-15
Result: Republic Act documents containing "Education" issued on Jan 15, 2024
```

#### Scenario 3: Unauthorized Access
```
User tries to access: Memorandum folder
User's access: None
Result: "Unauthorized: You do not have access to this folder."
```

## API Response Format

### Successful Search
```json
{
    "success": true,
    "documents": [
        {
            "id": 1,
            "title": "Republic Act 1234",
            "category": "Republic Act",
            "case_no": "RA-2024-001",
            "date_issued": "2024-01-15",
            "file_path": "admin_documents/...",
            "file_name": "RA1234.pdf"
        }
    ],
    "count": 1
}
```

### Unauthorized Access
```json
{
    "success": false,
    "message": "Unauthorized: You do not have access to this folder.",
    "documents": []
}
```

## Customization

### Adding New Folders
To add new folders/categories, update the admin document categories and grant user privileges through the admin panel.

### Modifying Search Filters
Edit the search form in `user-dashboard.blade.php` to add or remove filters.

### Styling Changes
Modify the `<style>` section or update the CSS classes to match your design requirements.

## Troubleshooting

### Common Issues

1. **No Folders Showing in Dropdown**
   - Check if user has folder privileges assigned
   - Verify `can_access` and `can_view` are set to true

2. **Search Returns No Results**
   - Verify documents exist in the database
   - Check if documents are in accessible folders
   - Ensure search criteria match document data

3. **Unauthorized Errors**
   - User lacks folder access
   - Admin must grant permissions via privilege management

## Future Enhancements

### Potential Features
1. Advanced search with multiple categories
2. Export search results to PDF/Excel
3. Save favorite searches
4. Recent searches history
5. Pagination for large result sets
6. Sort by different columns
7. Bookmark favorite documents

## Maintenance

### Regular Tasks
1. Monitor folder privilege assignments
2. Review access logs for unauthorized attempts
3. Update document categories as needed
4. Backup database regularly

## Support

For issues or questions:
1. Check the Laravel logs: `storage/logs/laravel.log`
2. Review browser console for JavaScript errors
3. Verify database connections and permissions

---

**Last Updated**: October 29, 2025
**Version**: 1.0.0
