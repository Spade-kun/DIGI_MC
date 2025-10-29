@extends('layouts.dashboard')

@section('header', $category . ' Documents')

@section('content')
<div class="row">
    <div class="col-12">
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

        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                            <i class="fas fa-arrow-left"></i> Back to Folders
                        </a>
                        <h6>{{ $category }} Documents</h6>
                        <p class="text-sm mb-0">Manage documents in {{ $category }} category</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <i class="fas fa-plus"></i> Add Document
                    </button>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Case No.</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Issued</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Uploaded By</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $document->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->case_no }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->date_issued->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->uploaded_by }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <button type="button" 
                                                class="btn btn-sm btn-info mb-0" 
                                                onclick="viewDocument('{{ Storage::url($document->file_path) }}', '{{ $document->title }}')"
                                                title="View Document">
                                            <i class="fas fa-eye"></i> View
                                        </button>
                                        <a href="{{ route('admin.documents.download', $document->id) }}" 
                                           class="btn btn-sm btn-success mb-0" 
                                           title="Download">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-warning mb-0" 
                                                onclick="editDocument({{ $document->id }}, '{{ $document->title }}', '{{ $document->case_no }}', '{{ $document->date_issued->format('Y-m-d') }}')"
                                                title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        @if($document->google_drive_id)
                                        <span class="badge badge-sm bg-gradient-success" title="Uploaded to Google Drive">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                        </span>
                                        @endif
                                        <button type="button" 
                                                class="btn btn-sm btn-danger mb-0" 
                                                onclick="confirmDelete({{ $document->id }})"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $document->id }}" 
                                              action="{{ route('admin.documents.destroy', $document->id) }}" 
                                              method="POST" 
                                              style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">No documents found in this category.</p>
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

<script>
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

function editDocument(id, title, caseNo, dateIssued) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_case_no').value = caseNo;
    document.getElementById('edit_date_issued').value = dateIssued;
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
@endsection
