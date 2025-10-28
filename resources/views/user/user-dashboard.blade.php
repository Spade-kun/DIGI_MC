@extends('layouts.dashboard')

@section('header')
<div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('../assets/img/curved-images/curved14.jpg'); background-position-y: 50%;">
    <span class="mask bg-gradient-success opacity-6"></span>
</div>
<div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
    <div class="row gx-4">
        <div class="col-auto">
            <div class="avatar avatar-xl position-relative">
                <img src="../assets/img/team-1.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
            </div>
        </div>
        <div class="col-auto my-auto">
            <div class="h-100">
                <h5 class="mb-1">
                    {{ Auth::user()->name }}
                </h5>
                <p class="mb-0 font-weight-bold text-sm">
                    Member
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Account Status</p>
                            <h5 class="font-weight-bolder mb-0">
                                <span class="text-success">Active</span>
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
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Member Since</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ Auth::user()->created_at->format('M Y') }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                            <i class="ni ni-badge text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Last Login</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ now()->format('M d, Y') }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                            <i class="ni ni-clock-2 text-lg opacity-10" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-lg-8 mb-lg-0 mb-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0">Your Activity</h6>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end align-items-center">
                        <i class="far fa-calendar-alt me-2"></i>
                        <small>Last 30 days</small>
                    </div>
                </div>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Profile Updated</h6>
                                <span class="text-xs">22 DEC 7:20 PM</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-success text-gradient text-sm font-weight-bold">
                            Completed
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button class="btn btn-icon-only btn-rounded btn-outline-info mb-0 me-3 btn-sm d-flex align-items-center justify-content-center">
                                <i class="fas fa-sync"></i>
                            </button>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">System Update</h6>
                                <span class="text-xs">21 DEC 11:01 AM</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center text-info text-gradient text-sm font-weight-bold">
                            In Progress
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header pb-0 p-3">
                <div class="row">
                    <div class="col-6 d-flex align-items-center">
                        <h6 class="mb-0">Quick Access</h6>
                    </div>
                </div>
            </div>
            <div class="card-body p-3 pb-0">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Profile Settings</h6>
                            <span class="text-xs">Edit your personal information</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                                <i class="fas fa-pencil-alt text-dark ms-2"></i>
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-1 text-dark font-weight-bold text-sm">Security Settings</h6>
                            <span class="text-xs">Manage your account security</span>
                        </div>
                        <div class="d-flex align-items-center text-sm">
                            <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4">
                                <i class="fas fa-shield-alt text-dark ms-2"></i>
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
