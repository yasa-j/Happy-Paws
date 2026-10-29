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
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3"
    >

    <!-- Schedule CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/vet-schedule.css?v=1000">

     <!-- staff header CSS -->
     <link
    rel="stylesheet"
    href="<?php echo URLROOT; ?>/css/shared-staff-header.css"
>

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

        <?php require APPROOT . '/views/layouts/staff-header.php'; ?>
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

                        <strong><?php echo date('M d, Y'); ?></strong>

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
                                
                            </p>

                        </div>


                        <div class="appointment-total">

                            Total:
                            <strong id="appointment-total">
                                0
                            </strong>

                        </div>

                    </div>


                    <div class="appointments-divider"></div>


                    <!-- Appointment list -->

                    <div
                        class="appointment-list"
                        id="appointment-list"
                    >


                        <!-- Appointment cards are built by vet-schedule.js -->



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

<script>
    // Appointments of the logged-in vet, grouped by date (from VetController::schedule)
    window.vetAppointments = <?php
        echo json_encode(
            $data['appointmentsByDate'] ?? new stdClass(),
            JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        );
    ?>;
</script>

<script src="<?php echo URLROOT; ?>/js/vet-schedule.js"></script>


</body>

</html>