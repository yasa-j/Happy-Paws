<?php
$currentUrl = $_GET['url'] ?? 'vet';
?>

<aside class="vet-sidebar">

    <!-- ================= LOGO ================= -->

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


    <!-- ================= NAVIGATION ================= -->

    <nav class="vet-navigation">

        <!-- Dashboard -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet"
            class="vet-nav-item <?php echo ($currentUrl === 'vet') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">
    <img src="<?php echo URLROOT; ?>/images/sidebar-icons/dashboard.png" alt="Dashboard">
</span>
            <span>Dashboard</span>
        </a>


        <!-- Schedule -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/schedule"
            class="vet-nav-item <?php echo ($currentUrl === 'vet/schedule') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon"><img src="<?php echo URLROOT; ?>/images/sidebar-icons/calendar.png" alt="Schedule"></span>
            <span>Schedule</span>
        </a>


        <!-- Health Records -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecords"
            class="vet-nav-item <?php echo ($currentUrl === 'vet/healthRecords') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon"><img src="<?php echo URLROOT; ?>/images/sidebar-icons/health-record.png" alt="Health Records"></span>
            <span>Health Records</span>
        </a>


        <!-- Reviews & Ratings -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/reviews"
            class="vet-nav-item <?php echo ($currentUrl === 'vet/reviews') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon">☷</span>
            <span>Reviews &amp; Ratings</span>
        </a>


        <!-- Notifications -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
            class="vet-nav-item <?php echo ($currentUrl === 'vet/notifications') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon"><img src="<?php echo URLROOT; ?>/images/sidebar-icons/notification.png"
                 alt="Notifications"></span>
            <span>Notifications</span>
        </a>


        <!-- Profile -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
            class="vet-nav-item <?php echo ($currentUrl === 'vet/profile') ? 'active' : ''; ?>"
        >
            <span class="vet-nav-icon"><img src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                 alt="Profile"></span>
            <span>Profile</span>
        </a>

    </nav>


   <!-- ================= LOGOUT ================= -->

<a href="<?php echo URLROOT; ?>/index.php?url=vet/logout"
   class="vet-logout"
   onclick="return confirm('Are you sure you want to logout?');">
    <span class="vet-logout-icon">⇥</span>
    <span>Logout</span>
</a>

</aside>