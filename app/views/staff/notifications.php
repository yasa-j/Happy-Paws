<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Notifications</title>


    <!-- Same font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">


    <!-- SAME COMMON STAFF CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">


    <!-- NOTIFICATION CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-notifications.css">

</head>


<body>


<!-- =========================================
     HEADER
========================================= -->

<header class="staff-header">

    <div class="header-logo">

        <img
            src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
            alt="HappyPaws">

        <span>HappyPaws</span>

    </div>


    <div class="search-box">

        <span>⌕</span>

        <input
            type="text"
            placeholder="Search patients, records...">

    </div>


    <div class="header-right">

        <span class="header-icon">?</span>

        <span class="header-icon">⚙</span>

        <div class="user-profile">

            <span>Jane D.</span>

            <img
                src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                alt="User">

        </div>

    </div>

</header>



<!-- =========================================
     SIDEBAR + CONTENT
========================================= -->

<div class="staff-layout">


    <!-- SAME SIDEBAR -->

    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>



    <!-- =====================================
         NOTIFICATIONS CONTENT
    ====================================== -->

    <main class="notifications-content">


        <!-- =================================
             PAGE HEADER
        ================================== -->

        <div class="notifications-heading">

            <div>

                <h1>
                    Notifications
                </h1>

            </div>


            <div class="notification-actions">

                <div class="notification-search">

                    <span>⌕</span>

                    <input
                        type="text"
                        placeholder="Search notifications...">

                </div>


                <button class="filter-button">

                    Filter

                    <span>⇅</span>

                </button>


                <button class="mark-read-button">

                    Mark All as Read

                </button>

            </div>

        </div>



        <!-- =================================
             FILTER TABS
        ================================== -->

        <div class="notification-tabs">

            <button class="notification-tab active">

                All

            </button>


            <button class="notification-tab">

                Unread


            </button>


            <button class="notification-tab">

                Appointments



            </button>


            <button class="notification-tab">

                Payments


            </button>

        </div>



        <!-- =================================
             TODAY
        ================================== -->

        <section class="notification-section">

            <h2>
                TODAY
            </h2>


            <!-- UNREAD NOTIFICATION -->

            <div class="notification-card unread">

                <div class="notification-icon appointment-icon">

                    ♟

                </div>


                <div class="notification-text">

                    <h3>
                        Appointment Confirmed
                    </h3>

                    <p>
                        John Doe's appointment for Bella has been confirmed.
                    </p>

                </div>


                <div class="notification-time">

                    <span>
                        5 mins ago
                    </span>

                    <i></i>

                </div>

            </div>



            <!-- READ NOTIFICATION -->

            <div class="notification-card">

                <div class="notification-icon payment-icon">

                    ▣

                </div>


                <div class="notification-text">

                    <h3>
                        Payment Received
                    </h3>

                    <p>
                        Payment of Rs. 4,500 received successfully.
                    </p>

                </div>


                <div class="notification-time">

                    <span>
                        2 hours ago
                    </span>

                </div>

            </div>

        </section>



        <!-- =================================
             YESTERDAY
        ================================== -->

        <section class="notification-section">

            <h2>
                YESTERDAY
            </h2>


            <div class="notification-card">

                <div class="notification-icon cancelled-icon">

                    ▣

                </div>


                <div class="notification-text">

                    <h3>
                        Appointment Cancelled
                    </h3>

                    <p>
                        James Thomson cancelled Max's appointment.
                    </p>

                </div>


                <div class="notification-time">

                    <span>
                        10:30 AM
                    </span>

                </div>

            </div>

        </section>



        <!-- =================================
             EARLIER
        ================================== -->

        <section class="notification-section">

            <h2>
                EARLIER
            </h2>


            <div class="notification-card">

                <div class="notification-icon feedback-icon">

                    ★

                </div>


                <div class="notification-text">

                    <h3>
                        New Feedback Received
                    </h3>

                    <p>
                        A client submitted a 5-star review for Dr. Smith.
                    </p>

                </div>


                <div class="notification-time">

                    <span>
                        Oct 24
                    </span>

                </div>

            </div>

        </section>


    </main>


</div>

<script src="<?php echo URLROOT; ?>/js/staff-notifications.js"></script>
</body>

</html>