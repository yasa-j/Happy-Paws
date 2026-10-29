<?php
$pet = $data['pet'] ?? [];
$petId = (int)($pet['id'] ?? 0);
$petName = $pet['name'] ?? 'Selected Pet';
$ownerName = $pet['owner'] ?? 'Owner information unavailable';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Medical Record - Happy Paws</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <link rel="stylesheet"
          href="<?= URLROOT ?>/css/vet-sidebar.css?v=3">

    <link rel="stylesheet"
          href="<?= URLROOT ?>/css/add-medical-record.css?v=1">
</head>

<body>

<div class="vet-page">

    <!-- Existing sidebar -->
    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>

    <main class="vet-main">

        <!-- Existing header style -->
        <header class="vet-topbar">

            <div class="vet-search">
                <span class="search-icon">⌕</span>

                <input type="text"
                       id="patient-search"
                       placeholder="Search appointments, patients...">
            </div>

            <div class="vet-header-right">

                <a href="<?= URLROOT ?>/index.php?url=vet/notifications"
                   class="header-action"
                   title="Notifications">
                    ♧
                </a>

                <button type="button"
                        class="header-action"
                        title="Settings">
                    ⚙
                </button>

                <div class="header-divider"></div>

                <a href="<?= URLROOT ?>/index.php?url=vet/profile"
                   class="vet-profile">

                    <img src="<?= URLROOT ?>/images/sidebar-icons/profile.png"
                         alt="Profile">

                    <div class="vet-profile-info">
                        <strong>
                            <?= htmlspecialchars(
                                $_SESSION['staff_name'] ?? 'Veterinarian',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </strong>

                        <span>Veterinarian</span>
                    </div>

                </a>

            </div>
        </header>

        <section class="medical-form-content">

            <div class="page-heading">

                <span class="form-badge">MEDICAL RECORD FORM</span>

                <h1>Add Medical Record</h1>


            </div>

            <?php if (!empty($data['error'])): ?>
                <div class="form-error">
                    <?= htmlspecialchars(
                        $data['error'],
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?>
                </div>
            <?php endif; ?>

           

            <!-- Add medical record form -->
            <form class="medical-record-form"
                  action="<?= URLROOT ?>/index.php?url=vet/saveMedicalRecord"
                  method="POST"
                  id="medicalRecordForm">

                <input type="hidden"
                       name="pet_id"
                       value="<?= $petId ?>">

                <div class="form-section-heading">

                    <div class="section-icon">🩺</div>

                    <div>
                        <h2>Medical Information</h2>

                        <p>
                            Enter the details of the examination
                            and treatment.
                        </p>
                    </div>

                </div>

                <div class="form-grid">

                    
                    <!-- Visit date -->
                    <div class="form-group">

                        <label for="visit_date">
                            Visit Date <span>*</span>
                        </label>

                        <input type="date"
                               name="visit_date"
                               id="visit_date"
                               value="<?= date('Y-m-d') ?>"
                               max="<?= date('Y-m-d') ?>"
                               required>

                    </div>

                    <!-- Diagnosis -->
                    <div class="form-group full-width">

                        <label for="diagnosis">
                            Diagnosis <span>*</span>
                        </label>

                        <textarea name="diagnosis"
                                  id="diagnosis"
                                  rows="3"
                                  maxlength="5000"
                                  placeholder="Enter the diagnosis..."
                                  required></textarea>

                    </div>

                    <!-- Treatment -->
                    <div class="form-group full-width">

                        <label for="treatment">
                            Treatment / Procedure <span>*</span>
                        </label>

                        <textarea name="treatment"
                                  id="treatment"
                                  rows="4"
                                  maxlength="5000"
                                  placeholder="Describe the treatment or procedure performed..."
                                  required></textarea>

                    </div>

                    <div class="form-group">
    <label for="status">Status <span class="required">*</span></label>

    <select id="status" name="status" required>
        <option value="Ongoing">Ongoing</option>
        <option value="Completed">Completed</option>
    </select>
</div>


                    <!-- Medicine Information -->
<div class="form-group full-width">
    <h3>Medicine Information</h3>
</div>

<div class="form-group">
    <label for="medicine_name">Medicine Name</label>
    <input
        type="text"
        id="medicine_name"
        name="medicine_name"
        placeholder="e.g. Amoxicillin Drops"
    >
</div>

<div class="form-group">
    <label for="medicine_dose">Dose</label>
    <input
        type="text"
        id="medicine_dose"
        name="medicine_dose"
        placeholder="e.g. 0.5ml"
    >
</div>

<div class="form-group">
    <label for="medicine_frequency">Frequency</label>
    <input
        type="text"
        id="medicine_frequency"
        name="medicine_frequency"
        placeholder="e.g. Twice daily (AM/PM)"
    >
</div>

<div class="form-group">
    <label for="medicine_duration">Duration</label>
    <input
        type="text"
        id="medicine_duration"
        name="medicine_duration"
        placeholder="e.g. 14 days"
    >
</div>
</div>

                    <!-- Prescription -->
                    <div class="form-group full-width">

                        <label for="prescription">
                            Prescription
                        </label>

                        <textarea name="prescription"
                                  id="prescription"
                                  rows="3"
                                  maxlength="5000"
                                  placeholder="Enter medications, dosages, and administration instructions..."></textarea>

                    </div>

                    <!-- Follow-up date -->
                    <div class="form-group">

                        <label for="follow_up_date">
                            Follow-up Date
                        </label>

                        <input type="date"
                               name="follow_up_date"
                               id="follow_up_date">

                    </div>

                    <!-- Notes -->
                    <div class="form-group full-width">

                        <label for="notes">
                            Additional Notes
                        </label>

                        <textarea name="notes"
                                  id="notes"
                                  rows="3"
                                  maxlength="5000"
                                  placeholder="Enter additional observations or test results..."></textarea>

                    </div>

                </div>

                <div class="form-actions">

                    <a href="<?= URLROOT ?>/index.php?url=vet/healthRecordDetails/<?= $petId ?>"
                       class="btn-cancel">
                        Cancel
                    </a>

                    <button type="submit"
                            class="btn-submit">
                        Save Medical Record
                    </button>

                </div>

            </form>

        </section>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('medicalRecordForm');
    const visitDate = document.getElementById('visit_date');
    const followUpDate = document.getElementById('follow_up_date');

    form.addEventListener('submit', function (event) {
        if (visitDate.value && followUpDate.value &&
            followUpDate.value < visitDate.value) {
            event.preventDefault();

            alert('The follow-up date cannot be earlier than the visit date.');

            followUpDate.focus();
        }
    });
});
</script>

</body>
</html>