<?php
$activePage = 'health';
?>

<link rel="stylesheet" href="<?= URLROOT ?>/public/css/petowner.css">
<link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/topbar.css">
<link rel="stylesheet" href="<?= URLROOT ?>/public/css/petowner-health-records.css">

<?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>

<link rel="stylesheet" href="<?= URLROOT ?>/public/css/petowner-health-records.css">

<div class="health-records-page">

    <!-- TOP BAR -->
    <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>



    <!-- MAIN CONTENT -->
    <main class="health-content">

        <!-- PAGE HEADER -->
        <div class="health-page-header">

            <div>
                <div class="health-title-row">

                    <h1>Health Records</h1>

                    <span class="verified-badge">
                        ✦ Verified by Clinic
                    </span>

                </div>

                <p>
                    View your pet's verified medical history, vaccinations,
                    prescriptions, and veterinary consultations.
                </p>
            </div>

            <button class="download-summary-button" onclick="downloadHealthSummary()">
                ↓
                Download Health Summary
            </button>

        </div>


        <!-- PET SELECTOR -->
        <div class="health-selector-row">

            <div class="pet-selector-wrapper">

                <label>Select Pet:</label>

                <select
                    class="pet-selector"
                    onchange="changeHealthPet(this.value)"
                >
                    <?php foreach ($pets as $ownerPet): ?>

                        <option
                            value="<?= $ownerPet->pet_id ?>"
                            <?= ($ownerPet->pet_id == $pet->pet_id) ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($ownerPet->name) ?>
                            -
                            <?= htmlspecialchars($ownerPet->breed ?? $ownerPet->species) ?>
                        </option>

                    <?php endforeach; ?>
                </select>

            </div>

            <div class="official-record-badge">
                🔒 Official Clinic Record (Read-Only Mode)
            </div>

        </div>


        <!-- PET SUMMARY CARD -->
        <section class="pet-summary-card">

        <div class="pet-summary-left">

            <div class="pet-image">
                <?= ($pet->species === 'Cat') ? '🐱' : '🐶' ?>
            </div>

            <div class="pet-main-info">

                <div class="pet-name-row">

                    <h2>
                        <?= htmlspecialchars($pet->name) ?>
                    </h2>

                    <?php if (!empty($pet->microchip_number)): ?>

                        <span class="microchip">
                            ▣ Microchipped:
                            <?= htmlspecialchars($pet->microchip_number) ?>
                        </span>

                    <?php endif; ?>

                </div>


                <span class="care-plan">
                    <?= htmlspecialchars($pet->species) ?> Health Profile
                </span>


                <p>

                    <?= htmlspecialchars($pet->breed ?? 'Breed not specified') ?>

                    ·

                    <?= htmlspecialchars($pet->gender) ?>

                    ·

                    <?php

                    if (!empty($pet->date_of_birth)) {

                        $dob = new DateTime($pet->date_of_birth);
                        $today = new DateTime();

                        $age = $today->diff($dob);

                        echo $age->y . ' years old';

                    } else {

                        echo 'Age not available';

                    }

                    ?>

                    · Weight:

                    <?= !empty($pet->weight_kg)
                        ? htmlspecialchars($pet->weight_kg) . ' kg'
                        : 'Not available'
                    ?>

                </p>

            </div>

        </div>


        <div class="pet-stat-boxes">

            <!-- LAST VISIT -->

            <div class="pet-stat">

                <span class="stat-label">
                    Last Visit
                </span>

                <?php if ($lastVisit): ?>

                    <strong>
                        <?= date('d M Y', strtotime($lastVisit->visit_date)) ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars($lastVisit->vet_name ?? 'Veterinarian') ?>
                    </small>

                <?php else: ?>

                    <strong>
                        No visits
                    </strong>

                    <small>
                        No medical records yet
                    </small>

                <?php endif; ?>

            </div>


            <!-- VACCINATIONS -->

            <div class="pet-stat">

                <span class="stat-label">
                    Vaccinations
                </span>

                <strong class="stat-green">
                    ●
                    <?= $vaccinationSummary->vaccination_count ?? 0 ?>
                    Records
                </strong>

                <small>
                    <?= !empty($vaccinations)
                        ? 'Records available'
                        : 'No records yet'
                    ?>
                </small>

            </div>


            <!-- PRESCRIPTIONS -->

            <div class="pet-stat">

                <span class="stat-label">
                    Prescriptions
                </span>

                <strong>
                    <?= count($prescriptions) ?>
                    Records
                </strong>

                <small>
                    <?= !empty($prescriptions)
                        ? 'Prescription history'
                        : 'No prescriptions'
                    ?>
                </small>

            </div>


            <!-- NEXT VACCINATION -->

            <div class="pet-stat">

                <span class="stat-label">
                    Next Due
                </span>

                <?php if ($nextVaccination): ?>

                    <strong>
                        <?= date(
                            'd M Y',
                            strtotime($nextVaccination->next_due_date)
                        ) ?>
                    </strong>

                    <small>
                        <?= htmlspecialchars(
                            $nextVaccination->vaccine_name
                        ) ?>
                    </small>

                <?php else: ?>

                    <strong>
                        None
                    </strong>

                    <small>
                        No upcoming vaccination
                    </small>

                <?php endif; ?>

            </div>

        </div>

    </section>


        <!-- RECORD CONTROLS -->
        <div class="records-controls">

            <div class="record-tabs">

                <button
                    class="record-tab active"
                    data-tab="medical"
                    onclick="switchHealthTab('medical')">

                    <span></span>
                    Medical History
                    <small><?= count($medicalHistory) ?></small>

                </button>


                <button
                    class="record-tab"
                    data-tab="vaccinations"
                    onclick="switchHealthTab('vaccinations')">

                    <span></span>
                    Vaccination Records
                    <small><?= count($vaccinations) ?></small>

                </button>


                <button
                    class="record-tab"
                    data-tab="prescriptions"
                    onclick="switchHealthTab('prescriptions')">

                    <span></span>
                    Prescriptions
                    <small><?= count($prescriptions) ?></small>

                </button>

            </div>


            <div class="record-filters">

                <div class="record-search">

                    <span>⌕</span>

                    <input
                        type="text"
                        id="recordSearch"
                        placeholder="Search records, vet, drugs..."
                    >

                </div>


                <select id="recordTimeFilter">

                    <option value="all">All Time</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>

                </select>

            </div>

        </div>


        <!-- ========================= -->
        <!-- MEDICAL HISTORY -->
        <!-- ========================= -->

        <div id="medical-tab" class="health-tab-content active">

            <?php if (!empty($medicalHistory)): ?>

                <?php foreach ($medicalHistory as $record): ?>

                    <article class="medical-record-card">

                        <div class="record-card-header">

                            <div class="record-title-area">

                                <div class="record-icon medical-icon">
                                    ♡
                                </div>

                                <div>

                                    <div class="record-title-line">

                                        <h2>
                                            <?= htmlspecialchars(
                                                $record->service_name ?? 'Veterinary Consultation'
                                            ) ?>
                                        </h2>

                                        <?php if (!empty($record->service_category)): ?>

                                            <span class="record-category">
                                                <?= htmlspecialchars(
                                                    $record->service_category
                                                ) ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                    <p>
                                        Attending Vet:

                                        <strong>
                                            <?= htmlspecialchars(
                                                $record->vet_name ?? 'Veterinarian'
                                            ) ?>
                                        </strong>
                                    </p>

                                </div>

                            </div>

                            <span class="record-date">
                                <?= date(
                                    'd F Y',
                                    strtotime($record->visit_date)
                                ) ?>
                            </span>

                        </div>


                        <div class="record-details">

                            <div class="detail-box">

                                <span class="detail-label">
                                    Reason for Visit
                                </span>

                                <p>
                                    <?= !empty($record->appointment_reason)
                                        ? htmlspecialchars(
                                            $record->appointment_reason
                                        )
                                        : 'No reason recorded.'
                                    ?>
                                </p>

                            </div>


                            <div class="detail-box">

                                <span class="detail-label">
                                    Clinical Findings / Diagnosis
                                </span>

                                <p>
                                    <?= !empty($record->diagnosis)
                                        ? htmlspecialchars(
                                            $record->diagnosis
                                        )
                                        : 'No diagnosis recorded.'
                                    ?>
                                </p>

                            </div>

                        </div>


                        <div class="record-footer">

                            <div class="treatment">

                                <span class="treatment-icon">
                                    ✚
                                </span>

                                <strong>
                                    Treatment:
                                </strong>

                                <?= !empty($record->treatment)
                                    ? htmlspecialchars($record->treatment)
                                    : 'No treatment recorded.'
                                ?>

                            </div>


                            <?php if (!empty($record->follow_up_date)): ?>

                                <span class="follow-up">
                                    Follow-up:
                                    <?= date(
                                        'd F Y',
                                        strtotime($record->follow_up_date)
                                    ) ?>
                                </span>

                            <?php elseif (!empty($record->notes)): ?>

                                <span class="follow-up">
                                    <?= htmlspecialchars($record->notes) ?>
                                </span>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-record-message">

                    <h3>No Medical Records</h3>

                    <p>
                        There are currently no medical records for
                        <?= htmlspecialchars($pet->name) ?>.
                    </p>

                </div>

            <?php endif; ?>

        </div>


        <!-- ========================= -->
        <!-- VACCINATION RECORDS -->
        <!-- ========================= -->

        <div id="vaccinations-tab" class="health-tab-content">

            <div class="vaccination-list">

                <?php if (!empty($vaccinations)): ?>

                    <?php foreach ($vaccinations as $vaccination): ?>

                        <article class="vaccination-card">

                            <div class="vaccination-icon">
                                💉
                            </div>

                            <div class="vaccination-info">

                                <h2>
                                    <?= htmlspecialchars(
                                        $vaccination->vaccine_name
                                    ) ?>
                                </h2>

                                <p>
                                    Administered:

                                    <?= date(
                                        'd F Y',
                                        strtotime(
                                            $vaccination->administered_date
                                        )
                                    ) ?>
                                </p>

                                <?php if (!empty($vaccination->vet_name)): ?>

                                    <p>
                                        Veterinarian:
                                        <?= htmlspecialchars(
                                            $vaccination->vet_name
                                        ) ?>
                                    </p>

                                <?php endif; ?>

                            </div>

                            <div class="vaccination-due">

                                <span>
                                    Next Due
                                </span>

                                <?php if (!empty($vaccination->next_due_date)): ?>

                                    <strong>
                                        <?= date(
                                            'd M Y',
                                            strtotime(
                                                $vaccination->next_due_date
                                            )
                                        ) ?>
                                    </strong>

                                <?php else: ?>

                                    <strong>
                                        Not scheduled
                                    </strong>

                                <?php endif; ?>

                            </div>

                            <span class="vaccination-status">
                                <?= htmlspecialchars(
                                    $vaccination->status
                                ) ?>
                            </span>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-record-message">

                        <h3>No Vaccination Records</h3>

                        <p>
                            There are currently no vaccination records for
                            <?= htmlspecialchars($pet->name) ?>.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>

        <!-- ========================= -->
        <!-- PRESCRIPTIONS -->
        <!-- ========================= -->

        <div id="prescriptions-tab" class="health-tab-content">

            <div class="prescription-list">

                <?php if (!empty($prescriptions)): ?>

                    <?php foreach ($prescriptions as $prescription): ?>

                        <article class="prescription-card">

                            <div class="prescription-icon">
                                💊
                            </div>

                            <div class="prescription-info">

                                <h2>
                                    Prescription
                                </h2>

                                <p>
                                    <?= htmlspecialchars(
                                        $prescription->prescription
                                    ) ?>
                                </p>

                            </div>

                            <div class="prescription-details">

                                <span>
                                    Prescribed
                                </span>

                                <strong>
                                    <?= date(
                                        'd M Y',
                                        strtotime(
                                            $prescription->visit_date
                                        )
                                    ) ?>
                                </strong>

                            </div>

                            <div class="prescription-details">

                                <span>
                                    Veterinarian
                                </span>

                                <strong>
                                    <?= htmlspecialchars(
                                        $prescription->vet_name
                                        ?? 'Veterinarian'
                                    ) ?>
                                </strong>

                            </div>

                            <span class="prescription-status">
                                Recorded
                            </span>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-record-message">

                        <h3>No Prescriptions</h3>

                        <p>
                            There are currently no prescription records for
                            <?= htmlspecialchars($pet->name) ?>.
                        </p>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </main>

</div>

<script src="<?= URLROOT ?>/public/js/petowner-health-records.js"></script>