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
                    <i class="fa fa-folder-open text-warning"></i>
                    {{ $folder['name'] }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Browse folder contents
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

    <!-- Breadcrumb / Navigation -->
    <div class="row mb-3">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('user.documents.index') }}" class="text-dark">
                            <i class="fa fa-home"></i> My Documents
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $folder['name'] }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Subfolders Section -->
    @if($subfolders->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">
                            <i class="fa fa-folder text-warning"></i> Folders
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($subfolders as $subfolder)
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                                    <div class="card folder-item">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <i class="fa fa-folder fa-2x text-warning me-3"></i>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 text-sm">{{ $subfolder['name'] }}</h6>
                                                    <p class="text-xs text-muted mb-0">Folder</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Files Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fa fa-file text-info"></i> Files
                        </h6>
                        <span class="text-sm text-muted">
                            {{ $documents->count() }} file(s)
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    @if($documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">File Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Size</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Modified</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    @if($document['icon'])
                                                        <img src="{{ $document['icon'] }}" class="me-3" width="20" height="20" alt="icon">
                                                    @else
                                                        <i class="fa fa-file me-3"></i>
                                                    @endif
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $document['name'] }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $document['mime_type'] ? basename($document['mime_type']) : 'Unknown' }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ $document['size'] ? number_format($document['size'] / 1024, 2) . ' KB' : '-' }}
                                                </p>
                                            </td>
                                            <td>
                                                <span class="text-xs">
                                                    {{ $document['modified_at'] ? \Carbon\Carbon::parse($document['modified_at'])->format('M d, Y H:i') : '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($document['web_view_link'])
                                                    <a href="{{ $document['web_view_link'] }}" 
                                                       target="_blank" 
                                                       class="btn btn-link text-primary text-gradient px-3 mb-0">
                                                        <i class="fa fa-external-link-alt text-xs me-1"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-xs text-muted">No preview</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fa fa-info-circle"></i>
                            This folder is empty.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .folder-item {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .folder-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endpush
