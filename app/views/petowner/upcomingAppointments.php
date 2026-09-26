<?php
// ---------------------------------------------------------
// Happy Paws - Upcoming Appointments
// Pet Owner Portal
// ---------------------------------------------------------

$activePage = 'appointments';
$activeSubPage = 'upcoming';


// ---------------------------------------------------------
// Safe default values
// ---------------------------------------------------------

$appointments = $appointments ?? [];

$appointmentCount = $appointmentCount ?? count($appointments);

$nextAppointment = $nextAppointment ?? null;


// ---------------------------------------------------------
// Get number of unique pets
// ---------------------------------------------------------

$uniquePets = [];

foreach ($appointments as $appointment) {

    if (!empty($appointment['pet_name'])) {
        $uniquePets[$appointment['pet_name']] = true;
    }
}

$petCount = count($uniquePets);


// ---------------------------------------------------------
// Calculate days until next appointment
// ---------------------------------------------------------

$daysUntilNext = null;

if (!empty($nextAppointment)) {

    $nextDate = strtotime(
        $nextAppointment['year'] . '-' .
        $nextAppointment['month'] . '-' .
        $nextAppointment['date']
    );

    if ($nextDate !== false) {

        $today = strtotime(date('Y-m-d'));

        $daysUntilNext = floor(
            ($nextDate - $today) / 86400
        );
    }
}

?>

<?php if (!empty($_SESSION['success_message'])): ?>

    <div class="success-popup" id="successPopup">

        <div class="success-popup-icon">
            ✓
        </div>

        <div class="success-popup-content">
            <strong>Success!</strong>
            <span>
                <?php echo htmlspecialchars($_SESSION['success_message']); ?>
            </span>
        </div>

        <button
            type="button"
            id="successPopupClose"
            class="success-popup-close">
            ×
        </button>

    </div>

    <?php unset($_SESSION['success_message']); ?>

<?php endif; ?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>

        <?php echo isset($title) ? $title : 'Upcoming Appointments'; ?>

        | Happy Paws

    </title>


    <!-- Main Pet Owner CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/public/css/petowner.css"
    >


    <!-- Topbar CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/topbar.css"
    >


    <!-- Upcoming Appointments CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/public/css/petowner-upcomingAppointments.css"
    >

</head>


<body>


<div class="petowner-layout">


    <!-- =====================================================
         REUSABLE SIDEBAR
         ===================================================== -->

    <?php require APPROOT . '/views/layouts/petowner-sidebar.php'; ?>


    <!-- =====================================================
         MAIN CONTENT
         ===================================================== -->

    <main class="upcoming-main">


        <!-- =====================================================
             TOP HEADER
             ===================================================== -->

        <header class="upcoming-topbar">


            <div class="upcoming-search">

                <span class="search-icon">
                    ⌕
                </span>


                <input
                    type="text"
                    id="appointmentSearch"
                    placeholder="Search pets, records..."
                >

            </div>



            <div class="topbar-actions">


                <!-- Notification -->

                <button
                    class="topbar-icon-button"
                    type="button"
                    title="Notifications"
                >

                    <span>♧</span>

                    <span class="notification-dot"></span>

                </button>



                <!-- Cart -->

                <button
                    class="topbar-icon-button"
                    type="button"
                    title="Cart"
                >

                    🛒

                </button>



                <div class="topbar-divider"></div>



                <!-- Profile -->

                <button
                    class="profile-button"
                    type="button"
                >

                    <div class="profile-avatar">

                        <span>👤</span>

                    </div>


                    <span class="profile-arrow">
                        ⌄
                    </span>

                </button>


            </div>


        </header>



        <!-- =====================================================
             PAGE CONTENT
             ===================================================== -->

        <section class="upcoming-content">


            <!-- =================================================
                 BREADCRUMB
                 ================================================= -->

            <div class="breadcrumb">

                <span>
                    PET OWNER PORTAL
                </span>


                <span class="breadcrumb-arrow">
                    ›
                </span>


                <span>
                    APPOINTMENTS
                </span>


                <span class="breadcrumb-arrow">
                    ›
                </span>


                <strong>
                    UPCOMING APPOINTMENTS
                </strong>

            </div>



            <!-- =================================================
                 PAGE TITLE
                 ================================================= -->

            <div class="page-heading-row">


                <div>

                    <h1>
                        Upcoming Appointments
                    </h1>


                    <p>
                        View and manage your upcoming scheduled visits
                        to Happy Paws clinic.
                    </p>

                </div>



                <a
                    href="<?php echo URLROOT; ?>/petowner/bookAppointment"
                    class="new-appointment-button"
                >

                    <span class="button-icon">
                        ＋
                    </span>

                    Book New Appointment

                </a>


            </div>



            <!-- =================================================
                 SUMMARY CARDS
                 ================================================= -->

            <div class="summary-grid">


                <!-- =================================================
                     UPCOMING COUNT
                     ================================================= -->

                <div class="summary-card">


                    <div class="summary-icon calendar-summary">

                        ▣

                    </div>



                    <div class="summary-information">


                        <span class="summary-label">

                            Upcoming Appointments

                        </span>



                        <div class="summary-number-row">

                            <strong>

                                <?php echo $appointmentCount; ?>

                            </strong>


                            <span>

                                visits booked

                            </span>

                        </div>



                        <span class="summary-highlight">


                            <?php if ($daysUntilNext !== null): ?>

                                <?php if ($daysUntilNext <= 0): ?>

                                    Appointment today

                                <?php elseif ($daysUntilNext == 1): ?>

                                    Next visit tomorrow

                                <?php else: ?>

                                    Next visit in
                                    <?php echo $daysUntilNext; ?>
                                    days

                                <?php endif; ?>


                            <?php else: ?>

                                No upcoming visits

                            <?php endif; ?>


                        </span>


                    </div>


                </div>



                <!-- =================================================
                     NEXT APPOINTMENT
                     ================================================= -->

                <div class="summary-card">


                    <div class="summary-icon clock-summary">

                        ◷

                    </div>



                    <div class="summary-information">


                        <span class="summary-label">

                            Next Appointment

                        </span>



                        <?php if (!empty($nextAppointment)): ?>


                            <strong class="next-appointment-date">


                                <?php

                                echo htmlspecialchars(
                                    $nextAppointment['date']
                                );

                                echo ' ';

                                echo htmlspecialchars(
                                    $nextAppointment['month']
                                );

                                echo ' ';

                                echo htmlspecialchars(
                                    $nextAppointment['year']
                                );

                                echo ', ';

                                echo htmlspecialchars(
                                    $nextAppointment['time']
                                );

                                ?>


                            </strong>



                            <span class="next-appointment-details">


                                <?php

                                echo htmlspecialchars(
                                    $nextAppointment['vet']
                                );

                                ?>


                                •


                                <?php

                                echo htmlspecialchars(
                                    $nextAppointment['pet_name']
                                );

                                ?>


                            </span>


                        <?php else: ?>


                            <strong class="next-appointment-date">

                                No upcoming appointments

                            </strong>


                            <span class="next-appointment-details">

                                Book an appointment to see it here.

                            </span>


                        <?php endif; ?>


                    </div>


                </div>



                <!-- =================================================
                     CLINIC NOTICE
                     ================================================= -->

                <div class="clinic-notice">


                    <div class="notice-icon">

                        i

                    </div>



                    <div class="notice-content">


                        <div class="notice-heading">

                            <strong>
                                CLINIC ARRIVAL NOTICE
                            </strong>


                            <span>
                                • Colombo
                            </span>

                        </div>


                        <p>

                            Please arrive 10 mins prior.
                            Bring existing vaccination records
                            or pet passports.

                        </p>


                    </div>


                </div>


            </div>



            <!-- =================================================
                 FEATURED / NEXT APPOINTMENT
                 ================================================= -->

            <?php if (!empty($appointments)): ?>


                <?php

                $featured = $appointments[0];

                // The controller formats appointment data for this view.
                // Build the original database values needed by the reschedule form.
                $featuredAppointmentId = (int) preg_replace('/[^0-9]/', '', $featured['id']);

                $featuredDate = date(
                    'Y-m-d',
                    strtotime(
                        $featured['date'] . ' ' .
                        $featured['month'] . ' ' .
                        $featured['year']
                    )
                );

                $featuredTime = date(
                    'H:i',
                    strtotime($featured['time'])
                );

                ?>


                <article class="featured-appointment">


                    <!-- =================================================
                         FEATURED DATE
                         ================================================= -->

                    <div class="featured-date">


                        <span class="next-visit-label">

                            NEXT VISIT

                        </span>



                        <strong class="featured-day">

                            <?php

                            echo htmlspecialchars(
                                $featured['date']
                            );

                            ?>

                        </strong>



                        <strong class="featured-month">

                            <?php

                            echo htmlspecialchars(
                                $featured['month']
                            );

                            ?>

                        </strong>



                        <span class="featured-time">

                            <?php

                            echo htmlspecialchars(
                                $featured['time']
                            );

                            ?>

                        </span>



                        <span class="featured-duration">

                            <?php

                            echo htmlspecialchars(
                                $featured['duration']
                            );

                            ?>

                        </span>


                    </div>



                    <!-- =================================================
                         FEATURED DETAILS
                         ================================================= -->

                    <div class="featured-details">


                        <!-- Pet and Room -->

                        <div class="appointment-tags">


                            <span class="appointment-tag">


                                <span class="tag-icon">

                                    ♣

                                </span>



                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $featured['pet_name']
                                    );

                                    ?>

                                </strong>



                                <span>

                                    (

                                    <?php

                                    echo htmlspecialchars(
                                        $featured['pet_type']
                                    );

                                    ?>

                                    ,

                                    <?php

                                    echo htmlspecialchars(
                                        $featured['pet_age']
                                    );

                                    ?>

                                    )

                                </span>


                            </span>



                            <span class="appointment-tag">


                                <span class="tag-icon">

                                    ⌖

                                </span>


                                <?php

                                echo htmlspecialchars(
                                    $featured['room']
                                );

                                ?>


                                •


                                <?php

                                echo htmlspecialchars(
                                    $featured['location']
                                );

                                ?>


                            </span>


                        </div>



                        <!-- Appointment title -->

                        <h2>

                            <?php

                            echo htmlspecialchars(
                                $featured['title']
                            );

                            ?>

                        </h2>



                        <!-- Appointment description -->

                        <p class="featured-description">

                            <?php

                            echo htmlspecialchars(
                                $featured['description']
                            );

                            ?>

                        </p>



                        <!-- Veterinarian -->

                        <div class="veterinarian-info">


                            <div class="vet-icon">

                                ♧

                            </div>



                            <div>


                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $featured['vet']
                                    );

                                    ?>

                                </strong>



                                <span>

                                    <?php

                                    echo htmlspecialchars(
                                        $featured['vet_role']
                                    );

                                    ?>

                                </span>


                            </div>


                        </div>


                    </div>



                    <!-- =================================================
                         FEATURED RIGHT SIDE
                         ================================================= -->

                    <div class="featured-actions">


                        <div class="featured-status">


                            <span class="status-dot">

                                ✓

                            </span>


                            <?php

                            echo htmlspecialchars(
                                $featured['status']
                            );

                            ?>


                        </div>



                        <div class="appointment-reference">


                            Ref:


                            <strong>

                                <?php

                                echo htmlspecialchars(
                                    $featured['id']
                                );

                                ?>

                            </strong>



                            <button
                                type="button"
                                class="copy-reference"
                                data-reference="<?php echo htmlspecialchars($featured['id']); ?>"
                                title="Copy reference"
                            >

                                □

                            </button>


                        </div>



                        <button
                            type="button"
                            class="view-pass-button"
                            data-appointment="<?php echo htmlspecialchars($featured['id']); ?>"
                        >


                            View Appointment Details

                        </button>



                        <div class="featured-secondary-actions">


                            <button
                                type="button"
                                class="reschedule-btn"
                                onclick="openRescheduleModal(
                                    <?php echo $featured['appointment_id']; ?>,
                                    '<?php echo $featured['appointment_date']; ?>',
                                    '<?php echo $featured['appointment_time']; ?>',
                                    <?php echo $featured['vet_id']; ?>,
                                    '<?php echo htmlspecialchars($featured['vet'], ENT_QUOTES); ?>'
                                )">
                                Reschedule
                            </button>



                            <form
                                method="POST"
                                action="<?php echo URLROOT; ?>/petowner/cancelAppointment"
                                class="cancel-form"
                                onsubmit="return confirmCancelAppointment();"
                            >

                                <input
                                    type="hidden"
                                    name="appointment_id"
                                    value="<?php echo htmlspecialchars($featured['appointment_id']); ?>"
                                >

                                <button
                                    type="submit"
                                    class="cancel-button"
                                >
                                    Cancel
                                </button>

                            </form>


                        </div>


                    </div>


                </article>


            <?php endif; ?>



            <!-- =================================================
                 ALL APPOINTMENTS HEADER
                 ================================================= -->

            <div class="appointments-section-heading">


                <div class="section-title-wrapper">


                    <h2>

                        All Scheduled Appointments

                    </h2>



                    <span class="appointment-count-badge">

                        <?php

                        echo $appointmentCount;

                        ?>

                    </span>


                </div>



                <div class="appointment-filters">


                    <!-- PET FILTER -->

                    <button
                        type="button"
                        class="filter-button"
                        id="petFilterButton"
                    >

                        ♣


                        <span>

                            All Pets
                            (<?php echo $petCount; ?>)

                        </span>


                        <span>

                            ⌄

                        </span>

                    </button>



                    <!-- SORT -->

                    <button
                        type="button"
                        class="filter-button"
                        id="sortButton"
                    >

                        ☷


                        <span>

                            Earliest First

                        </span>


                        <span>

                            ⌄

                        </span>

                    </button>


                </div>


            </div>



            <!-- =================================================
                 APPOINTMENT LIST
                 ================================================= -->

            <div
                class="appointment-list"
                id="appointmentList"
            >


                <?php if (!empty($appointments)): ?>


                    <?php foreach ($appointments as $index => $appointment): ?>


                        <article
                            class="appointment-list-card"

                            data-pet="<?php echo htmlspecialchars(
                                strtolower($appointment['pet_name'])
                            ); ?>"

                            data-date="<?php echo htmlspecialchars(
                                $appointment['year'] . '-' .
                                $appointment['month'] . '-' .
                                $appointment['date']
                            ); ?>"
                        >


                            <!-- =================================================
                                 DATE
                                 ================================================= -->

                            <div class="list-date">


                                <strong>

                                    <?php

                                    echo htmlspecialchars(
                                        $appointment['date']
                                    );

                                    ?>

                                </strong>



                                <span>

                                    <?php

                                    echo htmlspecialchars(
                                        $appointment['month']
                                    );

                                    ?>

                                </span>



                                <small>

                                    <?php

                                    echo htmlspecialchars(
                                        $appointment['year']
                                    );

                                    ?>

                                </small>


                            </div>



                            <!-- =================================================
                                 DETAILS
                                 ================================================= -->

                            <div class="list-appointment-content">


                                <div class="list-title-row">


                                    <h3>

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['title']
                                        );

                                        ?>

                                    </h3>



                                    <span class="confirmed-badge">

                                        ✓

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['status']
                                        );

                                        ?>

                                    </span>



                                    <?php if ($index > 0): ?>


                                        <span class="appointment-id">

                                            <?php

                                            echo htmlspecialchars(
                                                $appointment['id']
                                            );

                                            ?>

                                        </span>


                                    <?php endif; ?>


                                </div>



                                <!-- META INFORMATION -->

                                <div class="list-meta">


                                    <span>

                                        ◷

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['time']
                                        );

                                        ?>

                                        –

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['end_time']
                                        );

                                        ?>

                                    </span>



                                    <span>

                                        •

                                    </span>



                                    <span>

                                        ♣

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['pet_name']
                                        );

                                        ?>


                                        (

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['pet_type']
                                        );

                                        ?>

                                        )

                                    </span>



                                    <span>

                                        •

                                    </span>



                                    <span>

                                        ♧

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['vet']
                                        );

                                        ?>

                                    </span>



                                    <span>

                                        •

                                    </span>



                                    <span>

                                        ⌖

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['room']
                                        );

                                        ?>

                                    </span>


                                </div>



                                <!-- DESCRIPTION -->

                                <?php if ($index > 0): ?>


                                    <p class="list-description">

                                        <?php

                                        echo htmlspecialchars(
                                            $appointment['description']
                                        );

                                        ?>

                                    </p>


                                <?php endif; ?>


                            </div>



                            <!-- =================================================
                                 ACTIONS
                                 ================================================= -->

                            <div class="list-actions">


                                <?php
                                $listAppointmentId = (int) preg_replace(
                                    '/[^0-9]/',
                                    '',
                                    $appointment['id']
                                );

                                $listAppointmentDate = date(
                                    'Y-m-d',
                                    strtotime(
                                        $appointment['date'] . ' ' .
                                        $appointment['month'] . ' ' .
                                        $appointment['year']
                                    )
                                );

                                $listAppointmentTime = date(
                                    'H:i',
                                    strtotime($appointment['time'])
                                );
                                ?>

                                <button
                                    type="button"
                                    class="list-reschedule"
                                    onclick="openRescheduleModal(
                                        <?php echo $appointment['appointment_id']; ?>,
                                        '<?php echo $appointment['appointment_date']; ?>',
                                        '<?php echo $appointment['appointment_time']; ?>',
                                        <?php echo $appointment['vet_id']; ?>,
                                        '<?php echo htmlspecialchars($appointment['vet'], ENT_QUOTES); ?>'
                                    )">
                                    Reschedule
                                </button>



                                <button
                                    type="button"
                                    class="view-details-button"
                                    data-appointment="<?php echo htmlspecialchars($appointment['id']); ?>"
                                >

                                    View Details

                                    <span>
                                        →
                                    </span>

                                </button>


                            </div>


                        </article>


                    <?php endforeach; ?>


                <?php else: ?>


                    <!-- =================================================
                         NO APPOINTMENTS
                         ================================================= -->

                    <div class="no-appointments-message">


                        <div class="empty-icon">

                            📅

                        </div>


                        <h3>

                            No upcoming appointments

                        </h3>


                        <p>

                            You currently have no scheduled appointments.

                        </p>


                        <a
                            href="<?php echo URLROOT; ?>/petowner/bookAppointment"
                            class="new-appointment-button"
                        >

                            <span class="button-icon">
                                ＋
                            </span>

                            Book an Appointment

                        </a>


                    </div>


                <?php endif; ?>


            </div>



            <!-- =================================================
                 EMPTY SEARCH RESULT
                 ================================================= -->

            <div
                class="no-appointments-message"
                id="noAppointmentsMessage"
                style="display: none;"
            >


                <div class="empty-icon">

                    🔍

                </div>


                <h3>

                    No appointments found

                </h3>


                <p>

                    Try searching for another pet or appointment.

                </p>


            </div>


        </section>


    </main>


</div>



<!-- =====================================================
     RESCHEDULE APPOINTMENT MODAL
====================================================== -->

<div id="rescheduleModal" class="reschedule-modal">

    <div class="reschedule-box">

        <button
            type="button"
            class="close-reschedule"
            onclick="closeRescheduleModal()">
            &times;
        </button>


        <h2>Reschedule Appointment</h2>

        <p class="reschedule-description">
            Select a new date and available time for your appointment.
        </p>


        <form
            id="rescheduleForm"
            action="<?php echo URLROOT; ?>/petowner/rescheduleAppointment"
            method="POST">


            <!-- =========================================
                 APPOINTMENT ID
            ========================================== -->

            <input
                type="hidden"
                name="appointment_id"
                id="rescheduleAppointmentId">


            <!-- =========================================
                 VETERINARIAN
            ========================================== -->

            <div class="reschedule-vet-section">

                <label>
                    Veterinarian
                </label>

                <div class="reschedule-vet-card">

                    <div class="reschedule-vet-icon">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>

                    <div>

                        <strong id="rescheduleVetName">
                            Veterinarian
                        </strong>

                        <span>
                            Veterinarian
                        </span>

                    </div>

                </div>

            </div>


            <!-- =========================================
                 NEW DATE
            ========================================== -->

            <div class="reschedule-field">

                <label for="rescheduleDate">
                    New Date
                </label>

                <input
                    type="date"
                    name="appointment_date"
                    id="rescheduleDate"
                    min="<?php echo date('Y-m-d'); ?>"
                    required>

            </div>


            <!-- =========================================
                 AVAILABLE TIME SLOTS
            ========================================== -->

            <div class="reschedule-time-section">

                <label>
                    Available Time
                </label>

                <p
                    id="rescheduleTimeMessage"
                    class="reschedule-time-message">
                    Select a date to see available times.
                </p>


                <div
                    id="rescheduleTimeSlots"
                    class="reschedule-time-slots">
                </div>


                <!-- Selected time -->

                <input
                    type="hidden"
                    name="appointment_time"
                    id="rescheduleTime"
                    required>

            </div>


            <!-- =========================================
                 ACTION BUTTONS
            ========================================== -->

            <div class="reschedule-actions">

                <button
                    type="button"
                    class="reschedule-cancel-btn"
                    onclick="closeRescheduleModal()">
                    Cancel
                </button>


                <button
                    type="submit"
                    class="reschedule-save-btn"
                    id="rescheduleSaveBtn"
                    disabled>
                    Save Changes
                </button>

            </div>

        </form>

    </div>

</div>

<script>

/*
|--------------------------------------------------------------------------
| Reschedule Variables
|--------------------------------------------------------------------------
*/

let rescheduleAppointmentId = null;

let rescheduleVetId = null;

let selectedRescheduleDate = null;

let selectedRescheduleTime = null;


/*
|--------------------------------------------------------------------------
| Open Reschedule Modal
|--------------------------------------------------------------------------
*/

function openRescheduleModal(
    appointmentId,
    appointmentDate,
    appointmentTime,
    vetId,
    vetName
) {

    /*
    |--------------------------------------------------------------------------
    | Save appointment information
    |--------------------------------------------------------------------------
    */

    rescheduleAppointmentId = appointmentId;

    rescheduleVetId = vetId;


    /*
    |--------------------------------------------------------------------------
    | Put appointment ID into hidden field
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleAppointmentId'
    ).value = appointmentId;


    /*
    |--------------------------------------------------------------------------
    | Display veterinarian
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleVetName'
    ).textContent = vetName;


    /*
    |--------------------------------------------------------------------------
    | Set current appointment date
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleDate'
    ).value = appointmentDate;


    /*
    |--------------------------------------------------------------------------
    | Clear previous time
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleTime'
    ).value = '';

    selectedRescheduleTime = null;


    /*
    |--------------------------------------------------------------------------
    | Disable Save button
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleSaveBtn'
    ).disabled = true;


    /*
    |--------------------------------------------------------------------------
    | Open modal
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        'rescheduleModal'
    ).style.display = 'flex';


    /*
    |--------------------------------------------------------------------------
    | Load available slots for current date
    |--------------------------------------------------------------------------
    */

    loadRescheduleTimeSlots(appointmentDate);
}


/*
|--------------------------------------------------------------------------
| Load Available Reschedule Time Slots
|--------------------------------------------------------------------------
*/

function loadRescheduleTimeSlots(date) {

    const slotsContainer =
        document.getElementById(
            'rescheduleTimeSlots'
        );

    const message =
        document.getElementById(
            'rescheduleTimeMessage'
        );


    /*
    |--------------------------------------------------------------------------
    | Clear old slots
    |--------------------------------------------------------------------------
    */

    slotsContainer.innerHTML = '';

    message.textContent =
        'Loading available times...';


    /*
    |--------------------------------------------------------------------------
    | Build API URL
    |--------------------------------------------------------------------------
    */

    const url =
        '<?php echo URLROOT; ?>/petowner/getRescheduleAvailability'
        + '?appointment_id='
        + encodeURIComponent(rescheduleAppointmentId)
        + '&date='
        + encodeURIComponent(date);


    /*
    |--------------------------------------------------------------------------
    | Get availability from controller
    |--------------------------------------------------------------------------
    */

    fetch(url)

        .then(function(response) {

            return response.json();

        })

        .then(function(data) {

            /*
            |--------------------------------------------------------------------------
            | Clear loading message
            |--------------------------------------------------------------------------
            */

            slotsContainer.innerHTML = '';


            /*
            |--------------------------------------------------------------------------
            | Check response
            |--------------------------------------------------------------------------
            */

            if (!data.success) {

                message.textContent =
                    data.message ||
                    'Unable to load available times.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | No available slots
            |--------------------------------------------------------------------------
            */

            if (
                !data.slots ||
                data.slots.length === 0
            ) {

                message.textContent =
                    'No available times for this date.';

                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Show available slots
            |--------------------------------------------------------------------------
            */

            message.textContent =
                'Select an available time:';


            data.slots.forEach(function(slot) {

                const button =
                    document.createElement('button');


                button.type = 'button';

                button.className =
                    'reschedule-time-btn';


                button.textContent =
                    slot.display;


                button.dataset.time =
                    slot.value;


                /*
                |--------------------------------------------------------------------------
                | Select time
                |--------------------------------------------------------------------------
                */

                button.addEventListener(
                    'click',
                    function() {

                        /*
                        | Remove previous selection
                        */

                        document
                            .querySelectorAll(
                                '.reschedule-time-btn.selected'
                            )
                            .forEach(function(item) {

                                item.classList.remove(
                                    'selected'
                                );

                            });


                        /*
                        | Select this button
                        */

                        button.classList.add(
                            'selected'
                        );


                        /*
                        | Save selected time
                        */

                        selectedRescheduleTime =
                            slot.value;


                        document.getElementById(
                            'rescheduleTime'
                        ).value =
                            slot.value;


                        /*
                        | Enable save button
                        */

                        document.getElementById(
                            'rescheduleSaveBtn'
                        ).disabled = false;

                    }
                );


                slotsContainer.appendChild(
                    button
                );

            });

        })

        .catch(function(error) {

            console.error(
                'Reschedule availability error:',
                error
            );


            slotsContainer.innerHTML = '';


            message.textContent =
                'Unable to load available times.';

        });
}


/*
|--------------------------------------------------------------------------
| Date Changed
|--------------------------------------------------------------------------
*/

document
    .getElementById('rescheduleDate')
    .addEventListener(
        'change',
        function() {

            const selectedDate =
                this.value;


            /*
            | Clear selected time
            */

            document.getElementById(
                'rescheduleTime'
            ).value = '';


            selectedRescheduleTime =
                null;


            /*
            | Disable Save button
            */

            document.getElementById(
                'rescheduleSaveBtn'
            ).disabled = true;


            /*
            | Load new available slots
            */

            if (selectedDate) {

                loadRescheduleTimeSlots(
                    selectedDate
                );

            }

        }
    );


/*
|--------------------------------------------------------------------------
| Close Modal
|--------------------------------------------------------------------------
*/

function closeRescheduleModal() {

    document.getElementById(
        'rescheduleModal'
    ).style.display = 'none';

}


/*
|--------------------------------------------------------------------------
| Close When Clicking Outside Modal
|--------------------------------------------------------------------------
*/

document
    .getElementById('rescheduleModal')
    .addEventListener(
        'click',
        function(event) {

            if (
                event.target === this
            ) {

                closeRescheduleModal();

            }

        }
    );

</script>

<!-- =====================================================
     Upcoming Appointments JavaScript
     ===================================================== -->

<script
    src="<?php echo URLROOT; ?>/public/js/petowner-upcomingAppointments.js?v=2">
</script>


</body>

</html>