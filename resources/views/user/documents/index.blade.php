@extends('layouts.dashboard')

@section('header', 'Drive Documents')

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
                <div>
                    <h6>Google Drive Folders</h6>
                    <p class="text-sm mb-0">Access your authorized document folders</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($folders as $folder)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card folder-card {{ $folder['has_access'] ? 'authorized' : 'unauthorized' }}">
                                <div class="card-body text-center">
                                    <div class="folder-icon mb-3">
                                        <i class="fas fa-folder fa-4x {{ $folder['has_access'] ? 'text-warning' : 'text-secondary' }}"></i>
                                        @if(!$folder['has_access'])
                                            <i class="fas fa-lock lock-overlay"></i>
                                        @endif
                                    </div>
                                    <h6 class="mb-3">{{ $folder['name'] }}</h6>
                                    
                                    @if($folder['has_access'])
                                        <a href="{{ route('user.documents.show', $folder['id']) }}" 
                                           class="btn btn-primary btn-sm w-100"
                                           target="_blank">
                                            <i class="fas fa-external-link-alt"></i> Open in Drive
                                        </a>
                                        <span class="badge bg-gradient-success mt-2 w-100">Authorized</span>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" 
                                                onclick="showUnauthorizedMessage('{{ $folder['name'] }}')"
                                                disabled>
                                            <i class="fas fa-lock"></i> No Access
                                        </button>
                                        <span class="badge bg-gradient-danger mt-2 w-100">Unauthorized</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <p class="mb-0">No folders available at the moment.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.folder-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
    height: 100%;
}

.folder-card.authorized {
    border-color: #2dce89;
    background: linear-gradient(135deg, #fff 0%, #f0fdf4 100%);
}

.folder-card.unauthorized {
    border-color: #f5365c;
    background: linear-gradient(135deg, #fff 0%, #fef2f2 100%);
    opacity: 0.7;
}

.folder-card:hover.authorized {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(45, 206, 137, 0.2);
}

.folder-icon {
    position: relative;
    display: inline-block;
}

.lock-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    color: #f5365c;
}
</style>

<script>
function showUnauthorizedMessage(folderName) {
    alert('You do not have permission to access "' + folderName + '" folder.\n\nPlease contact the administrator to request access.');
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
