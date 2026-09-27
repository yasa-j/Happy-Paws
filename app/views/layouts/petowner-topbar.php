<?php

$userName = $_SESSION['user_name'] ?? 'User';

$nameParts = explode(' ', trim($userName));

$initials = '';

foreach ($nameParts as $part) {
    if (!empty($part)) {
        $initials .= strtoupper(substr($part, 0, 1));
    }
}

$initials = substr($initials, 0, 2);

?>
<!-- Pet Owner Topbar -->

<header class="dashboard-topbar">

    <!-- Search -->
    <div class="dashboard-search">

        <img src="<?php echo URLROOT; ?>/Assets/search.png"
             alt="Search"
             class="search-icon">

        <input type="text"
               placeholder="Search pets, records...">

    </div>


    <!-- Top Right Icons -->
    <div class="topbar-actions">

        <!-- Notifications -->
        <a href="<?php echo URLROOT; ?>/petowner/notifications"
           class="topbar-icon">

            <img src="<?php echo URLROOT; ?>/Assets/notification.png"
                 alt="Notifications">

        </a>


        <!-- Cart -->
        <a href="<?php echo URLROOT; ?>/petowner/cart"
           class="topbar-icon">

            <img src="<?php echo URLROOT; ?>/Assets/shopping-cart.png"
                 alt="Shopping Cart">

        </a>


        <!-- User -->
        <a href="<?php echo URLROOT; ?>/petowner/profile" class="topbar-user">

            <div class="user-avatar">
                <?php echo htmlspecialchars($initials); ?>
            </div>

            <span class="user-arrow">
                ▾
            </span>

        </a>

    </div>

</header>