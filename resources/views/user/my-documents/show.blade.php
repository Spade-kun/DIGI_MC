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
                        <h6>{{ $category }} Documents</h6>
                        <p class="text-sm mb-0">View and manage documents in this category</p>
                    </div>
                    <a href="{{ route('user.my-documents.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </a>
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
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Permissions</th>
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
                                        @if($document->user_can_add)
                                            <span class="badge badge-sm bg-gradient-success me-1">Add</span>
                                        @endif
                                        @if($document->user_can_view)
                                            <span class="badge badge-sm bg-gradient-info me-1">View</span>
                                        @endif
                                        @if($document->user_can_edit)
                                            <span class="badge badge-sm bg-gradient-primary me-1">Edit</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($document->user_can_view)
                                            <button type="button" 
                                                    class="btn btn-sm btn-info mb-0 me-1" 
                                                    onclick="viewDocument('{{ Storage::url($document->file_path) }}', '{{ $document->title }}')"
                                                    title="View Document">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        @endif
                                        
                                        <a href="{{ route('user.my-documents.download', [$category, $document->id]) }}" 
                                           class="btn btn-sm btn-success mb-0 me-1" 
                                           title="Download">
                                            <i class="fas fa-download"></i> Download
                                        </a>

                                        @if($document->user_can_edit)
                                            <button type="button" 
                                                    class="btn btn-sm btn-primary mb-0" 
                                                    title="Edit Document">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <p class="text-sm text-secondary mb-0">No documents found in this category.</p>
                                        <p class="text-xs text-muted">Contact your administrator to request access.</p>
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

<script>
function viewDocument(url, title) {
    document.getElementById('documentTitle').textContent = title;
    document.getElementById('documentFrame').src = url;
    
    var viewModal = new bootstrap.Modal(document.getElementById('viewDocumentModal'));
    viewModal.show();
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

// Reset modal on close
document.getElementById('viewDocumentModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('documentFrame').src = '';
});
</script>
@endsection
