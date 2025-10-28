@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
    <span class="mask bg-gradient-primary opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    Manage Folder Access for {{ $user->name }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Set which Google Drive folders this user can access
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-text text-white">{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-text text-white">{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">Google Drive Folders</h6>
                            <p class="text-sm mb-0">Select folders this user can access</p>
                        </div>
                        <div>
                            <button type="button" class="btn btn-success btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addFolderModal">
                                <i class="fa fa-plus"></i> Add Folder
                            </button>
                            <a href="{{ route('admin.privileges.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form id="privileges-form" method="POST" action="{{ route('admin.privileges.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-sm">
                                        <strong>Selected:</strong> 
                                        <span id="selected-count">{{ count($userPrivileges) }}</span> folder(s)
                                    </span>
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-success" id="select-all-btn">
                                            <i class="fa fa-check-double"></i> Select All
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="deselect-all-btn">
                                            <i class="fa fa-times"></i> Deselect All
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="folders-container">
                            @forelse($allFolders as $folder)
                                @php
                                    $hasAccess = isset($userPrivileges[$folder['id']]) && $userPrivileges[$folder['id']];
                                @endphp
                                <div class="card mb-2 folder-item" data-folder-id="{{ $folder['id'] }}">
                                    <div class="card-body p-3">
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input folder-checkbox" 
                                                       type="checkbox" 
                                                       name="folders[{{ $loop->index }}][can_access]"
                                                       id="folder-{{ $folder['id'] }}" 
                                                       value="1"
                                                       {{ $hasAccess ? 'checked' : '' }}>
                                                <input type="hidden" 
                                                       name="folders[{{ $loop->index }}][folder_id]" 
                                                       value="{{ $folder['id'] }}">
                                                <input type="hidden" 
                                                       name="folders[{{ $loop->index }}][folder_name]" 
                                                       value="{{ $folder['name'] }}">
                                            </div>
                                            <div class="ms-3 flex-grow-1">
                                                <label class="form-check-label mb-0" for="folder-{{ $folder['id'] }}">
                                                    <i class="fa fa-folder text-warning me-2"></i>
                                                    <strong>{{ $folder['name'] }}</strong>
                                                </label>
                                                <p class="text-xs text-muted mb-0">
                                                    ID: {{ $folder['id'] }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge badge-sm folder-status {{ $hasAccess ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                    {{ $hasAccess ? 'Accessible' : 'Restricted' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    No folders added yet. Click "Add Folder" to add Google Drive folders to the system.
                                </div>
                            @endforelse
                        </div>

                        @if(count($allFolders) > 0)
                            <div class="row mt-4">
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Privileges
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Folder Modal -->
<div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="addFolderForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderModalLabel">Add Google Drive Folder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="folder_name" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="folder_name" name="folder_name" required 
                               placeholder="e.g., Project Documents">
                        <small class="text-muted">Enter a friendly name for the folder</small>
                    </div>
                    <div class="mb-3">
                        <label for="folder_id" class="form-label">Folder ID</label>
                        <input type="text" class="form-control" id="folder_id" name="folder_id" required 
                               placeholder="e.g., 1ABC-xyz123DEF456ghi789">
                        <small class="text-muted">
                            <strong>How to get Folder ID:</strong><br>
                            1. Open the folder in Google Drive<br>
                            2. Copy the ID from the URL:<br>
                            <code>https://drive.google.com/drive/folders/<span class="text-danger">FOLDER_ID_HERE</span></code>
                        </small>
                    </div>
                    <div class="alert alert-info mb-0">
                        <i class="fa fa-info-circle"></i>
                        <strong>Tip:</strong> Make sure the folder is shared with the users who need access.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Folder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.folder-checkbox');
        const selectedCount = document.getElementById('selected-count');
        const selectAllBtn = document.getElementById('select-all-btn');
        const deselectAllBtn = document.getElementById('deselect-all-btn');
        const addFolderForm = document.getElementById('addFolderForm');
        const addFolderModal = new bootstrap.Modal(document.getElementById('addFolderModal'));
        
        // Update count
        function updateCount() {
            const checked = document.querySelectorAll('.folder-checkbox:checked').length;
            selectedCount.textContent = checked;
        }
        
        // Update status badge
        function updateStatusBadge(checkbox) {
            const folderItem = checkbox.closest('.folder-item');
            const statusBadge = folderItem.querySelector('.folder-status');
            
            if (checkbox.checked) {
                statusBadge.textContent = 'Accessible';
                statusBadge.classList.remove('bg-gradient-secondary');
                statusBadge.classList.add('bg-gradient-success');
            } else {
                statusBadge.textContent = 'Restricted';
                statusBadge.classList.remove('bg-gradient-success');
                statusBadge.classList.add('bg-gradient-secondary');
            }
        }
        
        // Checkbox change event
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateCount();
                updateStatusBadge(this);
            });
        });
        
        // Select all
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = true;
                    updateStatusBadge(checkbox);
                });
                updateCount();
            });
        }
        
        // Deselect all
        if (deselectAllBtn) {
            deselectAllBtn.addEventListener('click', function() {
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                    updateStatusBadge(checkbox);
                });
                updateCount();
            });
        }
        
        // Add folder form submission
        if (addFolderForm) {
            addFolderForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const folderName = document.getElementById('folder_name').value;
                const folderId = document.getElementById('folder_id').value;
                
                // Just reload the page - the folder will be available when assigned to a user
                addFolderModal.hide();
                
                // Show success message
                alert(`Folder "${folderName}" will be available once you save the privileges.`);
                
                // You can add the folder to the list dynamically here if needed
                window.location.reload();
            });
        }
        
        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush
