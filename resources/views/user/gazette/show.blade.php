@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
    <span class="mask bg-gradient-warning opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <div class="icon icon-shape icon-xl bg-gradient-warning text-center rounded-circle">
                    <i class="ni ni-single-copy-04 text-white text-lg opacity-10"></i>
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    {{ $gazette->title }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    <span class="badge bg-gradient-info">{{ $gazette->category }}</span>
                </p>
            </div>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{ route('user.gazette.index') }}" class="btn btn-sm btn-secondary">
                <i class="ni ni-bold-left"></i> Back to Gazette
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0">{{ $gazette->title }}</h6>
                            <p class="text-sm mb-0">
                                <i class="ni ni-calendar-grid-58 text-primary"></i> 
                                Published on {{ $gazette->created_at->format('F d, Y') }}
                            </p>
                        </div>
                        <div>
                            <a href="{{ asset('storage/' . $gazette->file_path) }}" 
                               download="{{ $gazette->file_name }}"
                               class="btn btn-success btn-sm">
                                <i class="ni ni-cloud-download-95"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $fileExtension = pathinfo($gazette->file_path, PATHINFO_EXTENSION);
                    @endphp
                    
                    @if(strtolower($fileExtension) === 'pdf')
                        <!-- Embedded PDF Viewer -->
                        <div class="pdf-viewer-container">
                            <iframe src="{{ asset('storage/' . $gazette->file_path) }}" 
                                    class="pdf-viewer"
                                    frameborder="0">
                                <p>Your browser does not support PDFs. 
                                   <a href="{{ asset('storage/' . $gazette->file_path) }}" download>Download the PDF</a>
                                </p>
                            </iframe>
                        </div>
                    @else
                        <!-- For DOC/DOCX files -->
                        <div class="p-5 text-center">
                            <i class="ni ni-single-copy-04 text-primary" style="font-size: 4rem;"></i>
                            <h5 class="mt-3">Document File</h5>
                            <p class="text-muted">{{ $gazette->file_name }}</p>
                            <p class="text-sm text-muted mb-4">
                                This document format cannot be previewed in the browser.
                            </p>
                            <a href="{{ asset('storage/' . $gazette->file_path) }}" 
                               download="{{ $gazette->file_name }}"
                               class="btn btn-primary">
                                <i class="ni ni-cloud-download-95"></i> Download Document
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pdf-viewer-container {
    width: 100%;
    height: 800px;
    position: relative;
    background-color: #525659;
}

.pdf-viewer {
    width: 100%;
    height: 100%;
}

@media (max-width: 768px) {
    .pdf-viewer-container {
        height: 600px;
    }
}
</style>
@endsection
