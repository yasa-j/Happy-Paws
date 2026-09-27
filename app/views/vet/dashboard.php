<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Happy Paws - Vet Dashboard</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <!-- Vet Sidebar CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">

    <!-- Vet Dashboard CSS -->
   <!-- Vet Dashboard CSS -->
<link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/vet-dashboard.css?v=3">
</head>

<body>

<div class="vet-layout">

    <!-- ================= VET SIDEBAR ================= -->

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="vet-dashboard-content">


        <!-- ================= HEADER ================= -->

        <header class="vet-header">

            <div class="vet-search">

                <span class="search-icon">⌕</span>

                <input
                    type="text"
                    placeholder="Search appointments, patients..."
                >

            </div>


            <div class="vet-header-right">

                <!-- Notification -->
                <span class="header-notification">
                    ♧
                    <span class="notification-dot"></span>
                </span>


                <!-- Settings -->
                <span class="header-settings">
                    ⚙
                </span>


                <div class="header-divider"></div>


                <!-- Vet Profile -->
                <div class="vet-profile">

                    
                    <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">

                    <div>

                        <strong>
    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
</strong>

                        <span>Lead Veterinarian</span>

                    </div>

                </div>

            </div>

        </header>


        <!-- ================= WELCOME ================= -->

        <section class="welcome-section">

            <div>

                <h1>Welcome Back, Dr.Michael Vance </h1>

            </div>


            <div class="today-box">

                <span class="calendar-icon">□</span>

                <div>

                    <small>TODAY</small>

                    <strong>Oct 24, 2024</strong>

                </div>

            </div>

        </section>


        <!-- ================= STATISTICS ================= -->

        <section class="stats-grid">


            <!-- Today's Appointments -->

            <div class="stat-card">

                <div class="stat-icon">
                    ▣
                </div>

                <span class="stat-title">
                    Today's<br>
                    Appointments
                </span>

                <strong class="stat-number">
                    12
                </strong>

            </div>


            <!-- Completed Today -->

            <div class="stat-card">

                <div class="stat-icon">
                    ●
                </div>

                <span class="stat-title">
                    Completed Today
                </span>

                <strong class="stat-number">
                    8
                </strong>

            </div>


            <!-- Pending Consultations -->

            <div class="stat-card">

                <div class="stat-icon">
                    ♧
                </div>

                <span class="stat-title">
                    Pending<br>
                    Consultations
                </span>

                <strong class="stat-number">
                    4
                </strong>

            </div>


            <!-- Average Rating -->

            <div class="stat-card">

                <div class="stat-icon">
                    ★
                </div>

                <span class="stat-title">
                    Average Rating
                </span>

                <strong class="stat-number">
                    4.9<span class="rating-small">/5</span>
                </strong>

            </div>

        </section>


        <!-- ================= LOWER CONTENT ================= -->

        <section class="dashboard-columns">


            <!-- ================= TODAY'S SCHEDULE ================= -->

            <div class="schedule-card">


                <!-- Card Header -->

                <div class="card-header">

                    <h2>Today's Schedule</h2>

                    <a href="<?php echo URLROOT; ?>/index.php?url=vet/schedule">
                        View Full →
                    </a>

                </div>


                <!-- Table Header -->

                <div class="schedule-header">

                    <span>TIME</span>

                    <span>PATIENT</span>

                    <span>TYPE</span>

                    <span>ACTION</span>

                </div>


                <!-- ================= PATIENT 1 ================= -->

                <div class="schedule-row">


                    <!-- Time -->

                    <div class="appointment-time">
                        09:00 AM
                    </div>


                    <!-- Patient -->

                    <div class="patient-info">

                        <div class="patient-image">
                            🐕
                        </div>

                        <div>

                            <strong>Luka</strong>

                            <span>
                                Owner: John D.
                            </span>

                        </div>

                    </div>


                    <!-- Type -->

                    <div class="appointment-type">

                        General<br>
                        Checkup

                    </div>


                    <!-- Action -->

                    <div class="action-icon">
                        ◉
                    </div>

                </div>


                <!-- ================= PATIENT 2 ================= -->

                <div class="schedule-row">


                    <!-- Time -->

                    <div class="appointment-time">
                        10:30 AM
                    </div>


                    <!-- Patient -->

                    <div class="patient-info">

                        <div class="patient-image">
                            🐈
                        </div>

                        <div>

                            <strong>Pepper</strong>

                            <span>
                                Owner: Sarah W.
                            </span>

                        </div>

                    </div>


                    <!-- Type -->

                    <div class="appointment-type">

                        Vaccination

                    </div>



                    <!-- Action -->

                    <div class="action-icon">
                        ◉
                    </div>

                </div>


                <!-- ================= PATIENT 3 ================= -->

                <div class="schedule-row">


                    <!-- Time -->

                    <div class="appointment-time">
                        11:45 AM
                    </div>


                    <!-- Patient -->

                    <div class="patient-info">

                        <div class="patient-image">
                            🐕
                        </div>

                        <div>

                            <strong>Max</strong>

                            <span>
                                Owner: Emily R.
                            </span>

                        </div>

                    </div>


                    <!-- Type -->

                    <div class="appointment-type">

                        Dental Cleaning

                    </div>


                    <!-- Action -->

                    <div class="action-icon">
                        ◉
                    </div>

                </div>


            </div>


            <!-- ================= RIGHT COLUMN ================= -->

            <div class="right-column">


                <!-- ================= UP NEXT ================= -->

                <div class="up-next-card">


                    <h2>
                        ◷ &nbsp;Up Next
                    </h2>


                    <!-- Bella -->

                    <div class="up-next-item">

                        <div class="time-box">

                            <strong>1:00</strong>

                            <span>PM</span>

                        </div>


                        <div>

                            <strong>
                                Bella
                                <small>(Persian Cat)</small>
                            </strong>

                            <span class="urgent">
                                ● Urgent Care
                            </span>

                        </div>

                    </div>


                    <!-- Charlie -->

                    <div class="up-next-item">

                        <div class="time-box">

                            <strong>2:15</strong>

                            <span>PM</span>

                        </div>


                        <div>

                            <strong>
                                Charlie
                                <small>(Beagle)</small>
                            </strong>

                            <span class="follow-up">
                                ● Follow-up
                            </span>

                        </div>

                    </div>


                </div>


                <!-- ================= RECENT RECORDS ================= -->

                <div class="recent-records-card">


                    <h2>
                        ↶ &nbsp;Recent Records
                    </h2>


                    <!-- Luna -->

                    <div class="record-item">

                        <div class="record-image">
                            🐱
                        </div>


                        <div>

                            <strong>
                                Luna
                            </strong>

                            <span>
                                Feline · Updated 2h ago
                            </span>

                        </div>


                        <button type="button">
                            □
                        </button>

                    </div>


                    <!-- Buster -->

                    <div class="record-item">

                        <div class="record-image">
                            🐶
                        </div>


                        <div>

                            <strong>
                                Buster
                            </strong>

                            <span>
                                Canine · Updated 4h ago
                            </span>

                        </div>


                        <button type="button">
                            □
                        </button>

                    </div>


                    <!-- View All -->

                    <a
                        href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecords"
                        class="view-patients"
                    >
                        View All Patients
                    </a>


                </div>


            </div>


        </section>


    </main>

</div>
<script src="<?php echo URLROOT; ?>/js/vet-dashboard.js"></script>
</body>

</html>