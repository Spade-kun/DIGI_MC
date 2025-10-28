<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>User Registration - {{ config('app.name', 'Laravel') }}</title>
  
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
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg position-absolute top-0 z-index-3 w-100 shadow-none my-3 navbar-transparent mt-4">
    <div class="container">
      <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 text-white" href="{{ route('dashboard') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
    </div>
  </nav>
  <!-- End Navbar -->
  <main class="main-content mt-0">
    <section class="min-vh-100 mb-8">
      <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('{{ asset('assets/img/curved-images/curved14.jpg') }}');">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-5 text-center mx-auto">
              <h1 class="text-white mb-2 mt-5">Welcome!</h1>
              <p class="text-lead text-white">Create your account and join us today.</p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10">
          <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
            <div class="card z-index-0">
              <div class="card-header text-center pt-4">
                <h5>Register</h5>
              </div>
              <div class="card-body">
                <!-- Error Messages -->
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <span class="alert-icon"><i class="ni ni-fat-remove"></i></span>
                  <span class="alert-text">
                    <strong>Oops!</strong> Please fix the following errors:
                    <ul class="mb-0 mt-2">
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </span>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif

                <form role="form text-left" method="POST" action="{{ route('user.register') }}" id="registrationForm">
                  @csrf
                  <div class="mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                      name="name" placeholder="Name" value="{{ old('name') }}" required>
                    @error('name')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                      name="email" placeholder="Email" value="{{ old('email') }}" required>
                    @error('email')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                      name="password" placeholder="Password" required>
                    @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                    @enderror
                  </div>
                  <div class="mb-3">
                    <input type="password" class="form-control" 
                      name="password_confirmation" placeholder="Confirm Password" required>
                  </div>
                  <div class="form-check form-check-info text-left">
                    <input class="form-check-input" type="checkbox" name="terms" id="flexCheckDefault" required>
                    <label class="form-check-label" for="flexCheckDefault">
                      I agree the <a href="javascript:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                    </label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
                  </div>
                  <p class="text-sm mt-3 mb-0">Already have an account? <a href="{{ route('user.login') }}" class="text-dark font-weight-bolder">Sign in</a></p>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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
  </main>

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-success">
          <h5 class="modal-title text-white" id="successModalLabel">
            <i class="fas fa-check-circle me-2"></i>Registration Successful!
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center py-4">
          <div class="mb-3">
            <i class="fas fa-hourglass-half text-warning" style="font-size: 4rem;"></i>
          </div>
          <h5 class="text-dark mb-3">
            @if(session('user_name'))
              Welcome, {{ session('user_name') }}!
            @else
              Your Account is Pending Approval
            @endif
          </h5>
          <p class="text-sm text-secondary mb-0">
            Thank you for registering! Your account has been created successfully and is currently pending admin approval. 
            You will be able to log in once an administrator approves your registration.
          </p>
          <div class="alert alert-info mt-3 mb-0" role="alert">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Please wait for approval notification</strong>
          </div>
        </div>
        <div class="modal-footer">
          <a href="{{ route('user.login') }}" class="btn bg-gradient-primary w-100">Go to Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <style>
    .alert ul {
      padding-left: 20px;
    }
    .alert ul li {
      font-size: 0.875rem;
    }
    .modal-content {
      border: none;
      border-radius: 1rem;
      overflow: hidden;
      animation: slideDown 0.5s ease-out;
    }
    .modal-header {
      border-bottom: none;
      padding: 1.5rem;
    }
    .modal-footer {
      border-top: none;
      padding: 1.5rem;
    }
    @keyframes slideDown {
      from {
        transform: translateY(-100px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }
    .fa-hourglass-half {
      animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
      0%, 100% {
        transform: scale(1);
        opacity: 1;
      }
      50% {
        transform: scale(1.1);
        opacity: 0.8;
      }
    }
  </style>

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
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
  
  <!-- Show success modal if registration was successful -->
  @if(session('registration_success'))
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var successModal = new bootstrap.Modal(document.getElementById('successModal'));
      successModal.show();
      
      // Clear the form
      document.getElementById('registrationForm').reset();
    });
  </script>
  @endif
</body>
</html>