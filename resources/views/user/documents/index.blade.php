@extends('layouts.dashboard')

@section('header', 'Documents')

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
                <h6>Document Folders</h6>
                <p class="text-sm mb-0">Access documents based on your assigned permissions</p>
            </div>
            <div class="card-body">
                <div class="row">
                    @forelse($folders as $folder)
                        <div class="col-lg-4 col-md-6 col-12 mb-4">
                            <div class="folder-card {{ $folder['is_locked'] ? 'locked' : '' }}" 
                                 onclick="{{ $folder['is_locked'] ? '' : 'window.location.href=\'' . route('user.documents.category', $folder['category']) . '\'' }}">
                                <div class="card h-100 {{ $folder['is_locked'] ? 'border-danger' : 'border-primary' }}">
                                    <div class="card-body text-center">
                                        <!-- Folder Icon -->
                                        <div class="folder-icon mb-3">
                                            @if($folder['is_locked'])
                                                <i class="fas fa-folder-lock fa-4x text-danger"></i>
                                            @else
                                                <i class="fas fa-folder-open fa-4x text-warning"></i>
                                            @endif
                                        </div>

                                        <!-- Folder Name -->
                                        <h5 class="mb-2">{{ $folder['category'] }}</h5>

                                        <!-- Document Count -->
                                        <div class="mb-3">
                                            @if($folder['is_locked'])
                                                <span class="badge bg-gradient-danger">
                                                    <i class="fas fa-lock"></i> Unauthorized
                                                </span>
                                            @else
                                                <span class="badge bg-gradient-success">
                                                    <i class="fas fa-check-circle"></i> Authorized
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Stats -->
                                        <div class="text-sm text-secondary mb-3">
                                            @if($folder['is_locked'])
                                                <p class="mb-0">
                                                    <i class="fas fa-file-alt"></i> {{ $folder['total_documents'] }} {{ Str::plural('document', $folder['total_documents']) }}
                                                </p>
                                                <p class="text-danger mb-0">
                                                    <i class="fas fa-ban"></i> No access
                                                </p>
                                            @else
                                                <p class="mb-0">
                                                    <i class="fas fa-file-alt"></i> {{ $folder['accessible_documents'] }} of {{ $folder['total_documents'] }} accessible
                                                </p>
                                            @endif
                                        </div>

                                        <!-- Permissions -->
                                        @if(!$folder['is_locked'])
                                            <div class="permissions-badges">
                                                @if($folder['can_add'])
                                                    <span class="badge badge-sm bg-gradient-success me-1">
                                                        <i class="fas fa-plus"></i> Add
                                                    </span>
                                                @endif
                                                @if($folder['can_view'])
                                                    <span class="badge badge-sm bg-gradient-primary me-1">
                                                        <i class="fas fa-eye"></i> View
                                                    </span>
                                                @endif
                                                @if($folder['can_edit'])
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </span>
                                                @endif
                                            </div>
                                        @endif

                                        <!-- Action Button -->
                                        <div class="mt-3">
                                            @if($folder['is_locked'])
                                                <button class="btn btn-sm btn-outline-danger" disabled>
                                                    <i class="fas fa-lock"></i> Locked
                                                </button>
                                            @else
                                                <a href="{{ route('user.documents.category', $folder['category']) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-folder-open"></i> Open Folder
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p class="mb-0">No document folders available.</p>
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
    cursor: pointer;
    transition: transform 0.3s ease;
}

.folder-card:not(.locked):hover {
    transform: translateY(-5px);
}

.folder-card.locked {
    cursor: not-allowed;
    opacity: 0.7;
}

.folder-icon {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.card {
    border-width: 2px;
    transition: all 0.3s ease;
}

.folder-card:not(.locked) .card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.permissions-badges {
    min-height: 24px;
}
</style>

<script>
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
