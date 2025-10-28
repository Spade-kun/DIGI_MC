@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
    <span class="mask bg-gradient-primary opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <img src="../assets/img/bruce-mars.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    Pending Registrations
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Manage User Registration Requests
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Pending Registration Requests</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Registration Date</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->created_at->format('M d, Y H:i') }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('admin.registrations.approve', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link text-success text-gradient px-3 mb-0">
                                            <i class="fas fa-check me-2"></i>Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.registrations.reject', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                            <i class="fas fa-times me-2"></i>Reject
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">
                                    <p class="text-sm font-weight-bold mb-0">No pending registration requests</p>
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

<!-- Notification for success message -->
@if(session('success'))
<div class="position-fixed bottom-1 end-1 z-index-2">
    <div class="toast fade show p-2 bg-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header border-0">
            <i class="ni ni-check-bold text-success me-2"></i>
            <span class="me-auto font-weight-bold">Success</span>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="position-fixed bottom-1 end-1 z-index-2">
    <div class="toast fade show p-2 bg-white" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header border-0">
            <i class="ni ni-fat-remove text-danger me-2"></i>
            <span class="me-auto font-weight-bold">Error</span>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('error') }}
        </div>
    </div>
</div>
@endif

<script>
    // Auto-hide toast after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() {
                    toast.remove();
                }, 150);
            }, 5000);
        });
    });
</script>

<style>
    .toast {
        min-width: 300px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }
    .z-index-2 {
        z-index: 1050;
    }
</style>
@endsection