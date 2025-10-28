@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
    <span class="mask bg-gradient-primary opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <img src="{{ asset('assets/img/bruce-mars.jpg') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    My Documents
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Access your Google Drive folders
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
                            <h6 class="mb-0">Available Folders</h6>
                            <p class="text-sm mb-0">
                                <i class="fa fa-folder"></i> 
                                All folders from your Google Drive
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse($folders as $folder)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                                <div class="card folder-card" data-folder-id="{{ $folder['id'] }}">
                                    <div class="card-body p-3">
                                        <div class="text-center mb-3">
                                            <div class="folder-icon-wrapper">
                                                <i class="fa fa-folder fa-4x text-warning"></i>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <h6 class="mb-2">
                                                {{ $folder['name'] }}
                                            </h6>
                                            <a href="{{ route('user.documents.show', $folder['id']) }}" 
                                               class="btn btn-sm btn-primary w-100">
                                                <i class="fa fa-folder-open"></i> Open Folder
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="fa fa-info-circle"></i>
                                    No folders found in your Google Drive.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .folder-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        cursor: pointer;
    }
    
    .folder-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-color: #5e72e4;
    }
    
    .folder-icon-wrapper {
        position: relative;
        display: inline-block;
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
