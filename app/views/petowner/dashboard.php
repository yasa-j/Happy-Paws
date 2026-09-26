<?php

/*
 * This page is the Pet Owner Dashboard.
 *
 * The controller sends these values:
 *
 * $userName
 * $petCount
 * $upcomingAppointments
 * $vaccinationsDue
 * $newNotifications
 */

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Happy Paws</title>


    <!-- Pet Owner CSS -->

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">
    <link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/topbar.css">


</head>


<body>


    <!-- ================= SIDEBAR ================= -->

    <?php

    /*
     * Reuse our existing Pet Owner sidebar.
     *
     * We do NOT copy the sidebar HTML here.
     */

    require_once APPROOT . '/views/layouts/petowner-sidebar.php';

    ?>


    <!-- ================= MAIN CONTENT ================= -->

    <main class="petowner-main">


        <!-- ================= TOP BAR ================= -->

        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <!-- ================= DASHBOARD CONTENT ================= -->

        <div class="dashboard-content">


            <!-- ================= WELCOME CARD ================= -->

            <section class="welcome-card">


                <div class="welcome-text">

                    <p class="section-label">
                        DASHBOARD OVERVIEW
                    </p>


                    <h1>
                        <?php echo htmlspecialchars($greeting); ?>
                        <?php echo htmlspecialchars($userName); ?>
                    </h1>


                    <p class="welcome-description">

                        Welcome back to Happy Paws.
                        Here's what's happening with
                        your furry friends today.

                    </p>

                </div>

            </section>



            <!-- ================= STAT CARDS ================= -->

            <section class="stats-grid">


                <!-- My Pets -->

                <div class="stat-card">

                    <div class="stat-icon">
                        <img src="<?php echo URLROOT; ?>/Assets/my-pets.png"
                            alt="My Pets">
                    </div>

                    <h2>
                        <?php echo $petCount; ?>
                    </h2>

                    <p>
                        My Pets
                    </p>

                </div>


                <!-- Upcoming Appointments -->

                <div class="stat-card">

                    <div class="stat-icon">
                        <img src="<?php echo URLROOT; ?>/Assets/appointment.png"
                            alt="Upcoming Appointments">
                    </div>

                    <h2>
                        <?php echo $upcomingAppointments; ?>
                    </h2>

                    <p>
                        Upcoming Appts
                    </p>

                </div>


                <!-- Vaccinations -->

                <div class="stat-card">

                    <div class="stat-icon">
                        <img src="<?php echo URLROOT; ?>/Assets/vaccine.png"
                            alt="Vaccinations Due">
                    </div>

                    <h2>
                        <?php echo $vaccinationsDue; ?>
                    </h2>

                    <p>
                        Vaccinations Due
                    </p>

                </div>


                <!-- Notifications -->

                <div class="stat-card">

                    <div class="stat-icon">
                        <img src="<?php echo URLROOT; ?>/Assets/notify.png"
                            alt="Notifications">
                    </div>

                    <h2>
                        <?php echo $newNotifications; ?>
                    </h2>

                    <p>
                        New Notifications
                    </p>

                </div>


            </section>



            <!-- ================= LOWER DASHBOARD ================= -->

            <section class="dashboard-lower">


                <!-- ================= QUICK ACTIONS ================= -->

                <div class="quick-actions-section">


                    <h2 class="dashboard-section-title">

                        <span>ϟ</span>

                        Quick Actions

                    </h2>


                    <div class="quick-actions-grid">


                        <!-- Book Appointment -->

                        <a href="<?php echo URLROOT; ?>/petowner/bookAppointment"
                           class="quick-action-card">

                            <div class="quick-action-icon">
                                ▣
                            </div>

                            <h3>
                                Book Appointment
                            </h3>

                            <p>
                                Schedule a visit for checkups
                                or concerns.
                            </p>

                        </a>


                        <!-- Add New Pet -->

                        <a href="<?php echo URLROOT; ?>/petowner/registerPet"
                           class="quick-action-card">

                            <div class="quick-action-icon">
                                +
                            </div>

                            <h3>
                                Add New Pet
                            </h3>

                            <p>
                                Register a new furry family
                                member.
                            </p>

                        </a>


                        <!-- Browse Products -->

                        <a href="<?php echo URLROOT; ?>/petowner/store"
                           class="quick-action-card">

                            <div class="quick-action-icon">
                                ▣
                            </div>

                            <h3>
                                Browse Products
                            </h3>

                            <p>
                                Shop for food, toys, and
                                medications.
                            </p>

                        </a>


                        <!-- Medical Records -->

                        <a href="<?php echo URLROOT; ?>/petowner/healthRecords"
                           class="quick-action-card">

                            <div class="quick-action-icon">
                                ▰
                            </div>

                            <h3>
                                Medical Records
                            </h3>

                            <p>
                                View history, lab results,
                                and notes.
                            </p>

                        </a>


                    </div>

                </div>



                <!-- ================= NEEDS ATTENTION ================= -->

                <div class="attention-section">


                    <h2 class="dashboard-section-title">

                        <span>♧</span>

                        Needs Attention

                    </h2>


                    <!-- Upcoming Appointment -->

                    <div class="attention-card appointment-card">


                        <div class="attention-card-header">

                            <span>
                                UPCOMING APPOINTMENT
                            </span>

                            <span class="status-badge">
                                Confirmed
                            </span>

                        </div>


                        <div class="appointment-content">

                            <div class="pet-photo">
                                🐶
                            </div>


                            <div>

                                <h3>
                                    Max – Annual Checkup
                                </h3>

                                <p>
                                    ♧ Dr. Sarah Jenkins
                                </p>

                            </div>

                        </div>


                    </div>



                    <!-- Vaccination Due -->

                    <div class="attention-card vaccine-card">


                        <div class="vaccine-content">


                            <div class="vaccine-big-icon">
                                💉
                            </div>


                            <div class="vaccine-details">

                                <div class="vaccine-title-row">

                                    <h3>
                                        Vaccination Due
                                    </h3>

                                    <span class="days-badge">
                                        In 5 Days
                                    </span>

                                </div>


                                <p class="vaccine-name">
                                    Bella - Rabies Vaccine
                                </p>


                                <p>
                                    It's time for Bella's
                                    annual rabies booster
                                    to keep her protected.
                                </p>


                                <a href="<?php echo URLROOT; ?>/petowner/bookAppointment">

                                    Schedule Now →

                                </a>

                            </div>

                        </div>


                    </div>


                </div>


            </section>


        </div>


    </main>



    <!-- ================= JAVASCRIPT ================= -->

    <script src="<?php echo URLROOT; ?>/js/petowner.js"></script>


</body>

</html>