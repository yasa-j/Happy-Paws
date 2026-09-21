<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] . ' | Happy Paws' : 'System Admin Dashboard | Happy Paws'; ?></title>
    <!-- CSS aligned with home.css -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/admin_dashboard.css">
</head>
<body>

<div class="dashboard-container">

    <!-- =========================================================
         LEFT SIDEBAR (Clean White Theme)
         ========================================================= -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <!-- Sidebar Header / Mobile Logo (Link to index.php) -->
            <a href="<?php echo URLROOT; ?>/index.php" class="sidebar-header-mobile" style="text-decoration:none;">
                <img src="<?php echo URLROOT; ?>/public/images/happy_paws_logo.png" alt="Happy Paws Logo" onerror="this.src='https://cdn-icons-png.flaticon.com/512/616/616408.png'">
                <span>Happy Paws</span>
            </a>

            <!-- Sidebar Navigation Tabs (Stacked aligned left) -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin" class="sidebar-link <?php echo ($data['activePage'] == 'dashboard') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/staff" class="sidebar-link <?php echo ($data['activePage'] == 'staff') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>Staff Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/accounts" class="sidebar-link <?php echo ($data['activePage'] == 'accounts') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                        <span>Staff Accounts</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/clinic" class="sidebar-link <?php echo ($data['activePage'] == 'clinic') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <span>Clinic Management</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/clinicInfo" class="sidebar-link <?php echo ($data['activePage'] == 'clinic_info') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Clinic Information</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/reports" class="sidebar-link <?php echo ($data['activePage'] == 'reports') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="<?php echo URLROOT; ?>/admin/viewReports" class="sidebar-link <?php echo ($data['activePage'] == 'view_reports') ? 'active' : ''; ?>">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>View Reports</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Sidebar Bottom Buttons (Settings & Logout) -->
        <div class="sidebar-bottom">
            <a href="<?php echo URLROOT; ?>/admin/settings" class="sidebar-btn-bottom">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Settings</span>
            </a>
            <a href="<?php echo URLROOT; ?>/auth/logout" class="sidebar-btn-bottom btn-logout">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- =========================================================
         MAIN CONTENT AREA WRAPPER
         ========================================================= -->
    <div class="main-wrapper">

        <!-- HEADER -->
        <header class="header">
            <!-- Left: Logo with Name linking to index.php -->
            <div class="header-left">
                <a href="<?php echo URLROOT; ?>/index.php" class="header-logo-link">
                    <img src="<?php echo URLROOT; ?>/public/images/happy_paws_logo.png" alt="Happy Paws Logo" class="header-logo-img" onerror="this.src='https://cdn-icons-png.flaticon.com/512/616/616408.png'">
                    <div class="header-brand-name">
                        Happy Paws
                        <span class="header-brand-badge">System Admin</span>
                    </div>
                </a>
            </div>

            <!-- Right: Admin Image and Name -->
            <div class="header-right">
                <div class="admin-profile">
                    <img src="<?php echo $data['adminAvatar']; ?>" alt="<?php echo $data['adminName']; ?>" class="admin-avatar" onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=120&q=80'">
                    <div class="admin-info">
                        <span class="admin-name"><?php echo htmlspecialchars($data['adminName']); ?></span>
                        <span class="admin-role"><?php echo htmlspecialchars($data['adminRole']); ?></span>
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN DASHBOARD CONTENT -->
        <main class="content-area">

            <!-- WELCOME BANNER (Clean White Card) -->
            <section class="welcome-banner">
                <div class="welcome-text">
                    <h1>Welcome, <?php echo htmlspecialchars($data['adminName']); ?></h1>
                    <p>Here is your system overview, staff operations status, and financial report summaries.</p>
                </div>
                <div class="quick-stats-row">
                    <div class="stat-chip">
                        <div class="stat-chip-val"><?php echo count($data['staffList']); ?></div>
                        <div class="stat-chip-label">Staff Members</div>
                    </div>
                    <div class="stat-chip">
                        <div class="stat-chip-val"><?php echo $data['appointmentsReport']['total']; ?></div>
                        <div class="stat-chip-label">Appointments</div>
                    </div>
                </div>
            </section>

            <!-- =========================================================
                 MIDDLE CONTENT: 2 TABS / PANELS SIDE-BY-SIDE
                 Left: Staff Overview (Name, Role, Status)
                 Right: Clinic Information (Name, Address, Phone, Email, etc.)
                 ========================================================= -->
            <section class="middle-grid">

                <!-- LEFT PANEL: STAFF OVERVIEW -->
                <div class="panel-card">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            Staff Overview
                        </h2>
                        <a href="<?php echo URLROOT; ?>/admin/staff" class="panel-action-btn">Manage Staff &rarr;</a>
                    </div>

                    <div class="staff-table-wrapper">
                        <table class="staff-table">
                            <thead>
                                <tr>
                                    <th>Staff Name</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['staffList'] as $staff): ?>
                                    <tr>
                                        <td>
                                            <div class="staff-profile-cell">
                                                <img src="<?php echo $staff['avatar']; ?>" alt="<?php echo $staff['name']; ?>" class="staff-avatar-mini" onerror="this.src='https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=80&q=80'">
                                                <div>
                                                    <div class="staff-name"><?php echo htmlspecialchars($staff['name']); ?></div>
                                                    <div class="staff-email-sub"><?php echo htmlspecialchars($staff['email']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="role-badge"><?php echo htmlspecialchars($staff['role']); ?></span>
                                        </td>
                                        <td>
                                            <?php 
                                                $statusClass = 'active';
                                                if ($staff['status'] === 'On Leave') $statusClass = 'on-leave';
                                                if ($staff['status'] === 'Busy' || $staff['status'] === 'On Duty') $statusClass = 'active';
                                            ?>
                                            <span class="status-badge <?php echo $statusClass; ?>">
                                                <span class="status-dot"></span>
                                                <?php echo htmlspecialchars($staff['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- RIGHT PANEL: CLINIC INFORMATION -->
                <div class="panel-card">
                    <div class="panel-header">
                        <h2 class="panel-title">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Clinic Information
                        </h2>
                        <a href="<?php echo URLROOT; ?>/admin/clinicInfo" class="panel-action-btn">Edit Details &rarr;</a>
                    </div>

                    <div class="clinic-info-list">
                        <div class="clinic-info-item">
                            <div class="clinic-icon-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div class="clinic-detail-content">
                                <span class="clinic-detail-label">Clinic Name</span>
                                <span class="clinic-detail-value"><?php echo htmlspecialchars($data['clinicInfo']['name']); ?></span>
                            </div>
                        </div>

                        <div class="clinic-info-item">
                            <div class="clinic-icon-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="clinic-detail-content">
                                <span class="clinic-detail-label">Address</span>
                                <span class="clinic-detail-value"><?php echo htmlspecialchars($data['clinicInfo']['address']); ?></span>
                            </div>
                        </div>

                        <div class="clinic-info-item">
                            <div class="clinic-icon-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h32a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V5zM3 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zm0 8a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="clinic-detail-content">
                                <span class="clinic-detail-label">Phone & Emergency</span>
                                <span class="clinic-detail-value"><?php echo htmlspecialchars($data['clinicInfo']['phone']); ?></span>
                            </div>
                        </div>

                        <div class="clinic-info-item">
                            <div class="clinic-icon-box">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="clinic-detail-content">
                                <span class="clinic-detail-label">Email Address</span>
                                <span class="clinic-detail-value"><?php echo htmlspecialchars($data['clinicInfo']['email']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

            <!-- =========================================================
                 BOTTOM SECTION: REPORT SUMMARY (LONG TAB SECTION)
                 ========================================================= -->
            <section class="report-summary-card">

                <div class="report-summary-header">
                    <h2 class="report-summary-title">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Report Summary
                    </h2>

                    <!-- 3 INTERACTIVE TABS BAR -->
                    <div class="report-tabs-bar">
                        <button class="report-tab-btn active" data-tab="tab-appointments">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Appointments
                        </button>
                        <button class="report-tab-btn" data-tab="tab-revenue">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Revenue Report
                        </button>
                        <button class="report-tab-btn" data-tab="tab-performance">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            Staff Performance
                        </button>
                    </div>
                </div>

                <!-- TAB 1: APPOINTMENTS REPORT -->
                <div class="tab-content-pane active" id="tab-appointments">
                    <div class="metrics-row">
                        <div class="metric-card">
                            <span class="metric-card-label">Total Appointments</span>
                            <span class="metric-card-value"><?php echo $data['appointmentsReport']['total']; ?></span>
                            <span class="metric-card-change up">&uarr; 12% this month</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Completed</span>
                            <span class="metric-card-value"><?php echo $data['appointmentsReport']['completed']; ?></span>
                            <span class="metric-card-change up">&uarr; 83% completion rate</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Scheduled / Pending</span>
                            <span class="metric-card-value"><?php echo $data['appointmentsReport']['pending']; ?></span>
                            <span class="metric-card-change">Active queue</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Cancelled</span>
                            <span class="metric-card-value"><?php echo $data['appointmentsReport']['cancelled']; ?></span>
                            <span class="metric-card-change down">&darr; 4.3% low cancel rate</span>
                        </div>
                    </div>

                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pet Name</th>
                                <th>Owner</th>
                                <th>Assigned Vet</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['appointmentsReport']['recent'] as $apt): ?>
                                <tr>
                                    <td><strong><?php echo $apt['id']; ?></strong></td>
                                    <td><?php echo htmlspecialchars($apt['pet']); ?></td>
                                    <td><?php echo htmlspecialchars($apt['owner']); ?></td>
                                    <td><?php echo htmlspecialchars($apt['vet']); ?></td>
                                    <td><?php echo htmlspecialchars($apt['date']); ?></td>
                                    <td>
                                        <span class="status-badge <?php echo $apt['status'] === 'Completed' ? 'active' : 'on-leave'; ?>">
                                            <?php echo htmlspecialchars($apt['status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- TAB 2: REVENUE REPORT -->
                <div class="tab-content-pane" id="tab-revenue">
                    <div class="metrics-row">
                        <div class="metric-card">
                            <span class="metric-card-label">Monthly Revenue</span>
                            <span class="metric-card-value"><?php echo $data['revenueReport']['total_month']; ?></span>
                            <span class="metric-card-change up">&uarr; <?php echo $data['revenueReport']['growth']; ?> vs last month</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Consultation Revenue</span>
                            <span class="metric-card-value"><?php echo $data['revenueReport']['consultation_rev']; ?></span>
                            <span class="metric-card-change">45% total share</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Surgery Revenue</span>
                            <span class="metric-card-value"><?php echo $data['revenueReport']['surgery_rev']; ?></span>
                            <span class="metric-card-change">37% total share</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Pharmacy / Supplies</span>
                            <span class="metric-card-value"><?php echo $data['revenueReport']['pharmacy_rev']; ?></span>
                            <span class="metric-card-change">18% total share</span>
                        </div>
                    </div>

                    <div class="chart-bar-container">
                        <?php 
                            $max = 50000;
                            foreach ($data['revenueReport']['monthly'] as $m): 
                                $val = (float)str_replace(['$', ','], '', $m['amount']);
                                $heightPercent = min(100, round(($val / $max) * 100));
                        ?>
                            <div class="chart-bar-item">
                                <div class="chart-bar-fill" style="height: <?php echo $heightPercent; ?>%;"></div>
                                <span class="chart-bar-label"><?php echo $m['month']; ?> (<?php echo $m['amount']; ?>)</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- TAB 3: STAFF PERFORMANCE -->
                <div class="tab-content-pane" id="tab-performance">
                    <div class="metrics-row">
                        <div class="metric-card">
                            <span class="metric-card-label">Top Performing Clinician</span>
                            <span class="metric-card-value" style="font-size:1.1rem; padding-top:4px;"><?php echo $data['staffPerformance']['top_doctor']; ?></span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Total Hours Logged</span>
                            <span class="metric-card-value"><?php echo $data['staffPerformance']['total_hours']; ?> hrs</span>
                            <span class="metric-card-change up">&uarr; Optimal workload</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Average Satisfaction</span>
                            <span class="metric-card-value"><?php echo $data['staffPerformance']['avg_rating']; ?> / 5.0</span>
                            <span class="metric-card-change up">&uarr; Client rating</span>
                        </div>
                        <div class="metric-card">
                            <span class="metric-card-label">Team Efficiency</span>
                            <span class="metric-card-value">95.4%</span>
                            <span class="metric-card-change up">High performance</span>
                        </div>
                    </div>

                    <table class="report-table">
                        <thead>
                            <tr>
                                <th>Staff Member</th>
                                <th>Consultations Completed</th>
                                <th>Customer Rating</th>
                                <th>Productivity Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data['staffPerformance']['performers'] as $perf): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($perf['name']); ?></strong></td>
                                    <td><?php echo $perf['consultations']; ?> cases</td>
                                    <td><span style="color:#f59e0b; font-weight:600;"><?php echo $perf['rating']; ?></span></td>
                                    <td>
                                        <div style="display:flex; align-items:center; gap:10px;">
                                            <div style="flex:1; background:#e2e8f0; height:8px; border-radius:4px; overflow:hidden;">
                                                <div style="width:<?php echo $perf['productivity']; ?>; background:#006f6a; height:100%;"></div>
                                            </div>
                                            <span style="font-weight:600; font-size:0.85rem;"><?php echo $perf['productivity']; ?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </section>

        </main>
    </div>

</div>

<!-- INTERACTIVE TAB SWITCHING SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.report-tab-btn');
    const tabPanes = document.querySelectorAll('.tab-content-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');

            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            button.classList.add('active');
            const activePane = document.getElementById(targetTab);
            if (activePane) {
                activePane.classList.add('active');
            }
        });
    });
});
</script>

</body>
</html>
