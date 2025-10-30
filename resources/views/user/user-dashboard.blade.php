@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved14.jpg'); background-position-y: 50%;">
    <span class="mask bg-gradient-success opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <img src="../assets/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    {{ $user->name }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    {{ ucfirst($user->role ?? 'Member') }}
                </p>
                <p class="mb-0 text-xs text-secondary">
                    {{ $user->email }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<!-- Search Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <h6 class="mb-0">Document Search</h6>
                <p class="text-sm mb-0">Search for documents from accessible folders. Type any keyword to find matching documents.</p>
            </div>
            <div class="card-body">
                <form id="searchForm" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-sm">Category (Folder)</label>
                        <select class="form-select form-select-sm" name="category" id="category">
                            <option value="">All Accessible Folders</option>
                            @php
                                // Get unique categories from documents user has access to
                                $accessibleDocumentIds = \App\Models\UserDocumentPrivilege::where('user_id', $user->id)
                                    ->where('can_access', 1)
                                    ->where('can_view', 1)
                                    ->pluck('admin_document_id');
                                
                                $categories = \App\Models\AdminDocument::whereIn('id', $accessibleDocumentIds)
                                    ->distinct()
                                    ->pluck('category');
                            @endphp
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Optional: Filter by folder</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-sm">Title</label>
                        <input type="text" class="form-control form-control-sm" name="title" id="title" placeholder="Type any keyword...">
                        <small class="text-muted">Example: "Republic", "Act", etc.</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-sm">Case Number</label>
                        <input type="text" class="form-control form-control-sm" name="case_no" id="case_no" placeholder="Type any keyword...">
                        <small class="text-muted">Example: "RA-2024", "001", etc.</small>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-sm">Date Issued</label>
                        <input type="date" class="form-control form-control-sm" name="date_issued" id="date_issued">
                        <small class="text-muted">Optional: Filter by date</small>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary" id="clearBtn">
                            <i class="fas fa-times me-1"></i> Clear
                        </button>
                        <small class="text-muted ms-3">
                            <i class="fas fa-info-circle"></i> 
                            Tip: You can search with any combination of fields. Leave blank to show all accessible documents.
                        </small>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Search Results Section -->
<div class="row mt-4" id="searchResults" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-0">Search Results</h6>
                    <p class="text-sm mb-0" id="resultCount">0 documents found</p>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Case Number</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date Issued</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="documentsTable">
                            <!-- Results will be loaded here via AJAX -->
                        </tbody>
                    </table>
                </div>
                <div id="noResults" class="text-center p-4" style="display: none;">
                    <i class="fas fa-folder-open fa-3x text-secondary mb-3"></i>
                    <p class="text-secondary mb-0">No documents found matching your search criteria.</p>
                </div>
                <div id="unauthorizedMessage" class="text-center p-4" style="display: none;">
                    <i class="fas fa-lock fa-3x text-danger mb-3"></i>
                    <p class="text-danger mb-0">You do not have access to this folder.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Account Status</p>
                            <h5 class="font-weight-bolder mb-0">
                                <span class="text-success">Active</span>
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                            <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Member Since</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ $user->created_at->format('M Y') }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Last Login</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ now()->format('M d, Y') }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-clock-2 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Your Activity</h6>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="far fa-calendar-alt me-2"></i>
                        <small>Last 30 days</small>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Profile Updated</h6>
                                <span class="text-xs">22 DEC 7:20 PM</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                            Completed
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-info mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                <i class="fas fa-sync"></i>
                            </button>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">System Update</h6>
                                <span class="text-xs">21 DEC 11:01 AM</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-info text-gradient text-sm font-weight-bold">
                            In Progress
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Quick Access</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 pb-0">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Profile Settings</h6>
                            <span class="text-xs">Edit your personal information</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                                <i class="fas fa-pencil-alt text-dark ms-2"></i>
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Security Settings</h6>
                            <span class="text-xs">Manage your account security</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                                <i class="fas fa-shield-alt text-dark ms-2"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.3s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchForm = document.getElementById('searchForm');
    const clearBtn = document.getElementById('clearBtn');
    const searchResults = document.getElementById('searchResults');
    const documentsTable = document.getElementById('documentsTable');
    const resultCount = document.getElementById('resultCount');
    const noResults = document.getElementById('noResults');
    const unauthorizedMessage = document.getElementById('unauthorizedMessage');

    // Handle form submission
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(searchForm);
        const params = new URLSearchParams(formData);
        
        // Show loading state
        documentsTable.innerHTML = '<tr><td colspan="5" class="text-center"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div> Searching...</td></tr>';
        searchResults.style.display = 'block';
        noResults.style.display = 'none';
        unauthorizedMessage.style.display = 'none';
        
        // Make AJAX request
        fetch('{{ route("user.dashboard.search") }}?' + params, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                // Unauthorized access
                documentsTable.innerHTML = '';
                unauthorizedMessage.style.display = 'block';
                resultCount.textContent = data.message;
                return;
            }
            
            if (data.count === 0) {
                documentsTable.innerHTML = '';
                noResults.style.display = 'block';
                resultCount.textContent = data.message || '0 documents found';
                return;
            }
            
            // Display results
            resultCount.textContent = `${data.count} document${data.count !== 1 ? 's' : ''} found`;
            documentsTable.innerHTML = data.documents.map(doc => {
                const date = new Date(doc.date_issued).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                });
                
                return `
                    <tr>
                        <td>
                            <div class="d-flex px-3 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${doc.title}</h6>
                                    <p class="text-xs text-secondary mb-0">File: ${doc.file_name}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">${doc.category || 'N/A'}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">${doc.case_no}</p>
                        </td>
                        <td>
                            <span class="text-secondary text-xs font-weight-bold">${date}</span>
                        </td>
                        <td class="align-middle">
                            <a href="{{ url('user/documents/view') }}/${doc.id}" class="btn btn-link text-info text-gradient px-3 mb-0" target="_blank">
                                <i class="fas fa-eye text-info me-2"></i>View
                            </a>
                            <a href="{{ url('user/documents/download') }}/${doc.id}" class="btn btn-link text-success text-gradient px-3 mb-0">
                                <i class="fas fa-download text-success me-2"></i>Download
                            </a>
                        </td>
                    </tr>
                `;
            }).join('');
        })
        .catch(error => {
            console.error('Error:', error);
            documentsTable.innerHTML = '<tr><td colspan="5" class="text-center text-danger">An error occurred while searching. Please try again.</td></tr>';
        });
    });

    // Clear form
    clearBtn.addEventListener('click', function() {
        searchForm.reset();
        searchResults.style.display = 'none';
        documentsTable.innerHTML = '';
        noResults.style.display = 'none';
        unauthorizedMessage.style.display = 'none';
    });
});
</script>
@endsection
