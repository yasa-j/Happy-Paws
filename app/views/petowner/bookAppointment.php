<?php
// Book Appointment Page
?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner.css">
<link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/topbar.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/book-appointment.css">


<div class="petowner-layout">

    <!-- ===================================== -->
    <!-- SIDEBAR -->
    <!-- ===================================== -->

    <?php
    $activePage = 'appointments';
    require_once APPROOT . '/views/layouts/petowner-sidebar.php';
    ?>


    <!-- ===================================== -->
    <!-- MAIN CONTENT -->
    <!-- ===================================== -->

    <div class="appointment-main">


        <!-- ===================================== -->
        <!-- TOP BAR -->
        <!-- ===================================== -->

        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <!-- ===================================== -->
        <!-- PAGE HEADER -->
        <!-- MOVED OUTSIDE appointment-content -->
        <!-- ===================================== -->

        <div class="appointment-page-header">

            <div class="appointment-title-area">

                <h1 id="pageTitle">
                    Book Appointment
                </h1>

                <p id="pageSubtitle">
                    Schedule a visit for your pet in just a few simple steps.
                </p>

            </div>


            <button
                type="button"
                class="appointment-back-btn"
                id="topBackBtn"
                onclick="goBackStep()"
                style="display: none;">

                ← Back

            </button>

        </div>


        <!-- ===================================== -->
        <!-- PAGE CONTENT -->
        <!-- ===================================== -->

        <div class="appointment-content">


            <!-- ===================================== -->
            <!-- ONE SINGLE FORM -->
            <!-- ===================================== -->

            <form
                id="appointmentForm"
                method="POST"
                action="<?php echo URLROOT; ?>/petowner/bookAppointment">


                <!-- ===================================== -->
                <!-- PROGRESS STEPPER -->
                <!-- ===================================== -->

                <div class="appointment-stepper">

                    <div class="step-item active" id="stepper1">

                        <div class="step-circle" id="circle1">
                            1
                        </div>

                        <div class="step-label">
                            Appointment Details
                        </div>

                    </div>


                    <div class="step-line" id="line1"></div>


                    <div class="step-item" id="stepper2">

                        <div class="step-circle" id="circle2">
                            2
                        </div>

                        <div class="step-label">
                            Veterinarian & Schedule
                        </div>

                    </div>


                    <div class="step-line" id="line2"></div>


                    <div class="step-item" id="stepper3">

                        <div class="step-circle" id="circle3">
                            3
                        </div>

                        <div class="step-label">
                            Confirmation
                        </div>

                    </div>

                </div>



                <!-- ===================================== -->
                <!-- STEP 1 - APPOINTMENT DETAILS -->
                <!-- ===================================== -->

                <div
                    class="appointment-step active-step"
                    id="appointmentStep1">


                    <div class="appointment-card">


                        <div class="card-heading">

                            <h2>
                                Appointment Details
                            </h2>

                        </div>



                        <!-- SELECT PET -->

                        <div class="form-field">

                            <label for="pet">
                                Select Pet <span>*</span>
                            </label>

                            <select name="pet_id" id="petSelect" required>

                                <option value="" disabled selected>
                                    Select your pet
                                </option>

                                <?php if (!empty($data['pets'])): ?>

                                    <?php foreach ($data['pets'] as $pet): ?>

                                        <option value="<?php echo $pet->pet_id; ?>">

                                            <?php echo htmlspecialchars($pet->name); ?>

                                            <?php if (!empty($pet->breed)): ?>
                                                - <?php echo htmlspecialchars($pet->breed); ?>
                                            <?php endif; ?>

                                        </option>

                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <option value="" disabled>
                                        No registered pets
                                    </option>

                                <?php endif; ?>

                            </select>

                        </div>



                        <!-- APPOINTMENT TYPE -->

                        <div class="form-field">

                            <label>
                                Appointment Type <span>*</span>
                            </label>


                            <div class="appointment-types">

                                <?php if (!empty($data['services'])): ?>

                                    <?php foreach ($data['services'] as $service): ?>


                                        <!-- APPOINTMENT SERVICE -->

                                        <label class="appointment-type-card">

                                            <input
                                                type="radio"
                                                name="service_id"
                                                value="<?php echo $service->service_id; ?>"
                                                required>


                                            <div class="type-icon">

                                                <?php if ($service->name === 'General Checkup'): ?>

                                                    ♡

                                                <?php elseif ($service->name === 'Vaccination'): ?>

                                                    ✚

                                                <?php elseif ($service->name === 'Follow-up Visit'): ?>

                                                    ▰

                                                <?php elseif ($service->name === 'Sick Visit'): ?>

                                                    ✚

                                                <?php else: ?>

                                                    ♡

                                                <?php endif; ?>

                                            </div>


                                            <div class="type-content">

                                                <strong>
                                                    <?php echo htmlspecialchars($service->name); ?>
                                                </strong>


                                                <p>
                                                    <?php echo htmlspecialchars($service->description); ?>
                                                </p>

                                            </div>

                                        </label>


                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <p>
                                        No appointment services are currently available.
                                    </p>

                                <?php endif; ?>

                            </div>

                        </div>


                        <!-- REASON -->

                        <div class="form-field">

                            <label for="reason">

                                Reason for Visit

                                <span class="optional">
                                    (Optional)
                                </span>

                            </label>


                            <textarea
                                name="reason"
                                id="reason"
                                rows="4"
                                placeholder="Briefly describe the reason for your visit or any concerns about your pet..."></textarea>

                        </div>



                        <!-- STEP BUTTONS -->

                        <div class="appointment-buttons">

                            <button
                                type="button"
                                class="appointment-cancel"
                                onclick="cancelAppointment()">

                                Cancel

                            </button>


                            <button
                                type="button"
                                class="appointment-primary"
                                onclick="goToStep2()">

                                Continue →

                            </button>

                        </div>


                    </div>

                </div>



                <!-- ===================================== -->
                <!-- STEP 2 - VET AND SCHEDULE -->
                <!-- ===================================== -->

                <div
                    class="appointment-step"
                    id="appointmentStep2">


                    <div class="appointment-step2-card">


                        <!-- VETERINARIAN -->

                        <div class="schedule-card">

                            <div class="schedule-card-header">

                                <h2>
                                    Select Veterinarian
                                </h2>

                                <p>
                                    Choose your preferred doctor.
                                </p>

                            </div>


                            <div class="veterinarian-list">

                                <?php if (!empty($data['veterinarians'])): ?>

                                    <?php foreach ($data['veterinarians'] as $vet): ?>

                                        <?php
                                            // Get veterinarian's full name
                                            $vetName =
                                                $vet->first_name . ' ' . $vet->last_name;

                                            // Create initials for the avatar
                                            $initials =
                                                strtoupper(
                                                    substr($vet->first_name, 0, 1) .
                                                    substr($vet->last_name, 0, 1)
                                                );

                                            // Check veterinarian account status
                                            $isActive =
                                                isset($vet->status) &&
                                                strtolower($vet->status) === 'active';
                                        ?>


                                        <label
                                            class="veterinarian-card <?php echo !$isActive ? 'busy' : ''; ?>">

                                            <!-- VETERINARIAN ID -->

                                            <input
                                                type="radio"
                                                name="vet_id"
                                                value="<?php echo $vet->user_id; ?>"
                                                <?php echo $isActive ? 'required' : ''; ?>>


                                            <!-- AVATAR -->

                                            <div class="vet-avatar">
                                                <?php echo htmlspecialchars($initials); ?>
                                            </div>


                                            <!-- VETERINARIAN INFORMATION -->

                                            <div class="vet-info">

                                                <strong>
                                                    Dr.
                                                    <?php
                                                        echo htmlspecialchars($vetName);
                                                    ?>
                                                </strong>


                                                <span>
                                                    Veterinarian
                                                </span>


                                                <?php if ($isActive): ?>

                                                    <small>
                                                        ● AVAILABLE
                                                    </small>

                                                <?php else: ?>

                                                    <small class="busy-text">
                                                        ● UNAVAILABLE
                                                    </small>

                                                <?php endif; ?>

                                            </div>


                                            <!-- CHECK ICON -->

                                            <?php if ($isActive): ?>

                                                <div class="vet-check">
                                                    ✓
                                                </div>

                                            <?php endif; ?>

                                        </label>

                                    <?php endforeach; ?>


                                <?php else: ?>

                                    <p>
                                        No veterinarians are currently available.
                                    </p>

                                <?php endif; ?>

                            </div>

                        </div>



                        <!-- CALENDAR -->

                        <div class="schedule-card">

                            <div class="schedule-card-header">

                                <h2>
                                    Select Date
                                </h2>

                                <p>
                                    September 2026
                                </p>

                            </div>


                            <div class="calendar">

                                <!-- CALENDAR HEADER -->

                                <div class="calendar-header">

                                    <button
                                        type="button"
                                        id="previousMonthBtn">
                                        ‹
                                    </button>


                                    <strong id="calendarMonth">
                                        September 2026
                                    </strong>


                                    <button
                                        type="button"
                                        id="nextMonthBtn">
                                        ›
                                    </button>

                                </div>


                                <!-- DAYS OF WEEK -->

                                <div class="calendar-weekdays">

                                    <span>Su</span>
                                    <span>Mo</span>
                                    <span>Tu</span>
                                    <span>We</span>
                                    <span>Th</span>
                                    <span>Fr</span>
                                    <span>Sa</span>

                                </div>


                                <!-- CALENDAR DAYS -->

                                <div
                                    class="calendar-days"
                                    id="calendarDays">
                                </div>

                            </div>


                            <!-- SELECTED DATE -->

                            <input
                                type="hidden"
                                name="appointment_date"
                                id="appointmentDate"
                                value="">

                        </div>



                        <!-- AVAILABLE TIMES -->

                        <div class="schedule-card">

                            <div class="schedule-card-header">

                                <h2>
                                    Available Time
                                </h2>

                                <p id="selectedTimeDate">
                                    For Tue, Sep 15
                                </p>

                            </div>


                            <div
                                class="time-slots"
                                id="timeSlots">
                            </div>

                        </div>

                    </div>



                    <!-- INFORMATION -->

                    <div class="schedule-info">

                        <span>
                            ⓘ
                        </span>

                        Available times depend on the selected veterinarian's schedule.

                    </div>



                    <!-- BUTTONS -->

                    <div class="appointment-bottom-buttons">

                        <button
                            type="button"
                            class="appointment-secondary"
                            onclick="goToStep1()">

                            ← Previous

                        </button>


                        <button
                            type="button"
                            class="appointment-primary"
                            onclick="goToStep3()">

                            Continue →

                        </button>

                    </div>

                </div>



                <!-- ===================================== -->
                <!-- STEP 3 - CONFIRMATION -->
                <!-- ===================================== -->

                <div
                    class="appointment-step"
                    id="appointmentStep3">


                    <div class="confirmation-card">


                        <div class="confirmation-header">

                            <h2>
                                Appointment Summary
                            </h2>

                            <span class="pending-badge">
                                Pending
                            </span>

                        </div>



                        <div class="confirmation-grid">


                            <!-- PET -->

                            <div class="confirmation-section">

                                <label>
                                    Pet
                                </label>


                                <div class="confirmation-person">

                                    <div class="pet-avatar">
                                        🐕
                                    </div>


                                    <div>

                                        <strong id="summaryPet">
                                            Max
                                        </strong>

                                        <span id="summaryBreed">
                                            Golden Retriever
                                        </span>

                                    </div>

                                </div>

                            </div>



                            <!-- VET -->

                            <div class="confirmation-section">

                                <label>
                                    Veterinarian
                                </label>


                                <div class="confirmation-person">

                                    <div class="vet-avatar small">
                                        SF
                                    </div>


                                    <div>

                                        <strong id="summaryVet">
                                            Dr. Sarah Fernando
                                        </strong>

                                        <span>
                                            General Veterinarian • 8 Yrs Exp
                                        </span>

                                    </div>

                                </div>

                            </div>



                            <!-- APPOINTMENT DETAILS -->

                            <div class="confirmation-section">

                                <label>
                                    Appointment Details
                                </label>

                                <strong id="summaryType">
                                    General Checkup
                                </strong>

                                <span id="summaryReason">
                                    Routine health examination
                                </span>

                            </div>



                            <!-- SCHEDULE -->

                            <div class="confirmation-section">

                                <label>
                                    Schedule
                                </label>

                                <strong>

                                    📅

                                    <span id="summaryDate">
                                        Tuesday, 15 Sep 2026
                                    </span>

                                </strong>

                                <span id="summaryTime">
                                    10:00 AM (30 mins)
                                </span>

                            </div>

                        </div>



                        <div class="confirmation-divider"></div>



                        <!-- CLINIC / OWNER -->

                        <div class="clinic-owner-grid">


                            <div>

                                <label>
                                    Clinic Location
                                </label>

                                <strong>
                                    Happy Paws Veterinary Clinic
                                </strong>

                                <span>
                                    Colombo
                                </span>

                            </div>



                            <div>

                                <label>
                                    Registered Owner
                                </label>

                                <strong>
                                    🔒
                                    <?php
                                    echo htmlspecialchars(
                                        ($data['user']->first_name ?? '') . ' ' .
                                        ($data['user']->last_name ?? '')
                                    );
                                    ?>
                                </strong>

                                <span>
                                    <?php
                                        echo htmlspecialchars(
                                            $data['user']->email ?? ''
                                        );
                                    ?>

                                    •

                                    <?php
                                        echo htmlspecialchars(
                                            $data['user']->phone_number ?? ''
                                        );
                                    ?>
                                </span>

                            </div>

                        </div>



                        <!-- INFORMATION -->

                        <div class="confirmation-info">

                            <span>
                                ●
                            </span>

                            <p>
                                Your appointment is ready to be booked.
                                Click "Book Appointment" to confirm your appointment.
                            </p>

                        </div>



                        <!-- AGREEMENT -->

                        <div class="agreement">

                            <input
                                type="checkbox"
                                id="appointmentAgreement"
                                required>


                            <label for="appointmentAgreement">

                                I confirm that the appointment details above
                                are correct and I agree to the clinic's
                                cancellation policy.

                            </label>

                        </div>



                        <!-- FINAL BUTTONS -->

                        <div class="appointment-bottom-buttons">

                            <button
                                type="button"
                                class="appointment-secondary"
                                onclick="goToStep2()">

                                Previous Step

                            </button>


                            <button
                                type="submit"
                                class="appointment-primary">

                                ▣ Book Appointment

                            </button>

                        </div>


                    </div>

                </div>


            </form>

        </div>

    </div>

</div>



<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>

<script src="<?php echo URLROOT; ?>/js/book-appointment.js"></script>