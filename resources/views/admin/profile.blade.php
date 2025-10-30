<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Profile - LEGALITEASE</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 2rem 1rem 1rem;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .sidebar-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 0.5rem;
        }

        .sidebar-menu {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: #f9fafb;
            color: #6b21a8;
        }

        .menu-item.active {
            background: #f3e8ff;
            color: #6b21a8;
            border-left-color: #6b21a8;
            font-weight: 600;
        }

        .menu-item i {
            margin-right: 0.75rem;
            font-size: 1.1rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .logout-btn {
            width: 100%;
            padding: 0.75rem;
            background: white;
            border: 1px solid #e5e7eb;
            color: #6b21a8;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: #f3e8ff;
            border-color: #6b21a8;
        }

        /* Main Content */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 2rem;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .brand-title {
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .brand-title .legal {
            color: #6b21a8;
        }

        .brand-title .it {
            color: #f59e0b;
        }

        .brand-title .ease {
            color: #6b21a8;
        }

        /* Profile Container */
        .profile-container {
            display: grid;
            grid-template-columns: 350px 1fr;
            gap: 2rem;
        }

        /* Profile Card */
        .profile-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
            height: fit-content;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 3rem;
            font-weight: 700;
            color: white;
        }

        .profile-name {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .profile-role {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #6b21a8;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .profile-role {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: #f3e8ff;
            color: #6b21a8;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        /* Form Section */
        .form-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .form-section .subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #6b21a8;
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
        }

        .form-input:disabled {
            background: #f9fafb;
            cursor: not-allowed;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .btn-primary {
            padding: 0.75rem 2rem;
            background: #6b21a8;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .btn-primary:hover {
            background: #7c3aed;
        }

        .btn-secondary {
            padding: 0.75rem 2rem;
            background: white;
            color: #6b7280;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 2rem 0;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Logout Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
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

        .modal-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .modal-icon {
            width: 60px;
            height: 60px;
            background: #fef3c7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2rem;
            color: #f59e0b;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .modal-text {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .modal-btn {
            flex: 1;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .btn-cancel {
            background: #f3f4f6;
            color: #6b7280;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-confirm {
            background: #6b21a8;
            color: white;
        }

        .btn-confirm:hover {
            background: #7c3aed;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('City-Legal-Office-1024x1024-1.png') }}" alt="City Legal Office Logo" class="sidebar-logo">
        </div>
        
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.documents.index') }}" class="menu-item">
                <i class="fas fa-folder"></i>
                <span>Documents</span>
            </a>
            <a href="{{ route('admin.registrations.pending') }}" class="menu-item">
                <i class="fas fa-user-friends"></i>
                <span>Users</span>
            </a>
            <a href="{{ route('admin.tracking.index') }}" class="menu-item">
                <i class="fas fa-truck"></i>
                <span>Tracking</span>
            </a>
            <a href="{{ route('admin.roles.index') }}" class="menu-item">
                <i class="fas fa-user-shield"></i>
                <span>Role and Privileges</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}" class="menu-item active">
                <i class="fas fa-user"></i>
                <span>Profile</span>
            </a>
        </div>
        
        <div class="sidebar-footer">
            <button class="logout-btn" onclick="showLogoutModal()">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="page-header">
            <div>
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Profile</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <span>There were some errors with your submission.</span>
        </div>
        @endif

        <!-- Profile Container -->
        <div class="profile-container">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-avatar">
                    {{ strtoupper(substr($admin->name, 0, 2)) }}
                </div>
                <h2 class="profile-name">{{ $admin->name }}</h2>
                <span class="profile-role">
                    <i class="fas fa-user-circle"></i> Admin
                </span>
                <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.5rem;">
                    <i class="fas fa-envelope" style="margin-right: 0.5rem;"></i>
                    {{ $admin->email }}
                </p>
                <p style="color: #6b7280; font-size: 0.875rem;">
                    <i class="fas fa-calendar" style="margin-right: 0.5rem;"></i>
                    Joined {{ $admin->created_at->format('M d, Y') }}
                </p>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ \App\Models\User::count() }}</div>
                        <div class="stat-label">Total Users</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ \App\Models\AdminDocument::count() }}</div>
                        <div class="stat-label">Documents</div>
                    </div>
                </div>
            </div>

            <!-- Forms Section -->
            <div>
                <!-- Profile Information Form -->
                <div class="form-section">
                    <h2>Profile Information</h2>
                    <p class="subtitle">Update your account's profile information and email address.</p>

                    <form method="POST" action="{{ route('admin.profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label class="form-label" for="name">Name</label>
                            <input 
                                type="text" readonly
                                id="name" 
                                name="name" 
                                class="form-input" 
                                value="{{ old('name', $admin->name) }}" 
                                required
                            >
                            @error('name')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="email">Email</label>
                            <input 
                                type="email" readonly
                                id="email" 
                                name="email" 
                                class="form-input" 
                                value="{{ old('email', $admin->email) }}" 
                                required
                            >
                            @error('email')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save" style="margin-right: 0.5rem;"></i>
                                Save Changes
                            </button>
                        </div> -->
                    </form>
                </div>

                <div style="height: 2rem;"></div>

                <!-- Update Password Form -->
                <div class="form-section">
                    <h2>Update Password</h2>
                    <p class="subtitle">Ensure your account is using a long, random password to stay secure.</p>

                    <form method="POST" action="{{ route('admin.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label class="form-label" for="current_password">Current Password</label>
                            <input 
                                type="password" 
                                id="current_password" 
                                name="current_password" 
                                class="form-input" 
                                required
                            >
                            @error('current_password')
                                <p class="error-message">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label" for="password">New Password</label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="form-input" 
                                    required
                                >
                                @error('password')
                                    <p class="error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="form-input" 
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-key" style="margin-right: 0.5rem;"></i>
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal" id="logoutModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="modal-title">Confirm Logout</h3>
                <p class="modal-text">Are you sure you want to logout? Your session will end.</p>
            </div>
            <div class="modal-actions">
                <button class="modal-btn btn-cancel" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('admin.logout') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="modal-btn btn-confirm" style="width: 100%;">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('show');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('show');
        }

        // Close modal on backdrop click
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });
    </script>
</body>
</html>
