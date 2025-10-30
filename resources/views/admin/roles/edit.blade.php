<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Edit User Role & Privileges - LEGALITEASE</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap 5 CSS -->
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
    .logout-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.5);
    }

    .logout-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logout-modal-content {
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

    .logout-modal-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .logout-modal-icon {
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

    .logout-modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .logout-modal-text {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .logout-modal-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .logout-modal-btn {
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

    /* Card Styling */
    .card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        border: none;
    }

    .card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-bottom: 1px solid #e5e7eb;
        padding: 1.5rem 2rem;
    }

    .card-header h6 {
        color: #1f2937;
        font-weight: 600;
        font-size: 1.125rem;
        margin: 0;
    }

    .card-body {
        padding: 2rem;
    }

    /* Form Styling */
    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.625rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #6b21a8;
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }

    /* Folder Access Cards */
    .folder-access-card {
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .folder-access-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .folder-access-card.border-success {
        border-color: #10b981 !important;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    }

    .folder-access-card .card-body {
        padding: 1.5rem;
    }

    /* Form Checkboxes */
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid #d1d5db;
        cursor: pointer;
        transition: all 0.3s;
    }

    .form-check-input:checked {
        background-color: #10b981;
        border-color: #10b981;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }

    .form-check-label {
        cursor: pointer;
        font-size: 0.875rem;
        color: #374151;
        margin-left: 0.5rem;
    }

    /* Permissions Section */
    .permissions {
        padding: 1rem;
        background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s;
        margin-top: 1rem;
    }

    .permissions.disabled {
        opacity: 0.5;
        pointer-events: none;
        background: #f3f4f6;
    }

    .permission-checkbox:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }

    /* Buttons */
    .btn {
        padding: 0.625rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.4);
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #6b7280;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.8125rem;
    }

    /* Horizontal Rule */
    .horizontal {
        margin: 1.5rem 0;
        border: 0;
        border-top: 2px solid #e5e7eb;
    }

    /* Text Utilities */
    .text-xs {
        font-size: 0.75rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-muted {
        color: #6b7280;
    }

    /* Alert */
    .alert {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    /* Icon Styling */
    .fa-folder {
        font-size: 2rem;
        margin-right: 1rem;
    }

    /* User Info Badge */
    .text-success {
        color: #10b981 !important;
        font-weight: 600;
    }

    .text-secondary {
        color: #6b7280 !important;
    }

    .text-danger {
        color: #ef4444 !important;
    }

    .text-info {
        color: #3b82f6 !important;
    }

    .text-warning {
        color: #f59e0b !important;
    }

    .text-primary {
        color: #6b21a8 !important;
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Edit User Role & Privileges</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Managing: {{ $user->name }}</h6>
                                <p class="text-sm mb-0" style="color: #6b7280;">{{ $user->email }}</p>
                            </div>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.roles.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Role Selection -->
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label class="form-label">User Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" required>
                                        <option value="">-- Select Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role }}" {{ $user->role == $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="text-danger text-xs">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <hr class="horizontal dark">

                            <!-- Document Access -->
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="mb-3" style="color: #1f2937; font-weight: 600;">Folder Access Permissions</h6>
                                    <p class="text-sm text-muted mb-4">Select which folders this user can access and their specific permissions</p>

                                    <div class="row">
                                        @forelse($foldersByCategory as $folder)
                                            <div class="col-md-12 mb-3">
                                                <div class="card folder-access-card {{ $folder['has_access'] ? 'border-success' : '' }}" 
                                                     data-folder-category="{{ $folder['category'] }}">
                                                    <div class="card-body p-3">
                                                        <!-- Main Folder Access Checkbox -->
                                                        <div class="form-check mb-3">
                                                            <input class="form-check-input folder-main-checkbox" 
                                                                   type="checkbox" 
                                                                   name="folders[]" 
                                                                   value="{{ $folder['category'] }}"
                                                                   id="folder_{{ Str::slug($folder['category']) }}"
                                                                   {{ $folder['has_access'] ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="folder_{{ Str::slug($folder['category']) }}">
                                                                <div class="d-flex align-items-center">
                                                                    <i class="fa fa-folder text-warning fa-2x me-3"></i>
                                                                    <div>
                                                                        <h6 class="mb-0" style="color: #1f2937; font-weight: 600;">{{ $folder['category'] }}</h6>
                                                                        <div class="text-xs text-secondary">
                                                                            {{ $folder['document_count'] }} {{ Str::plural('document', $folder['document_count']) }}
                                                                        </div>
                                                                        <span class="text-xs {{ $folder['has_access'] ? 'text-success' : 'text-secondary' }}">
                                                                            {{ $folder['has_access'] ? '✓ Authorized' : '✗ Unauthorized' }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        <!-- Folder Permissions -->
                                                        <div class="permissions ms-5 {{ !$folder['has_access'] ? 'disabled' : '' }}" 
                                                             id="permissions_{{ Str::slug($folder['category']) }}">
                                                            <div class="row">
                                                                <!-- <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-checkbox" 
                                                                               type="checkbox" 
                                                                               name="add_{{ Str::slug($folder['category']) }}"
                                                                               value="{{ $folder['category'] }}"
                                                                               id="add_{{ Str::slug($folder['category']) }}"
                                                                               {{ $folder['can_add'] ? 'checked' : '' }}
                                                                               {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                        <label class="form-check-label text-sm" for="add_{{ Str::slug($folder['category']) }}">
                                                                            <i class="fa fa-plus-circle text-success"></i> Add Documents
                                                                        </label>
                                                                    </div>
                                                                </div> -->
                                                                <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-checkbox" 
                                                                               type="checkbox" 
                                                                               name="edit_{{ Str::slug($folder['category']) }}"
                                                                               value="{{ $folder['category'] }}"
                                                                               id="edit_{{ Str::slug($folder['category']) }}"
                                                                               {{ $folder['can_edit'] ? 'checked' : '' }}
                                                                               {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                        <label class="form-check-label text-sm" for="edit_{{ Str::slug($folder['category']) }}">
                                                                            <i class="fa fa-edit text-info"></i> Edit
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-12 mb-2">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input permission-checkbox" 
                                                                               type="checkbox" 
                                                                               name="view_{{ Str::slug($folder['category']) }}"
                                                                               value="{{ $folder['category'] }}"
                                                                               id="view_{{ Str::slug($folder['category']) }}"
                                                                               {{ $folder['can_view'] ? 'checked' : '' }}
                                                                               {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                        <label class="form-check-label text-sm" for="view_{{ Str::slug($folder['category']) }}">
                                                                            <i class="fa fa-eye text-primary"></i> View 
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-info">
                                                    <i class="fa fa-info-circle"></i>
                                                    <span>No folders available in the system.</span>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    
</div>
    </div>
</div>

    <!-- Logout Modal -->
    <div class="logout-modal" id="logoutModal">
        <div class="logout-modal-content">
            <div class="logout-modal-header">
                <div class="logout-modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="logout-modal-title">Confirm Logout</h3>
                <p class="logout-modal-text">Are you sure you want to logout? Your session will end.</p>
            </div>
            <div class="logout-modal-actions">
                <button class="logout-modal-btn btn-cancel" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('admin.logout') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="logout-modal-btn btn-confirm" style="width: 100%;">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
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

document.addEventListener('DOMContentLoaded', function() {
    // Handle main folder checkbox changes
    document.querySelectorAll('.folder-main-checkbox').forEach(mainCheckbox => {
        mainCheckbox.addEventListener('change', function() {
            const folderCategory = this.value;
            const card = this.closest('.folder-access-card');
            const categorySlug = folderCategory.toLowerCase().replace(/\s+/g, '-');
            const permissionsContainer = document.getElementById('permissions_' + categorySlug);
            const permissionCheckboxes = permissionsContainer.querySelectorAll('.permission-checkbox');
            
            if (this.checked) {
                // Authorized - enable and AUTO-CHECK all permission checkboxes
                card.classList.add('border-success');
                permissionsContainer.classList.remove('disabled');
                permissionCheckboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.checked = true; // Automatically check all permissions
                });
            } else {
                // Unauthorized - disable and uncheck all permission checkboxes
                card.classList.remove('border-success');
                permissionsContainer.classList.add('disabled');
                permissionCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
            }
        });
    });
});
</script>
</body>
</html>
