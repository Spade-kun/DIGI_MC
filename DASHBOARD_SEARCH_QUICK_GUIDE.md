# User Dashboard Search - Quick Reference

## What Was Added

### 1. User Profile Header
✅ Displays: Name, Email, and Role

### 2. Search Bar with Filters
✅ **Category Dropdown** - Select folder (only accessible ones)
✅ **Title Input** - Search by document title
✅ **Case Number Input** - Search by case number  
✅ **Date Issued** - Filter by date

### 3. Search Results Table
✅ Shows: Title, Category, Case Number, Date, Actions
✅ Actions: View (new tab) and Download buttons

### 4. Security
✅ Only shows documents from accessible folders
✅ Authorization check on every search
✅ "Unauthorized" message for restricted folders

## How It Works

```
User selects "Republic Act" → Types "Republic" → Clicks Search
    ↓
System checks folder access (user_folder_privileges)
    ↓
If authorized → Shows matching documents
If not authorized → Shows "Unauthorized" message
```

## Files Modified

1. **Controller**: `app/Http/Controllers/User/DashboardController.php`
   - Added `search()` method
   - Added folder permission checks

2. **View**: `resources/views/user/user-dashboard.blade.php`
   - Added search form
   - Added results table
   - Added JavaScript for AJAX search

3. **Route**: `routes/web.php`
   - Added `user.dashboard.search` route

4. **Document Controller**: `app/Http/Controllers/User/DocumentController.php`
   - Updated `view()` and `download()` to use folder privileges

## Example Usage

### Search by Category
```
Category: Republic Act
Title: (empty)
Case Number: (empty)
Date: (empty)
→ Returns all Republic Act documents user can access
```

### Search with Title
```
Category: (All Accessible Folders)
Title: "Republic"
Case Number: (empty)
Date: (empty)
→ Returns all documents with "Republic" in title from accessible folders
```

### Full Search
```
Category: Republic Act
Title: "Education"
Case Number: "RA-2024"
Date: 2024-01-15
→ Returns specific matching documents
```

## Authorization Logic

```php
// Step 1: Get accessible folders
$folders = UserFolderPrivilege::where('user_id', $user->id)
    ->where('can_access', true)
    ->where('can_view', true)
    ->pluck('folder_name');

// Step 2: Filter by category (if selected)
if ($category && !in_array($category, $folders)) {
    return "Unauthorized";
}

// Step 3: Apply other filters
// Step 4: Return results
```

## Database Tables

### `admin_documents`
- Stores all documents
- Key fields: `title`, `category`, `case_no`, `date_issued`

### `user_folder_privileges`
- Controls folder access per user
- Key fields: `user_id`, `folder_name`, `can_access`, `can_view`

## Testing Checklist

- [ ] Search with category only
- [ ] Search with title only
- [ ] Search with case number only
- [ ] Search with date only
- [ ] Search with all filters
- [ ] Try accessing unauthorized folder
- [ ] Test with no results
- [ ] View document (new tab)
- [ ] Download document

## Common Issues & Solutions

| Issue | Solution |
|-------|----------|
| No folders in dropdown | Assign folder privileges to user |
| "Unauthorized" message | Grant folder access in admin panel |
| No results found | Check if documents exist in accessible folders |
| Can't view document | Verify `can_view = true` in privileges |
| Can't download | Same as above |

## Quick Commands

```bash
# Clear route cache
php artisan route:clear

# Check routes
php artisan route:list --name=user.dashboard

# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## URL Structure

- Dashboard: `/user/dashboard`
- Search: `/user/dashboard/search?category=X&title=Y`
- View: `/user/documents/view/{id}`
- Download: `/user/documents/download/{id}`

---

**Quick Tip**: The search only returns files from folders the user has **both** `can_access=true` AND `can_view=true` permissions.
