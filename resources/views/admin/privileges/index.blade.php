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
                    User Folder Privileges
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Manage user access to Google Drive folders
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
                    <div class="d-lg-flex">
                        <div>
                            <h5 class="mb-0">Users List</h5>
                            <p class="text-sm mb-0">
                                Click on a user to manage their folder access privileges
                            </p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-flush" id="users-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Folders Access</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $user->email }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">
                                                {{ $user->folderPrivileges->count() }} folder(s)
                                            </span>
                                            <span class="badge badge-sm bg-gradient-success">
                                                {{ $user->folderPrivileges->where('can_access', true)->count() }} accessible
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="{{ route('admin.privileges.edit', $user) }}" 
                                               class="btn btn-link text-secondary mb-0">
                                                <i class="fa fa-edit text-xs"></i> Manage Access
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p class="text-sm mb-0">No approved users found.</p>
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
</div>
@endsection

@push('scripts')
<script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
@endpush
