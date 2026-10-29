<?php
$record = $data['record'];
$pet = $data['pet'];

$e = function ($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$petId = (int)($record->pet_id ?? $pet['id'] ?? 0);
$recordId = (int)$record->record_id;
$status = $record->status ?? 'Ongoing';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medical Record - Happy Paws</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/vet-sidebar.css?v=3">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/edit-medical-record.css?v=1">
</head>
<body>

<div class="vet-page">
    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>

    <main class="vet-main">
        <header class="vet-topbar">
            <div class="vet-search">
                <span class="search-icon">⌕</span>
                <input type="text" placeholder="Search appointments, patients...">
            </div>

            <div class="vet-header-right">
                <a href="<?= URLROOT ?>/index.php?url=vet/notifications"
                   class="header-action">♧</a>
                <button type="button" class="header-action">⚙</button>
                <div class="header-divider"></div>

                <a href="<?= URLROOT ?>/index.php?url=vet/profile" class="vet-profile">
                    <img src="<?= URLROOT ?>/images/sidebar-icons/profile.png" alt="Profile">
                    <div class="vet-profile-info">
                        <strong><?= $e($_SESSION['staff_name'] ?? 'Veterinarian') ?></strong>
                        <span>Veterinarian</span>
                    </div>
                </a>
            </div>
        </header>

        <section class="edit-content">
            <div class="edit-heading">
                <div>
                    <h1>Edit Medical Record</h1>
                    <p>Update examination details, treatment and clinical notes for <?= $e($pet['name'] ?? 'this pet') ?>.</p>
                </div>
                <span class="record-badge">Record #<?= $recordId ?></span>
            </div>

            <?php if (!empty($data['error'])): ?>
                <div class="form-error"><?= $e($data['error']) ?></div>
            <?php endif; ?>

            <section class="pet-card">
                <div class="pet-avatar">🐾</div>
                <div class="pet-info">
                    <h2><?= $e($pet['name'] ?? 'Selected Pet') ?></h2>
                    <p>
                        <?= $e($pet['breed'] ?? 'Breed unavailable') ?>
                        · Owner: <?= $e($pet['owner'] ?? 'Owner unavailable') ?>
                    </p>
                </div>
                <div class="pet-record-number">
                    <small>MEDICAL RECORD</small>
                    <strong>#<?= $recordId ?></strong>
                </div>
            </section>

            <form class="edit-form"
                  action="<?= URLROOT ?>/index.php?url=vet/updateMedicalRecord/<?= $recordId ?>"
                  method="POST"
                  id="editMedicalRecordForm">

                <input type="hidden" name="record_id" value="<?= $recordId ?>">
                <input type="hidden" name="pet_id" value="<?= $petId ?>">

                <section class="form-card">
                    <div class="section-heading">
                        <div class="section-icon">🩺</div>
                        <div>
                            <h2>Medical Information</h2>
                            <p>Modify the examination and treatment details.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="visit_date">Visit Date <span>*</span></label>
                            <input type="date" id="visit_date" name="visit_date"
                                   value="<?= $e($record->visit_date ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span>*</span></label>
                            <select id="status" name="status" required>
                                <option value="Ongoing" <?= strcasecmp($status, 'Ongoing') === 0 ? 'selected' : '' ?>>Ongoing</option>
                                <option value="Completed" <?= strcasecmp($status, 'Completed') === 0 ? 'selected' : '' ?>>Completed</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label for="diagnosis">Diagnosis <span>*</span></label>
                            <textarea id="diagnosis" name="diagnosis" rows="3" maxlength="5000" required><?= $e($record->diagnosis ?? '') ?></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label for="treatment">Treatment / Procedure <span>*</span></label>
                            <textarea id="treatment" name="treatment" rows="4" maxlength="5000" required><?= $e($record->treatment ?? '') ?></textarea>
                        </div>
                    </div>
                </section>

                <section class="form-card">
                    <div class="section-heading">
                        <div class="section-icon">💊</div>
                        <div>
                            <h2>Medicine Information</h2>
                            <p>Update the medication prescribed for this treatment.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="medicine_name">Medicine Name</label>
                            <input type="text" id="medicine_name" name="medicine_name"
                                   maxlength="255" value="<?= $e($record->medicine_name ?? '') ?>"
                                   placeholder="e.g. Amoxicillin Drops">
                        </div>

                        <div class="form-group">
                            <label for="medicine_dose">Dose</label>
                            <input type="text" id="medicine_dose" name="medicine_dose"
                                   maxlength="100" value="<?= $e($record->medicine_dose ?? '') ?>"
                                   placeholder="e.g. 0.5ml">
                        </div>

                        <div class="form-group">
                            <label for="medicine_frequency">Frequency</label>
                            <input type="text" id="medicine_frequency" name="medicine_frequency"
                                   maxlength="255" value="<?= $e($record->medicine_frequency ?? '') ?>"
                                   placeholder="e.g. Twice daily">
                        </div>

                        <div class="form-group">
                            <label for="medicine_duration">Duration</label>
                            <input type="text" id="medicine_duration" name="medicine_duration"
                                   maxlength="100" value="<?= $e($record->medicine_duration ?? '') ?>"
                                   placeholder="e.g. 14 days">
                        </div>
                    </div>
                </section>

                <section class="form-card">
                    <div class="section-heading">
                        <div class="section-icon">📋</div>
                        <div>
                            <h2>Prescription & Follow-up</h2>
                            <p>Update instructions and recommended follow-up.</p>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label for="prescription">Prescription</label>
                            <textarea id="prescription" name="prescription" rows="3" maxlength="5000"><?= $e($record->prescription ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="follow_up_date">Follow-up Date</label>
                            <input type="date" id="follow_up_date" name="follow_up_date"
                                   value="<?= $e($record->follow_up_date ?? '') ?>">
                        </div>

                        <div class="form-group full-width">
                            <label for="notes">Additional Notes</label>
                            <textarea id="notes" name="notes" rows="4" maxlength="5000"><?= $e($record->notes ?? '') ?></textarea>
                        </div>
                    </div>
                </section>

                <div class="form-actions">
                    <a class="cancel-button"
                       href="<?= URLROOT ?>/index.php?url=vet/treatmentDetails/<?= $recordId ?>">
                        Cancel
                    </a>
                    <button class="save-button" type="submit">✓ Save Changes</button>
                </div>
            </form>
        </section>
    </main>
</div>

<script>
document.getElementById('editMedicalRecordForm').addEventListener('submit', function (event) {
    const visit = document.getElementById('visit_date').value;
    const followUp = document.getElementById('follow_up_date').value;

    if (visit && followUp && followUp < visit) {
        event.preventDefault();
        alert('The follow-up date cannot be earlier than the visit date.');
    }
});
</script>
</body>
</html>