<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    {{ config('app.name', 'Laravel') }}
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#">
        <img src="{{ asset('assets/img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold">{{ config('app.name', 'Laravel') }}</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          @if(Auth::guard('admin')->check())
          <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
          @else
          <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          @endif
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        @if(Auth::guard('web')->check())
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('user.documents.*') ? 'active' : '' }}" href="{{ route('user.documents.index') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-folder-17 text-info text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Documents</span>
          </a>
        </li>
        @endif
        @if(Auth::guard('admin')->check())
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">User Management</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.registrations.pending') ? 'active' : '' }}" href="{{ route('admin.registrations.pending') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-time-alarm text-warning text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Pending Users</span>
            @if($pendingCount = \App\Models\User::where('status', 'pending')->count())
            <span class="badge badge-sm bg-gradient-warning ms-auto">{{ $pendingCount }}</span>
            @endif
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.registrations.approved') ? 'active' : '' }}" href="{{ route('admin.registrations.approved') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-check-bold text-success text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Approved Users</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('admin.registrations.rejected') ? 'active' : '' }}" href="{{ route('admin.registrations.rejected') }}">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-fat-remove text-danger text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Rejected Users</span>
          </a>
        </li>
        @endif
      </ul>
    </div>
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">@yield('header')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              @if(Auth::guard('admin')->check())
              <form method="POST" action="{{ route('admin.logout') }}">
              @else
              <form method="POST" action="{{ route('user.logout') }}">
              @endif
                @csrf
                <button type="submit" class="nav-link text-body font-weight-bold px-0 border-0 bg-transparent">
                  <i class="fa fa-user me-sm-1"></i>
                  <span class="d-sm-inline d-none">Sign Out</span>
                </button>
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    <div class="container-fluid py-4">
      @yield('content')
      
      <footer class="footer pt-3">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>
                {{ config('app.name', 'Laravel') }}
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Control Center for Soft Dashboard -->
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>

</html>