<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ $category }} Documents - LEGALITEASE</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f5f5;
        overflow-x: hidden;
    }

    /* Sidebar */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 250px;
        height: 100vh;
        background: white;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .sidebar-header {
        padding: 2rem 1rem 1rem;
        text-align: center;
        border-bottom: 1px solid #e5e7eb;
    }

    .sidebar-logo {
        width: 80px;
        height: 80px;
        margin: 0 auto 0.5rem;
    }

    .sidebar-menu {
        flex: 1;
        padding: 1rem 0;
        overflow-y: auto;
    }

    .menu-item {
        display: flex;
        align-items: center;
        padding: 0.85rem 1.5rem;
        color: #6b7280;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
        border-left: 3px solid transparent;
    }

    .menu-item:hover {
        background: #f9fafb;
        color: #6b21a8;
    }

    .menu-item.active {
        background: #f3e8ff;
        color: #6b21a8;
        border-left-color: #6b21a8;
        font-weight: 600;
    }

    .menu-item i {
        margin-right: 0.75rem;
        font-size: 1.1rem;
        width: 24px;
        text-align: center;
    }

    .sidebar-footer {
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
    }

    .logout-btn {
        width: 100%;
        padding: 0.75rem;
        background: white;
        border: 1px solid #e5e7eb;
        color: #6b21a8;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .logout-btn:hover {
        background: #f3e8ff;
        border-color: #6b21a8;
    }

    /* Main Content */
    .main-content {
        margin-left: 250px;
        min-height: 100vh;
        padding: 2rem;
    }

    /* Header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .breadcrumb {
        color: #9ca3af;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
    }

    .breadcrumb span {
        color: #1f2937;
    }

    .brand-title {
        font-size: 1.5rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .brand-title .legal {
        color: #6b21a8;
    }

    .brand-title .it {
        color: #f59e0b;
    }

    .brand-title .ease {
        color: #6b21a8;
    }

    /* Logout Modal */
    .modal-logout {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.5);
    }

    .modal-logout.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content-logout {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .modal-header-logout {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .modal-icon {
        width: 60px;
        height: 60px;
        background: #fef3c7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 2rem;
        color: #f59e0b;
    }

    .modal-title-logout {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .modal-text {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .modal-btn {
        flex: 1;
        padding: 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    .btn-confirm {
        background: #6b21a8;
        color: white;
    }

    .btn-confirm:hover {
        background: #7c3aed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
        }
    }

    
    /* Enhanced Card Styling */
    .documents-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .documents-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    /* Enhanced Header Section */
    .card-header-enhanced {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        padding: 2rem;
        border: none;
    }

    .card-header-enhanced h6 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-header-enhanced p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
        margin-bottom: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Enhanced Buttons */
    .btn-enhanced {
        padding: 0.65rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateX(-3px);
    }

    .btn-add-doc {
        background: white;
        color: #6b21a8;
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }

    .btn-add-doc:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    }

    /* Enhanced Alerts */
    .alert-enhanced {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInDown 0.5s ease-out;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-enhanced i {
        font-size: 1.5rem;
    }

    .alert-success-enhanced {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .alert-danger-enhanced {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Enhanced Table */
    .table-enhanced {
        margin: 0;
    }

    .table-enhanced thead {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }

    .table-enhanced thead th {
        padding: 1.25rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6b21a8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .table-enhanced tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .table-enhanced tbody tr:hover {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        transform: scale(1.01);
        box-shadow: 0 2px 8px rgba(107, 33, 168, 0.1);
    }

    .table-enhanced tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
    }

    /* Document Info with Icon */
    .document-info-enhanced {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .document-icon-enhanced {
        font-size: 2.5rem;
        color: #ef4444;
        filter: drop-shadow(0 2px 4px rgba(239, 68, 68, 0.3));
    }

    .document-details-enhanced h6 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }

    .document-details-enhanced p {
        font-size: 0.8rem;
        color: #6b7280;
        margin: 0;
    }

    /* Action Buttons Enhanced */
    .action-buttons-enhanced {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-action-enhanced {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        text-decoration: none;
    }

    .btn-view-enhanced {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
    }

    .btn-view-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.4);
    }

    .btn-download-enhanced {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-download-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-edit-enhanced {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .btn-edit-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    }

    .btn-delete-enhanced {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-delete-enhanced:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    /* Badge Enhanced */
    .badge-drive-enhanced {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Empty State Enhanced */
    .empty-state-enhanced {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-enhanced i {
        font-size: 5rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state-enhanced h3 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-state-enhanced p {
        font-size: 1rem;
        color: #9ca3af;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-header-enhanced {
            padding: 1.5rem 1rem;
        }

        .card-header-enhanced h6 {
            font-size: 1.25rem;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .action-buttons-enhanced {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-action-enhanced {
            width: 100%;
            justify-content: center;
        }
    }
</style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Logo" class="sidebar-logo">
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.documents.index') }}" class="menu-item">
                <i class="fas fa-folder"></i>
                <span>Documents</span>
            </a>
            <a href="{{ route('admin.registrations.pending') }}" class="menu-item">
                <i class="fas fa-user-friends"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('admin.tracking.index') }}" class="menu-item">
                <i class="fas fa-truck"></i>
                <span>Tracking</span>
            </a>
            <a href="{{ route('admin.roles.index') }}" class="menu-item">
                <i class="fas fa-user-shield"></i>
                <span>Role and Privileges</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="menu-item">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <button class="logout-btn" onclick="showLogoutModal()">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div>
                <p class="breadcrumb">Pages / Documents / <span>{{ $category }}</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert-enhanced alert-success-enhanced">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-enhanced alert-danger-enhanced">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

<div class="row">
    <div class="col-12">
        <div class="card documents-card">
            <div class="card-header-enhanced">
                <div class="d-flex justify-content-between align-items-center flex-wrap" style="gap: 1rem;">
                    <div>
                        <h6>
                            <i class="fas fa-folder-open"></i>
                            {{ $category }} Documents
                        </h6>
                        <p>Manage and organize documents in {{ $category }} category</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('admin.documents.index') }}" class="btn-enhanced btn-back">
                            <i class="fas fa-arrow-left"></i> Back to Folders
                        </a>
                        <button type="button" class="btn-enhanced btn-add-doc" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                            <i class="fas fa-plus"></i> Add Document
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table table-enhanced align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th>Case No.</th>
                                <th class="text-center">Date Issued</th>
                                <th class="text-center">Stored At</th>
                                <th class="text-center">Uploaded By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                                <tr>
                                    <td>
                                        <div class="document-info-enhanced">
                                            <i class="fas fa-file-pdf document-icon-enhanced"></i>
                                            <div class="document-details-enhanced">
                                                <h6>{{ $document->title }}</h6>
                                                <p>{{ $document->file_name ?? 'Document File' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="font-size: 0.875rem; font-weight: 600; color: #374151;">{{ $document->case_no }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span style="font-size: 0.8rem; color: #6b7280;">{{ $document->date_issued->format('M d, Y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span style="font-size: 0.8rem; color: #6b7280;">{{ $document->stored_at ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span style="font-size: 0.8rem; color: #6b7280;">{{ $document->uploaded_by }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons-enhanced">
                                            <button type="button" 
                                                    class="btn-action-enhanced btn-view-enhanced" 
                                                    onclick="viewDocument('{{ Storage::url($document->file_path) }}', '{{ addslashes($document->title) }}')"
                                                    title="View Document">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <a href="{{ route('admin.documents.download', $document->id) }}" 
                                               class="btn-action-enhanced btn-download-enhanced" 
                                               title="Download">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                            <button type="button" 
                                                    class="btn-action-enhanced btn-edit-enhanced" 
                                                    onclick="editDocument({{ $document->id }}, '{{ addslashes($document->title) }}', '{{ $document->case_no }}', '{{ $document->date_issued->format('Y-m-d') }}', '{{ addslashes($document->stored_at ?? '') }}')"
                                                    title="Edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            @if($document->google_drive_id)
                                            <span class="badge-drive-enhanced" title="Uploaded to Google Drive">
                                                <i class="fas fa-cloud-upload-alt"></i> Drive
                                            </span>
                                            @endif
                                            <button type="button" 
                                                    class="btn-action-enhanced btn-delete-enhanced" 
                                                    onclick="confirmDelete({{ $document->id }})"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                            <form id="delete-form-{{ $document->id }}" 
                                                  action="{{ route('admin.documents.destroy', $document->id) }}" 
                                                  method="POST" 
                                                  style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="empty-state-enhanced">
                                            <i class="fas fa-inbox"></i>
                                            <h3>No documents found</h3>
                                            <p>There are currently no documents in this category. Add your first document to get started.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="addDocumentModalLabel">
                    <i class="fas fa-plus-circle"></i> Add New Document to {{ $category }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   placeholder="Enter document title"
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="case_no" class="form-label">Case No. <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('case_no') is-invalid @enderror" 
                                   id="case_no" 
                                   name="case_no" 
                                   placeholder="Enter case number"
                                   required>
                            @error('case_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('date_issued') is-invalid @enderror" 
                                   id="date_issued" 
                                   name="date_issued" 
                                   required>
                            @error('date_issued')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="stored_at" class="form-label">Stored At</label>
                            <input type="text" 
                                   class="form-control @error('stored_at') is-invalid @enderror" 
                                   id="stored_at" 
                                   name="stored_at" 
                                   placeholder="e.g., Cabinet A, Shelf 3, Box 12">
                            @error('stored_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                            <input type="file" 
                                   class="form-control @error('file') is-invalid @enderror" 
                                   id="file" 
                                   name="file" 
                                   accept=".pdf"
                                   required>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Accepted format: PDF only (Max 10MB). 
                                File will be uploaded to Google Drive automatically.
                            </small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-folder"></i> 
                                <strong>Category:</strong> {{ $category }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Document Modal -->
<div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="viewDocumentModalLabel">
                    <i class="fas fa-file-pdf"></i> <span id="documentTitle">Document</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="documentFrame" 
                        style="width: 100%; height: 80vh; border: none;" 
                        src="">
                </iframe>
            </div>
        </div>
    </div>
</div>

<!-- Edit Document Modal -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-warning">
                <h5 class="modal-title text-white" id="editDocumentModalLabel">
                    <i class="fas fa-edit"></i> Edit Document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDocumentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_title" 
                                   name="title" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_case_no" class="form-label">Case No. <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_case_no" 
                                   name="case_no" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control" 
                                   id="edit_date_issued" 
                                   name="date_issued" 
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_stored_at" class="form-label">Stored At</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="edit_stored_at" 
                                   name="stored_at" 
                                   placeholder="e.g., Cabinet A, Shelf 3, Box 12">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Update Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
    </div>
</div>

<!-- Logout Modal -->
<div class="modal-logout" id="logoutModal">
    <div class="modal-content-logout">
        <div class="modal-header-logout">
            <div class="modal-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="modal-title-logout">Confirm Logout</h3>
            <p class="modal-text">Are you sure you want to logout? Your session will end.</p>
        </div>
        <div class="modal-actions">
            <button class="modal-btn btn-cancel" onclick="closeLogoutModal()">Cancel</button>
            <form method="POST" action="{{ route('admin.logout') }}" style="flex: 1;">
                @csrf
                <button type="submit" class="modal-btn btn-confirm" style="width: 100%;">Yes, Logout</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function showLogoutModal() {
    document.getElementById('logoutModal').classList.add('show');
}

function closeLogoutModal() {
    document.getElementById('logoutModal').classList.remove('show');
}

// Close modal on backdrop click
document.getElementById('logoutModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLogoutModal();
    }
});

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
}

function viewDocument(url, title) {
    document.getElementById('documentTitle').textContent = title;
    document.getElementById('documentFrame').src = url;
    
    var viewModal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
    viewModal.show();
}

function editDocument(id, title, caseNo, dateIssued, storedAt) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_case_no').value = caseNo;
    document.getElementById('edit_date_issued').value = dateIssued;
    document.getElementById('edit_stored_at').value = storedAt || '';
    document.getElementById('editDocumentForm').action = '/admin/documents/' + id + '/update';
    
    var editModal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
    editModal.show();
}

// Auto-dismiss alerts
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);

// Reset modals on close
document.getElementById('addDocumentModal').addEventListener('hidden.bs.modal', function () {
    this.querySelector('form').reset();
});

document.getElementById('viewDocumentModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('documentFrame').src = '';
});
</script>
</body>
</html>
