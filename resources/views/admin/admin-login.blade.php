<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>
  
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
      padding: 2.5rem 3rem;
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
      margin-bottom: 1rem;
    }

    .logo-container img {
      width: 140px;
      height: auto;
      animation: float 3s ease-in-out infinite;
    }

    /* Logo Text */
    .logo-text {
      font-size: 1.8rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      letter-spacing: 1px;
    }

    .logo-text .legal {
      color: #6b21a8;
    }

    .logo-text .it {
      color: #f59e0b;
    }

    .logo-text .ease {
      color: #6b21a8;
    }

    /* Admin Badge */
    .admin-badge {
      display: inline-block;
      padding: 0.5rem 1.25rem;
      background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
      color: white;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
      letter-spacing: 0.5px;
    }

    .admin-badge i {
      margin-right: 0.5rem;
    }

    /* Input Fields */
    .input-group {
      margin-bottom: 1rem;
      text-align: left;
    }

    .input-label {
      display: block;
      font-size: 0.85rem;
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 1rem;
    }

    .input-field {
      width: 100%;
      padding: 0.75rem 1rem 0.75rem 2.75rem;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      background: white;
      font-family: 'Poppins', sans-serif;
    }

    .input-field:focus {
      outline: none;
      border-color: #dc2626;
      box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .input-field::placeholder {
      color: #9ca3af;
    }

    .input-field.is-invalid {
      border-color: #ef4444;
    }

    .invalid-feedback {
      display: block;
      margin-top: 0.5rem;
      font-size: 0.8rem;
      color: #ef4444;
    }

    /* Remember Me */
    .remember-group {
      display: flex;
      align-items: center;
      margin-bottom: 1.25rem;
      text-align: left;
    }

    .remember-group input[type="checkbox"] {
      width: 18px;
      height: 18px;
      margin-right: 0.5rem;
      cursor: pointer;
      accent-color: #dc2626;
    }

    .remember-group label {
      font-size: 0.85rem;
      color: #6b7280;
      cursor: pointer;
      user-select: none;
    }

    /* Login Button */
    .login-btn {
      width: 100%;
      padding: 0.85rem 2rem;
      background: #6b21a8;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 0.95rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      text-decoration: none;
      box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
      margin-top: 0.5rem;
    }

    .login-btn:hover {
      background: #874ab8ff;
      box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
      transform: translateY(-2px);
    }

    .login-btn:active {
      transform: translateY(0);
    }

    .login-btn i {
      font-size: 1rem;
    }

    /* Back to User Login Link */
    .back-link {
      text-align: center;
      margin-top: 1.5rem;
      font-size: 0.85rem;
      color: #6b7280;
    }

    .back-link a {
      color: #6b21a8;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .back-link a:hover {
      color: #7c3aed;
      text-decoration: underline;
    }

    /* Alerts */
    .alert {
      padding: 0.85rem 1rem;
      border-radius: 12px;
      margin-bottom: 1rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      animation: slideInDown 0.5s ease-out;
      border: none;
      font-size: 0.85rem;
      text-align: left;
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
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .alert-close {
      margin-left: auto;
      background: none;
      border: none;
      font-size: 1.3rem;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 0.3s;
      flex-shrink: 0;
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

      <!-- Logo -->
      <div class="logo-container">
        <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Malaybalay Logo">
      </div>

      <!-- Logo Text -->
      <div class="logo-text">
        <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
      </div>

      <!-- Admin Badge -->
      <!-- <div class="admin-badge">
        <i class="fas fa-shield-alt"></i>
        ADMIN PORTAL
      </div> -->

      <!-- Login Form -->
      <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        
        <!-- Email Input -->
        <div class="input-group">
          <label for="email" class="input-label">Email Address</label>
          <div class="input-wrapper">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" 
                   id="email"
                   name="email" 
                   class="input-field @error('email') is-invalid @enderror" 
                   placeholder="admin@example.com"
                   value="{{ old('email') }}"
                   required 
                   autofocus>
          </div>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="input-group">
          <label for="password" class="input-label">Password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" 
                   id="password"
                   name="password" 
                   class="input-field @error('password') is-invalid @enderror" 
                   placeholder="Enter your password"
                   required>
          </div>
          @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <!-- Remember Me -->
        <div class="remember-group">
          <input type="checkbox" 
                 id="remember" 
                 name="remember" 
                 {{ old('remember') ? 'checked' : '' }}>
          <label for="remember">Remember me</label>
        </div>

        <!-- Login Button -->
        <button type="submit" class="login-btn">
          <i class="fas fa-sign-in-alt"></i>
          Login
        </button>
      </form>

      <!-- Back to User Login Link -->
      <div class="back-link">
        <a href="{{ route('user.login') }}">
          <i class="fas fa-arrow-left"></i> Back to User Login
        </a>
      </div>
    </div>
  </div>

  <script>
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
      });
    }, 5000);
  </script>
</body>
</html>