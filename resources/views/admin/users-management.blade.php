<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>User Management - LEGALITEASE</title>
    
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

        /* Content Section */
        .content-section {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        /* Search and Filter Bar */
        .search-filter-bar {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            align-items: center;
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
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
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .filter-btn {
            padding: 0.75rem 1.5rem;
            background: #6b21a8;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .filter-btn:hover {
            background: #7c3aed;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .tab {
            padding: 0.875rem 1.5rem;
            background: transparent;
            border: none;
            color: #6b7280;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
            position: relative;
        }

        .tab:hover {
            color: #6b21a8;
        }

        .tab.active {
            color: #6b21a8;
            border-bottom-color: #6b21a8;
        }

        .tab-count {
            display: inline-block;
            margin-left: 0.5rem;
            padding: 0.125rem 0.5rem;
            background: #f3f4f6;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .tab.active .tab-count {
            background: #f3e8ff;
            color: #6b21a8;
        }

        /* Table */
        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table thead {
            background: #f9fafb;
        }

        .user-table th {
            padding: 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .user-table td {
            padding: 1rem;
            border-top: 1px solid #e5e7eb;
            font-size: 0.875rem;
        }

        .user-table tbody tr {
            transition: background-color 0.2s;
        }

        .user-table tbody tr:hover {
            background: #f9fafb;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .user-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0 0 0.125rem 0;
        }

        .user-details p {
            font-size: 0.8rem;
            color: #6b7280;
            margin: 0;
        }

        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.875rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-badge.approved {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn-view {
            background: transparent;
            color: #6b21a8;
            text-decoration: none;
        }

        .btn-view:hover {
            background: #f3e8ff;
        }

        .btn-edit {
            background: transparent;
            color: #6b21a8;
            text-decoration: none;
        }

        .btn-edit:hover {
            background: #f3e8ff;
        }

        .more-btn {
            background: transparent;
            border: none;
            color: #6b7280;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.3s;
        }

        .more-btn:hover {
            background: #f3f4f6;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-state i {
            font-size: 3rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #6b7280;
            font-size: 0.875rem;
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

            .search-filter-bar {
                flex-direction: column;
            }

            .tabs {
                overflow-x: auto;
                flex-wrap: nowrap;
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Users</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        <!-- Content Section -->
        <div class="content-section">
            <!-- Search and Filter Bar -->
            <div class="search-filter-bar">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Search" id="searchInput">
                </div>
                <button class="filter-btn">
                    Filter
                </button>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab active" data-tab="user-management">
                    User Management
                    <span class="tab-count">{{ $pendingUsers->count() + $approvedUsers->count() + $rejectedUsers->count() }}</span>
                </button>
                <button class="tab" data-tab="pending">
                    Pending Users
                    <span class="tab-count">{{ $pendingUsers->count() }}</span>
                </button>
                <button class="tab" data-tab="rejected">
                    Rejected Users
                    <span class="tab-count">{{ $rejectedUsers->count() }}</span>
                </button>
            </div>

            <!-- User Management Tab (All Users) -->
            <div class="tab-content active" id="user-management-content">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Officers</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvedUsers as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <div class="user-details">
                                        <h4>{{ $user->name }}</h4>
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #9ca3af;">{{ $user->role ?? 'Legal Officer' }}</td>
                            <td>
                                <span class="status-badge approved">Approved</span>
                            </td>
                            <td style="color: #6b21a8;">View</td>
                            <td>
                                <button class="more-btn">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h3>No users found</h3>
                                    <p>There are no approved users at the moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pending Users Tab -->
            <div class="tab-content" id="pending-content">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Officers</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingUsers as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <div class="user-details">
                                        <h4>{{ $user->name }}</h4>
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #9ca3af;">{{ $user->role ?? 'Legal Officer' }}</td>
                            <td>
                                <span class="status-badge pending">Pending</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <form action="{{ route('admin.registrations.approve', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-view">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.registrations.reject', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-edit">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <button class="more-btn">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-clock"></i>
                                    <h3>No pending users</h3>
                                    <p>There are no pending registration requests at the moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Rejected Users Tab -->
            <div class="tab-content" id="rejected-content">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>Officers</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rejectedUsers as $user)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <div class="user-details">
                                        <h4>{{ $user->name }}</h4>
                                        <p>{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color: #9ca3af;">{{ $user->role ?? 'Legal Officer' }}</td>
                            <td>
                                <span class="status-badge rejected">Rejected</span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <form action="{{ route('admin.registrations.approve', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-view">
                                            <i class="fas fa-check"></i> Approve
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <button class="more-btn">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-user-times"></i>
                                    <h3>No rejected users</h3>
                                    <p>There are no rejected users at the moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
        // Logout modal functions
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

        // Tab switching functionality
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Remove active class from all tabs and contents
                tabs.forEach(t => t.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Add active class to clicked tab
                tab.classList.add('active');

                // Show corresponding content
                const tabName = tab.getAttribute('data-tab');
                document.getElementById(tabName + '-content').classList.add('active');
            });
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            const activeContent = document.querySelector('.tab-content.active');
            const rows = activeContent.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
