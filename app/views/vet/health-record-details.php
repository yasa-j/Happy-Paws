<?php
$pet = $data['pet'] ?? [];
$petId = (int)($pet['id'] ?? 0);
$vaccinations = $data['vaccinations'] ?? [];
$treatments = $data['treatments'] ?? [];
$allergies = $data['allergies'] ?? [];
$medications = $data['medications'] ?? [];

$e = static fn($value) =>
    htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');

$species = strtolower((string)($pet['type'] ?? 'cat'));

$petEmoji = $species === 'dog'
    ? '🐶'
    : ($species === 'rabbit' ? '🐰' : '🐱');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?= $e($data['title'] ?? 'Health Record Details') ?>
    </title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet"
          href="<?= URLROOT ?>/css/vet-sidebar.css">

    <link rel="stylesheet"
          href="<?= URLROOT ?>/css/shared-staff-header.css">

    <link rel="stylesheet"
          href="<?= URLROOT ?>/css/vet-health-record-details.css?v=20261027">
</head>

<body>

<div class="vet-page">

    <?php
    require_once APPROOT . '/views/layouts/vet_sidebar.php';
    ?>

    <main class="vet-main">

        <?php
        require APPROOT . '/views/layouts/staff-header.php';
        ?>

        <section class="medical-detail-content">


            <!-- PET INFORMATION CARD -->

            <section class="pet-profile-card"
                     aria-label="Pet information">

                <div class="pet-profile-image" aria-hidden="true">
                    <?= $petEmoji ?>
                </div>

                <div class="pet-profile-main">

                    <div class="pet-name-line">

                        <h1>
                            <?= $e($pet['name'] ?? 'Pet') ?>
                        </h1>

                        <span class="pet-type-badge">
                            ♀ <?= $e($pet['type'] ?? 'Pet') ?>
                        </span>

                    </div>

                    <div class="pet-details-grid">

                        <div class="pet-detail-item">
                            <span>BREED</span>

                            <strong>
                                <?= $e($pet['breed'] ?? '—') ?>
                            </strong>
                        </div>

                        <div class="pet-detail-item">
                            <span>AGE</span>

                            <strong>
                                <?= $e($pet['age'] ?? '—') ?>
                            </strong>
                        </div>

                        <div class="pet-detail-item">
                            <span>WEIGHT</span>

                            <strong>
                                <?= $e($pet['weight'] ?? '—') ?>
                            </strong>
                        </div>

                        <div class="pet-detail-item owner-detail">
                            <span>OWNER</span>

                            <strong>
                                ♙ <?= $e($pet['owner'] ?? '—') ?>
                            </strong>
                        </div>

                    </div>

                </div>

                <button type="button"
                        class="edit-pet-button"
                        id="edit-pet-button"
                        aria-label="View pet information"
                        title="Pet information">
                    
                </button>

            </section>


            <!-- MAIN CONTENT -->

            <div class="medical-detail-grid">

                <div class="medical-left-column">

                    <!-- TABS -->

                    <div class="records-tabs"
                         role="tablist"
                         aria-label="Medical record categories">

                        <button
                            class="records-tab active"
                            type="button"
                            role="tab"
                            id="tab-treatments"
                            aria-selected="true"
                            aria-controls="panel-treatments"
                            data-tab="treatments">

                            ⊞
                            <span>
                                Treatments &amp; Clinical Notes
                            </span>

                        </button>

                        <button
                            class="records-tab"
                            type="button"
                            role="tab"
                            id="tab-vaccinations"
                            aria-selected="false"
                            aria-controls="panel-vaccinations"
                            data-tab="vaccinations">

                            ♧
                            <span>
                                Vaccinations
                            </span>

                        </button>

                    </div>


                    <!-- TREATMENT HISTORY -->

                    <section
                        class="medical-card records-tab-content active"
                        id="panel-treatments"
                        role="tabpanel"
                        aria-labelledby="tab-treatments"
                        data-tab-content="treatments">

                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon treatment-icon">
                                    ♧
                                </span>

                                <h2>Treatment History</h2>

                            </div>

                           
<a href="<?= URLROOT ?>/index.php?url=vet/addMedicalRecord/<?= (int)$data['pet']['id'] ?>"
   class="add-record-button">
    <span class="add-icon">+</span>
    Add Record
</a>


                        </div>


                        <div class="treatment-table-wrap">

                            <table class="treatment-table">

                                <thead>

                                    <tr>
                                        <th>Date</th>
                                        <th>Treatment / Clinical Note</th>
                                        <th>Veterinarian</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>

                                <tbody>

                               <?php if (!empty($data['medicalRecords'])): ?>

    <?php foreach ($data['medicalRecords'] as $record): ?>

        <tr>
            <td>
                <?= htmlspecialchars($record->visit_date ?? '') ?>
            </td>

            <td>
                <strong>
                    <?= htmlspecialchars($record->diagnosis ?? 'No diagnosis') ?>
                </strong>

                <br>

                <small>
                    <?= htmlspecialchars($record->treatment ?? '') ?>
                </small>

                <?php if (!empty($record->notes)): ?>
                    <br>
                    <small>
                        <?= htmlspecialchars($record->notes) ?>
                    </small>
                <?php endif; ?>
            </td>

            <td>
                <?= htmlspecialchars($record->vet_name ?? 'Not available') ?>
            </td>

            <td>
                <span class="status-badge">
    <?= $e($record->status ?? 'Completed') ?>
</span>
            </td>

            <td>
                <a class="view-treatment-link"
   href="<?= URLROOT ?>/index.php?url=vet/treatmentDetails/<?= (int)$record->record_id ?>">
    View
</a>
            </td>
        </tr>

    <?php endforeach; ?>

<?php else: ?>

    <tr>
        <td colspan="5" style="text-align: center; padding: 35px;">
            No treatment records available.
        </td>
    </tr>

<?php endif; ?>

                </tbody>
            </table>

        </div>

    </section>


                    <!-- VACCINATION HISTORY -->

                    <section
                        class="medical-card records-tab-content"
                        id="panel-vaccinations"
                        role="tabpanel"
                        aria-labelledby="tab-vaccinations"
                        data-tab-content="vaccinations"
                        hidden>

                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon vaccination-icon">
                                    ♧
                                </span>

                                <h2>Vaccination History</h2>

                            </div>

                            <a
                                class="add-record-button"
                                href="<?= URLROOT ?>/index.php?url=vet/addVaccination/<?= $petId ?>">

                                ＋ Add Record

                            </a>

                        </div>


                        <div class="vaccination-table-wrap">

                            <table class="vaccination-table">

                                <thead>

                                    <tr>
                                        <th>Date</th>
                                        <th>Vaccine Name</th>
                                        <th>Status</th>
                                        <th>Next Due</th>
                                        <th>Actions</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php if (!$vaccinations): ?>

                                    <tr>
                                        <td colspan="5"
                                            class="empty-state">

                                            No vaccination records available.

                                        </td>
                                    </tr>

                                <?php else: ?>

                                    <?php foreach ($vaccinations as $vaccination): ?>

                                        <tr>

                                            <td>
                                                <?= $e($vaccination['date'] ?? '—') ?>
                                            </td>

                                            <td>

                                                <strong>
                                                    <?= $e($vaccination['vaccine'] ?? 'Vaccine') ?>
                                                </strong>

                                            </td>

                                            <td>

                                                <span class="status-pill <?= (($vaccination['status_class'] ?? '') === 'due') ? 'due' : '' ?>">

                                                    <?= $e($vaccination['status'] ?? 'Unknown') ?>

                                                </span>

                                            </td>

                                            <td>
                                                <?= $e($vaccination['next_due'] ?? '—') ?>
                                            </td>

                                            <td>

                                                <a
                                                    class="text-action"
                                                    href="<?= URLROOT ?>/index.php?url=vet/vaccinationDetails/<?= (int)($vaccination['id'] ?? 0) ?>">

                                                    View

                                                </a>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </section>

                </div>


                <!-- RIGHT COLUMN -->

                <aside class="medical-right-column">


                    <!-- ALLERGIES -->

                    <section class="medical-card side-info-card">

                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon allergy-icon">
                                    ☷
                                </span>

                                <h2>Allergies</h2>

                            </div>

                            <button
                                type="button"
                                class="round-action"
                                id="add-allergy-button"
                                aria-label="Add allergy"
                                title="Add allergy">

                                ＋

                            </button>

                        </div>


                        <div class="allergy-list" id="allergy-list">

                            <?php if (!$allergies): ?>

                                <span class="muted-note">
                                    No allergies recorded
                                </span>

                            <?php else: ?>

                                <?php foreach ($allergies as $allergy): ?>

                                    <span class="allergy-tag">
                                        <?= $e($allergy) ?>
                                    </span>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </div>

                    </section>


                    <!-- ACTIVE MEDICATIONS -->

                    <section class="medical-card side-info-card medications-card">

                        <div class="medical-card-header">

                            <div class="medical-card-title">

                                <span class="section-icon medication-icon">
                                    ▤
                                </span>

                                <h2>Active Meds</h2>

                            </div>


                        </div>


                       <div class="medication-list" id="medication-list">

    <?php if (!empty($data['medicines'])): ?>

        <div class="active-meds-list">

            <?php foreach ($data['medicines'] as $medicine): ?>

                <div class="medicine-card">

                    <a
                        href="<?= URLROOT ?>/index.php?url=vet/treatmentDetails/<?= (int)$medicine->record_id ?>"
                        class="medicine-link"
                    >
                        <h4>
                            <?= $e($medicine->medicine_name ?? 'Medicine') ?>
                        </h4>

                        <p>
                            ♧ <strong>Dose:</strong>
                            <?= $e($medicine->medicine_dose ?? '--') ?>
                        </p>

                        <p>
                            ◷ <strong>Freq:</strong>
                            <?= $e($medicine->medicine_frequency ?? '--') ?>
                        </p>

                        <p>
                            ▦ <strong>Duration:</strong>
                            <?= $e($medicine->medicine_duration ?? '--') ?>
                        </p>
                    </a>

                    <form
                        action="<?= URLROOT ?>/index.php?url=vet/deleteMedicalRecord"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this medical record?');"
                    >
                        <input
                            type="hidden"
                            name="record_id"
                            value="<?= (int)$medicine->record_id ?>"
                        >

                        <input
                            type="hidden"
                            name="pet_id"
                            value="<?= (int)$medicine->pet_id ?>"
                        >

                        <button
                            type="submit"
                            class="delete-medicine-button"
                        >
                            Delete
                        </button>
                    </form>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <p class="muted-note">
            No medicines have been added for this pet.
        </p>

    <?php endif; ?>

</div>


<script
    src="<?= URLROOT ?>/js/vet-health-record-details.js?v=20261027"
    defer>
</script>

</body>
</html>