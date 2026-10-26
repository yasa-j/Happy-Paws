
<?php
/*
|--------------------------------------------------------------------------
| Appointment History Page
|--------------------------------------------------------------------------
|
| The controller provides:
| $appointments
| $pets
| $totalAppointments
| $completedAppointments
| $cancelledAppointments
| $completedRate
| $cancelledRate
|
*/

$pageTitle = $data['pageTitle'] ?? 'Appointment History';

$appointments = $data['appointments'] ?? [];
$pets = $data['pets'] ?? [];

$totalAppointments = $data['totalAppointments'] ?? 0;
$completedAppointments = $data['completedAppointments'] ?? 0;
$cancelledAppointments = $data['cancelledAppointments'] ?? 0;

$completedRate = $data['completedRate'] ?? 0;
$cancelledRate = $data['cancelledRate'] ?? 0;

// Escape output before displaying database values.
function historyEscape($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo historyEscape($pageTitle); ?> | Happy Paws
    </title>

    <!-- Shared Pet Owner Styles -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <!-- Appointment History Styles -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner-appointment-history.css">

    <!-- Google Font -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
          rel="stylesheet">

</head>

<body>

<?php
// Keep the existing sidebar active on the Appointments section.
$activePage = 'appointments';

require_once APPROOT . '/views/layouts/petowner-sidebar.php';
?>

<!-- Main Content -->
<main class="petowner-main history-main">

    <!-- Shared Topbar -->
    <?php
    require_once APPROOT . '/views/layouts/petowner-topbar.php';
    ?>

    <!-- Appointment History Content -->
    <section class="history-content">

        <!-- Breadcrumb -->
        <div class="breadcrumb">

            <span>PET OWNER PORTAL</span>

            <span class="breadcrumb-arrow">›</span>

            <span>APPOINTMENTS</span>

            <span class="breadcrumb-arrow">›</span>

            <span class="breadcrumb-current">
                APPOINTMENT HISTORY
            </span>

        </div>


        <!-- Page Heading -->
        <div class="page-heading">

            <h1>Appointment History</h1>

            <p>
                View your previous visits and clinical
                <br class="desktop-break">
                appointment records at Happy Paws.
            </p>

        </div>


        <!-- Summary Cards -->
        <div class="summary-cards">

            <!-- Total Appointments -->
            <div class="summary-card">

                <div class="summary-card-top">

                    <div>

                        <p class="summary-label">
                            Total Appointments
                        </p>

                        <div class="summary-number-row">

                            <span class="summary-number">
                                <?php echo (int) $totalAppointments; ?>
                            </span>

                            <span class="summary-small-text">
                                historical records
                            </span>

                        </div>

                    </div>

                    <div class="summary-icon neutral-icon">
                        ▣
                    </div>

                </div>

                <div class="summary-description">

                    <span class="description-dot blue-dot"></span>

                    Past appointments on file

                </div>

            </div>


            <!-- Completed Appointments -->
            <div class="summary-card">

                <div class="summary-card-top">

                    <div>

                        <p class="summary-label">
                            Completed
                        </p>

                        <div class="summary-number-row">

                            <span class="summary-number">
                                <?php echo (int) $completedAppointments; ?>
                            </span>

                            <span class="summary-percentage green-text">
                                ↗ <?php echo $completedRate; ?>% rate
                            </span>

                        </div>

                    </div>

                    <div class="summary-icon completed-icon">
                        ✓
                    </div>

                </div>

                <div class="summary-description">

                    <span class="description-dot green-dot"></span>

                    Completed clinical visits

                </div>

            </div>


            <!-- Cancelled Appointments -->
            <div class="summary-card">

                <div class="summary-card-top">

                    <div>

                        <p class="summary-label">
                            Cancelled
                        </p>

                        <div class="summary-number-row">

                            <span class="summary-number">
                                <?php echo (int) $cancelledAppointments; ?>
                            </span>

                            <span class="summary-percentage red-text">
                                <?php echo $cancelledRate; ?>%
                            </span>

                        </div>

                    </div>

                    <div class="summary-icon cancelled-icon">
                        ×
                    </div>

                </div>

                <div class="summary-description">

                    <span class="description-dot red-dot"></span>

                    Cancelled appointments

                </div>

            </div>

        </div>


        <!-- Filter Bar -->
        <div class="history-filter-bar">

            <!-- Search -->
            <div class="history-search">

                <span class="filter-search-icon">⌕</span>

                <input
                    type="text"
                    id="appointmentSearch"
                    placeholder="Search by pet name, vet, or appointment ID..."
                    aria-label="Search appointment history"
                >

            </div>


            <!-- Pet Filter -->
            <div class="filter-select-wrapper">

                <select id="petFilter"
                        aria-label="Filter by pet">

                    <option value="all">
                        All Pets (<?php echo count($pets); ?>)
                    </option>

                    <?php foreach ($pets as $pet): ?>

                        <option value="<?php echo (int) $pet->pet_id; ?>">

                            <?php echo historyEscape($pet->name); ?>

                        </option>

                    <?php endforeach; ?>

                </select>

                <span class="select-arrow">⌄</span>

            </div>


            <!-- Status Filter -->
            <div class="filter-select-wrapper">

                <select id="statusFilter"
                        aria-label="Filter by appointment status">

                    <option value="all">All Statuses</option>

                    <option value="completed">Completed</option>

                    <option value="cancelled">Cancelled</option>

                </select>

                <span class="select-arrow">⌄</span>

            </div>


            <!-- Sort -->
            <button
                type="button"
                class="sort-button"
                id="sortButton"
                data-order="newest"
            >

                <span id="sortText">
                    Newest First
                </span>

                <span class="sort-icon">↕</span>

            </button>


            <!-- Clear Filters -->
            <button
                type="button"
                class="clear-filter-button"
                id="clearFilters"
                title="Clear filters"
                aria-label="Clear filters"
            >
                ◇
            </button>

        </div>


        <!-- Previous Appointments Heading -->
        <div class="appointments-heading-row">

            <div class="appointments-title">

                <h2>

                    Previous Appointments

                    <span class="record-count">
                        <?php echo count($appointments); ?> records
                    </span>

                </h2>

            </div>

            <div class="records-showing">

                Showing records

                <span id="recordStart">
                    <?php echo count($appointments) > 0 ? 1 : 0; ?>
                </span>

                -

                <span id="recordEnd">
                    <?php echo min(4, count($appointments)); ?>
                </span>

                of

                <span id="recordTotal">
                    <?php echo count($appointments); ?>
                </span>

            </div>

        </div>


        <!-- Appointment List -->
        <div id="appointmentList">

            <?php foreach ($appointments as $appointment): ?>

                <?php

                $status = strtolower(
                    trim($appointment['status'] ?? '')
                );

                $statusClass = $status === 'completed'
                    ? 'completed'
                    : ($status === 'cancelled' ? 'cancelled' : 'other');

                $species = strtolower(
                    $appointment['species'] ?? ''
                );

                $petIcon = $species === 'cat' ? '🐈' : '🐕';

                $petDescription = !empty($appointment['breed'])
                    ? $appointment['breed']
                    : ucfirst($appointment['species'] ?? 'Pet');

                $searchText = strtolower(
                    $appointment['search_text'] ?? ''
                );

                ?>

                <article
                    class="appointment-card"
                    data-pet="<?php echo (int) $appointment['pet_id']; ?>"
                    data-status="<?php echo historyEscape($status); ?>"
                    data-date="<?php echo historyEscape($appointment['appointment_date']); ?>"
                    data-search="<?php echo historyEscape($searchText); ?>"
                >

                    <!-- Appointment Date -->
                    <div class="appointment-date">

                        <span class="date-month">
                            <?php echo historyEscape($appointment['month']); ?>
                        </span>

                        <strong class="date-day">
                            <?php echo historyEscape($appointment['date']); ?>
                        </strong>

                        <span class="date-year">
                            <?php echo historyEscape($appointment['year']); ?>
                        </span>

                    </div>


                    <!-- Appointment Information -->
                    <div class="appointment-information">

                        <div class="appointment-meta">

                            <span class="status-badge <?php echo $statusClass; ?>">

                                <?php if ($status === 'completed'): ?>

                                    ✓

                                <?php elseif ($status === 'cancelled'): ?>

                                    ×

                                <?php endif; ?>

                                <?php echo historyEscape($appointment['status']); ?>

                            </span>

                            <span class="appointment-time">

                                ◷

                                <?php echo historyEscape($appointment['time']); ?>

                                -

                                <?php echo historyEscape($appointment['end_time']); ?>

                                (<?php echo (int) $appointment['duration']; ?> min)

                            </span>

                        </div>


                        <!-- Service -->
                        <h3>
                            <?php echo historyEscape($appointment['title']); ?>
                        </h3>


                        <!-- Pet Information -->
                        <div class="pet-information">

                            <span class="pet-name">

                                <?php echo $petIcon; ?>

                                <?php echo historyEscape($appointment['pet_name']); ?>

                            </span>

                            <span class="pet-details">

                                <?php echo historyEscape($petDescription); ?>,

                                <?php echo historyEscape($appointment['pet_age']); ?>

                            </span>

                        </div>


                        <!-- Veterinarian -->
                        <div class="vet-information">

                            <span class="vet-icon">♡</span>

                            <strong>

                                <?php

                                $vetName = preg_replace(
                                    '/^Dr\.\s*/i',
                                    '',
                                    $appointment['vet']
                                );

                                echo 'Dr. ' . historyEscape($vetName);

                                ?>

                            </strong>

                            <span>(Veterinarian)</span>

                        </div>


                        <!-- Clinic -->
                        <div class="clinic-information">

                            <span>⌖</span>

                            <span>Happy Paws Clinic</span>

                        </div>

                    </div>


                    <!-- Appointment Actions -->
                    <div class="appointment-actions">

                        <div class="appointment-reference">

                            Ref:

                            <strong>
                                <?php echo historyEscape($appointment['id']); ?>
                            </strong>

                            <button
                                type="button"
                                class="copy-reference"
                                data-reference="<?php echo historyEscape($appointment['id']); ?>"
                                title="Copy appointment ID"
                            >
                                ▣
                            </button>

                        </div>


                        <div class="action-buttons">

                            <button
                                type="button"
                                class="details-button"
                                data-appointment="<?php echo (int) $appointment['appointment_id']; ?>"
                            >
                                View Details
                            </button>

                            <?php if ($status === 'completed'): ?>

                                <a
                                    class="health-record-button"
                                    href="<?php echo URLROOT; ?>/petowner/healthRecords?pet_id=<?php echo (int) $appointment['pet_id']; ?>"
                                >

                                    View Health Records

                                    <span>→</span>

                                </a>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>


        <!-- No Results / Empty State -->
        <div
            id="noResults"
            class="no-results"
            style="<?php echo empty($appointments) ? 'display: block;' : 'display: none;'; ?>"
        >

            <div class="no-results-icon">
                🔎
            </div>

            <h3>
                <?php echo empty($appointments)
                    ? 'No appointment history yet'
                    : 'No appointments found'; ?>
            </h3>

            <p>
                <?php echo empty($appointments)
                    ? 'Your previous and cancelled appointments will appear here.'
                    : 'Try changing your search or filters.'; ?>
            </p>

        </div>


        <!-- Pagination -->
        <div class="pagination-container">

            <button
                type="button"
                class="pagination-button previous-button"
                id="previousPage"
                disabled
            >
                ← Previous
            </button>


            <div class="pagination-pages"></div>


            <button
                type="button"
                class="pagination-button"
                id="nextPage"
            >
                Next →
            </button>

        </div>

    </section>

</main>


<!-- Appointment History JavaScript -->
<script src="<?php echo URLROOT; ?>/js/petowner-appointment-history.js"></script>
<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>
</body>
</html>
