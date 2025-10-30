# User Dashboard - Visual Layout Guide

## Dashboard Layout

```
┌─────────────────────────────────────────────────────────────────┐
│                     HEADER SECTION                              │
│  ┌──────┐                                                       │
│  │ 👤  │  John Doe                                             │
│  └──────┘  Member                                               │
│            john@example.com                                     │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                  DOCUMENT SEARCH                                │
│  Search for documents from accessible folders                   │
├─────────────────────────────────────────────────────────────────┤
│  Category (Folder) ▼  │  Title           │  Case Number       │ │
│  [Select Folder...]   │  [Search...]     │  [Search...]       │ │
│                       │                  │                     │ │
│  Date Issued          │                                         │
│  [📅 Select Date]     │  [🔍 Search]  [✖ Clear]               │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│                   SEARCH RESULTS (Hidden until search)          │
│  5 documents found                                              │
├────────────┬──────────┬────────────┬─────────────┬─────────────┤
│ Title      │ Category │ Case No    │ Date Issued │ Actions     │
├────────────┼──────────┼────────────┼─────────────┼─────────────┤
│ RA 1234    │ Republic │ RA-2024-01 │ Jan 15,2024 │ 👁 View     │
│            │ Act      │            │             │ ⬇ Download  │
├────────────┼──────────┼────────────┼─────────────┼─────────────┤
│ RA 5678    │ Republic │ RA-2024-02 │ Feb 10,2024 │ 👁 View     │
│            │ Act      │            │             │ ⬇ Download  │
└────────────┴──────────┴────────────┴─────────────┴─────────────┘

┌───────────────────┬───────────────────┬───────────────────┐
│  ✓ ACCOUNT STATUS │  📅 MEMBER SINCE  │  🕐 LAST LOGIN   │
│     Active        │    Jan 2024       │   Oct 29, 2025   │
└───────────────────┴───────────────────┴───────────────────┘
```

## Search Flow Diagram

```
START
  │
  ├─→ User Opens Dashboard
  │   │
  │   ├─→ Sees Profile Info (Name, Email, Role)
  │   ├─→ Sees Search Bar
  │   └─→ Sees Stats Cards
  │
  ├─→ User Selects Category (e.g., "Republic Act")
  │   │
  │   └─→ Dropdown shows ONLY accessible folders
  │
  ├─→ User Enters Search Term (e.g., "Republic")
  │
  ├─→ User Clicks "Search" Button
  │   │
  │   └─→ AJAX Request to Server
  │
  ├─→ SERVER CHECKS PERMISSIONS
  │   │
  │   ├─→ ✓ Has Access?
  │   │   │
  │   │   ├─→ YES: Query Documents
  │   │   │   │
  │   │   │   ├─→ Found Documents?
  │   │   │   │   │
  │   │   │   │   ├─→ YES: Return Results
  │   │   │   │   │   └─→ Display Table
  │   │   │   │   │
  │   │   │   │   └─→ NO: Show "No Results"
  │   │   │   │
  │   │   │   └─→ Filter by:
  │   │   │       - Category
  │   │   │       - Title
  │   │   │       - Case Number
  │   │   │       - Date Issued
  │   │   │
  │   │   └─→ NO: Return "Unauthorized"
  │   │       └─→ Display 🔒 Lock Icon
  │   │
  │   └─→ Return JSON Response
  │
  └─→ User Clicks Action Button
      │
      ├─→ VIEW: Opens document in new tab
      │   └─→ Server checks can_view permission
      │
      └─→ DOWNLOAD: Downloads file
          └─→ Server checks can_view permission
```

## Example Scenarios

### Scenario 1: Authorized Search
```
INPUT:
┌─────────────────────────────────────┐
│ Category: Republic Act              │
│ Title:    Republic                  │
└─────────────────────────────────────┘

OUTPUT:
┌─────────────────────────────────────────────────────┐
│ ✓ 3 documents found                                 │
├─────────────────────────────────────────────────────┤
│ • Republic Act 1234                                 │
│ • Republic Act 5678                                 │
│ • Republic of the Philippines Proclamation          │
└─────────────────────────────────────────────────────┘
```

### Scenario 2: Unauthorized Access
```
INPUT:
┌─────────────────────────────────────┐
│ Category: Confidential Memos        │
│ (User doesn't have access)          │
└─────────────────────────────────────┘

OUTPUT:
┌─────────────────────────────────────┐
│     🔒                              │
│  You do not have access             │
│  to this folder.                    │
└─────────────────────────────────────┘
```

### Scenario 3: No Results
```
INPUT:
┌─────────────────────────────────────┐
│ Category: Republic Act              │
│ Title:    Nonexistent               │
└─────────────────────────────────────┘

OUTPUT:
┌─────────────────────────────────────┐
│     📂                              │
│  No documents found matching        │
│  your search criteria.              │
└─────────────────────────────────────┘
```

## Permission Matrix

```
User: John Doe
┌──────────────────┬────────┬─────┬──────┬──────┬────────┐
│ Folder           │ Access │ Add │ Edit │ View │ Delete │
├──────────────────┼────────┼─────┼──────┼──────┼────────┤
│ Republic Act     │   ✓    │  ✓  │  ✓   │  ✓   │   ✗    │
│ Memorandum       │   ✗    │  ✗  │  ✗   │  ✗   │   ✗    │
│ Proclamations    │   ✓    │  ✗  │  ✗   │  ✓   │   ✗    │
└──────────────────┴────────┴─────┴──────┴──────┴────────┘

Search dropdown will show:
  ☑ Republic Act
  ☑ Proclamations
  ☐ Memorandum (not shown - no access)
```

## Mobile Responsive Layout

```
DESKTOP (Wide Screen)
┌─────────────────────────────────────┐
│ [Category ▼] [Title] [Case] [Date] │
│ [Search] [Clear]                    │
└─────────────────────────────────────┘

MOBILE (Narrow Screen)
┌─────────────┐
│ Category ▼  │
├─────────────┤
│ Title       │
├─────────────┤
│ Case Number │
├─────────────┤
│ Date        │
├─────────────┤
│ [Search]    │
│ [Clear]     │
└─────────────┘
```

## Color Coding

```
✓ Active Status   → 🟢 Green
📅 Member Since   → 🔵 Blue  
🕐 Last Login     → 🟡 Yellow/Orange

🔍 Search Button  → 🔵 Primary Blue
✖ Clear Button   → ⚪ Secondary Gray

👁 View Button    → ℹ️ Info Blue
⬇ Download Button → ✅ Success Green

🔒 Unauthorized   → 🔴 Danger Red
📂 No Results     → ⚫ Secondary Gray
```

## JavaScript Interaction Flow

```
User Types in Form
    ↓
Form Submit Event
    ↓
Prevent Default
    ↓
Show Loading Spinner
    ↓
Fetch API Call
    ↓
Parse JSON Response
    ↓
┌─────────────────┐
│  success: true  │ → Display Results in Table
└─────────────────┘   │
                      └─→ Format dates
                          Add action buttons
                          Update count

┌─────────────────┐
│ success: false  │ → Display Error Message
└─────────────────┘   │
                      └─→ Show unauthorized icon
                          Clear table
```

## Key UI Components

### Search Form
- Responsive grid (4 columns on desktop, stacked on mobile)
- Form controls with proper labels
- Clear visual hierarchy
- Accessible (proper labels and ARIA)

### Results Table
- Sortable columns (future enhancement)
- Action buttons with icons
- Hover effects on rows
- Empty states for no results

### Stats Cards
- Hover animation (translateY)
- Icon with gradient background
- Clean typography
- Responsive sizing

---

**Note**: All colors, icons, and styles match the Soft UI Dashboard theme already in use.
