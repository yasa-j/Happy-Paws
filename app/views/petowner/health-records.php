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

                <div class="pet-selector" id="petSelector">

                    <div class="pet-mini-icon">
                        🐶
                    </div>

                    <div class="pet-selector-info">
                        <strong><?= htmlspecialchars($pet['name']) ?> — <?= htmlspecialchars($pet['breed']) ?></strong>
                        <span>Active Pet Profile</span>
                    </div>

                    <span class="selector-arrow">⌄</span>

                </div>

            </div>

            <div class="official-record-badge">
                🔒 Official Clinic Record (Read-Only Mode)
            </div>

        </div>


        <!-- PET SUMMARY CARD -->
        <section class="pet-summary-card">

            <div class="pet-summary-left">

                <div class="pet-image">
                    🐕
                </div>

                <div class="pet-main-info">

                    <div class="pet-name-row">

                        <h2><?= htmlspecialchars($pet['name']) ?></h2>

                        <span class="microchip">
                            ▣ Microchipped: <?= htmlspecialchars($pet['microchip']) ?>
                        </span>

                    </div>

                    <span class="care-plan">
                        <?= htmlspecialchars($pet['status']) ?>
                    </span>

                    <p>
                        <?= htmlspecialchars($pet['breed']) ?>
                        · <?= htmlspecialchars($pet['gender']) ?>
                        · <?= htmlspecialchars($pet['age']) ?>
                        · Weight: <?= htmlspecialchars($pet['weight']) ?>
                    </p>

                </div>

            </div>


            <div class="pet-stat-boxes">

                <div class="pet-stat">

                    <span class="stat-label">Last Visit</span>

                    <strong>12 Sep<br>2026</strong>

                    <small>Dr. Sarah<br>Fernando</small>

                </div>


                <div class="pet-stat">

                    <span class="stat-label">Vaccinations</span>

                    <strong class="stat-green">● 4 Active</strong>

                    <small>Up to Date</small>

                </div>


                <div class="pet-stat">

                    <span class="stat-label">Prescriptions</span>

                    <strong>1 Active</strong>

                    <small>Amoxicillin 250mg</small>

                </div>


                <div class="pet-stat">

                    <span class="stat-label">Next Due</span>

                    <strong>12 Oct 2026</strong>

                    <small>Rabies Booster</small>

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

                    <span>▣</span>
                    Medical History
                    <small><?= count($medicalHistory) ?></small>

                </button>


                <button
                    class="record-tab"
                    data-tab="vaccinations"
                    onclick="switchHealthTab('vaccinations')">

                    <span>♜</span>
                    Vaccination Records
                    <small><?= count($vaccinations) ?></small>

                </button>


                <button
                    class="record-tab"
                    data-tab="prescriptions"
                    onclick="switchHealthTab('prescriptions')">

                    <span>▤</span>
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
                                        <?= htmlspecialchars($record['title']) ?>
                                    </h2>

                                    <span class="record-category">
                                        <?= htmlspecialchars($record['category']) ?>
                                    </span>

                                </div>

                                <p>
                                    Attending Vet:
                                    <strong><?= htmlspecialchars($record['vet']) ?></strong>
                                    (<?= htmlspecialchars($record['specialization']) ?>)
                                </p>

                            </div>

                        </div>

                        <span class="record-date">
                            <?= htmlspecialchars($record['date']) ?>
                        </span>

                    </div>


                    <div class="record-details">

                        <div class="detail-box">

                            <span class="detail-label">
                                Reason for Visit
                            </span>

                            <p>
                                <?= htmlspecialchars($record['reason']) ?>
                            </p>

                        </div>


                        <div class="detail-box">

                            <span class="detail-label">
                                Clinical Findings / Diagnosis
                            </span>

                            <p>
                                <?= htmlspecialchars($record['diagnosis']) ?>
                            </p>

                        </div>

                    </div>


                    <div class="record-footer">

                        <div class="treatment">

                            <span class="treatment-icon">
                                ✚
                            </span>

                            <strong>Treatment:</strong>

                            <?= htmlspecialchars($record['treatment']) ?>

                        </div>

                        <span class="follow-up">
                            <?= htmlspecialchars($record['followup']) ?>
                        </span>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>


        <!-- ========================= -->
        <!-- VACCINATION RECORDS -->
        <!-- ========================= -->

        <div id="vaccinations-tab" class="health-tab-content">

            <div class="vaccination-list">

                <?php foreach ($vaccinations as $vaccination): ?>

                    <article class="vaccination-card">

                        <div class="vaccination-icon">
                            💉
                        </div>

                        <div class="vaccination-info">

                            <h2>
                                <?= htmlspecialchars($vaccination['name']) ?>
                            </h2>

                            <p>
                                Administered:
                                <?= htmlspecialchars($vaccination['date']) ?>
                            </p>

                        </div>

                        <div class="vaccination-due">

                            <span>Next Due</span>

                            <strong>
                                <?= htmlspecialchars($vaccination['nextDue']) ?>
                            </strong>

                        </div>

                        <span class="vaccination-status">
                            <?= htmlspecialchars($vaccination['status']) ?>
                        </span>

                    </article>

                <?php endforeach; ?>

            </div>

        </div>


        <!-- ========================= -->
        <!-- PRESCRIPTIONS -->
        <!-- ========================= -->

        <div id="prescriptions-tab" class="health-tab-content">

            <div class="prescription-list">

                <?php foreach ($prescriptions as $prescription): ?>

                    <article class="prescription-card">

                        <div class="prescription-icon">
                            💊
                        </div>

                        <div class="prescription-info">

                            <h2>
                                <?= htmlspecialchars($prescription['medicine']) ?>
                            </h2>

                            <p>
                                <?= htmlspecialchars($prescription['dosage']) ?>
                            </p>

                        </div>

                        <div class="prescription-details">

                            <span>
                                Prescribed
                            </span>

                            <strong>
                                <?= htmlspecialchars($prescription['date']) ?>
                            </strong>

                        </div>

                        <div class="prescription-details">

                            <span>
                                Veterinarian
                            </span>

                            <strong>
                                <?= htmlspecialchars($prescription['vet']) ?>
                            </strong>

                        </div>

                        <span class="prescription-status">
                            <?= htmlspecialchars($prescription['status']) ?>
                        </span>

                    </article>

                <?php endforeach; ?>

            </div>

        </div>

    </main>

</div>

<script src="<?= URLROOT ?>/public/js/petowner-health-records.js"></script>