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
                    {{ Auth::guard('admin')->user()->name }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Administrator
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Users</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ \App\Models\User::count() }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-single-02 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <a href="{{ route('admin.registrations.pending') }}" class="text-decoration-none">
            <div class="card hover-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Pending Users</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ \App\Models\User::where('status', 'pending')->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-time-alarm text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <a href="{{ route('admin.registrations.approved') }}" class="text-decoration-none">
            <div class="card hover-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Approved Users</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ \App\Models\User::where('status', 'approved')->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <a href="{{ route('admin.registrations.rejected') }}" class="text-decoration-none">
            <div class="card hover-card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Rejected Users</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ \App\Models\User::where('status', 'rejected')->count() }}
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                <i class="ni ni-fat-remove text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
                <h6 class="text-capitalize">System Overview</h6>
                <p class="text-sm mb-0">
                    <i class="fa fa-arrow-up text-success"></i>
                    <span class="font-weight-bold">4% more</span> in 2025
                </p>
            </div>
            <div class="card-body p-3">
                <div class="chart" style="height: 300px;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <!-- Add your chart here -->
                    <div class="bg-gradient-primary opacity-3 w-100 h-100 border-radius-lg"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-primary shadow text-center">
                                <i class="ni ni-mobile-button text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Manage Users</h6>
                                <span class="text-xs">View and manage user accounts</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                <i class="ni ni-bold-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-success shadow text-center">
                                <i class="ni ni-settings text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">System Settings</h6>
                                <span class="text-xs">Configure system parameters</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                <i class="ni ni-bold-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-warning shadow text-center">
                                <i class="ni ni-single-copy-04 text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Pending Registrations</h6>
                                <span class="text-xs">{{ \App\Models\User::where('status', 'pending')->count() }} requests waiting</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('admin.registrations.pending') }}" class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                <i class="ni ni-bold-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                                <i class="ni ni-chart-bar-32 text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">View Reports</h6>
                                <span class="text-xs">Access system analytics</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                <i class="ni ni-bold-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
.hover-card {
    transition: transform 0.3s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection