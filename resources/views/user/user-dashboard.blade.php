<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Dashboard - LEGALITEASE</title>
    
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

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-card-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-info h3 {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-change {
            color: #10b981;
            font-size: 0.875rem;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #6b21a8;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        /* Search Section */
        .search-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .search-section h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        .search-box {
            position: relative;
            margin-bottom: 2rem;
        }

        .search-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: #6b21a8;
            box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .suggested-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .document-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .doc-type-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .doc-type-card:hover {
            background: #f9fafb;
            border-color: #6b21a8;
        }

        .doc-type-card h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .doc-type-card p {
            font-size: 0.8rem;
            color: #6b7280;
            margin: 0;
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
            <a href="{{ route('dashboard') }}" class="menu-item active">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('user.documents.index') }}" class="menu-item">
                <i class="fas fa-folder"></i>
                <span>Documents</span>
            </a>
            <a href="{{ route('user.tracking.index') }}" class="menu-item">
                <i class="fas fa-truck"></i>
                <span>Tracking</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="menu-item">
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Dashboard</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Total Documents</h3>
                        <div>
                            <span class="stat-value">8,000</span>
                            <span class="stat-change">+25</span>
                        </div>
                        <p class="stat-label">+25 from last week</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Pending Request</h3>
                        <div>
                            <span class="stat-value">8,000</span>
                            <span class="stat-change">+25</span>
                        </div>
                        <p class="stat-label">+25 from last week</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-card-content">
                    <div class="stat-info">
                        <h3>Fulfilled Requests</h3>
                        <div>
                            <span class="stat-value">8,000</span>
                            <span class="stat-change">+25</span>
                        </div>
                        <p class="stat-label">+25 from last week</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="search-section">
            <h2>Search Documents</h2>
            
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search">
            </div>

            <h3 class="suggested-title">Suggested Document Types</h3>
            <div class="document-types">
                <div class="doc-type-card">
                    <h4>Memorandum of Agreements</h4>
                    <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0;">Suggested Document Types</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">200 accessed this week</p>
                </div>
                <div class="doc-type-card">
                    <h4>Republic Acts</h4>
                    <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0;">Legislative documents</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">150 accessed this week</p>
                </div>
                <div class="doc-type-card">
                    <h4>Proclamations</h4>
                    <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0;">Official declarations</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">180 accessed this week</p>
                </div>
                <div class="doc-type-card">
                    <h4>Memorandums</h4>
                    <p style="color: #9ca3af; font-size: 0.75rem; margin: 0.25rem 0;">Official memorandums</p>
                    <p style="color: #9ca3af; font-size: 0.75rem;">120 accessed this week</p>
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
                <form method="POST" action="{{ route('user.logout') }}" style="flex: 1;">
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
