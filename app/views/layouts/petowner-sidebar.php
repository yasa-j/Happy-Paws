<?php

/*
 * The $activePage variable is sent by the controller.
 *
 * Examples:
 *
 * dashboard
 * pets
 * register-pet
 * appointments
 * health
 * store
 * notifications
 * profile
 *
 * If it hasn't been set, use an empty value.
 */

$activePage = $activePage ?? '';

?>

<!-- ================= PET OWNER SIDEBAR ================= -->

<aside class="petowner-sidebar">


    <!-- ================= BRAND ================= -->

    <div class="sidebar-brand">

        <div class="brand-logo">
            <img src="<?php echo URLROOT; ?>/Assets/Images/logo.png"
                alt="Happy Paws Logo">
        </div>

        <div class="brand-text">
            <h2>Happy Paws</h2>
            <p>Pet Care Portal</p>
        </div>

    </div>


    <!-- ================= NAVIGATION ================= -->

    <nav class="sidebar-navigation">


        <!-- ================= DASHBOARD ================= -->

        <a href="<?php echo URLROOT; ?>/petowner/dashboard"
           class="sidebar-link <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">

            <span class="sidebar-icon">

                <img src="<?php echo URLROOT; ?>/Assets/dashboard.png"
                     alt="Dashboard Icon">

            </span>

            <span>Dashboard</span>

        </a>


        <!-- ================= MY PETS ================= -->

        <div class="sidebar-dropdown">

            <?php
            /*
             * If one of the My Pets pages is active,
             * we also highlight the My Pets button.
             */
            $petsActive =
                ($activePage == 'pets' ||
                 $activePage == 'register-pet');
            ?>

            <button type="button"
                    class="sidebar-link dropdown-button
                    <?php echo $petsActive ? 'active' : ''; ?>"
                    onclick="toggleDropdown('petsDropdown')">

                <span class="sidebar-icon">

                    <img src="<?php echo URLROOT; ?>/Assets/pets.png"
                        alt="My Pets">

                </span>

                <span class="dropdown-title">
                    My Pets
                </span>

                <span class="dropdown-arrow">
                    ▾
                </span>

            </button>


            <!-- My Pets Dropdown -->

            <div class="dropdown-menu
                        <?php echo $petsActive ? 'show' : ''; ?>"
                 id="petsDropdown">

                <a href="<?php echo URLROOT; ?>/petowner/pets"
                   class="<?php echo ($activePage == 'pets') ? 'submenu-active' : ''; ?>">

                    My Pets

                </a>

                <a href="<?php echo URLROOT; ?>/petowner/registerPet"
                   class="<?php echo ($activePage == 'register-pet') ? 'submenu-active' : ''; ?>">

                    Register New Pet

                </a>

            </div>

        </div>


        <!-- ================= APPOINTMENTS ================= -->

        <div class="sidebar-dropdown">

            <?php

            /*
             * Check whether one of the appointment pages
             * is currently active.
             */

            $appointmentsActive =
                ($activePage == 'book-appointment' ||
                 $activePage == 'upcoming' ||
                 $activePage == 'history');

            ?>

            <button type="button"
                    class="sidebar-link dropdown-button
                    <?php echo $appointmentsActive ? 'active' : ''; ?>"
                    onclick="toggleDropdown('appointmentsDropdown')">

                <span class="sidebar-icon">

                    <img src="<?php echo URLROOT; ?>/Assets/calendar.png"
                        alt="Appointments">

                </span>

                <span class="dropdown-title">
                    Appointments
                </span>

                <span class="dropdown-arrow">
                    ▾
                </span>

            </button>


            <!-- Appointment Dropdown -->

            <div class="dropdown-menu
                        <?php echo $appointmentsActive ? 'show' : ''; ?>"
                 id="appointmentsDropdown">

                <a href="<?php echo URLROOT; ?>/petowner/bookAppointment"
                   class="<?php echo ($activePage == 'book-appointment') ? 'submenu-active' : ''; ?>">

                    Book Appointment

                </a>

                <a href="<?php echo URLROOT; ?>/petowner/upcomingAppointments"
                   class="<?php echo ($activePage == 'upcoming') ? 'submenu-active' : ''; ?>">

                    Upcoming

                </a>

                <a href="<?php echo URLROOT; ?>/petowner/appointmentHistory"
                   class="<?php echo ($activePage == 'history') ? 'submenu-active' : ''; ?>">

                    History

                </a>

            </div>

        </div>


        <!-- ================= HEALTH RECORDS ================= -->

        <a href="<?php echo URLROOT; ?>/petowner/healthRecords"
           class="sidebar-link
           <?php echo ($activePage == 'health-records') ? 'active' : ''; ?>">

            <span class="sidebar-icon">

                <img src="<?php echo URLROOT; ?>/Assets/medical-report.png"
                    alt="Health Records">

            </span>

            <span>Health Records</span>

        </a>


        <!-- ================= PRODUCT STORE ================= -->

        <div class="sidebar-dropdown">

            <?php

            /*
             * Product Store pages.
             */

            $storeActive =
                ($activePage == 'store' ||
                 $activePage == 'cart' ||
                 $activePage == 'orders');

            ?>

            <button type="button"
                    class="sidebar-link dropdown-button
                    <?php echo $storeActive ? 'active' : ''; ?>"
                    onclick="toggleDropdown('storeDropdown')">

                <span class="sidebar-icon">

                    <img src="<?php echo URLROOT; ?>/Assets/online-store.png"
                        alt="Product Store">

                </span>

                <span class="dropdown-title">
                    Product Store
                </span>

                <span class="dropdown-arrow">
                    ▾
                </span>

            </button>


            <!-- Product Store Dropdown -->

            <div class="dropdown-menu
                        <?php echo $storeActive ? 'show' : ''; ?>"
                 id="storeDropdown">

                <a href="<?php echo URLROOT; ?>/petowner/store"
                   class="<?php echo ($activePage == 'store') ? 'submenu-active' : ''; ?>">

                    Browse Products

                </a>

                <a href="<?php echo URLROOT; ?>/petowner/cart"
                   class="<?php echo ($activePage == 'cart') ? 'submenu-active' : ''; ?>">

                    My Cart

                </a>

                <a href="<?php echo URLROOT; ?>/petowner/orders"
                   class="<?php echo ($activePage == 'orders') ? 'submenu-active' : ''; ?>">

                    My Orders

                </a>

            </div>

        </div>


        <!-- ================= NOTIFICATIONS ================= -->

        <a href="<?php echo URLROOT; ?>/petowner/notifications"
           class="sidebar-link
           <?php echo ($activePage == 'notifications') ? 'active' : ''; ?>">

            <span class="sidebar-icon">

                <img src="<?php echo URLROOT; ?>/Assets/notification.png"
                    alt="Notifications">

            </span>

            <span>Notifications</span>

        </a>


        <!-- ================= PROFILE ================= -->

        <a href="<?php echo URLROOT; ?>/petowner/profile"
           class="sidebar-link
           <?php echo ($activePage == 'profile') ? 'active' : ''; ?>">

            <span class="sidebar-icon">

                <img src="<?php echo URLROOT; ?>/Assets/profile.png"
                    alt="Profile">

            </span>

            <span>Profile</span>

        </a>


    </nav>


    <!-- ================= LOGOUT ================= -->

    <div class="sidebar-logout">

        <a href="<?php echo URLROOT; ?>/auth/logout"
            class="logout-btn"
            onclick="return confirm('Are you sure you want to logout?');">

            <span>⇥</span>
            Logout

        </a>

    </div>

</aside>