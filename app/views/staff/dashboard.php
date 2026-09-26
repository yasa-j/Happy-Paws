<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Dashboard</title>

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- COMMON STAFF CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">

    <!-- DASHBOARD CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-dashboard.css">

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
     SIDEBAR + DASHBOARD
========================================= -->

<div class="staff-layout">


    <!-- SAME SIDEBAR USED BY ALL STAFF PAGES -->

    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>


    <!-- =====================================
         DASHBOARD CONTENT
    ====================================== -->

    <main class="staff-dashboard-content">


        <!-- =================================
             PAGE HEADING
        ================================== -->

        <div class="page-heading">

            <div>

                <h1>
                    Welcome Back! 👋
                </h1>

                <p>
                    <span class="info-symbol">ⓘ</span>
                    Here's what's happening at HappyPaws clinic today.
                </p>

            </div>


            <div class="date-box">

                <span>▣</span>

                Monday, Oct 25th 2027

            </div>

        </div>



        <!-- =================================
             STAT CARDS
        ================================== -->

        <section class="stats-grid">


            <!-- TODAY'S APPOINTMENTS -->

            <div class="stat-card">

                <div class="stat-top">

                    <div>

                        <p class="stat-title">
                            TODAY'S APPOINTMENTS
                        </p>

                        <h2>
                            12
                        </h2>

                    </div>


                    <div class="stat-icon green-light">
                        ▣
                    </div>

                </div>


                <div class="card-line"></div>


                <a href="#">
                    Details →
                </a>

            </div>



            <!-- WALK-INS -->

            <div class="stat-card">

                <div class="stat-top">

                    <div>

                        <p class="stat-title">
                            WALK-INS
                        </p>

                        <h2>
                            4
                        </h2>

                    </div>


                    <div class="stat-icon green">
                        ♟
                    </div>

                </div>


                <div class="card-line"></div>


                <a href="#">
                    View all →
                </a>

            </div>



            <!-- NOTIFICATIONS -->

            <div class="stat-card">

                <div class="stat-top">

                    <div>

                        <p class="stat-title">
                            NOTIFICATIONS
                        </p>

                        <h2 class="danger-number">
                            3
                        </h2>

                    </div>


                    <div class="stat-icon red-light">
                        ♧
                    </div>

                </div>


                <div class="card-line"></div>


                <a href="#" class="danger-link">
                    Check →
                </a>

            </div>



            <!-- PAYMENTS -->

            <div class="stat-card payment-card">

                <div class="stat-top">

                    <div>

                        <p class="stat-title">
                            PAYMENTS TODAY
                        </p>

                        <h2>
                            Rs.10,000
                        </h2>

                    </div>


                    <div class="stat-icon payment-icon">
                        ▣
                    </div>

                </div>


                <div class="card-line"></div>


                <div class="payment-bottom">

                    <span>
                        CASH: Rs.2.5k
                    </span>

                    <span>
                        CARD: Rs.7.5k
                    </span>

                    <a href="#">
                        Full Report →
                    </a>

                </div>

            </div>



            <!-- NEW CLIENTS -->

            <div class="stat-card">

                <div class="stat-top">

                    <div>

                        <p class="stat-title">
                            NEW CLIENTS
                        </p>

                        <h2 class="blue-number">
                            3
                        </h2>

                    </div>


                    <div class="stat-icon blue-light">
                        ♙+
                    </div>

                </div>


                <div class="card-line"></div>


                <a href="#" class="blue-link">
                    Profiles →
                </a>

            </div>


        </section>



        <!-- =================================
             RECENT PATIENT ARRIVALS
        ================================== -->

        <section class="recent-section">


            <div class="section-heading">

                <h2>

                    <span></span>

                    Recent Patient Arrivals

                </h2>


                <a href="#">
                    History ↄ
                </a>

            </div>



            <div class="patient-table">


                <!-- TABLE HEADER -->

                <div class="table-header">

                    <span>
                        PATIENT & OWNER
                    </span>

                    <span>
                        VISIT PURPOSE
                    </span>

                    <span>
                        STATUS
                    </span>

                </div>



                <!-- PATIENT 1 -->

                <div class="patient-row">


                    <div class="patient-info">

                        <div class="pet-image">
                            🐕
                        </div>

                        <div>

                            <strong>
                                Cooper
                            </strong>

                            <small>
                                Sarah Jenkins
                            </small>

                        </div>

                    </div>


                    <div>

                        <span class="purpose checkup">
                            Check-up
                        </span>

                    </div>


                    <div class="status-area">

                        <span class="status checked">
                            CHECKED IN
                        </span>

                        <small>
                            2 MINS AGO
                        </small>

                    </div>


                </div>



                <!-- PATIENT 2 -->

                <div class="patient-row">


                    <div class="patient-info">

                        <div class="pet-image">
                            🐈
                        </div>

                        <div>

                            <strong>
                                Luna
                            </strong>

                            <small>
                                Mark Robinson
                            </small>

                        </div>

                    </div>


                    <div>

                        <span class="purpose vaccination">
                            Vaccination
                        </span>

                    </div>


                    <div class="status-area">

                        <span class="status waiting">
                            WAITING
                        </span>

                        <small>
                            15 MINS AGO
                        </small>

                    </div>


                </div>



                <!-- VIEW MORE -->

                <div class="view-more">

                    VIEW MORE

                </div>


            </div>


        </section>


    </main>


</div>
<script src="<?php echo URLROOT; ?>/js/staff-dashboard.js"></script>

</body>

</html>