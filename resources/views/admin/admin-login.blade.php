<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>User Login - {{ config('app.name', 'Laravel') }}</title>
  
  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #1a1a1a;
      overflow-x: hidden;
    }

    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
      background: #e8e8e8;
    }

    /* Purple Wave Decorations */
    .wave-decoration {
      position: absolute;
      z-index: 1;
    }

    .wave-top-left {
      top: 0;
      left: 0;
      width: 470px;
      height: 395px;
      background-image: url("{{ asset('Top-left.svg') }}");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: top left;
    }

    .wave-bottom-right {
      bottom: 0;
      right: 0;
      width: 470px;
      height: 395px;
      background-image: url("{{ asset('Bottom-Right.svg') }}");
      background-size: cover;
      background-repeat: no-repeat;
      background-position: bottom right;
    }

    /* Centered Login Card */
    .login-card {
      background: white;
      border-radius: 25px;
      padding: 3rem 3.5rem;
      width: 100%;
      max-width: 420px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      position: relative;
      z-index: 2;
      text-align: center;
      animation: fadeIn 1s ease-out;
    }

    /* Logo */
    .logo-container {
      margin-bottom: 1.5rem;
    }

    .logo-container img {
      width: 180px;
      height: auto;
      animation: float 3s ease-in-out infinite;
    }

    /* Logo Text */
    .logo-text {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 2.5rem;
      background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 50%, #f59e0b 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: 0.5px;
    }

    /* Login Button */
    .login-btn {
      width: 100%;
      padding: 0.85rem 2rem;
      background: white;
      color: #4b5563;
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      font-size: 0.95rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      text-decoration: none;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .login-btn:hover {
      background: #f9fafb;
      border-color: #d1d5db;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .login-btn i {
      font-size: 1.1rem;
      color: #4285f4;
    }

    /* Alerts */
    .alert {
      padding: 1rem 1.25rem;
      border-radius: 15px;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      animation: slideInDown 0.5s ease-out;
      border: none;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
    }

    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
    }

    .alert i {
      font-size: 1.5rem;
    }

    .alert-close {
      margin-left: auto;
      background: none;
      border: none;
      font-size: 1.5rem;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 0.3s;
    }

    .alert-close:hover {
      opacity: 1;
    }

    /* Animations */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: scale(0.95);
      }
      to {
        opacity: 1;
        transform: scale(1);
      }
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

    @keyframes float {
      0%, 100% {
        transform: translateY(0px);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    /* Responsive Design */
    @media (max-width: 968px) {
      .wave-top-left {
        width: 250px;
        height: 210px;
      }

      .wave-bottom-right {
        width: 300px;
        height: 250px;
      }

      .login-card {
        padding: 2.5rem 2rem;
        max-width: 380px;
      }

      .logo-container img {
        width: 150px;
      }

      .logo-text {
        font-size: 1.75rem;
      }
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 2rem 1.5rem;
        max-width: 340px;
        margin: 1rem;
      }

      .logo-container img {
        width: 130px;
      }

      .logo-text {
        font-size: 1.5rem;
      }

      .wave-top-left {
        width: 180px;
        height: 150px;
      }

      .wave-bottom-right {
        width: 220px;
        height: 180px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <!-- Purple Wave Decorations -->
    <div class="wave-decoration wave-top-left"></div>
    <div class="wave-decoration wave-bottom-right"></div>

    <!-- Centered Login Card -->
    <div class="login-card">
      <!-- Success Alert -->
      @if(session('success'))
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <div>
          <strong>Success!</strong><br>
          <span style="font-size: 0.9rem;">{{ session('success') }}</span>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
      </div>
      @endif

      <!-- Error Alert -->
      @if(session('error'))
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div>
          <strong>Error!</strong><br>
          <span style="font-size: 0.9rem;">{{ session('error') }}</span>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
      </div>
      @endif

      <!-- Success Alert for Registration -->
      @if(session('status'))
      <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <div>
          <strong>Registration Successful!</strong><br>
          <span style="font-size: 0.9rem;">{{ session('status') }}</span>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
      </div>
      @endif

        <!-- Logo -->
      <div class="logo-container">
        <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Malaybalay Logo">
        
      </div>

      <!-- Logo Text -->
      <img src="{{ asset('LegalitEase.png') }}" alt="LegalitEase Logo" style="width: 200px; height: auto; margin-bottom:2px;">


      <!-- Login Form -->
      <form method="POST" action="{{ route('admin.login') }}" class="mt-4">
        @csrf
        
        <!-- Email Input -->
        <div class="mb-4">
          <input type="email" 
                 name="email" 
                 id="email" 
                 value="{{ old('email') }}"
                 required 
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                 placeholder="Enter your email"
                 style="width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 10px; outline: none; transition: all 0.3s ease;">
          @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
<br
        <!-- Password Input -->
        <div class="mb-4">
          <input type="password" 
                 name="password" 
                 id="password" 
                 required 
                 class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                 placeholder="Enter your password"
                 style="width: 100%; padding: 12px 16px; border: 1px solid #e5e7eb; border-radius: 10px; outline: none; transition: all 0.3s ease;">
          @error('password')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="login-btn" 
                style="background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%); color: white; border: none; margin-top: 1rem;">
          <i class="fas fa-sign-in-alt"></i>
          Login as Admin
        </button>
      </form>

    </div>
  </div>

  <!-- Core JS Files -->
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js') }}"></script>
</body>
</html>