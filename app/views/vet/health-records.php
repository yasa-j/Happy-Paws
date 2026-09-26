<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Happy Paws - Medical Records</title>


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Vet Sidebar CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    


    <!-- Medical Records CSS -->

    <link
    rel="stylesheet"
   href="<?php echo URLROOT; ?>/css/vet-health-records.css?v=1001">


</head>


<body>

<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- =====================================================
         MAIN CONTENT
         ===================================================== -->

    <main class="vet-main">


        <!-- =================================================
             TOP HEADER
             ================================================= -->

        <header class="vet-topbar">


            <!-- Search -->

            <div class="vet-search">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    id="patient-search"
                    placeholder="Search appointments, patients..."
                >

            </div>



            <!-- Header Right -->

            <div class="vet-header-right">


                <!-- Notifications -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
                    class="header-action notification-button"
                    title="Notifications"
                >

                    ♧

                    <span class="notification-dot"></span>

                </a>


                <!-- Settings -->

                <button
                    type="button"
                    class="header-action"
                    title="Settings"
                >
                    ⚙
                </button>


                <!-- Divider -->

                <div class="header-divider"></div>


                <!-- Profile -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                    class="vet-profile"
                >

                    
                   <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">

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



        <!-- =================================================
             MEDICAL RECORDS CONTENT
             ================================================= -->

        <section class="medical-records-content">


            <!-- =================================================
                 PAGE TITLE
                 ================================================= -->

            <div class="medical-records-title">

                <h1>
                    Medical Records
                </h1>

            </div>



            <!-- =================================================
                 TABS
                 ================================================= -->

            <div class="records-tabs">

                <button
                    type="button"
                    class="records-tab active"
                    data-tab="today"
                >
                    Today's Appointments
                </button>


                <button
                    type="button"
                    class="records-tab"
                    data-tab="all"
                >
                    All Patients
                </button>

            </div>



            <!-- =================================================
     TODAY'S APPOINTMENTS
     ================================================= -->

<div class="records-tab-content active" id="today-tab">

    <?php if (!empty($data['todayAppointments'])): ?>

        <?php foreach ($data['todayAppointments'] as $appointment): ?>

            <div
                class="main-record-card"
                data-patient="<?php
                    echo strtolower(
                        $appointment->pet_name . ' ' .
                        $appointment->owner_first_name . ' ' .
                        $appointment->owner_last_name . ' ' .
                        $appointment->species . ' ' .
                        $appointment->breed . ' ' .
                        $appointment->reason
                    );
                ?>"
            >

                <!-- Decorative circle -->
                <div class="record-decoration"></div>

                <!-- Appointment status -->
                <div class="arrival-status">
                    <span class="status-dot"></span>

                    <?php echo htmlspecialchars($appointment->status); ?>
                </div>

                <!-- Patient top -->
                <div class="record-patient-header">

                    <!-- Pet image -->
                    <div class="pet-image-large">

                        <?php
                        echo strtolower($appointment->species) === 'cat'
                            ? '🐱'
                            : '🐶';
                        ?>

                    </div>

                    <!-- Pet information -->
                    <div class="pet-main-info">

                        <h2>
                            <?php echo htmlspecialchars($appointment->pet_name); ?>
                        </h2>

                        <p>
                            <?php echo htmlspecialchars($appointment->species); ?>

                            <?php if (!empty($appointment->breed)): ?>
                                • <?php echo htmlspecialchars($appointment->breed); ?>
                            <?php endif; ?>
                        </p>

                    </div>

                </div>

                <!-- Appointment information -->
                <div class="record-information">

                    <!-- Owner -->
                    <div class="record-info-item">

                        <span class="record-label">
                            Owner
                        </span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $appointment->owner_first_name . ' ' .
                                $appointment->owner_last_name
                            );
                            ?>
                        </strong>

                    </div>

                    <!-- Time -->
                    <div class="record-info-item">

                        <span class="record-label">
                            Time
                        </span>

                        <strong>
                            <?php
                            echo date(
                                'h:i A',
                                strtotime($appointment->appointment_time)
                            );
                            ?>
                        </strong>

                    </div>

                    <!-- Reason -->
                    <div class="record-info-item reason-item">

                        <span class="record-label">
                            Reason
                        </span>

                        <strong>
                            <?php
                            echo !empty($appointment->reason)
                                ? htmlspecialchars($appointment->reason)
                                : 'No reason provided';
                            ?>
                        </strong>

                    </div>

                </div>

                <!-- Details button -->
                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecordDetails/<?php echo $appointment->pet_id; ?>"
                    class="view-details-button"
                >
                    View More Details
                </a>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="no-appointments">
            <p>No appointments scheduled for today.</p>
        </div>

    <?php endif; ?>


    <!-- =================================================
         UPCOMING APPOINTMENTS
         ================================================= -->

    <?php if (!empty($data['upcomingAppointments'])): ?>

        <div class="upcoming-section">

            <h2>Upcoming Next</h2>

            <?php foreach ($data['upcomingAppointments'] as $appointment): ?>

                <div
                    class="upcoming-record"
                    data-patient="<?php
                        echo strtolower(
                            $appointment->pet_name . ' ' .
                            $appointment->owner_first_name . ' ' .
                            $appointment->owner_last_name . ' ' .
                            $appointment->species . ' ' .
                            $appointment->breed
                        );
                    ?>"
                >

                    <div class="upcoming-pet">

                        <div class="pet-avatar">
                            <?php
                            echo strtoupper(
                                substr($appointment->pet_name, 0, 1)
                            );
                            ?>
                        </div>

                        <div class="upcoming-pet-info">

                            <strong>
                                <?php echo htmlspecialchars($appointment->pet_name); ?>
                            </strong>

                            <span>
                                <?php echo htmlspecialchars($appointment->species); ?>

                                <?php if (!empty($appointment->breed)): ?>
                                    • <?php echo htmlspecialchars($appointment->breed); ?>
                                <?php endif; ?>
                            </span>

                        </div>

                    </div>


                    <div class="upcoming-owner">

                        <span>Owner</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                $appointment->owner_first_name . ' ' .
                                $appointment->owner_last_name
                            );
                            ?>
                        </strong>

                    </div>


                    <div class="upcoming-time">

                        <span>Time</span>

                        <strong>
                            <?php
                            echo date(
                                'h:i A',
                                strtotime($appointment->appointment_time)
                            );
                            ?>
                        </strong>

                    </div>


                <div class="upcoming-date">

    <span>Date</span>

    <strong>
        <?php
        echo date(
            'M d, Y',
            strtotime($appointment->appointment_date)
        );
        ?>
    </strong>

</div>
<a
    href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecordDetails/<?php echo $appointment->pet_id; ?>"
    class="upcoming-view-details-button"
>
    View More Details
</a>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

            <!-- =================================================
                 ALL PATIENTS
                 ================================================= -->

            <div
                class="records-tab-content"
                id="all-tab"
            >


                <div class="all-patients-header">

                    <div>

                        <h2>
                            All Patients
                        </h2>

                        <p>
                            Patients registered with Happy Paws
                        </p>

                    </div>

                    <span class="patient-count">
                        6 Patients
                    </span>

                </div>


                <div class="all-patients-list">


                    <!-- Patient 1 -->

                    <div
                        class="patient-record-row"
                        data-patient="luna emily tan feline persian"
                    >

                        <div class="patient-small-avatar cat">
                            L
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Luna
                            </strong>

                            <span>
                                Feline • Persian
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                Emily Tan
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Luna"
                        >
                            View
                        </button>

                    </div>



                    <!-- Patient 2 -->

                    <div
                        class="patient-record-row"
                        data-patient="buddy mark johnson canine golden retriever"
                    >

                        <div class="patient-small-avatar dog">
                            B
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Buddy
                            </strong>

                            <span>
                                Canine • Golden Retriever
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                Mark Johnson
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Buddy"
                        >
                            View
                        </button>

                    </div>



                    <!-- Patient 3 -->

                    <div
                        class="patient-record-row"
                        data-patient="chloe sarah williams feline siamese"
                    >

                        <div class="patient-small-avatar chloe">
                            C
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Chloe
                            </strong>

                            <span>
                                Feline • Siamese
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                Sarah Williams
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Chloe"
                        >
                            View
                        </button>

                    </div>



                    <!-- Patient 4 -->

                    <div
                        class="patient-record-row"
                        data-patient="bella michael johnson canine labrador"
                    >

                        <div class="patient-small-avatar blue">
                            B
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Bella
                            </strong>

                            <span>
                                Canine • Labrador
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                Michael Johnson
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Bella"
                        >
                            View
                        </button>

                    </div>



                    <!-- Patient 5 -->

                    <div
                        class="patient-record-row"
                        data-patient="max david brown canine beagle"
                    >

                        <div class="patient-small-avatar green">
                            M
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Max
                            </strong>

                            <span>
                                Canine • Beagle
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                David Brown
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Max"
                        >
                            View
                        </button>

                    </div>



                    <!-- Patient 6 -->

                    <div
                        class="patient-record-row"
                        data-patient="coco emma wilson feline persian"
                    >

                        <div class="patient-small-avatar yellow">
                            C
                        </div>

                        <div class="patient-row-info">

                            <strong>
                                Coco
                            </strong>

                            <span>
                                Feline • Persian
                            </span>

                        </div>

                        <div class="patient-row-owner">

                            <span>
                                Owner
                            </span>

                            <strong>
                                Emma Wilson
                            </strong>

                        </div>

                        <button
                            type="button"
                            class="patient-view-button"
                            data-patient="Coco"
                        >
                            View
                        </button>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->


<script src="<?php echo URLROOT; ?>/js/vet-health-records.js?v=2"></script>
</body>

</html>