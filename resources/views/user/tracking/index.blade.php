<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Tracking - LEGALITEASE</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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

    /* Logout Modal */
    .logout-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: rgba(0, 0, 0, 0.5);
    }

    .logout-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logout-modal-content {
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

    .logout-modal-header {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .logout-modal-icon {
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

    .logout-modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .logout-modal-text {
        color: #6b7280;
        font-size: 0.95rem;
    }

    .logout-modal-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .logout-modal-btn {
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

    /* Enhanced Card Styling */
    .tracking-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }

    /* Search Section */
    .search-section {
        padding: 2rem;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-bottom: 1px solid #e5e7eb;
    }

    .search-container {
        max-width: 600px;
        margin: 0 auto;
        position: relative;
    }

    .search-input {
        width: 100%;
        padding: 1rem 3.5rem 1rem 1.25rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #6b21a8;
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-icon {
        position: absolute;
        right: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.25rem;
        pointer-events: none;
    }

    /* Header Section */
    .tracking-header {
        padding: 2rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-icon {
        font-size: 6rem;
        color: #d1d5db;
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .empty-description {
        font-size: 1rem;
        color: #9ca3af;
    }

    /* Table Styles */
    .tracking-table {
        width: 100%;
    }

    .tracking-table thead {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    }

    .tracking-table thead th {
        padding: 1.25rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        color: #6b21a8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: none;
    }

    .tracking-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .tracking-table tbody tr:hover {
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    }

    .btn-view {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 33, 168, 0.4);
        color: white;
    }

    .btn-view i {
        font-size: 0.875rem;
    }

    .tracking-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border: none;
    }

    /* Status Badge */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .status-received {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .status-drafting {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .status-for-review {
        background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
        color: #831843;
    }

    .status-revision {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #9a3412;
    }

    .status-approved {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    /* Alert */
    .alert-enhanced {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInDown 0.5s ease-out;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-success-enhanced {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }

    .alert-danger-enhanced {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
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
            <a href="{{ route('user.tracking.index') }}" class="menu-item active">
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Tracking</span></p>
            </div>
            <div class="brand-title">
                <span class="legal">LEGAL</span><span class="it">IT</span><span class="ease">EASE</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-enhanced alert-success-enhanced">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-enhanced alert-danger-enhanced">
                <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="card tracking-card">
            <!-- Search Section -->
            <div class="search-section">
                <form action="{{ route('user.tracking.search') }}" method="GET">
                    <div class="search-container">
                        <input type="text" 
                               name="tracking_no" 
                               class="search-input" 
                               placeholder="XX-XXXX-XXX-XXX"
                               required>
                        <i class="fas fa-search search-icon"></i>
                    </div>
                </form>
            </div>

            <!-- Header Section -->
            <div class="tracking-header">
                <div>
                    <h5 style="margin: 0; color: #1f2937; font-weight: 600;">Tracking Documents</h5>
                    <p style="margin: 0; color: #6b7280; font-size: 0.875rem;">Track and view document workflow status</p>
                </div>
            </div>

            <!-- Documents List or Empty State -->
            @if($documents->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-file-alt empty-icon"></i>
                    <h3 class="empty-title">No Records Found</h3>
                    <p class="empty-description">Use the search bar above to find documents by tracking number</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="tracking-table">
                        <thead>
                            <tr>
                                <th>Tracking No.</th>
                                <th>Name</th>
                                <th>Source/Office</th>
                                <th>Document Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Date Created</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $document)
                                <tr>
                                    <td style="font-weight: 600; color: #6b21a8;">{{ $document->tracking_no }}</td>
                                    <td style="color: #374151;">{{ $document->name }}</td>
                                    <td style="color: #6b7280;">{{ $document->source_office }}</td>
                                    <td style="color: #6b7280;">{{ $document->document_type }}</td>
                                    <td class="text-center">
                                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $document->status)) }}">
                                            {{ $document->status }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="color: #6b7280; font-size: 0.875rem;">
                                        {{ $document->created_at->format('m/d/Y H:i') }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.tracking.show', $document->tracking_no) }}" 
                                           class="btn-view" 
                                           title="View Details">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="logout-modal" id="logoutModal">
        <div class="logout-modal-content">
            <div class="logout-modal-header">
                <div class="logout-modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h3 class="logout-modal-title">Confirm Logout</h3>
                <p class="logout-modal-text">Are you sure you want to logout? Your session will end.</p>
            </div>
            <div class="logout-modal-actions">
                <button class="logout-modal-btn btn-cancel" onclick="closeLogoutModal()">Cancel</button>
                <form method="POST" action="{{ route('user.logout') }}" style="flex: 1;">
                    @csrf
                    <button type="submit" class="logout-modal-btn btn-confirm" style="width: 100%;">Yes, Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    const alerts = document.querySelectorAll('.alert-enhanced');
    alerts.forEach(alert => {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
</body>
</html>
