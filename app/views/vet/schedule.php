<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Happy Paws - Schedule</title>

    <!-- Google Font -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Vet Sidebar CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    >

    <!-- Schedule CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/vet-schedule.css?v=999">

</head>


<body>

<div class="vet-page">


    <!-- =========================================================
         SIDEBAR
         ========================================================= -->

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- =========================================================
         MAIN AREA
         ========================================================= -->

    <main class="vet-main">


        <!-- =====================================================
             TOP HEADER
             ===================================================== -->

        <header class="vet-topbar">

            <!-- Search -->
            <div class="vet-search">

                <span class="search-icon">⌕</span>

                <input
                    type="text"
                    placeholder="Search appointments, patients..."
                >

            </div>


            <!-- Header right -->
            <div class="vet-header-right">

                <!-- Notification -->
                <button class="header-action notification-button">
                    ♧
                    <span class="notification-dot"></span>
                </button>


                <!-- Settings -->
                <button class="header-action">
                    ⚙
                </button>


                <!-- Divider -->
                <div class="header-divider"></div>


                <!-- Profile -->
                <div class="vet-profile">

                  
                    <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">

                    <div class="vet-profile-info">

                        <strong>
    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
</strong>

                        <span>Lead Veterinarian</span>

                    </div>

                </div>

            </div>

        </header>


        <!-- =====================================================
             PAGE CONTENT
             ===================================================== -->

        <section class="schedule-content">


            <!-- Page heading -->

            <div class="schedule-heading">

                <h1>Schedule</h1>


                <div class="today-box">

                    <span class="today-calendar-icon">▣</span>

                    <div>

                        <small>TODAY</small>

                        <strong>Oct 24, 2024</strong>

                    </div>

                </div>

            </div>



            <!-- =================================================
                 SCHEDULE GRID
                 ================================================= -->

            <div class="schedule-grid">


                <!-- =============================================
                     APPOINTMENTS
                     ============================================= -->

                <section class="appointments-card">


                    <div class="appointments-header">

                        <div>

                            <h2>
                                Appointments for Selected Date
                            </h2>

                            <p id="selected-date-text">
                                Monday, 25 October 2027
                            </p>

                        </div>


                        <div class="appointment-total">

                            Total:
                            <strong id="appointment-total">
                                8
                            </strong>

                        </div>

                    </div>


                    <div class="appointments-divider"></div>


                    <!-- Appointment list -->

                    <div
                        class="appointment-list"
                        id="appointment-list"
                    >


                        <!-- Appointment 1 -->

                        <div class="appointment-card">

                            <div class="appointment-time">

                                <strong>09:00</strong>

                                <span>30 min</span>

                            </div>


                            <div class="appointment-pet-image">

                                <img
                                    src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                                    alt="Buddy"
                                >

                            </div>


                            <div class="appointment-pet-info">

                                <h3>Buddy</h3>

                                <p>
                                    Owner:
                                    <br>
                                    John
                                    <br>
                                    Smith
                                </p>

                            </div>


                            <div class="appointment-purpose">

                                Annual
                                <br>
                                Checkup

                            </div>


                            <div class="appointment-status completed">

                                Completed

                            </div>

                        </div>



                        <!-- Appointment 2 -->

                        <div class="appointment-card">

                            <div class="appointment-time">

                                <strong>09:45</strong>

                                <span>15 min</span>

                            </div>


                            <div class="appointment-pet-image paw">

                                🐾

                            </div>


                            <div class="appointment-pet-info">

                                <h3>Luna</h3>

                                <p>
                                    Owner:
                                    <br>
                                    Emily
                                    <br>
                                    Davis
                                </p>

                            </div>


                            <div class="appointment-purpose">

                                Vaccination

                            </div>


                            <div class="appointment-status checked">

                                Checked
                                <br>
                                In

                            </div>

                        </div>



                        <!-- Appointment 3 -->

                        <div class="appointment-card">

                            <div class="appointment-time">

                                <strong>10:30</strong>

                                <span>45 min</span>

                            </div>


                            <div class="appointment-pet-image">

                                <img
                                    src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                                    alt="Bella"
                                >

                            </div>


                            <div class="appointment-pet-info">

                                <h3>Bella</h3>

                                <p>
                                    Owner:
                                    <br>
                                    Michael
                                    <br>
                                    Johnson
                                </p>

                            </div>


                            <div class="appointment-purpose">

                                Dental
                                <br>
                                Exam

                            </div>


                            <div class="appointment-status pending">

                                Pending

                            </div>

                        </div>


                    </div>

                </section>



                <!-- =============================================
                     CALENDAR
                     ============================================= -->

                <section class="calendar-card">


                    <!-- Calendar header -->

                    <div class="calendar-header">

                        <button
                            type="button"
                            class="calendar-arrow"
                            id="previous-month"
                        >
                            ‹
                        </button>


                        <h2 id="calendar-month">
                            October 2027
                        </h2>


                        <button
                            type="button"
                            class="calendar-today"
                            id="calendar-today"
                        >
                            Today
                        </button>


                        <button
                            type="button"
                            class="calendar-arrow"
                            id="next-month"
                        >
                            ›
                        </button>

                    </div>



                    <!-- Week days -->

                    <div class="calendar-weekdays">

                        <span>S</span>
                        <span>M</span>
                        <span>T</span>
                        <span>W</span>
                        <span>T</span>
                        <span>F</span>
                        <span>S</span>

                    </div>



                    <!-- Calendar dates -->

                    <div
                        class="calendar-days"
                        id="calendar-days"
                    >

                    </div>



                    <!-- Calendar legend -->

                    <div class="calendar-divider"></div>


                    <div class="calendar-legend">

                        <div class="legend-item">

                            <span class="legend-dot available"></span>

                            <span>Available</span>

                        </div>


                        <div class="legend-item">

                            <span class="legend-dot busy"></span>

                            <span>Busy</span>

                        </div>


                        <div class="legend-item">

                            <span class="legend-dot booked"></span>

                            <span>Fully Booked</span>

                        </div>

                    </div>


                    <div class="no-appointments-legend">

                        <span class="legend-dot no-appointments"></span>

                        <span>No Appts</span>

                    </div>


                </section>

            </div>

        </section>

    </main>

</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script src="<?php echo URLROOT; ?>/js/vet-schedule.js"></script>


</body>

</html>