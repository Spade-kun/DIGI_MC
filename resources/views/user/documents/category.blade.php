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
                        <h6>
                            <i class="fas fa-folder-open text-warning"></i> {{ $category }}
                        </h6>
                        <p class="text-sm mb-0">
                            Your permissions: 
                            @if($canAdd)
                                <span class="badge badge-sm bg-gradient-success"><i class="fas fa-plus"></i> Add</span>
                            @endif
                            @if($canView)
                                <span class="badge badge-sm bg-gradient-primary"><i class="fas fa-eye"></i> View</span>
                            @endif
                            @if($canEdit)
                                <span class="badge badge-sm bg-gradient-info"><i class="fas fa-edit"></i> Edit</span>
                            @endif
                            @if(!$canAdd && !$canView && !$canEdit)
                                <span class="badge badge-sm bg-gradient-danger"><i class="fas fa-ban"></i> No Permissions</span>
                            @endif
                        </p>
                    </div>
                    <div>
                        @if($canAdd)
                            <button type="button" class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                                <i class="fas fa-plus"></i> Add Document
                            </button>
                        @endif
                        <a href="{{ route('user.documents.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Folders
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if($documents->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                        <p class="text-sm text-secondary mb-0">No documents available in this folder.</p>
                    </div>
                @else
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Document</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Case No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Issued</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Uploaded By</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($documents as $document)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div>
                                                    <i class="fas fa-file-pdf text-danger fa-2x"></i>
                                                </div>
                                                <div class="d-flex flex-column justify-content-center ms-3">
                                                    <h6 class="mb-0 text-sm">{{ $document->title }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $document->file_name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $document->case_no }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $document->date_issued->format('M d, Y') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $document->uploaded_by ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if($document->can_view)
                                                <button type="button" 
                                                        class="btn btn-sm btn-primary mb-0" 
                                                        onclick="viewDocument({{ $document->id }}, '{{ $document->title }}')"
                                                        title="View Document">
                                                    <i class="fas fa-eye"></i> View
                                                </button>
                                            @endif
                                            
                                            @if($document->can_view)
                                                <a href="{{ route('user.documents.download', $document->id) }}" 
                                                   class="btn btn-sm btn-success mb-0" 
                                                   title="Download">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            @endif
                                            
                                            @if($document->can_edit)
                                                <button type="button" 
                                                        class="btn btn-sm btn-info mb-0" 
                                                        onclick="editDocument({{ $document->id }}, '{{ addslashes($document->title) }}', '{{ $document->case_no }}', '{{ $document->date_issued->format('Y-m-d') }}')"
                                                        title="Edit Document">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                            @endif
                                            
                                            @if(!$document->can_view && !$document->can_edit)
                                                <button type="button" 
                                                        class="btn btn-sm btn-secondary mb-0" 
                                                        disabled
                                                        title="No Permission">
                                                    <i class="fas fa-ban"></i> No Access
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Document Modal -->
@if($canAdd)
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="addDocumentModalLabel">
                    <i class="fas fa-plus"></i> Add Document to {{ $category }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="category" value="{{ $category }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="case_no" class="form-label">Case No. <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="case_no" 
                               name="case_no" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control" 
                               id="date_issued" 
                               name="date_issued" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File (PDF Only) <span class="text-danger">*</span></label>
                        <input type="file" 
                               class="form-control" 
                               id="file" 
                               name="file" 
                               accept=".pdf"
                               required>
                        <small class="text-muted">Maximum file size: 10MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Edit Document Modal -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" aria-labelledby="editDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-info">
                <h5 class="modal-title text-white" id="editDocumentModalLabel">
                    <i class="fas fa-edit"></i> Edit Document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editDocumentForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="edit_title" 
                               name="title" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_case_no" class="form-label">Case No. <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="edit_case_no" 
                               name="case_no" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_date_issued" class="form-label">Date Issued <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control" 
                               id="edit_date_issued" 
                               name="date_issued" 
                               required>
                    </div>

                    <p class="text-sm text-muted mb-0">
                        <i class="fas fa-info-circle"></i> Note: You cannot change the file. To update the file, please delete and re-upload.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-save"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Document Modal -->
<div class="modal fade" id="viewDocumentModal" tabindex="-1" aria-labelledby="viewDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="viewDocumentModalLabel">
                    <i class="fas fa-file-pdf"></i> <span id="documentTitle"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="documentViewer" 
                        style="width: 100%; height: 600px; border: none;" 
                        src="">
                </iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewDocument(documentId, documentTitle) {
    document.getElementById('documentTitle').textContent = documentTitle;
    document.getElementById('documentViewer').src = '{{ url("/user/documents/view") }}/' + documentId;
    
    var modal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
    modal.show();
}

function editDocument(documentId, title, caseNo, dateIssued) {
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_case_no').value = caseNo;
    document.getElementById('edit_date_issued').value = dateIssued;
    
    var form = document.getElementById('editDocumentForm');
    form.action = '{{ url("/user/documents/update") }}/' + documentId;
    
    var modal = new bootstrap.Modal(document.getElementById('editDocumentModal'));
    modal.show();
}

// Clear iframe when modal is closed
document.getElementById('viewDocumentModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('documentViewer').src = '';
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
@endsection
