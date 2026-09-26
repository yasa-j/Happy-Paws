<?php
$currentUrl = $_GET['url'] ?? 'staff';
?>

<aside class="staff-sidebar">

    <nav class="staff-navigation">

        <!-- Dashboard -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff"
            class="staff-nav-item <?php echo ($currentUrl === 'staff') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/dashboard.png"
                    alt="Dashboard"
                >
            </span>
            <span>Dashboard</span>
        </a>


        <!-- Appointments -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/appointments"
            class="staff-nav-item <?php echo ($currentUrl === 'staff/appointments') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/calendar.png"
                    alt="Appointments"
                >
            </span>
            <span>Appointments</span>
        </a>


        <!-- Clients -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/clients"
            class="staff-nav-item <?php echo ($currentUrl === 'staff/clients') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                    alt="Clients"
                >
            </span>
            <span>Clients</span>
        </a>


        <!-- Billing -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/billing"
            class="staff-nav-item <?php echo ($currentUrl === 'staff/billing') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/shopping-cart.png"
                    alt="Billing"
                >
            </span>
            <span>Billing</span>
        </a>


        <!-- Notifications -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/notifications"
            class="staff-nav-item <?php echo ($currentUrl === 'staff/notifications') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/notification.png"
                    alt="Notifications"
                >
            </span>

            <span>Notifications</span>

            <span class="notification-count">3</span>
        </a>


        <!-- Divider -->
        <div class="sidebar-divider"></div>


        <!-- Register Walk-in -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=staff/walkin"
            class="staff-nav-item walk-in <?php echo ($currentUrl === 'staff/walkin') ? 'active' : ''; ?>"
        >
            <span class="staff-nav-icon">
                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                    alt="Register Walk-in"
                >
            </span>

            <span>Register Walk-in</span>
        </a>

    </nav>


    <!-- Logout -->
    <a
    href="<?php echo URLROOT; ?>/index.php?url=staff/logout"
    class="staff-logout"
    onclick="return confirm('Are you sure you want to logout?');"
>
    <span class="logout-icon">⇥</span>
    <span>Logout</span>
</a>

</aside>