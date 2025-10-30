<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>Tracking Details - LEGALITEASE</title>
    
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

    /* Card Styling */
    .tracking-detail-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    /* Search Bar */
    .search-bar {
        padding: 2rem;
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .search-input-group {
        max-width: 400px;
        position: relative;
        flex: 1;
    }

    .back-to-tracking {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .back-to-tracking:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 33, 168, 0.4);
        color: white;
    }

    .search-input {
        width: 100%;
        padding: 0.75rem 2.5rem 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.9rem;
    }

    .copy-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6b7280;
        transition: color 0.3s;
    }

    .copy-icon:hover {
        color: #6b21a8;
    }

    /* Content Layout */
    .tracking-content {
        display: flex;
        gap: 2rem;
        padding: 2rem;
    }

    .document-info-section {
        flex: 1;
        max-width: 600px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .section-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        padding: 0.75rem;
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        font-size: 0.875rem;
    }

    /* Timeline Section */
    .timeline-section {
        flex: 1;
        max-width: 500px;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.625rem;
        top: 2.5rem;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-dot {
        position: absolute;
        left: -1.875rem;
        top: 0.25rem;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .timeline-dot.active {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
    }

    .timeline-dot.inactive {
        background: #d1d5db;
    }

    .timeline-content {
        background: #f9fafb;
        padding: 1rem;
        border-radius: 10px;
        border-left: 3px solid #6b21a8;
    }

    .timeline-date {
        font-size: 0.75rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    .timeline-status {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    /* Revised Button */
    .btn-revised {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 2rem;
        width: 100%;
    }

    .btn-revised:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 33, 168, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .tracking-content {
            flex-direction: column;
        }

        .document-info-section,
        .timeline-section {
            max-width: 100%;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
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

    /* Modal Styles */
    .modal-content {
        border-radius: 16px;
        border: none;
    }

    .modal-header {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        border-radius: 16px 16px 0 0;
        padding: 1.5rem 2rem;
        border: none;
    }

    .modal-title {
        color: white;
        font-weight: 600;
        font-size: 1.25rem;
    }

    .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #6b21a8;
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }

    .btn-save {
        background: linear-gradient(135deg, #6b21a8 0%, #7c3aed 100%);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        border: none;
        width: 100%;
        margin-top: 1rem;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(107, 33, 168, 0.4);
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
            <a href="{{ route('admin.privileges.index') }}" class="menu-item">
                <i class="fas fa-user-shield"></i>
                <span>Privileges</span>
            </a>
            <a href="{{ route('admin.tracking.index') }}" class="menu-item active">
                <i class="fas fa-truck"></i>
                <span>Tracking</span>
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
                <p style="color: #9ca3af; font-size: 0.875rem; margin-bottom: 0.25rem;">Pages / <span style="color: #1f2937;">Tracking Details</span></p>
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

        <div class="card tracking-detail-card">
            <!-- Search Bar -->
            <div class="search-bar">
                <div class="search-input-group">
                    <input type="text" 
                           class="search-input" 
                           value="{{ $document->tracking_no }}" 
                           readonly 
                           id="trackingNumber">
                    <i class="fas fa-copy copy-icon" onclick="copyTrackingNumber()" title="Copy tracking number"></i>
                </div>
                <a href="{{ route('admin.tracking.index') }}" class="back-to-tracking">
                    <i class="fas fa-arrow-left"></i> Back to Tracking
                </a>
            </div>

            <!-- Content -->
            <div class="tracking-content">
                <!-- Document Information -->
                <div class="document-info-section">
                    <h2 class="section-title">Document Information</h2>
                    <p class="section-subtitle">Track you document in real time</p>

                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">Tracking No.</label>
                            <div class="info-value">{{ $document->tracking_no }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Status:</label>
                            <div class="info-value">{{ $document->status }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Source/Office</label>
                            <div class="info-value">{{ $document->source_office }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Document Type:</label>
                            <div class="info-value">{{ $document->document_type }}</div>
                        </div>
                        <div class="info-item">
                            <label class="info-label">Privacy:</label>
                            <div class="info-value">{{ $document->privacy }}</div>
                        </div>
                        <!-- <div class="info-item">
                            <label class="info-label">File</label>
                            <div class="info-value">
                                @if($document->file_path)
                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" style="color: #6b21a8; text-decoration: none;">
                                        <i class="fas fa-file"></i> View File
                                    </a>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div> -->
                    </div>

                    <button type="button" class="btn-revised" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                        <i class="fas fa-sync-alt"></i> Update Status
                    </button>
                </div>

                <!-- Timeline -->
                <div class="timeline-section">
                    <h2 class="section-title">Status History</h2>
                    <p class="section-subtitle">Document workflow timeline</p>

                    <div class="timeline">
                        @foreach($document->histories()->orderBy('created_at', 'desc')->get() as $history)
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $loop->first ? 'active' : 'inactive' }}"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">{{ $history->created_at->format('m/d/Y  H:i') }}</div>
                                    <div class="timeline-status">{{ $history->status }}</div>
                                    @if($history->remarks)
                                        <div style="margin-top: 0.5rem; font-size: 0.875rem; color: #6b7280;">
                                            {{ $history->remarks }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.tracking.update-status', $document->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Received" {{ $document->status == 'Received' ? 'selected' : '' }}>Received</option>
                            <option value="Drafting" {{ $document->status == 'Drafting' ? 'selected' : '' }}>Drafting</option>
                            <option value="For Review" {{ $document->status == 'For Review' ? 'selected' : '' }}>For Review</option>
                            <option value="Revision" {{ $document->status == 'Revision' ? 'selected' : '' }}>Revision</option>
                            <option value="Approved" {{ $document->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Add any comments or notes..."></textarea>
                    </div>
                    <button type="submit" class="btn-save">Update Status</button>
                </div>
            </form>
        </div>
    </div>
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
                <form method="POST" action="{{ route('admin.logout') }}" style="flex: 1;">
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

function copyTrackingNumber() {
    const input = document.getElementById('trackingNumber');
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');
    
    // Show tooltip or alert
    const icon = document.querySelector('.copy-icon');
    const originalClass = icon.className;
    icon.className = 'fas fa-check copy-icon';
    icon.style.color = '#10b981';
    
    setTimeout(() => {
        icon.className = originalClass;
        icon.style.color = '#6b7280';
    }, 2000);
}

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
