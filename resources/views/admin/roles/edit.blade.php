@extends('layouts.dashboard')

@section('header', 'Edit User Role & Privileges')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Managing: {{ $user->name }}</h6>
                        <p class="text-sm mb-0">{{ $user->email }}</p>
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

                    <!-- Folder Access -->
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="mb-3">Folder Access Permissions</h6>
                            <p class="text-sm text-muted mb-3">Select which folders this user can access</p>

                            <div class="row">
                                @forelse($foldersWithAccess as $folder)
                                    <div class="col-md-12 mb-3">
                                        <div class="card folder-access-card {{ $folder['has_access'] ? 'border-success' : '' }}" 
                                             data-folder-id="{{ $folder['id'] }}">
                                            <div class="card-body p-3">
                                                <!-- Main Folder Access Checkbox -->
                                                <div class="form-check mb-3">
                                                    <input class="form-check-input folder-main-checkbox" 
                                                           type="checkbox" 
                                                           name="folders[]" 
                                                           value="{{ $folder['id'] }}"
                                                           id="folder_{{ $folder['id'] }}"
                                                           {{ $folder['has_access'] ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="folder_{{ $folder['id'] }}">
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-folder text-warning fa-2x me-3"></i>
                                                            <div>
                                                                <h6 class="mb-0">{{ $folder['name'] }}</h6>
                                                                <span class="text-xs {{ $folder['has_access'] ? 'text-success' : 'text-secondary' }}">
                                                                    {{ $folder['has_access'] ? 'Authorized' : 'Unauthorized' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>

                                                <!-- CRUD Permissions -->
                                                <div class="crud-permissions ms-5 {{ !$folder['has_access'] ? 'disabled' : '' }}" 
                                                     id="crud_{{ $folder['id'] }}">
                                                    <div class="row">
                                                        <div class="col-md-3 col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input crud-checkbox" 
                                                                       type="checkbox" 
                                                                       name="add_{{ $folder['id'] }}"
                                                                       id="add_{{ $folder['id'] }}"
                                                                       {{ $folder['can_add'] ? 'checked' : '' }}
                                                                       {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                <label class="form-check-label text-sm" for="add_{{ $folder['id'] }}">
                                                                    <i class="fa fa-plus-circle text-success"></i> Add
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input crud-checkbox" 
                                                                       type="checkbox" 
                                                                       name="edit_{{ $folder['id'] }}"
                                                                       id="edit_{{ $folder['id'] }}"
                                                                       {{ $folder['can_edit'] ? 'checked' : '' }}
                                                                       {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                <label class="form-check-label text-sm" for="edit_{{ $folder['id'] }}">
                                                                    <i class="fa fa-edit text-info"></i> Edit
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input crud-checkbox" 
                                                                       type="checkbox" 
                                                                       name="view_{{ $folder['id'] }}"
                                                                       id="view_{{ $folder['id'] }}"
                                                                       {{ $folder['can_view'] ? 'checked' : '' }}
                                                                       {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                <label class="form-check-label text-sm" for="view_{{ $folder['id'] }}">
                                                                    <i class="fa fa-eye text-primary"></i> View
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-6">
                                                            <div class="form-check">
                                                                <input class="form-check-input crud-checkbox" 
                                                                       type="checkbox" 
                                                                       name="delete_{{ $folder['id'] }}"
                                                                       id="delete_{{ $folder['id'] }}"
                                                                       {{ $folder['can_delete'] ? 'checked' : '' }}
                                                                       {{ !$folder['has_access'] ? 'disabled' : '' }}>
                                                                <label class="form-check-label text-sm" for="delete_{{ $folder['id'] }}">
                                                                    <i class="fa fa-trash text-danger"></i> Delete
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
                                            No folders available. Please add folders in GoogleDriveService.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Changes
                            </button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.folder-access-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.folder-access-card:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.folder-access-card.border-success {
    border-color: #2dce89 !important;
    background-color: #f0fdf4;
}

.form-check-input:checked {
    background-color: #2dce89;
    border-color: #2dce89;
}

.crud-permissions {
    padding: 10px;
    background-color: #f8f9fa;
    border-radius: 5px;
    transition: opacity 0.3s;
}

.crud-permissions.disabled {
    opacity: 0.4;
    pointer-events: none;
}

.crud-checkbox:disabled {
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle main folder checkbox changes
    document.querySelectorAll('.folder-main-checkbox').forEach(mainCheckbox => {
        mainCheckbox.addEventListener('change', function() {
            const folderId = this.value;
            const card = this.closest('.folder-access-card');
            const crudContainer = document.getElementById('crud_' + folderId);
            const crudCheckboxes = crudContainer.querySelectorAll('.crud-checkbox');
            
            if (this.checked) {
                // Authorized - enable CRUD checkboxes
                card.classList.add('border-success');
                crudContainer.classList.remove('disabled');
                crudCheckboxes.forEach(cb => cb.disabled = false);
            } else {
                // Unauthorized - disable and uncheck all CRUD checkboxes
                card.classList.remove('border-success');
                crudContainer.classList.add('disabled');
                crudCheckboxes.forEach(cb => {
                    cb.checked = false;
                    cb.disabled = true;
                });
            }
        });
    });
});
</script>
@endsection
