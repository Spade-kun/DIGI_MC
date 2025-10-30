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

@push('styles')
<!-- DataTables Bootstrap 5 styling -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
<!-- DataTables & Plugins -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#documentsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('admin.documents.data') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'category', name: 'category'},
            {data: 'date', name: 'date_issued'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false},
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {
                    return moment(data).format('YYYY-MM-DD HH:mm');
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"<"d-flex align-items-center"l><"d-flex"f>>rt<"d-flex justify-content-between align-items-center"<"d-flex align-items-center"i><"d-flex"p>>',
        buttons: [
            {
                extend: 'collection',
                text: '<i class="fas fa-download"></i> Export',
                className: 'btn-primary',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records",
            lengthMenu: "_MENU_ records per page",
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            paginate: {
                first: '<i class="fas fa-angle-double-left"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
                next: '<i class="fas fa-angle-right"></i>',
                last: '<i class="fas fa-angle-double-right"></i>'
            }
        }
    });
});
</script>
@endpush
@endsection

@section('content')
<div class="row mt-4">
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card hover-card">
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-8">
                        <div class="numbers">
                            <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Total Documents</p>
                            <h5 class="font-weight-bolder mb-0">
                                {{ number_format(\App\Models\AdminDocument::count()) }}
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
                                <p class="text-sm mb-0 text-capitalize font-weight-bold opacity-7">Documents This Month</p>
                                <h5 class="font-weight-bolder mb-0">
                                    {{ number_format(\App\Models\AdminDocument::whereMonth('created_at', now()->month)->count()) }}
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
    <div class="col-12">
        <div class="card">
            <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Search Documents</h6>
            </div>
            <div class="card-body p-3">
                <div class="mb-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search documents..." id="documentSearch">
                    </div>
                </div>

                <h6 class="mb-3">Suggested Document Types</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card hover-card">
                            <div class="card-body">
                                <h6 class="card-title">Memorandum of Agreements</h6>
                                <p class="card-text text-xs text-muted">Suggested Document Types</p>
                                <small class="text-success">200 accessed this week</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card hover-card border border-primary">
                            <div class="card-body">
                                <h6 class="card-title">Memorandum of Agreements</h6>
                                <p class="card-text text-xs text-muted">Suggested Document Types</p>
                                <small class="text-success">200 accessed this week</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card hover-card">
                            <div class="card-body">
                                <h6 class="card-title">Memorandum of Agreements</h6>
                                <p class="card-text text-xs text-muted">Suggested Document Types</p>
                                <small class="text-success">200 accessed this week</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card hover-card">
                            <div class="card-body">
                                <h6 class="card-title">Memorandum of Agreements</h6>
                                <p class="card-text text-xs text-muted">Suggested Document Types</p>
                                <small class="text-success">200 accessed this week</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row mt-4">
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
                                <h6 class="mb-1 text-dark text-sm">Upload Document</h6>
                                <span class="text-xs">Add new documents to the system</span>
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
                                <h6 class="mb-1 text-dark text-sm">Document Categories</h6>
                                <span class="text-xs">Manage document categories</span>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto">
                                <i class="ni ni-bold-right" aria-hidden="true"></i>
                            </button>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape icon-sm me-3 bg-gradient-info shadow text-center">
                                <i class="ni ni-chart-bar-32 text-white opacity-10"></i>
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">Document Reports</h6>
                                <span class="text-xs">Generate document analytics</span>
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
</div> -->

<style>
.hover-card {
    transition: transform 0.3s ease-in-out;
}
.hover-card:hover {
    transform: translateY(-5px);
}
</style>
@endsection