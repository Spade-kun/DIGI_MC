@extends('layouts.dashboard')

@section('header', 'My Documents')

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

        <!-- Pending Documents Table -->
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6>Pending Documents</h6>
                        <p class="text-sm mb-0">Documents waiting for admin approval</p>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addDocumentModal">
                        <i class="fas fa-plus"></i> Add Document
                    </button>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if($pendingDocuments->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                        <p class="text-sm text-secondary mb-0">No pending documents.</p>
                    </div>
                @else
                    @foreach($categories as $category)
                        @if($pendingDocuments->has($category))
                            <div class="category-section mb-3">
                                <div class="px-3 py-2 bg-gradient-info">
                                    <h6 class="text-white mb-0">
                                        <i class="fas fa-folder-open"></i> {{ $category }}
                                    </h6>
                                </div>
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Submitted</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingDocuments[$category] as $document)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $document->title }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->file_name }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->created_at->format('M d, Y') }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-success mb-0" 
                                                                onclick="confirmApprove({{ $document->id }})"
                                                                title="Approve">
                                                            <i class="fas fa-check"></i> Approve
                                                        </button>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-warning mb-0" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#rejectModal{{ $document->id }}"
                                                                title="Reject">
                                                            <i class="fas fa-times"></i> Reject
                                                        </button>
                                                        
                                                        <!-- Approve Form -->
                                                        <form id="approve-form-{{ $document->id }}" 
                                                              action="{{ route('user.my-documents.approve', $document->id) }}" 
                                                              method="POST" 
                                                              style="display: none;">
                                                            @csrf
                                                            @method('PUT')
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rejectModal{{ $document->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-gradient-warning">
                                                                <h5 class="modal-title text-white">
                                                                    <i class="fas fa-exclamation-triangle"></i> Reject Document
                                                                </h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <form action="{{ route('user.my-documents.reject', $document->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="modal-body">
                                                                    <p><strong>Title:</strong> {{ $document->title }}</p>
                                                                    <div class="mb-3">
                                                                        <label for="rejection_reason{{ $document->id }}" class="form-label">
                                                                            Rejection Reason <span class="text-danger">*</span>
                                                                        </label>
                                                                        <textarea class="form-control" 
                                                                                  id="rejection_reason{{ $document->id }}" 
                                                                                  name="rejection_reason" 
                                                                                  rows="4" 
                                                                                  required
                                                                                  placeholder="Enter reason for rejection..."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="submit" class="btn btn-warning">
                                                                        <i class="fas fa-ban"></i> Reject Document
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Approved and Rejected Documents Table -->
        <div class="card">
            <div class="card-header pb-0">
                <div>
                    <h6>Reviewed Documents</h6>
                    <p class="text-sm mb-0">Approved and rejected documents</p>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                @if($reviewedDocuments->isEmpty())
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-3x text-secondary mb-3"></i>
                        <p class="text-sm text-secondary mb-0">No reviewed documents yet.</p>
                    </div>
                @else
                    @foreach($categories as $category)
                        @if($reviewedDocuments->has($category))
                            <div class="category-section mb-3">
                                <div class="px-3 py-2 bg-gradient-primary">
                                    <h6 class="text-white mb-0">
                                        <i class="fas fa-folder-open"></i> {{ $category }}
                                    </h6>
                                </div>
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Title</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date Reviewed</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($reviewedDocuments[$category] as $document)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $document->title }}</h6>
                                                                @if($document->status === 'rejected' && $document->rejection_reason)
                                                                    <p class="text-xs text-danger mb-0">
                                                                        <i class="fas fa-exclamation-circle"></i> {{ $document->rejection_reason }}
                                                                    </p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">{{ $document->file_name }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-xs font-weight-bold">
                                                            {{ $document->reviewed_at ? $document->reviewed_at->format('M d, Y') : 'N/A' }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if($document->status === 'approved')
                                                            <span class="badge badge-sm bg-gradient-success">Approved</span>
                                                        @else
                                                            <span class="badge badge-sm bg-gradient-danger">Rejected</span>
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if($document->status === 'approved')
                                                            <a href="{{ route('user.my-documents.download', $document->id) }}" 
                                                               class="btn btn-sm btn-success mb-0" 
                                                               title="Download">
                                                                <i class="fas fa-download"></i> Download
                                                            </a>
                                                        @else
                                                            <span class="text-danger text-xs">
                                                                <i class="fas fa-ban"></i> Not Available
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Document Modal -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" aria-labelledby="addDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="addDocumentModalLabel">
                    <i class="fas fa-file-upload"></i> Add New Document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('user.my-documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-control @error('category') is-invalid @enderror" 
                                id="category" 
                                name="category" 
                                required>
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">File <span class="text-danger">*</span></label>
                        <input type="file" 
                               class="form-control @error('file') is-invalid @enderror" 
                               id="file" 
                               name="file" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               required>
                        <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG (Max 10MB)</small>
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> Submit Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.category-section {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    overflow: hidden;
}

.category-section .table {
    margin-bottom: 0;
}

.category-section:last-child {
    margin-bottom: 0 !important;
}
</style>

<script>
function confirmApprove(id) {
    if (confirm('Are you sure you want to approve this document?')) {
        document.getElementById('approve-form-' + id).submit();
    }
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this document? This action cannot be undone.')) {
        document.getElementById('delete-form-' + id).submit();
    }
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
</script>
@endsection
