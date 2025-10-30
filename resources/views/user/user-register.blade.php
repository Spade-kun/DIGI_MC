<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
  <title>User Registration - {{ config('app.name', 'Laravel') }}</title>
  
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

    .register-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      position: relative;
      background: #e8e8e8;
      padding: 2rem 0;
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

    /* Centered Register Card */
    .register-card {
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
      width: 120px;
      height: auto;
      animation: float 3s ease-in-out infinite;
    }

    /* Logo Text */
    .logo-text {
      font-size: 1.6rem;
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

    /* Subtitle */
    .subtitle {
      font-size: 0.9rem;
      color: #6b7280;
      margin-bottom: 1.5rem;
    }

    /* Form */
    .input-group {
      margin-bottom: 0.85rem;
      text-align: left;
    }

    .input-field {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #e5e7eb;
      border-radius: 8px;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      background: white;
      font-family: 'Poppins', sans-serif;
    }

    .input-field:focus {
      outline: none;
      border-color: #6b21a8;
      box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }

    .input-field::placeholder {
      color: #9ca3af;
    }

    .input-field.is-invalid {
      border-color: #ef4444;
    }

    .invalid-feedback {
      display: block;
      font-size: 0.8rem;
      color: #ef4444;
      margin-top: 0.25rem;
      text-align: left;
    }

    /* Checkbox */
    .checkbox-group {
      display: flex;
      align-items: flex-start;
      gap: 0.5rem;
      margin-bottom: 0.85rem;
      text-align: left;
    }

    .checkbox-group input[type="checkbox"] {
      margin-top: 0.25rem;
      cursor: pointer;
      width: 16px;
      height: 16px;
      accent-color: #6b21a8;
    }

    .checkbox-label {
      font-size: 0.85rem;
      color: #6b7280;
      cursor: pointer;
    }

    .checkbox-label a {
      color: #6b21a8;
      font-weight: 600;
      text-decoration: none;
    }

    .checkbox-label a:hover {
      text-decoration: underline;
    }

    /* Register Button */
    .register-btn {
      width: 100%;
      padding: 0.75rem 2rem;
      background: #6b21a8;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(107, 33, 168, 0.3);
      margin-top: 0.3rem;
    }

    .register-btn:hover {
      background: #7c3aed;
      box-shadow: 0 6px 16px rgba(107, 33, 168, 0.4);
      transform: translateY(-1px);
    }

    /* Sign In Link */
    .signin-text {
      text-align: center;
      margin-top: 1.2rem;
      font-size: 0.85rem;
      color: #6b7280;
    }

    .signin-text a {
      color: #6b21a8;
      font-weight: 600;
      text-decoration: none;
      transition: color 0.3s ease;
    }

    .signin-text a:hover {
      color: #7c3aed;
      text-decoration: underline;
    }

    /* Alerts */
    .alert {
      padding: 0.85rem 1rem;
      border-radius: 12px;
      margin-bottom: 1rem;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      animation: slideInDown 0.5s ease-out;
      border: none;
      font-size: 0.85rem;
      text-align: left;
    }

    .alert-danger {
      background: #fee2e2;
      color: #991b1b;
    }

    .alert i {
      font-size: 1.2rem;
      margin-top: 0.1rem;
    }

    .alert ul {
      margin: 0.5rem 0 0 0;
      padding-left: 1.25rem;
      list-style: disc;
    }

    .alert ul li {
      margin-bottom: 0.25rem;
    }

    .alert-close {
      margin-left: auto;
      background: none;
      border: none;
      font-size: 1.3rem;
      cursor: pointer;
      opacity: 0.5;
      transition: opacity 0.3s;
      line-height: 1;
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

      .register-card {
        padding: 2.5rem 2rem;
        max-width: 400px;
      }

      .logo-container img {
        width: 110px;
      }

      .logo-text {
        font-size: 1.5rem;
      }
    }

    @media (max-width: 576px) {
      .register-card {
        padding: 2rem 1.5rem;
        max-width: 340px;
        margin: 1rem;
      }

      .logo-container img {
        width: 100px;
      }

      .logo-text {
        font-size: 1.4rem;
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

    /* Success Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      overflow: auto;
    }

    .modal.show {
      display: flex !important;
      align-items: center;
      justify-content: center;
    }

    .modal-backdrop {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 9998;
    }

    .modal-dialog {
      position: relative;
      z-index: 10000;
      max-width: 500px;
      width: 90%;
      margin: 1rem auto;
      animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
      from {
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
      }
      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    .modal-content {
      border: none;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      border: none;
      padding: 1.5rem;
      position: relative;
    }

    .modal-title {
      color: white;
      font-weight: 600;
      font-size: 1.25rem;
    }

    .btn-close-white {
      background: transparent;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
      opacity: 0.8;
      position: absolute;
      right: 1.5rem;
      top: 1.5rem;
      width: 30px;
      height: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity 0.3s;
    }

    .btn-close-white:hover {
      opacity: 1;
    }

    .modal-body {
      padding: 2rem;
      background: white;
    }

    .modal-footer {
      border: none;
      padding: 1.5rem;
      background: white;
    }

    .modal-footer .btn {
      background: #6b21a8;
      border: none;
      padding: 0.75rem 2rem;
      border-radius: 8px;
      font-weight: 600;
      transition: all 0.3s ease;
      color: white;
      text-decoration: none;
      display: inline-block;
    }

    .modal-footer .btn:hover {
      background: #7c3aed;
      transform: translateY(-1px);
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

    /* Terms Modal Styles */
    .terms-modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 9999;
      overflow: auto;
    }

    .terms-modal.show {
      display: flex !important;
      align-items: center;
      justify-content: center;
    }

    .terms-modal .modal-dialog {
      max-width: 700px;
      max-height: 90vh;
    }

    .terms-modal .modal-body {
      max-height: 60vh;
      overflow-y: auto;
      text-align: left;
    }

    .terms-modal .modal-header {
      background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
    }

    .terms-content h5 {
      color: #1f2937;
      font-weight: 600;
      margin-top: 1.5rem;
      margin-bottom: 0.75rem;
    }

    .terms-content h5:first-child {
      margin-top: 0;
    }

    .terms-content p, .terms-content ul {
      color: #6b7280;
      font-size: 0.9rem;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .terms-content ul {
      padding-left: 1.5rem;
    }

    .terms-content ul li {
      margin-bottom: 0.5rem;
    }
  </style>
</head>

<body>
  <div class="register-container">
    <!-- Purple Wave Decorations -->
    <div class="wave-decoration wave-top-left"></div>
    <div class="wave-decoration wave-bottom-right"></div>

    <!-- Centered Register Card -->
    <div class="register-card">
      <!-- Logo -->
      <div class="logo-container">
        <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Malaybalay Logo">
      </div>

      <!-- Logo Text -->
      <div class="logo-text">
        <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
      </div>

      <!-- Subtitle -->
      <div class="subtitle">Create your account</div>

      <!-- Error Messages -->
      @if ($errors->any())
      <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i>
        <div style="flex: 1;">
          <strong>Please fix the following errors:</strong>
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        <button type="button" class="alert-close" onclick="this.parentElement.style.display='none'">&times;</button>
      </div>
      @endif

      <!-- Registration Form -->
      <form method="POST" action="{{ route('user.register') }}" id="registrationForm">
        @csrf
        
        <!-- Name Input -->
        <div class="input-group">
          <input type="text" class="input-field @error('name') is-invalid @enderror" 
            name="name" placeholder="Full Name" value="{{ old('name') }}" required>
          @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <!-- Email Input -->
        <div class="input-group">
          <input type="email" class="input-field @error('email') is-invalid @enderror" 
            name="email" placeholder="Email Address" value="{{ old('email') }}" required>
          @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="input-group">
          <input type="password" class="input-field @error('password') is-invalid @enderror" 
            name="password" placeholder="Password" required>
          @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
          @enderror
        </div>

        <!-- Confirm Password Input -->
        <div class="input-group">
          <input type="password" class="input-field" 
            name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <!-- Terms Checkbox -->
        <div class="checkbox-group">
          <input type="checkbox" name="terms" id="terms" required>
          <label for="terms" class="checkbox-label">
            I agree to the <a href="javascript:void(0);" onclick="openTermsModal()">Terms and Conditions</a>
          </label>
        </div>

        <!-- Register Button -->
        <button type="submit" class="register-btn">Sign Up</button>

        <!-- Sign In Link -->
        <div class="signin-text">
          Already have an account? <a href="{{ route('user.login') }}">Sign in</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Success Modal -->
  <div class="modal" id="successModal">
    <div class="modal-backdrop" onclick="closeSuccessModal()"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-check-circle me-2"></i>Registration Successful!
          </h5>
          <button type="button" class="btn-close-white" onclick="closeSuccessModal()">
            <i class="fas fa-times"></i>
          </button>
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
          <div class="alert" style="background: #dbeafe; color: #1e40af; margin-top: 1rem; border: none;">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Please wait for approval notification</strong>
          </div>
        </div>
        <div class="modal-footer">
          <a href="{{ route('user.login') }}" class="btn w-100">Go to Login Page</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Terms and Conditions Modal -->
  <div class="terms-modal" id="termsModal">
    <div class="modal-backdrop" onclick="closeTermsModal()"></div>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-file-contract me-2"></i>Terms and Conditions
          </h5>
          <button type="button" class="btn-close-white" onclick="closeTermsModal()">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="terms-content">
            <h5>1. Acceptance of Terms</h5>
            <p>By accessing and using the DIGI MC Legal Portal ("the Service"), you accept and agree to be bound by the terms and provision of this agreement.</p>

            <h5>2. User Registration</h5>
            <p>To access certain features of the Service, you must register for an account. When you register, you agree to:</p>
            <ul>
              <li>Provide accurate, current, and complete information</li>
              <li>Maintain and promptly update your registration information</li>
              <li>Maintain the security of your password and account</li>
              <li>Accept all responsibility for all activities that occur under your account</li>
            </ul>

            <h5>3. Account Approval</h5>
            <p>Your account registration is subject to administrative approval. The administrators reserve the right to approve or reject any registration at their sole discretion.</p>

            <h5>4. Use of Service</h5>
            <p>You agree to use the Service only for lawful purposes and in accordance with these Terms. You agree not to:</p>
            <ul>
              <li>Use the Service in any way that violates any applicable law or regulation</li>
              <li>Attempt to gain unauthorized access to any portion of the Service</li>
              <li>Interfere with or disrupt the Service or servers</li>
              <li>Share confidential legal documents without proper authorization</li>
            </ul>

            <h5>5. Document Access and Confidentiality</h5>
            <p>Access to legal documents and gazettes through the Service is provided for informational purposes. You agree to:</p>
            <ul>
              <li>Respect the confidentiality of sensitive documents</li>
              <li>Use documents only for legitimate legal purposes</li>
              <li>Not redistribute documents without proper authorization</li>
            </ul>

            <h5>6. Intellectual Property</h5>
            <p>The Service and its original content, features, and functionality are owned by DIGI MC and are protected by international copyright, trademark, and other intellectual property laws.</p>

            <h5>7. Data Privacy</h5>
            <p>Your use of the Service is also governed by our Privacy Policy. We collect and process your personal information in accordance with applicable data protection laws.</p>

            <h5>8. Limitation of Liability</h5>
            <p>The Service is provided "as is" without warranties of any kind. DIGI MC shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of the Service.</p>

            <h5>9. Changes to Terms</h5>
            <p>We reserve the right to modify these Terms at any time. We will notify users of any material changes by posting the new Terms on this page.</p>

            <h5>10. Contact Information</h5>
            <p>If you have any questions about these Terms, please contact the City Legal Office of Malaybalay.</p>

            <p style="margin-top: 1.5rem; font-style: italic;">Last updated: {{ date('F d, Y') }}</p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn w-100" onclick="acceptTerms()">I Understand</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Success Modal Functions
    function closeSuccessModal() {
      document.getElementById('successModal').classList.remove('show');
    }

    // Terms Modal Functions
    function openTermsModal() {
      document.getElementById('termsModal').classList.add('show');
    }

    function closeTermsModal() {
      document.getElementById('termsModal').classList.remove('show');
    }

    function acceptTerms() {
      document.getElementById('terms').checked = true;
      closeTermsModal();
    }

    // Show success modal if registration was successful
    @if(session('registration_success'))
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('successModal').classList.add('show');
      // Clear the form
      document.getElementById('registrationForm').reset();
    });
    @endif

    // Prevent closing modals on content click
    document.querySelectorAll('.modal-dialog').forEach(function(dialog) {
      dialog.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });
  </script>
</body>
</html>