<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ $category }} - LEGALITEASE</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
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

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideInDown 0.5s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Documents Section */
        .documents-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .section-title {
            display: flex;
            flex-direction: column;
        }

        .section-title h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title h2 i {
            color: #f59e0b;
        }

        .permissions-row {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .permission-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .permission-badge.add {
            background: #d1fae5;
            color: #065f46;
        }

        .permission-badge.view {
            background: #dbeafe;
            color: #1e40af;
        }

        .permission-badge.edit {
            background: #fef3c7;
            color: #92400e;
        }

        .permission-badge.none {
            background: #fee2e2;
            color: #991b1b;
        }

        .section-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
        }

        .btn-primary {
            background: #6b21a8;
            color: white;
        }

        .btn-primary:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(107, 33, 168, 0.3);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        /* Table */
        .documents-table {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #f9fafb;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        th.text-center {
            text-align: center;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }

        td.text-center {
            text-align: center;
        }

        tbody tr {
            transition: background 0.2s;
        }

        tbody tr:hover {
            background: #f9fafb;
        }

        .document-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .document-icon {
            font-size: 2rem;
            color: #ef4444;
        }

        .document-details h6 {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .document-details p {
            font-size: 0.75rem;
            color: #6b7280;
            margin: 0;
        }

        .table-text {
            font-size: 0.875rem;
            color: #374151;
            font-weight: 500;
        }

        .table-text-sm {
            font-size: 0.75rem;
            color: #6b7280;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            text-decoration: none;
            font-size: 0.75rem;
        }

        .btn-view {
            background: #6b21a8;
            color: white;
        }

        .btn-view:hover {
            background: #7c3aed;
        }

        .btn-download {
            background: #10b981;
            color: white;
        }

        .btn-download:hover {
            background: #059669;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-edit:hover {
            background: #d97706;
        }

        .btn-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-dialog {
            background: white;
            border-radius: 16px;
            max-width: 600px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.3s ease-out;
        }

        .modal-dialog.modal-xl {
            max-width: 1200px;
            max-height: 85vh;
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

        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
            border-radius: 16px 16px 0 0;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: white;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-close {
            background: none;
            border: none;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: background 0.3s;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-label .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: #6b21a8;
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
        }

        .form-text {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: #6b7280;
        }

        .info-box {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        #documentViewer {
            width: 100%;
            height: 500px;
            border: none;
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

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .documents-table {
                font-size: 0.75rem;
            }

            th, td {
                padding: 0.75rem 0.5rem;
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
            <a href="{{ route('dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('user.documents.index') }}" class="menu-item active">
                <i class="fas fa-folder"></i>
                <span>Documents</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-truck"></i>
                <span>Tracking</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="menu-item">
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
        <div class="alert alert-success">
            <span><i class="fas fa-check-circle"></i> {{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <span><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</span>
        </div>
        @endif

        <!-- Documents Section -->
        <div class="documents-section">
            <div class="section-header">
                <div class="section-title">
                    <h2>
                        <i class="fas fa-folder-open"></i>
                        {{ $category }}
                    </h2>
                    <div class="permissions-row">
                        @if($canAdd)
                            <span class="permission-badge add">
                                <i class="fas fa-plus"></i> Add
                            </span>
                        @endif
                        @if($canView)
                            <span class="permission-badge view">
                                <i class="fas fa-eye"></i> View
                            </span>
                        @endif
                        @if($canEdit)
                            <span class="permission-badge edit">
                                <i class="fas fa-edit"></i> Edit
                            </span>
                        @endif
                        @if(!$canAdd && !$canView && !$canEdit)
                            <span class="permission-badge none">
                                <i class="fas fa-ban"></i> No Permissions
                            </span>
                        @endif
                    </div>
                </div>
                <div class="section-actions">
                    @if($canAdd)
                        <button type="button" class="btn btn-primary" onclick="showAddModal()">
                            <i class="fas fa-plus"></i> Add Document
                        </button>
                    @endif
                    <a href="{{ route('user.documents.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Folders
                    </a>
                </div>
            </div>

            @if($documents->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>No documents available</h3>
                    <p>There are currently no documents in this folder.</p>
                </div>
            @else
                <div class="documents-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Document</th>
                                <th>Case No.</th>
                                <th class="text-center">Date Issued</th>
                                <th class="text-center">Uploaded By</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                            <tr>
                                <td>
                                    <div class="document-info">
                                        <i class="fas fa-file-pdf document-icon"></i>
                                        <div class="document-details">
                                            <h6>{{ $document->title }}</h6>
                                            <p>{{ $document->file_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="table-text">{{ $document->case_no }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="table-text-sm">{{ $document->date_issued->format('M d, Y') }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="table-text-sm">{{ $document->uploaded_by ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($document->can_view)
                                            <button type="button" 
                                                    class="btn-action btn-view" 
                                                    onclick="viewDocument({{ $document->id }}, '{{ addslashes($document->title) }}')"
                                                    title="View Document">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @endif
                                        
                                        @if($document->can_view)
                                            <a href="{{ route('user.documents.download', $document->id) }}" 
                                               class="btn-action btn-download" 
                                               title="Download">
                                                <i class="fas fa-download"></i> Download
                                            </a>
                                        @endif
                                        
                                        @if($document->can_edit)
                                            <button type="button" 
                                                    class="btn-action btn-edit" 
                                                    onclick="editDocument({{ $document->id }}, '{{ addslashes($document->title) }}', '{{ $document->case_no }}', '{{ $document->date_issued->format('Y-m-d') }}')"
                                                    title="Edit Document">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        @endif
                                        
                                        @if(!$document->can_view && !$document->can_edit)
                                            <button type="button" 
                                                    class="btn-action btn-disabled" 
                                                    disabled
                                                    title="No Permission">
                                                <i class="fas fa-ban"></i> No Access
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>


    <!-- Logout Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-dialog">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <h3 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i>
                    Confirm Logout
                </h3>
                <button class="modal-close" onclick="closeLogoutModal()">×</button>
            </div>
            <div class="modal-body">
                <p style="color: #6b7280; text-align: center;">Are you sure you want to logout? Your session will end.</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('user.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Document Modal -->
    @if($canAdd)
    <div class="modal" id="addDocumentModal">
        <div class="modal-dialog">
            <form action="{{ route('user.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-plus"></i>
                        Add Document to {{ $category }}
                    </h3>
                    <button type="button" class="modal-close" onclick="closeAddModal()">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title" class="form-label">Title <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="case_no" class="form-label">Case No. <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="case_no" 
                               name="case_no" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="date_issued" class="form-label">Date Issued <span class="required">*</span></label>
                        <input type="date" 
                               class="form-control" 
                               id="date_issued" 
                               name="date_issued" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="file" class="form-label">File (PDF Only) <span class="required">*</span></label>
                        <input type="file" 
                               class="form-control" 
                               id="file" 
                               name="file" 
                               accept=".pdf"
                               required>
                        <small class="form-text">Maximum file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeAddModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Edit Document Modal -->
    <div class="modal" id="editDocumentModal">
        <div class="modal-dialog">
            <form id="editDocumentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h3 class="modal-title">
                        <i class="fas fa-edit"></i>
                        Edit Document
                    </h3>
                    <button type="button" class="modal-close" onclick="closeEditModal()">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_title" class="form-label">Title <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="edit_title" 
                               name="title" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="edit_case_no" class="form-label">Case No. <span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="edit_case_no" 
                               name="case_no" 
                               required>
                    </div>

                    <div class="form-group">
                        <label for="edit_date_issued" class="form-label">Date Issued <span class="required">*</span></label>
                        <input type="date" 
                               class="form-control" 
                               id="edit_date_issued" 
                               name="date_issued" 
                               required>
                    </div>

                    <div class="info-box">
                        <i class="fas fa-info-circle"></i>
                        <span>Note: You cannot change the file. To update the file, please delete and re-upload.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- View Document Modal -->
    <div class="modal" id="viewDocumentModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-header">
                <h3 class="modal-title">
                    <i class="fas fa-file-pdf"></i>
                    <span id="documentTitle"></span>
                </h3>
                <button type="button" class="modal-close" onclick="closeViewModal()">×</button>
            </div>
            <div class="modal-body" style="padding: 0;">
                <iframe id="documentViewer" src=""></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeViewModal()">Close</button>
            </div>
        </div>
    </div>

    <script>
        // Logout Modal
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('show');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('show');
        }

        // Add Document Modal
        function showAddModal() {
            document.getElementById('addDocumentModal').classList.add('show');
        }

        function closeAddModal() {
            document.getElementById('addDocumentModal').classList.remove('show');
        }

        // Edit Document Modal
        function editDocument(documentId, title, caseNo, dateIssued) {
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_case_no').value = caseNo;
            document.getElementById('edit_date_issued').value = dateIssued;
            
            var form = document.getElementById('editDocumentForm');
            form.action = '{{ url("/user/documents/update") }}/' + documentId;
            
            document.getElementById('editDocumentModal').classList.add('show');
        }

        function closeEditModal() {
            document.getElementById('editDocumentModal').classList.remove('show');
        }

        // View Document Modal
        function viewDocument(documentId, documentTitle) {
            document.getElementById('documentTitle').textContent = documentTitle;
            document.getElementById('documentViewer').src = '{{ url("/user/documents/view") }}/' + documentId;
            
            document.getElementById('viewDocumentModal').classList.add('show');
        }

        function closeViewModal() {
            document.getElementById('viewDocumentModal').classList.remove('show');
            document.getElementById('documentViewer').src = '';
        }

        // Close modals on backdrop click
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('show');
                    // Clear iframe if it's the view modal
                    if (this.id === 'viewDocumentModal') {
                        document.getElementById('documentViewer').src = '';
                    }
                }
            });
        });

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>

