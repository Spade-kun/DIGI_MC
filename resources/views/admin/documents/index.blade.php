<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Documents - LEGALITEASE</title>
    
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

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
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

        /* Content Section */
        .content-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .content-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .content-section .subtitle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        /* Folder Grid */
        .folder-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .folder-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s;
            cursor: pointer;
            text-align: center;
        }

        .folder-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-color: #6b21a8;
        }

        .folder-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            transition: all 0.3s;
        }

        .folder-card:hover .folder-icon {
            transform: scale(1.1);
        }

        .folder-icon.purple {
            background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
            color: white;
        }

        .folder-icon.blue {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .folder-icon.green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .folder-card h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .folder-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .folder-info i {
            color: #ef4444;
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
            <a href="{{ route('admin.profile.edit') }}" class="menu-item">
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Documents</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <h2>Document Folders</h2>
            <p class="subtitle">Browse documents by category</p>
            
            <div class="folder-grid">
                <!-- Republic Act Folder -->
                <a href="{{ route('admin.documents.category', 'Republic Act') }}" class="folder-card">
                    <div class="folder-icon purple">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h3>Republic Act</h3>
                    <div class="folder-info">
                        <i class="fas fa-file-pdf"></i>
                        <span>{{ $categories['Republic Act'] }} {{ $categories['Republic Act'] == 1 ? 'document' : 'documents' }}</span>
                    </div>
                </a>

                <!-- Memorandum Folder -->
                <a href="{{ route('admin.documents.category', 'Memorandum') }}" class="folder-card">
                    <div class="folder-icon blue">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h3>Memorandum</h3>
                    <div class="folder-info">
                        <i class="fas fa-file-pdf"></i>
                        <span>{{ $categories['Memorandum'] }} {{ $categories['Memorandum'] == 1 ? 'document' : 'documents' }}</span>
                    </div>
                </a>

                <!-- Proclamations Folder -->
                <a href="{{ route('admin.documents.category', 'Proclamations') }}" class="folder-card">
                    <div class="folder-icon green">
                        <i class="fas fa-folder"></i>
                    </div>
                    <h3>Proclamations</h3>
                    <div class="folder-info">
                        <i class="fas fa-file-pdf"></i>
                        <span>{{ $categories['Proclamations'] }} {{ $categories['Proclamations'] == 1 ? 'document' : 'documents' }}</span>
                    </div>
                </a>
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
