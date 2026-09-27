<!-- DASHBOARD CONTENT -->

<section class="welcome-banner">
    <div class="welcome-text">
        <h1>Welcome, <?php echo htmlspecialchars($data['adminName']); ?></h1>
        <p>
            Here is your system overview, staff operations status, and financial report summaries.
        </p>
    </div>

    <div class="quick-stats-row">
        <div class="stat-chip">
            <div class="stat-chip-val">
                <?php echo $data['totalStaff']; ?>
            </div>

            <div class="stat-chip-label">
                Staff Members
            </div>
        </div>

        <div class="stat-chip">
            <div class="stat-chip-val">
                <?php echo $data['appointmentsReport']['total']; ?>
            </div>

            <div class="stat-chip-label">
                Appointments
            </div>
        </div>

    </div>
</section>

<!-- =========================================================
     MIDDLE CONTENT
     ========================================================= -->

<section class="middle-grid">

    <!-- STAFF OVERVIEW -->
    <div class="panel-card">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Staff Overview
            </h2>

            <a href="<?php echo URLROOT; ?>/admin/staff" class="panel-action-btn">
                Manage Staff &rarr;
            </a>
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
                    <?php if (!empty($data['staffList'])): ?>
                        <?php foreach ($data['staffList'] as $staff): ?>  
                        <tr>
                            <td>
                                <div class="staff-profile-cell">
                                    <img
                                        src="<?php echo URLROOT; ?>/public/images/admin_avatar.png"
                                        alt="<?php echo htmlspecialchars($staff->first_name . ' ' . $staff->last_name); ?>" 
                                        class="staff-avatar-mini">
                                    <div>
                                        <div class="staff-name">
                                            <?php echo htmlspecialchars($staff->first_name . ' ' . $staff->last_name); ?>
                                        </div>
                                        <div class="staff-email-sub">
                                            <?php echo htmlspecialchars($staff->email); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="role-badge">
                                    <?php echo htmlspecialchars($staff->role); ?>
                                </span>
                            </td>

                            <td>
                                <?php
                                    $status = $staff->status ?? 'Inactive';
                                    $statusClass = ($status === 'Active')
                                        ? 'active'
                                        : 'on-leave';
                                ?>
                                <span class="status-badge <?php echo $statusClass; ?>">
                                    <span class="status-dot"></span>
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>

                        <tr>
                            <td colspan="3">
                                No staff members found.
                            </td>
                        </tr>

                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- CLINIC INFORMATION -->

    <div class="panel-card">
        <div class="panel-header">
            <h2 class="panel-title">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Clinic Information
            </h2>

            <a href="<?php echo URLROOT; ?>/admin/clinicInfo" class="panel-action-btn">
                Edit Details &rarr;
            </a>
        </div>

        <div class="clinic-info-list">
            <div class="clinic-info-item">
                <div class="clinic-icon-box">
                    🏥
                </div>
                <div class="clinic-detail-content">
                    <span class="clinic-detail-label">
                        Clinic Name
                    </span>
                    <span class="clinic-detail-value">
                        <?php echo htmlspecialchars($data['clinicInfo']['name'] ?? 'Not available'); ?>
                    </span>
                </div>
            </div>

            <div class="clinic-info-item">
                <div class="clinic-icon-box">
                    📍
                </div>
                <div class="clinic-detail-content">
                    <span class="clinic-detail-label">
                        Address
                    </span>
                    <span class="clinic-detail-value">
                        <?php echo htmlspecialchars($data['clinicInfo']['address'] ?? 'Not available'); ?>
                    </span>
                </div>
            </div>

            <div class="clinic-info-item">
                <div class="clinic-icon-box">
                    ☎
                </div>
                <div class="clinic-detail-content">
                    <span class="clinic-detail-label">
                        Phone & Emergency
                    </span>
                    <span class="clinic-detail-value">
                        <?php echo htmlspecialchars($data['clinicInfo']['phone'] ?? 'Not available'); ?>
                    </span>
                </div>
            </div>

            <div class="clinic-info-item">
                <div class="clinic-icon-box">
                    ✉
                </div>
                <div class="clinic-detail-content">
                    <span class="clinic-detail-label">
                        Email Address
                    </span>
                    <span class="clinic-detail-value">
                        <?php echo htmlspecialchars($data['clinicInfo']['email'] ?? 'Not available'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================
     REPORT SUMMARY
     ========================================================= -->
<section class="report-summary-card">
    <div class="report-summary-header">
        <h2 class="report-summary-title">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Report Summary
        </h2>

        <div class="report-tabs-bar">
            <button class="report-tab-btn active" data-tab="tab-appointments">
                Appointments
            </button>

            <button class="report-tab-btn" data-tab="tab-revenue">
                Revenue Report
            </button>

            <button class="report-tab-btn" data-tab="tab-performance">
                Staff Performance
            </button>
        </div>
    </div>

    <!-- APPOINTMENTS -->
    <div class="tab-content-pane active" id="tab-appointments">
        <div class="metrics-row">
            <div class="metric-card">
                <span class="metric-card-label">
                    Total Appointments
                </span>

                <span class="metric-card-value">
                    <?php echo $data['appointmentsReport']['total']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Completed
                </span>
                <span class="metric-card-value">
                    <?php echo $data['appointmentsReport']['completed']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Pending
                </span>
                <span class="metric-card-value">
                    <?php echo $data['appointmentsReport']['pending']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Cancelled
                </span>
                <span class="metric-card-value">
                    <?php echo $data['appointmentsReport']['cancelled']; ?>
                </span>
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
            <?php if (!empty($data['appointmentsReport']['recent'])): ?>
                <?php foreach ($data['appointmentsReport']['recent'] as $appointment): ?>
                    <tr>
                        <td>
                            <strong>
                                <?php echo htmlspecialchars($appointment['id']); ?>
                            </strong>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($appointment['pet']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($appointment['owner']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($appointment['vet']); ?>
                        </td>

                        <td>
                            <?php echo htmlspecialchars($appointment['date']); ?>
                        </td>

                        <td>
                            <span class="status-badge active">
                                <?php echo htmlspecialchars($appointment['status']); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>

                <tr>
                    <td colspan="6">
                        No appointments found.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- REVENUE -->
    <div class="tab-content-pane" id="tab-revenue">
        <div class="metrics-row">

            <div class="metric-card">
                <span class="metric-card-label">
                    Monthly Revenue
                </span>
                <span class="metric-card-value">
                    <?php echo htmlspecialchars($data['revenueReport']['total_month'] ?? 'Rs. 0'); ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Consultation Revenue
                </span>
                <span class="metric-card-value">
                    <?php echo htmlspecialchars($data['revenueReport']['consultation_rev'] ?? 'Rs. 0'); ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Surgery Revenue
                </span>
                <span class="metric-card-value">
                    <?php echo htmlspecialchars($data['revenueReport']['surgery_rev'] ?? 'Rs. 0'); ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Product Revenue
                </span>
                <span class="metric-card-value">
                    <?php echo htmlspecialchars($data['revenueReport']['pharmacy_rev'] ?? 'Rs. 0'); ?>
                </span>
            </div>
        </div>
    </div>

    <!-- STAFF PERFORMANCE -->
    <div class="tab-content-pane" id="tab-performance">
        <div class="metrics-row">
            
            <div class="metric-card">
                <span class="metric-card-label">
                    Total Staff
                </span>
                <span class="metric-card-value">
                    <?php echo $data['totalStaff']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Veterinarians
                </span>
                <span class="metric-card-value">
                    <?php echo $data['veterinarianCount']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Active Staff
                </span>
                <span class="metric-card-value">
                    <?php echo $data['activeStaffCount']; ?>
                </span>
            </div>

            <div class="metric-card">
                <span class="metric-card-label">
                    Other Staff
                </span>
                <span class="metric-card-value">
                    <?php echo $data['staffCount']; ?>
                </span>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabButtons = document.querySelectorAll('.report-tab-btn');
    const tabPanes = document.querySelectorAll('.tab-content-pane');

    tabButtons.forEach(function (button) {

        button.addEventListener('click', function () {

            const targetTab = button.getAttribute('data-tab');
            tabButtons.forEach(function (btn) {
                btn.classList.remove('active');
            });

            tabPanes.forEach(function (pane) {
                pane.classList.remove('active');
            });

            button.classList.add('active');
            const activePane = document.getElementById(targetTab);

            if (activePane) {
                activePane.classList.add('active');
            }
        });
    });
});
</script>