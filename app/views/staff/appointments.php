<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Appointments</title>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- Common Staff CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">

    <!-- Appointment CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-appointments.css">

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


    <!-- SAME SIDEBAR USED BY OTHER PAGES -->

    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>


    <!-- =====================================
         APPOINTMENT CONTENT
    ====================================== -->

    <main class="staff-appointments-content">


        <!-- PAGE HEADING -->

        <div class="appointment-heading">

            <div>

                <h1>
                    Appointment Management
                </h1>

                <p>
                    View and manage all clinic appointments.
                </p>

            </div>


            <div class="appointment-date">

                <span>▣</span>

                Monday, Oct 25th 2027

                <span class="date-arrow">⌄</span>

            </div>

        </div>



        <!-- =================================
             FILTER TABS
        ================================== -->

        <div class="appointment-tabs">

            <button class="appointment-tab active">
                All Appointments
            </button>

            <button class="appointment-tab">
                Completed
            </button>

            <button class="appointment-tab">
                Checked In
            </button>

            <button class="appointment-tab">
                Pending
            </button>

            <button class="appointment-tab">
                Cancelled
            </button>

        </div>



        <!-- =================================
             APPOINTMENTS TABLE
        ================================== -->

        <section class="appointments-table">


            <!-- TABLE HEADER -->

            <div class="appointment-table-header">

                <div>
                    DATE & TIME
                </div>

                <div>
                    PET DETAILS
                </div>

                <div>
                    OWNER
                </div>

                <div>
                    VETERINARIAN
                </div>

                <div>
                    STATUS
                </div>

                <div>
                    ACTIONS
                </div>

            </div>



            <!-- =================================
                 APPOINTMENT 1
            ================================== -->

            <div class="appointment-row">


                <div class="appointment-date-time">

                    <strong>
                        20 May 2025
                    </strong>

                    <span>
                        09:00 AM
                    </span>

                </div>


                <div class="pet-details">

                    <div class="pet-avatar">
                        🐕
                    </div>

                    <div>

                        <strong>
                            Luka
                        </strong>

                        <span>
                            Golden Retriever
                        </span>

                    </div>

                </div>


                <div class="owner-name">
                    John Doe
                </div>


                <div class="vet-name">

                    <span class="vet-icon">
                        ✚
                    </span>

                    Dr. Sarah Lee

                </div>


                <div>

                    <span class="status-badge completed">
                        COMPLETED
                    </span>

                </div>


                <div>

                    <a href="#" class="view-details">
                        View Details →
                    </a>

                </div>


            </div>



            <!-- =================================
                 APPOINTMENT 2
            ================================== -->

            <div class="appointment-row">


                <div class="appointment-date-time">

                    <strong>
                        20 May 2025
                    </strong>

                    <span>
                        10:15 AM
                    </span>

                </div>


                <div class="pet-details">

                    <div class="pet-avatar">
                        🐈
                    </div>

                    <div>

                        <strong>
                            Pepper
                        </strong>

                        <span>
                            Feline
                        </span>

                    </div>

                </div>


                <div class="owner-name">
                    Jane Smith
                </div>


                <div class="vet-name">

                    <span class="vet-icon">
                        ✚
                    </span>

                    Dr. Mike Ross

                </div>


                <div>

                    <span class="status-badge checked-in">
                        CHECKED IN
                    </span>

                </div>


                <div>

                    <a href="#" class="view-details">
                        View Details →
                    </a>

                </div>


            </div>



            <!-- =================================
                 APPOINTMENT 3
            ================================== -->

            <div class="appointment-row">


                <div class="appointment-date-time">

                    <strong>
                        20 May 2025
                    </strong>

                    <span>
                        11:30 AM
                    </span>

                </div>


                <div class="pet-details">

                    <div class="pet-avatar gray-avatar">
                        🐾
                    </div>

                    <div>

                        <strong>
                            Max
                        </strong>

                        <span>
                            Beagle
                        </span>

                    </div>

                </div>


                <div class="owner-name">
                    Robert Wilson
                </div>


                <div class="vet-name">

                    <span class="vet-icon">
                        ✚
                    </span>

                    Dr. Sarah Lee

                </div>


                <div>

                    <span class="status-badge pending">
                        PENDING
                    </span>

                </div>


                <div>

                    <a href="#" class="view-details">
                        View Details →
                    </a>

                </div>


            </div>



            <!-- =================================
                 APPOINTMENT 4
            ================================== -->

            <div class="appointment-row">


                <div class="appointment-date-time">

                    <strong>
                        20 May 2025
                    </strong>

                    <span>
                        01:45 PM
                    </span>

                </div>


                <div class="pet-details">

                    <div class="pet-avatar">
                        🐕
                    </div>

                    <div>

                        <strong>
                            Bella
                        </strong>

                        <span>
                            Bichon Frise
                        </span>

                    </div>

                </div>


                <div class="owner-name">
                    Emily Davis
                </div>


                <div class="vet-name">

                    <span class="vet-icon">
                        ✚
                    </span>

                    Dr. Mike Ross

                </div>


                <div>

                    <span class="status-badge cancelled">
                        CANCELLED
                    </span>

                </div>


                <div>

                    <a href="#" class="view-details">
                        View Details →
                    </a>

                </div>


            </div>



            <!-- =================================
                 TABLE FOOTER
            ================================== -->

            <div class="appointment-table-footer">


                <div class="appointment-showing">

                    SHOWING 1-4 OF 12 APPOINTMENTS

                </div>


                <div class="appointment-pagination">

                    <button class="pagination-arrow">
                        ‹
                    </button>

                    <button class="pagination-number active">
                        1
                    </button>

                    <button class="pagination-number">
                        2
                    </button>

                    <button class="pagination-number">
                        3
                    </button>

                    <button class="pagination-arrow">
                        ›
                    </button>

                </div>


            </div>


        </section>


    </main>


</div>



</body>

</html>