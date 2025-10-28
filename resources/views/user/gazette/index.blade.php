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
                    <i class="ni ni-book-bookmark text-white text-lg opacity-10"></i>
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    Official Gazette
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Browse official publications and documents
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    @forelse($gazettesByCategory as $category => $gazettes)
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="text-uppercase text-gradient text-primary font-weight-bold mb-3">
                    <i class="ni ni-collection"></i> {{ $category }}
                </h4>
            </div>
        </div>
        
        <div class="row mb-5">
            @foreach($gazettes as $gazette)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card gazette-card h-100">
                        <div class="card-body p-3 d-flex flex-column">
                            <!-- Category Badge -->
                            <div class="text-center mb-3">
                                <span class="badge badge-lg bg-gradient-warning text-white mb-2">
                                    {{ $category }}
                                </span>
                            </div>
                            
                            <!-- Icon -->
                            <div class="text-center mb-3">
                                <div class="icon icon-shape icon-xxl bg-gradient-primary shadow text-center border-radius-lg">
                                    <i class="ni ni-single-copy-04 text-white text-lg opacity-10"></i>
                                </div>
                            </div>
                            
                            <!-- Title -->
                            <div class="text-center mb-3 flex-grow-1">
                                <h6 class="mb-0">{{ $gazette->title }}</h6>
                                <p class="text-xs text-muted mt-1">
                                    <i class="ni ni-calendar-grid-58"></i> 
                                    {{ $gazette->created_at->format('M d, Y') }}
                                </p>
                            </div>
                            
                            <!-- View Button -->
                            <div class="text-center mt-auto">
                                <a href="{{ route('user.gazette.show', $gazette->id) }}" 
                                   class="btn btn-primary btn-sm w-100">
                                    <i class="ni ni-bold-right"></i> View Document
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @empty
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="ni ni-folder-17 text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No Gazette Documents Available</h5>
                        <p class="text-sm text-muted">Check back later for official publications.</p>
                    </div>
                </div>
            </div>
        </div>
    @endforelse
</div>

<style>
.gazette-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
    cursor: pointer;
}

.gazette-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border-color: #5e72e4;
}

.icon-xxl {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.badge-lg {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.text-gradient {
    background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>
@endsection
