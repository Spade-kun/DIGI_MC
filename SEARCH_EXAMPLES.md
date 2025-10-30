# Document Search - Usage Examples

## How the Search Works

The search functionality allows you to **type any keyword** in the input fields to find matching documents. The search is **case-insensitive** and uses **partial matching**.

## Search Examples

### Example 1: Search by Title

**Scenario**: You want to find all documents with "Republic" in the title

**Input**:
```
Category: (All Accessible Folders)
Title: Republic
Case Number: (leave blank)
Date Issued: (leave blank)
```

**Results**: Will find documents like:
- "Republic Act 1234 - Education Reform"
- "Republic of the Philippines Proclamation"
- "Republic Act 5678 - Health Services"

---

### Example 2: Search by Category and Title

**Scenario**: You want to find "Education" documents only in "Republic Act" folder

**Input**:
```
Category: Republic Act
Title: Education
Case Number: (leave blank)
Date Issued: (leave blank)
```

**Results**: Will find:
- "Republic Act 1234 - Education Reform"
- "Republic Act 9876 - Education Budget"

---

### Example 3: Search by Case Number

**Scenario**: You want to find documents with case number containing "2024"

**Input**:
```
Category: (All Accessible Folders)
Title: (leave blank)
Case Number: 2024
Date Issued: (leave blank)
```

**Results**: Will find documents like:
- Document with case_no: "RA-2024-001"
- Document with case_no: "MEM-2024-045"
- Document with case_no: "PROC-2024-123"

---

### Example 4: Specific Date Search

**Scenario**: Find all documents issued on January 15, 2024

**Input**:
```
Category: (All Accessible Folders)
Title: (leave blank)
Case Number: (leave blank)
Date Issued: 2024-01-15
```

**Results**: Only documents issued exactly on January 15, 2024

---

### Example 5: Combined Search

**Scenario**: Very specific search - Republic Acts about "Health" from 2024

**Input**:
```
Category: Republic Act
Title: Health
Case Number: 2024
Date Issued: (leave blank)
```

**Results**: Will find:
- "Republic Act - Health Services 2024" with case "RA-2024-XXX"

---

## Understanding Partial Matching

### Title Search Examples:

| You Type | Will Find Documents With |
|----------|-------------------------|
| "Act" | "Republic **Act** 1234", "Memorandum of **Act**ion" |
| "2024" | "Budget **2024**", "**2024** Education Reform" |
| "edu" | "**Edu**cation Act", "Higher **Edu**cation Reform" |
| "RA" | "**RA** 1234", "Memo**RA**ndum" |

### Case Number Search Examples:

| You Type | Will Find Documents With |
|----------|-------------------------|
| "RA" | "**RA**-2024-001", "**RA**-2023-999" |
| "001" | "RA-2024-**001**", "MEM-**001**-2024" |
| "2024" | "RA-**2024**-001", "PROC-**2024**-123" |

---

## Search Tips

### ✅ Best Practices

1. **Start Broad, Then Narrow Down**
   - First search: Just type "Republic"
   - If too many results: Add category filter
   - Still too many?: Add case number filter

2. **Use Meaningful Keywords**
   - Instead of "a" → use "act"
   - Instead of "r" → use "republic"

3. **Mix and Match Filters**
   - Category + Title
   - Title + Date
   - Category + Case Number + Date

4. **Leave Fields Blank**
   - Blank fields are ignored
   - Only filled fields are used for filtering

### ❌ Common Mistakes

1. ~~Typing the EXACT full title~~ → Just type a keyword
2. ~~Being too specific~~ → Start broad, then narrow
3. ~~Using quotes~~ → Not needed, just type the text

---

## Example Database Records

Assume these documents exist:

| ID | Title | Category | Case Number | Date Issued |
|----|-------|----------|-------------|-------------|
| 1 | Republic Act 1234 - Education Reform | Republic Act | RA-2024-001 | 2024-01-15 |
| 2 | Republic Act 5678 - Health Services | Republic Act | RA-2024-002 | 2024-02-10 |
| 3 | Memorandum on Budget 2024 | Memorandum | MEM-2024-001 | 2024-01-20 |
| 4 | Proclamation - National Holiday | Proclamations | PROC-2023-099 | 2023-12-25 |

### Test Searches:

**Search 1**: Title = "Republic"
- **Results**: Documents 1, 2 ✅

**Search 2**: Title = "2024"
- **Results**: Documents 1, 2, 3 ✅

**Search 3**: Case Number = "RA"
- **Results**: Documents 1, 2 ✅

**Search 4**: Case Number = "2024"
- **Results**: Documents 1, 2, 3 ✅

**Search 5**: Date = "2024-01-15"
- **Results**: Document 1 ✅

**Search 6**: Category = "Republic Act" + Title = "Health"
- **Results**: Document 2 ✅

**Search 7**: Title = "xyz" (doesn't exist)
- **Results**: No documents found ❌

---

## Authorization Rules

### Important Notes:

1. **Folder Access Required**
   - You can ONLY search in folders you have access to
   - If you try to search a restricted folder → "Unauthorized" message

2. **View Permission Required**
   - Search results only show documents from folders where you have `can_view = true`
   - If no folders accessible → "You do not have access to any folders" message

3. **Category Dropdown**
   - Only shows folders you can access
   - If a folder is not in the dropdown → You don't have access to it

---

## Real-World Example

**User**: John Doe
**Accessible Folders**: Republic Act, Proclamations
**Restricted Folders**: Memorandum

### Scenario 1: John searches for "Budget"

```
Title: Budget
```

**Result**: 
- ✅ "Republic Act - Budget 2024" (from Republic Act folder)
- ✅ "Proclamation - Budget Approval" (from Proclamations folder)
- ❌ "Memorandum on Budget 2024" (NOT SHOWN - no access to Memorandum folder)

### Scenario 2: John tries to search Memorandum folder

```
Category: Memorandum
(Not available in dropdown - restricted)
```

**Result**: John cannot even select it because it doesn't appear in the dropdown!

---

## Summary

✅ **You Can Type**:
- Any keyword in Title
- Any keyword in Case Number
- Any category you have access to
- Any date

✅ **Search Will Find**:
- Documents with partial matches
- Case-insensitive matches
- Only from folders you can access

❌ **Search Will NOT Find**:
- Documents from restricted folders
- Documents you don't have view permission for
- Exact matches only (it's flexible!)

---

**Remember**: The more specific you are, the fewer results you'll get. Start with broad searches and narrow down!
