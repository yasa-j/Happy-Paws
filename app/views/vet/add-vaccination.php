<?php

$pet = $data['pet'] ?? [
    'id' => 1,
    'name' => 'Luna',
    'type' => 'Cat',
    'breed' => 'Persian Cat',
    'gender' => 'Female',
    'owner' => 'Emily Tan',
    'age' => '3 Years',
    'weight' => '4.2 kg'
];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Add Vaccination Record - Happy Paws</title>


    <!-- Google Font -->

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
    >


    <!-- Existing Vet Sidebar -->

    <link
        rel="stylesheet"
       href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">


    <!-- Add Vaccination CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-add-vaccination.css?v=999">
    

</head>


<body>


<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php
    require_once APPROOT . '/views/layouts/vet_sidebar.php';
    ?>


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
                    placeholder="Search appointments, patients..."
                >

            </div>


            <!-- Header Right -->

            <div class="vet-header-right">


                <!-- Notification -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
                    class="header-action"
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
             PAGE
             ================================================= -->

        <section class="vaccination-page">


            <!-- =================================================
                 PAGE HEADER
                 ================================================= -->

            <div class="vaccination-page-header">


                <!-- LEFT -->

                <div class="vaccination-heading">


                    <a
                        href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecordDetails/<?php echo $pet['id']; ?>"
                        class="vaccination-back-button"
                        title="Back to Medical Record"
                    >
                        ←
                    </a>


                    <div>


                        <div class="vaccination-label">
                            IMMUNIZATION FORM
                        </div>


                        <h1>
                            Add Vaccination Record
                        </h1>


                        <p>

                            Pet:
                            <strong>
                                <?php echo htmlspecialchars($pet['name']); ?>
                            </strong>

                            <span>•</span>

                            Species:
                            <?php echo htmlspecialchars($pet['type']); ?>

                            <span>•</span>

                            Breed:
                            <?php echo htmlspecialchars($pet['breed']); ?>

                            <span>•</span>

                            Owner:
                            <?php echo htmlspecialchars($pet['owner']); ?>

                        </p>


                    </div>

                </div>



                <!-- =================================================
                     LUNA SUMMARY
                     ================================================= -->

                <div class="pet-summary-card">


                    <div class="pet-summary-top">


                        <div class="pet-summary-image">

                            🐱

                        </div>


                        <div class="pet-summary-info">


                            <div class="pet-summary-name">

                                <?php echo htmlspecialchars($pet['name']); ?>

                                <span class="pet-status">
                                    Indoor
                                </span>

                            </div>


                            <span>
                                <?php echo htmlspecialchars($pet['breed']); ?>
                                •
                                <?php echo htmlspecialchars($pet['gender']); ?>
                            </span>


                            <span class="pet-owner">
                                ♙
                                <?php echo htmlspecialchars($pet['owner']); ?>
                            </span>


                        </div>


                    </div>



                    <div class="pet-summary-bottom">


                        <div>

                            <span>
                                VACCINATION STATUS
                            </span>

                            <strong>
                                ◉ Up to Date
                            </strong>

                        </div>


                        <div>

                            <span>
                                LAST CHECKUP
                            </span>

                            <strong>
                                Sep 12, 2024
                            </strong>

                        </div>


                    </div>


                </div>


            </div>



            <!-- =================================================
                 FORM CARD
                 ================================================= -->

            <div class="vaccination-form-card">


                <!-- =================================================
                     FORM TITLE
                     ================================================= -->

                <div class="form-heading">


                    <div class="form-icon">
                        💉
                    </div>


                    <div>

                        <h2>
                            Vaccination Information
                        </h2>


                        <p>
                            Enter the details of the vaccination
                            administered to
                            <?php echo htmlspecialchars($pet['name']); ?>
                            for veterinary audit and owner wellness logs.
                        </p>

                    </div>


                </div>



                <!-- =================================================
                     FORM
                     ================================================= -->

                <form
                    id="vaccination-form"
                    method="POST"
                    action="<?php echo URLROOT; ?>/index.php?url=vet/saveVaccination"
                >


                    <!-- Pet ID -->

                    <input
                        type="hidden"
                        name="pet_id"
                        value="<?php echo htmlspecialchars($pet['id']); ?>"
                    >



                    <!-- =================================================
                         ROW 1
                         ================================================= -->

                    <div class="form-grid">


                        <!-- Vaccine -->

                        <div class="form-group">


                            <label for="vaccine_name">

                                Vaccine Name

                                <span>*</span>

                            </label>


                            <div class="select-wrapper">


                                <select
                                    id="vaccine_name"
                                    name="vaccine_name"
                                    required
                                >

                                    <option
                                        value=""
                                        selected
                                        disabled
                                    >
                                        Select a vaccine
                                    </option>


                                    <option value="FVRCP (Core)">
                                        FVRCP (Core)
                                    </option>


                                    <option value="Rabies">
                                        Rabies
                                    </option>


                                    <option value="FeLV (Lifestyle)">
                                        FeLV (Lifestyle)
                                    </option>


                                    <option value="Bordetella">
                                        Bordetella
                                    </option>


                                    <option value="Leptospirosis">
                                        Leptospirosis
                                    </option>


                                    <option value="Canine Distemper">
                                        Canine Distemper
                                    </option>


                                    <option value="Canine Parvovirus">
                                        Canine Parvovirus
                                    </option>


                                    <option value="Other">
                                        Other
                                    </option>

                                </select>


                                <span class="select-arrow">
                                    ⌄
                                </span>


                            </div>


                            <small class="field-error"></small>


                        </div>



                        <!-- Manufacturer -->

                        <div class="form-group">


                            <label for="manufacturer">
                                Manufacturer
                            </label>


                            <input
                                type="text"
                                id="manufacturer"
                                name="manufacturer"
                                placeholder="e.g. Zoetis, Merck, Boehringer Ingelheim"
                            >


                        </div>


                    </div>



                    <!-- =================================================
                         ROW 2
                         ================================================= -->

                    <div class="form-grid">


                        <!-- Date Given -->

                        <div class="form-group">


                            <label for="date_given">

                                Date Given

                                <span>*</span>

                            </label>


                            <input
                                type="date"
                                id="date_given"
                                name="date_given"
                                required
                            >


                            <small class="field-error"></small>


                        </div>



                        <!-- Next Due -->

                        <div class="form-group">


                            <div class="label-with-action">


                                <label for="next_due_date">
                                    Next Due Date
                                </label>


                                <button
                                    type="button"
                                    id="default-next-year"
                                    class="date-default-button"
                                >
                                    +1 Year Default
                                </button>


                            </div>


                            <input
                                type="date"
                                id="next_due_date"
                                name="next_due_date"
                            >


                            <small class="field-error"></small>


                        </div>


                    </div>



                    <!-- =================================================
                         ROW 3
                         ================================================= -->

                    <div class="form-grid">


                        <!-- Vaccination Type -->

                        <div class="form-group">


                            <label for="vaccination_type">

                                Vaccination Type

                                <span>*</span>

                            </label>


                            <div class="select-wrapper">


                                <select
                                    id="vaccination_type"
                                    name="vaccination_type"
                                    required
                                >

                                    <option
                                        value=""
                                        selected
                                        disabled
                                    >
                                        Select type
                                    </option>


                                    <option value="Core">
                                        Core
                                    </option>


                                    <option value="Lifestyle">
                                        Lifestyle
                                    </option>


                                    <option value="Booster">
                                        Booster
                                    </option>


                                    <option value="Rabies">
                                        Rabies
                                    </option>


                                    <option value="Other">
                                        Other
                                    </option>

                                </select>


                                <span class="select-arrow">
                                    ⌄
                                </span>


                            </div>


                            <small class="field-error"></small>


                        </div>



                        <!-- Status -->

                        <div class="form-group">


                            <label for="status">

                                Status

                                <span>*</span>

                            </label>


                            <div class="select-wrapper">


                                <select
                                    id="status"
                                    name="status"
                                    required
                                >

                                    <option value="Completed">
                                        Completed
                                    </option>


                                    <option value="Due">
                                        Due
                                    </option>


                                    <option value="Overdue">
                                        Overdue
                                    </option>

                                </select>


                                <span class="select-arrow">
                                    ⌄
                                </span>


                            </div>


                        </div>


                    </div>



                    <!-- =================================================
                         NOTES
                         ================================================= -->

                    <div class="form-group full-width">


                        <div class="label-with-info">


                            <label for="notes">
                                Administering Notes
                            </label>


                            <span id="notes-counter">
                                0/500
                            </span>


                        </div>


                        <textarea
                            id="notes"
                            name="notes"
                            maxlength="500"
                            rows="4"
                            placeholder="Enter any additional notes (e.g. reaction, injection site, remarks, patient behavior, etc.)"
                        ></textarea>


                    </div>



                    <!-- =================================================
                         ACTION BUTTONS
                         ================================================= -->

                    <div class="form-actions">


                        <a
                            href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecordDetails/<?php echo $pet['id']; ?>"
                            class="cancel-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="save-vaccination-button"
                        >

                            <span>
                                ✓
                            </span>

                            Save Vaccination

                        </button>


                    </div>


                </form>


            </div>


        </section>


    </main>


</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script
    src="<?php echo URLROOT; ?>/js/vet-add-vaccination.js?v=4"
></script>


</body>

</html>