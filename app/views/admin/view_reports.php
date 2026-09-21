<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports | Happy Paws Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin_dashboard.css">
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-top">
            <a href="<?php echo URLROOT; ?>/index.php" class="sidebar-header-mobile" style="text-decoration:none;">
                <img src="<?php echo URLROOT; ?>/public/images/happy_paws_logo.png" alt="Happy Paws Logo" onerror="this.src='https://cdn-icons-png.flaticon.com/512/616/616408.png'">
                <span>Happy Paws</span>
            </a>
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg><span>Dashboard</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/staff" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg><span>Staff Management</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/accounts" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg><span>Staff Accounts</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/clinic" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg><span>Clinic Management</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/clinicInfo" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><span>Clinic Information</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/reports" class="sidebar-link"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg><span>Reports</span></a></li>
                <li class="sidebar-nav-item"><a href="<?php echo URLROOT; ?>/admin/viewReports" class="sidebar-link active"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg><span>View Reports</span></a></li>
            </ul>
        </div>
        <div class="sidebar-bottom">
            <a href="<?php echo URLROOT; ?>/admin/settings" class="sidebar-btn-bottom"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg><span>Settings</span></a>
            <a href="<?php echo URLROOT; ?>/auth/logout" class="sidebar-btn-bottom btn-logout"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg><span>Logout</span></a>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="header">
            <div class="header-left">
                <a href="<?php echo URLROOT; ?>/index.php" class="header-logo-link">
                    <img src="<?php echo URLROOT; ?>/public/images/happy_paws_logo.png" alt="Happy Paws Logo" class="header-logo-img" onerror="this.src='https://cdn-icons-png.flaticon.com/512/616/616408.png'">
                    <div class="header-brand-name">Happy Paws <span class="header-brand-badge">System Admin</span></div>
                </a>
            </div>
            <div class="header-right">
                <div class="admin-profile">
                    <img src="<?php echo $data['adminAvatar']; ?>" class="admin-avatar" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80'">
                    <div class="admin-info"><span class="admin-name"><?php echo htmlspecialchars($data['adminName']); ?></span><span class="admin-role"><?php echo htmlspecialchars($data['adminRole']); ?></span></div>
                </div>
            </div>
        </header>

        <main class="content-area">
            <div class="subpage-card">
                <div class="subpage-header">
                    <h1 class="subpage-title">View Detailed System Reports</h1>
                </div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th>Report Name</th>
                            <th>Category</th>
                            <th>Date Range</th>
                            <th>Generated By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Q3 Financial Audit & Revenue</strong></td>
                            <td>Financial</td>
                            <td>Jul 2026 - Sep 2026</td>
                            <td>Sarah Jenkins</td>
                            <td><a href="#" style="color:#006f6a; font-weight:600; text-decoration:none;">View & Download PDF</a></td>
                        </tr>
                        <tr>
                            <td><strong>Annual Veterinary Clinical Outcomes</strong></td>
                            <td>Medical</td>
                            <td>Jan 2026 - Sep 2026</td>
                            <td>Dr. Michael Vance</td>
                            <td><a href="#" style="color:#006f6a; font-weight:600; text-decoration:none;">View & Download PDF</a></td>
                        </tr>
                        <tr>
                            <td><strong>Staff Productivity & Consultation Log</strong></td>
                            <td>Operations</td>
                            <td>Aug 2026 - Sep 2026</td>
                            <td>Sophia Martinez</td>
                            <td><a href="#" style="color:#006f6a; font-weight:600; text-decoration:none;">View & Download PDF</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

</body>
</html>
