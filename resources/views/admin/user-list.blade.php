@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('{{ asset('assets/img/curved-images/curved0.jpg') }}'); background-position-y: 50%;">
    <span class="mask bg-gradient-{{ $type === 'pending' ? 'warning' : ($type === 'approved' ? 'success' : 'danger') }} opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <div class="icon icon-shape icon-xxl bg-gradient-{{ $type === 'pending' ? 'warning' : ($type === 'approved' ? 'success' : 'danger') }} shadow text-center border-radius-xl">
                    <i class="ni {{ $type === 'pending' ? 'ni-time-alarm' : ($type === 'approved' ? 'ni-check-bold' : 'ni-fat-remove') }} text-lg opacity-10 text-white" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    {{ $title }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    {{ $users->count() }} {{ $users->count() === 1 ? 'user' : 'users' }} found
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
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h6>{{ $title }} List</h6>
                <div class="d-flex gap-2">
                    <span class="badge badge-sm bg-gradient-{{ $type === 'pending' ? 'warning' : ($type === 'approved' ? 'success' : 'danger') }}">
                        {{ ucfirst($type) }}
                    </span>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Registration Date</th>
                                @if($type !== 'approved')
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        <div>
                                            <div class="avatar avatar-sm me-3 bg-gradient-{{ $type === 'pending' ? 'warning' : ($type === 'approved' ? 'success' : 'danger') }}">
                                                <span class="text-white text-xs">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">ID: {{ $user->id }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <span class="badge badge-sm bg-gradient-{{ $user->status === 'pending' ? 'warning' : ($user->status === 'approved' ? 'success' : 'danger') }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">{{ $user->created_at->format('M d, Y') }}</span>
                                    <br>
                                    <span class="text-secondary text-xs">{{ $user->created_at->format('h:i A') }}</span>
                                </td>
                                @if($type !== 'approved')
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        @if($type === 'pending')
                                        <form action="{{ route('admin.registrations.approve', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm mb-0" title="Approve User">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.registrations.reject', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm mb-0" title="Reject User">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                        @elseif($type === 'rejected')
                                        <form action="{{ route('admin.registrations.approve', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm mb-0" title="Approve User">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ $type !== 'approved' ? '5' : '4' }}" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ni ni-folder-17 text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-sm font-weight-bold mb-0 mt-2">No {{ $type }} users found</p>
                                        <p class="text-xs text-secondary mb-0">There are currently no users with {{ $type }} status.</p>
                                    </div>
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

<!-- Success Message Toast -->
@if(session('success'))
<div class="position-fixed top-1 end-1 z-index-2" style="z-index: 9999;">
    <div class="toast fade show p-2 bg-white" role="alert" aria-live="assertive" id="successToast" aria-atomic="true">
        <div class="toast-header bg-transparent border-0">
            <i class="ni ni-check-bold text-success me-2"></i>
            <span class="me-auto font-weight-bold">Success</span>
            <small class="text-muted">Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var toastElement = document.getElementById('successToast');
            if(toastElement) {
                var toast = new bootstrap.Toast(toastElement, { delay: 5000 });
                toast.show();
            }
        }, 100);
    });
</script>
@endif

<style>
.table tbody tr {
    transition: background-color 0.2s ease;
}
.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}
.btn-sm {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}
.gap-2 {
    gap: 0.5rem;
}
</style>
@endsection
