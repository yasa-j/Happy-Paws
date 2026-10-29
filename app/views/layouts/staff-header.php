<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$headerName = $_SESSION['staff_name'] ?? 'Staff Member';

$headerRole = $_SESSION['staff_role'] ?? 'staff';

$headerRoleLabels = [
    'veterinarian' => 'Lead Veterinarian',
    'staff' => 'Receptionist',
    'product_manager' => 'Product Manager',
    'admin' => 'System Administrator'
];

$headerRoleLabel = $headerRoleLabels[$headerRole] ?? 'Staff Member';
?>

<header class="shared-staff-header">

    <div class="shared-header-search">
        <span class="shared-search-icon">⌕</span>

        <input
            type="text"
            placeholder="Search appointments, patients..."
            aria-label="Search appointments and patients"
        >
    </div>

    <div class="shared-header-right">

        <button
            type="button"
            class="shared-header-settings"
            aria-label="Settings"
        >
            ⚙
        </button>

        <div class="shared-header-divider"></div>

        <div class="shared-header-profile">

            <img
                src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                alt="Profile"
            >

            <div class="shared-profile-text">

                <strong>
                    <?php echo htmlspecialchars($headerName); ?>
                </strong>

                <span>
                    <?php echo htmlspecialchars($headerRoleLabel); ?>
                </span>

            </div>

        </div>

    </div>

</header>