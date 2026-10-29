<?php
$record = $data['record'];
$pet = $data['pet'];

$e = function ($value) {
    return htmlspecialchars((string)($value ?? '—'), ENT_QUOTES, 'UTF-8');
};

$petId = (int)($pet['id'] ?? $record->pet_id ?? 0);
$visitDate = !empty($record->visit_date)
    ? date('M d, Y', strtotime($record->visit_date))
    : '—';

$followUpDate = !empty($record->follow_up_date)
    ? date('M d, Y', strtotime($record->follow_up_date))
    : 'Not scheduled';

$status = $record->status ?? 'Completed';
$statusClass = strtolower($status) === 'ongoing' ? 'ongoing' : 'completed';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Record Details - Happy Paws</title>

    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">

    <link rel="stylesheet" href="<?= URLROOT ?>/css/vet-sidebar.css?v=3">
    <link rel="stylesheet" href="<?= URLROOT ?>/css/treatment-details.css?v=1">
</head>

<body>
<div class="vet-page">

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>

    <main class="vet-main">

        <header class="vet-topbar">
            <div class="vet-search">
                <span class="search-icon">⌕</span>
                <input type="text" placeholder="Search appointments, patients..." id="patient-search">
            </div>

            <div class="vet-header-right">
                <a href="<?= URLROOT ?>/index.php?url=vet/notifications"
                   class="header-action" title="Notifications">♧</a>

                <button type="button" class="header-action" title="Settings">⚙</button>

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

        <section class="details-content">

             <div class="page-heading">
    <span class="page-badge">MEDICAL RECORD</span>

    <div class="heading-title-row">
        <div>
            <h1>Medical Record Details</h1>
            <p>View and manage the clinical record for <?= $e($pet['name'] ?? 'this pet') ?>.</p>
        </div>

        <div class="heading-actions">
            <form method="POST"
                  action="<?= URLROOT ?>/index.php?url=vet/deleteMedicalRecord/<?= (int)$record->record_id ?>"
                  onsubmit="return confirm('Are you sure you want to delete this medical record? This action cannot be undone.');">

                <button type="button" class="delete-button" id="openDeleteModal">
    🗑 Delete Record
</button>
            </form>

           <a class="edit-button"
   href="<?= URLROOT ?>/index.php?url=vet/editMedicalRecord/<?= (int)$record->record_id ?>">
    ✎ Edit Record
</a>
        </div>
    </div>
</div>

            <!-- Pet summary -->
            <section class="detail-card pet-summary">
                <div class="pet-avatar">🐾</div>

                <div class="pet-summary-info">
                    <h2><?= $e($pet['name'] ?? 'Pet') ?></h2>
                    <p>
                        <?= $e($pet['breed'] ?? 'Breed unavailable') ?>
                        · Owner: <?= $e($pet['owner'] ?? 'Owner unavailable') ?>
                    </p>
                </div>

                <div class="record-number">
                    <small>RECORD ID</small>
                    <strong>#<?= (int)$record->record_id ?></strong>
                </div>
            </section>

            <!-- Medical information -->
            <section class="detail-card">
                <div class="card-heading">
                    <div class="heading-icon">🩺</div>
                    <div>
                        <h2>Medical Information</h2>
                        <p>Examination and treatment details</p>
                    </div>
                    <span class="status-pill <?= $statusClass ?>"><?= $e($status) ?></span>
                </div>

                <div class="detail-grid">
                    <div class="detail-item">
                        <small>Visit Date</small>
                        <strong><?= $e($visitDate) ?></strong>
                    </div>

                    <div class="detail-item">
                        <small>Veterinarian</small>
                        <strong><?= $e($record->vet_name ?? 'Veterinarian') ?></strong>
                    </div>

                    <div class="detail-item full-width">
                        <small>Diagnosis</small>
                        <p><?= nl2br($e($record->diagnosis ?? 'Not provided')) ?></p>
                    </div>

                    <div class="detail-item full-width">
                        <small>Treatment / Procedure</small>
                        <p><?= nl2br($e($record->treatment ?? 'Not provided')) ?></p>
                    </div>
                </div>
            </section>

            <!-- Medicine information -->
            <section class="detail-card">
                <div class="card-heading">
                    <div class="heading-icon">💊</div>
                    <div>
                        <h2>Medicine Information</h2>
                        <p>Medication prescribed for this treatment</p>
                    </div>
                </div>

                <?php if (!empty($record->medicine_name)): ?>
                    <div class="medicine-name">
                        <?= $e($record->medicine_name) ?>
                    </div>

                    <div class="detail-grid">
                        <div class="detail-item">
                            <small>Dose</small>
                            <strong><?= $e($record->medicine_dose ?: 'Not specified') ?></strong>
                        </div>

                        <div class="detail-item">
                            <small>Frequency</small>
                            <strong><?= $e($record->medicine_frequency ?: 'Not specified') ?></strong>
                        </div>

                        <div class="detail-item">
                            <small>Duration</small>
                            <strong><?= $e($record->medicine_duration ?: 'Not specified') ?></strong>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="empty-message">No medicine information was added to this record.</p>
                <?php endif; ?>
            </section>

            <!-- Prescription -->
            <section class="detail-card">
                <div class="card-heading">
                    <div class="heading-icon">📋</div>
                    <div>
                        <h2>Prescription</h2>
                        <p>Medication and administration instructions</p>
                    </div>
                </div>

                <div class="text-panel">
                    <?= nl2br($e($record->prescription ?: 'No prescription provided.')) ?>
                </div>
            </section>

            <!-- Follow-up and notes -->
            <section class="detail-card">
                <div class="card-heading">
                    <div class="heading-icon">🗓</div>
                    <div>
                        <h2>Follow-up & Additional Notes</h2>
                        <p>Recommended follow-up and clinical observations</p>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="detail-item full-width">
                        <small>Follow-up Date</small>
                        <strong><?= $e($followUpDate) ?></strong>
                    </div>

                    <div class="detail-item full-width">
                        <small>Additional Notes</small>
                        <p><?= nl2br($e($record->notes ?: 'No additional notes.')) ?></p>
                    </div>

                    <div class="detail-item full-width">
                        <small>Record Created</small>
                        <strong>
                            <?= !empty($record->created_at)
                                ? $e(date('M d, Y H:i', strtotime($record->created_at)))
                                : '—' ?>
                        </strong>
                    </div>
                </div>
            </section>

            <div class="bottom-actions">
                <a class="back-button"
                   href="<?= URLROOT ?>/index.php?url=vet/healthRecordDetails/<?= $petId ?>">
                    ← Back to Medical Record
                </a>
            </div>

        </section>
    </main>
</div>
<!-- Delete confirmation modal -->
<div class="delete-modal-overlay" id="deleteModal" aria-hidden="true">
    <div class="delete-modal" role="dialog"
         aria-modal="true" aria-labelledby="deleteModalTitle">

        <div class="delete-modal-icon">♜</div>

        <h2 id="deleteModalTitle">Delete Medical Record?</h2>

        <p>
            Are you sure you want to delete this medical record?
            This will also remove its medicine details from Active Meds.
            This action cannot be undone.
        </p>

        <div class="delete-modal-actions">
            <button type="button" class="modal-cancel-button" id="cancelDelete">
                Cancel
            </button>

            <form method="POST"
                  action="<?= URLROOT ?>/index.php?url=vet/deleteMedicalRecord/<?= (int)$record->record_id ?>"
                  id="confirmDeleteForm">
                <input type="hidden" name="record_id"
                       value="<?= (int)$record->record_id ?>">
                <input type="hidden" name="pet_id"
                       value="<?= (int)$petId ?>">

                <button type="submit" class="modal-delete-button">
                    Delete Record
                </button>
            </form>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('deleteModal');
    const openButton = document.getElementById('openDeleteModal');
    const cancelButton = document.getElementById('cancelDelete');

    function openModal() {
        modal.classList.add('visible');
        modal.setAttribute('aria-hidden', 'false');
        cancelButton.focus();
    }

    function closeModal() {
        modal.classList.remove('visible');
        modal.setAttribute('aria-hidden', 'true');
        openButton.focus();
    }

    openButton.addEventListener('click', openModal);
    cancelButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('visible')) {
            closeModal();
        }
    });
})();
</script>
</body>
</html>