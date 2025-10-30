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

        /* Alerts */
        .alert {
            padding: 1rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            animation: slideInDown 0.5s ease-out;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
        }

        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #ef4444;
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

        /* Document Folders Section */
        .documents-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .documents-section h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .documents-section p {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .folders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .folder-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
        }

        .folder-card:not(.locked):hover {
            border-color: #6b21a8;
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(107, 33, 168, 0.15);
        }

        .folder-card.locked {
            cursor: not-allowed;
            opacity: 0.6;
            border-color: #fca5a5;
        }

        .folder-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .folder-icon.unlocked {
            color: #6b21a8;
        }

        .folder-icon.locked {
            color: #ef4444;
        }

        .folder-name {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
        }

        .folder-status {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .folder-status.authorized {
            background: #d1fae5;
            color: #065f46;
        }

        .folder-status.unauthorized {
            background: #fee2e2;
            color: #991b1b;
        }

        .folder-stats {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .folder-permissions {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }

        .permission-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .permission-badge.add {
            background: #d1fae5;
            color: #065f46;
        }

        .permission-badge.view {
            background: #dbeafe;
            color: #1e40af;
        }

        .permission-badge.edit {
            background: #fef3c7;
            color: #92400e;
        }

        .folder-action {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
        }

        .folder-action.open {
            background: #6b21a8;
            color: white;
        }

        .folder-action.open:hover {
            background: #7c3aed;
        }

        .folder-action.locked-btn {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
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

            .folders-grid {
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
            <a href="{{ route('dashboard') }}" class="menu-item">
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Documents</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
        <div class="alert alert-success">
            <span><i class="fas fa-check-circle"></i> {{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger">
            <span><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</span>
        </div>
        @endif

        <!-- Documents Section -->
        <div class="documents-section">
            <h2>Document Folders</h2>
            <p>Access documents based on your assigned permissions</p>

            @if(count($folders) > 0)
            <div class="folders-grid">
                @foreach($folders as $folder)
                <div class="folder-card {{ $folder['is_locked'] ? 'locked' : '' }}" 
                     @if(!$folder['is_locked']) onclick="window.location.href='{{ route('user.documents.category', $folder['category']) }}'" @endif>
                    
                    <div class="folder-icon {{ $folder['is_locked'] ? 'locked' : 'unlocked' }}">
                        @if($folder['is_locked'])
                            <i class="fas fa-folder-lock"></i>
                        @else
                            <i class="fas fa-folder-open"></i>
                        @endif
                    </div>

                    <h3 class="folder-name">{{ $folder['category'] }}</h3>

                    <div class="folder-status {{ $folder['is_locked'] ? 'unauthorized' : 'authorized' }}">
                        @if($folder['is_locked'])
                            <i class="fas fa-lock"></i> Unauthorized
                        @else
                            <i class="fas fa-check-circle"></i> Authorized
                        @endif
                    </div>

                    <div class="folder-stats">
                        @if($folder['is_locked'])
                            <i class="fas fa-file-alt"></i> {{ $folder['total_documents'] }} {{ $folder['total_documents'] == 1 ? 'document' : 'documents' }}<br>
                            <span style="color: #ef4444;"><i class="fas fa-ban"></i> No access</span>
                        @else
                            <i class="fas fa-file-alt"></i> {{ $folder['accessible_documents'] }} of {{ $folder['total_documents'] }} accessible
                        @endif
                    </div>

                    @if(!$folder['is_locked'])
                    <div class="folder-permissions">
                        @if($folder['can_add'])
                        <span class="permission-badge add">
                            <i class="fas fa-plus"></i> Add
                        </span>
                        @endif
                        @if($folder['can_view'])
                        <span class="permission-badge view">
                            <i class="fas fa-eye"></i> View
                        </span>
                        @endif
                        @if($folder['can_edit'])
                        <span class="permission-badge edit">
                            <i class="fas fa-edit"></i> Edit
                        </span>
                        @endif
                    </div>
                    @endif

                    @if($folder['is_locked'])
                        <button class="folder-action locked-btn" disabled>
                            <i class="fas fa-lock"></i> Locked
                        </button>
                    @else
                        <a href="{{ route('user.documents.category', $folder['category']) }}" class="folder-action open">
                            <i class="fas fa-folder-open"></i> Open Folder
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="empty-state">
                <i class="fas fa-folder-open"></i>
                <h3>No document folders available</h3>
                <p>There are currently no folders to display.</p>
            </div>
            @endif
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

        // Auto-dismiss alerts
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
