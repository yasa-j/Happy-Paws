<?php

$pet = $data['pet'] ?? [
    'id' => 1,
    'name' => 'Luna',
    'type' => 'Cat',
    'breed' => 'Persian Cat',
    'age' => '3 Years',
    'weight' => '4.2 kg',
    'owner' => 'Emily Tan',
    'image' => 'cat'
];

$vaccinations = $data['vaccinations'] ?? [];

$allergies = $data['allergies'] ?? [];

$medications = $data['medications'] ?? [];

$treatments = $data['treatments'] ?? [];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo $data['title']; ?>
    </title>


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- Shared Vet Sidebar -->

    <link
        rel="stylesheet"
       href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">


    <!-- Medical Record Details CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-health-record-details.css?v=999">
    

</head>


<body>

<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- =====================================================
         MAIN
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



            <!-- Header right -->

            <div class="vet-header-right">


                <!-- Notifications -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
                    class="header-action"
                >

                    ♧

                    <span class="notification-dot"></span>

                </a>


                <!-- Settings -->

                <button
                    type="button"
                    class="header-action"
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
             CONTENT
             ================================================= -->

        <section class="medical-detail-content">


            <!-- =================================================
                 PET HEADER CARD
                 ================================================= -->

            <section class="pet-profile-card">


                <!-- Pet image -->

                <div class="pet-profile-image">

                    <span>
                        🐱
                    </span>

                </div>


                <!-- Pet main information -->

                <div class="pet-profile-main">

                    <div class="pet-name-line">

                        <h1>
                            <?php echo $data['pet']['name']; ?>
                        </h1>

                        <span class="pet-type-badge">
                            ♧
                            <?php echo $data['pet']['type']; ?>
                        </span>

                    </div>


                    <div class="pet-details-grid">


                        <div class="pet-detail-item">

                            <span>
                                BREED
                            </span>

                            <strong>
                                <?php echo $data['pet']['breed']; ?>
                            </strong>

                        </div>


                        <div class="pet-detail-item">

                            <span>
                                AGE
                            </span>

                            <strong>
                                <?php echo $data['pet']['age']; ?>
                            </strong>

                        </div>


                        <div class="pet-detail-item">

                            <span>
                                WEIGHT
                            </span>

                            <strong>
                                <?php echo $data['pet']['weight']; ?>
                            </strong>

                        </div>


                        <div class="pet-detail-item owner-detail">

                            <span>
                                OWNER
                            </span>

                            <strong>
                                ♙
                                <?php echo $data['pet']['owner']; ?>
                            </strong>

                        </div>

                    </div>

                </div>


                <!-- Edit -->

                <button
                    type="button"
                    class="edit-pet-button"
                    id="edit-pet-button"
                    title="Edit Pet"
                >
                    ✎
                </button>

            </section>



            <!-- =================================================
                 TWO COLUMN CONTENT
                 ================================================= -->

            <div class="medical-detail-grid">


                <!-- =================================================
                     LEFT COLUMN
                     ================================================= -->

                <div class="medical-left-column">


                    <!-- =================================================
                         VACCINATION HISTORY
                         ================================================= -->

                    <section class="medical-card vaccination-card">


                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon vaccination-icon">
                                    ♜
                                </span>

                                <h2>
                                    Vaccination History
                                </h2>

                            </div>


                     <a
    href="<?php echo URLROOT; ?>/index.php?url=vet/addVaccination/<?php echo $pet['id']; ?>"
    class="add-record-button"
>
    <span class="add-icon">+</span>
    Add Record
</a>

                        </div>


                        <!-- Table -->

                        <div class="vaccination-table">


                            <!-- Header -->

                            <div class="vaccination-table-header">

                                <span>
                                    DATE GIVEN
                                </span>

                                <span>
                                    VACCINE NAME
                                </span>

                                <span>
                                    STATUS
                                </span>

                                <span>
                                    NEXT DUE
                                </span>

                            </div>


                            <!-- Rows -->

                            <?php foreach ($data['vaccinations'] as $vaccination): ?>

                                <div class="vaccination-row">


                                    <span class="vaccination-date">

                                        <?php
                                        echo $vaccination['date'];
                                        ?>

                                    </span>


          <span class="vaccination-name">

    <a
        href="<?php echo URLROOT; ?>/index.php?url=vet/vaccinationDetails/<?php echo $vaccination['id']; ?>"
        class="vaccination-link"
    >
        <?php echo htmlspecialchars($vaccination['vaccine']); ?>
    </a>

</span>


                                    <span>

                                        <?php if ($vaccination['status_class'] === 'completed'): ?>

                                            <span class="vaccination-status completed">
                                                ✓
                                                <?php
                                                echo $vaccination['status'];
                                                ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="vaccination-status due">
                                                △
                                                <?php
                                                echo $vaccination['status'];
                                                ?>
                                            </span>

                                        <?php endif; ?>

                                    </span>


                                    <span
                                        class="
                                            vaccination-next-due
                                            <?php
                                            echo ($vaccination['status_class'] === 'due')
                                                ? 'danger-date'
                                                : '';
                                            ?>
                                        "
                                    >

                                        <?php
                                        echo $vaccination['next_due'];
                                        ?>

                                    </span>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>



                    <!-- =================================================
                         CLINICAL TREATMENTS
                         ================================================= -->

                    <section class="medical-card treatments-card">


                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon treatment-icon">
                                    ✚
                                </span>

                                <h2>
                                    Clinical Treatments
                                </h2>

                            </div>


                            <button
                                type="button"
                                class="header-text-button"
                                id="view-all-treatments"
                            >
                                View All
                            </button>

                        </div>


                        <!-- Treatment timeline -->

                        <div class="treatment-list">


                            <?php foreach ($data['treatments'] as $treatment): ?>

                                <div class="treatment-item">


                                    <div class="timeline-line"></div>


                                    <div class="timeline-dot"></div>


                                    <div class="treatment-content">


                                        <div class="treatment-top">

                                            <h3>
                                                <?php
                                                echo $treatment['title'];
                                                ?>
                                            </h3>

                                            <span>
                                                <?php
                                                echo $treatment['date'];
                                                ?>
                                            </span>

                                        </div>


                                        <p>
                                            <?php
                                            echo $treatment['description'];
                                            ?>
                                        </p>


                                        <div class="treatment-doctor">

                                            ♙

                                            <?php
                                            echo $treatment['doctor'];
                                            ?>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>

                </div>



                <!-- =================================================
                     RIGHT COLUMN
                     ================================================= -->

                <div class="medical-right-column">


                    <!-- =================================================
                         KNOWN ALLERGIES
                         ================================================= -->

                    <section class="medical-card allergies-card">


                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon allergy-icon">
                                    ✹
                                </span>

                                <h2>
                                    Known Allergies
                                </h2>

                            </div>

                        </div>


                        <div class="allergy-list">

                            <?php foreach ($data['allergies'] as $allergy): ?>

                                <span class="allergy-tag">

                                    <?php
                                    echo $allergy;
                                    ?>

                                </span>

                            <?php endforeach; ?>

                        </div>

                    </section>



                    <!-- =================================================
                         ACTIVE MEDICATIONS
                         ================================================= -->

                    <section class="medical-card medication-card">


                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon medication-icon">
                                    ♧
                                </span>

                                <h2>
                                    Active Meds
                                </h2>

                            </div>


                            <button
                                type="button"
                                class="add-medication-button"
                                id="add-medication-button"
                                title="Add Medication"
                            >
                                +
                            </button>

                        </div>


                        <div class="medication-list">


                            <?php foreach ($data['medications'] as $medication): ?>

                                <div class="medication-item">


                                    <div class="medication-name-row">

                                        <strong>
                                            <?php
                                            echo $medication['name'];
                                            ?>
                                        </strong>

                                        <span class="ongoing-badge">
                                            <?php
                                            echo $medication['status'];
                                            ?>
                                        </span>

                                    </div>


                                    <div class="medication-detail">

                                        <span>
                                            ⌛
                                        </span>

                                        <strong>
                                            Dose:
                                        </strong>

                                        <?php
                                        echo $medication['dose'];
                                        ?>

                                    </div>


                                    <div class="medication-detail">

                                        <span>
                                            ◷
                                        </span>

                                        <strong>
                                            Freq:
                                        </strong>

                                        <?php
                                        echo $medication['frequency'];
                                        ?>

                                    </div>


                                    <?php if (!empty($medication['duration'])): ?>

                                        <div class="medication-detail">

                                            <span>
                                                ▣
                                            </span>

                                            <strong>
                                                Duration:
                                            </strong>

                                            <?php
                                            echo $medication['duration'];
                                            ?>

                                        </div>

                                    <?php endif; ?>


                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>

                </div>

            </div>

        </section>

    </main>

</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script
    src="<?php echo URLROOT; ?>/js/vet-health-record-details.js"
></script>


</body>

</html>