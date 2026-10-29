<?php
$currentUrl = $_GET['url'] ?? 'staff';
$currentPage = explode('/', $currentUrl)[1] ?? 'index';
?>

<aside class="vet-sidebar">

    <!-- LOGO -->
    <div class="vet-sidebar-logo">

        <div class="vet-logo-icon">
            <img
                src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                alt="Happy Paws"
            >
        </div>

        <div class="vet-logo-text">
            <div>Happy Paws</div>
            <span>Pet Care Portal</span>
        </div>

    </div>

    <!-- NAVIGATION -->
    <nav class="vet-navigation">

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff"
            class="vet-nav-item <?php echo ($currentUrl === 'staff' || $currentUrl === 'staff/index') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/dashboard.png"
                    alt="Dashboard"
                >
            </span>
            <span>Dashboard</span>
        </a>

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/appointments"
            class="vet-nav-item <?php echo ($currentPage === 'appointments') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/calendar.png"
                    alt="Appointments"
                >
            </span>
            <span>Appointments</span>
        </a>

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/clients"
            class="vet-nav-item <?php echo ($currentPage === 'clients') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                    alt="Clients"
                >
            </span>
            <span>Clients</span>
        </a>

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/billing"
            class="vet-nav-item <?php echo ($currentPage === 'billing' || $currentPage === 'billingDetails') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/shopping-cart.png"
                    alt="Billing"
                >
            </span>
            <span>Billing</span>
        </a>

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/notifications"
            class="vet-nav-item <?php echo ($currentPage === 'notifications') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/notification.png"
                    alt="Notifications"
                >
            </span>
            <span>Notifications</span>
        </a>

        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/walkin"
            class="vet-nav-item <?php echo ($currentPage === 'walkin') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                    alt="Register Walk-in"
                >
            </span>
            <span>Register Walk-in</span>
        </a>

    </nav>

    <!-- LOGOUT -->
    <a
        href="<?php echo URLROOT; ?>/index.php?url=staff/logout"
        class="vet-logout"
        onclick="return confirm('Are you sure you want to logout?');"
    >
        <span class="vet-logout-icon">⇥</span>
        <span>Logout</span>
    </a>

</aside>