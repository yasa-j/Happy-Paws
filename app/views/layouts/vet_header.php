<!-- ================= HEADER ================= -->

<header class="vet-header">

    <!-- Search -->
    <div class="vet-search">

        <span class="search-icon">
            ⌕
        </span>

        <input
    type="text"
    id="<?php echo $headerSearchId ?? 'vet-global-search'; ?>"
    placeholder="<?php echo htmlspecialchars($headerSearchPlaceholder ?? 'Search appointments, patients...'); ?>"
>

    </div>


    <!-- Header Right -->
    <div class="vet-header-right">

        <!-- Notifications -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
            class="header-action"
            title="Notifications"
        >
            <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/notification.png"
    alt="Notifications"
    style="width: 22px !important; height: 22px !important; max-width: 22px !important; max-height: 22px !important; object-fit: contain !important; display: block !important;"
>

            <span class="notification-dot"></span>
        </a>


        <!-- Settings -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
            class="header-action"
            title="Settings"
        >
            ⚙
        </a>


        <div class="header-divider"></div>


        <!-- Profile -->
        <a
            href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
            class="vet-profile"
        >

            <div class="vet-user-avatar">

                <img
                    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
                    alt="Profile"
                >

            </div>


            <div class="vet-profile-info">

                <strong>
                    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
                </strong>

                <span>
                    Lead Veterinarian
                </span>

            </div>

        </a>

    </div>

</header>