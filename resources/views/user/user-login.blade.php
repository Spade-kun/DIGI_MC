<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>User Login - {{ config('app.name', 'Laravel') }}</title>
  
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="">
  <div class="container position-sticky z-index-sticky top-0">
    <div class="row">
      <div class="col-12">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg blur blur-rounded top-0 z-index-3 shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
          <div class="container-fluid pe-0">
            <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3" href="{{ route('user.login') }}">
             {{ config('app.name', 'Laravel') }} User
            </a>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>
    </div>
  </div>
  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">User Login</h3>
                  <p class="mb-0">Sign in with your Google account</p>
                </div>
                <div class="card-body">
                  <!-- Success Alert -->
                  @if(session('success'))
                  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <div class="d-flex align-items-center">
                      <span class="alert-icon me-3"><i class="fas fa-check-circle fa-2x"></i></span>
                      <div>
                        <span class="alert-text d-block"><strong>Success!</strong></span>
                        <span class="alert-text text-sm">{{ session('success') }}</span>
                      </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  <!-- Error Alert -->
                  @if(session('error'))
                  <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <div class="d-flex align-items-center">
                      <span class="alert-icon me-3"><i class="fas fa-exclamation-circle fa-2x"></i></span>
                      <div>
                        <span class="alert-text d-block"><strong>Error!</strong></span>
                        <span class="alert-text text-sm">{{ session('error') }}</span>
                      </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  <!-- Success Alert for Registration -->
                  @if(session('status'))
                  <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                    <div class="d-flex align-items-center">
                      <span class="alert-icon me-3"><i class="fas fa-check-circle fa-2x"></i></span>
                      <div>
                        <span class="alert-text d-block"><strong>Registration Successful!</strong></span>
                        <span class="alert-text text-sm">{{ session('status') }}</span>
                      </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  @endif

                  <!-- Google Login Button -->
                  <div class="text-center my-4">
                    <a href="{{ route('google.redirect') }}" class="btn btn-lg bg-gradient-info w-100 mb-0 google-btn">
                      <i class="fab fa-google me-2"></i>
                      Sign in with Google
                    </a>
                  </div>

                  <div class="text-center my-3">
                    <div class="d-flex align-items-center justify-content-center">
                      <div class="border-top flex-grow-1"></div>
                      <span class="px-3 text-sm text-muted">Secure Login</span>
                      <div class="border-top flex-grow-1"></div>
                    </div>
                  </div>

                  <div class="text-center">
                    <div class="alert alert-light mb-0" role="alert">
                      <i class="fas fa-shield-alt text-info me-1"></i>
                      <span class="text-sm">Only approved users can sign in</span>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="mb-4 text-sm mx-auto">
                    Don't have an account?
                    <a href="{{ route('user.register') }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" 
                  style="background-image:url('{{ asset('assets/img/curved-images/curved6.jpg') }}')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- Footer -->
  <footer class="footer py-5">
    <div class="container">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>document.write(new Date().getFullYear())</script> {{ config('app.name', 'Laravel') }}
          </p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Core JS Files -->
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
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
  
  <style>
    .alert {
      border-radius: 0.75rem;
      animation: slideInDown 0.5s ease-out;
    }
    @keyframes slideInDown {
      from {
        transform: translateY(-20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    .alert-icon i {
      color: #82d616;
    }
    .alert-danger .alert-icon i {
      color: #ea0606;
    }
    .btn-lg {
      padding: 15px 30px;
      font-size: 1rem;
      border-radius: 0.75rem;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(50, 50, 93, 0.11), 0 1px 3px rgba(0, 0, 0, 0.08);
    }
    .google-btn {
      position: relative;
      overflow: hidden;
    }
    .google-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    .google-btn:hover::before {
      width: 300px;
      height: 300px;
    }
    .google-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }
    .btn-lg i {
      font-size: 1.2rem;
      position: relative;
      z-index: 1;
    }
    .alert-light {
      background-color: #f8f9fa;
      border: 1px solid #e9ecef;
    }
  </style>
</body>
</html>