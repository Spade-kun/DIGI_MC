@extends('layouts.dashboard')

@section('header', 'Documents Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0">
                <div>
                    <h6>Document Folders</h6>
                    <p class="text-sm mb-0">Browse documents by category</p>
                </div>
            </div>
            <div class="card-body px-4 pt-4 pb-2">
                <div class="row">
                    <!-- Republic Act Folder -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="{{ route('admin.documents.category', 'Republic Act') }}" class="text-decoration-none">
                            <div class="card folder-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="icon-shape bg-gradient-primary shadow mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-folder fa-3x text-white"></i>
                                    </div>
                                    <h5 class="mb-2">Republic Act</h5>
                                    <p class="text-sm text-secondary mb-0">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                        {{ $categories['Republic Act'] }} {{ $categories['Republic Act'] == 1 ? 'document' : 'documents' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Memorandum Folder -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="{{ route('admin.documents.category', 'Memorandum') }}" class="text-decoration-none">
                            <div class="card folder-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="icon-shape bg-gradient-info shadow mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-folder fa-3x text-white"></i>
                                    </div>
                                    <h5 class="mb-2">Memorandum</h5>
                                    <p class="text-sm text-secondary mb-0">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                        {{ $categories['Memorandum'] }} {{ $categories['Memorandum'] == 1 ? 'document' : 'documents' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Proclamations Folder -->
                    <div class="col-lg-4 col-md-6 col-12 mb-4">
                        <a href="{{ route('admin.documents.category', 'Proclamations') }}" class="text-decoration-none">
                            <div class="card folder-card h-100">
                                <div class="card-body text-center p-4">
                                    <div class="icon-shape bg-gradient-success shadow mx-auto mb-3" style="width: 80px; height: 80px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-folder fa-3x text-white"></i>
                                    </div>
                                    <h5 class="mb-2">Proclamations</h5>
                                    <p class="text-sm text-secondary mb-0">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                        {{ $categories['Proclamations'] }} {{ $categories['Proclamations'] == 1 ? 'document' : 'documents' }}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.folder-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
    cursor: pointer;
}

.folder-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    border-color: #5e72e4;
}

.icon-shape {
    transition: all 0.3s ease;
}

.folder-card:hover .icon-shape {
    transform: scale(1.1);
}
</style>
@endsection
