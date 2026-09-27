<?php
$pageTitle = $data['pageTitle'] ?? 'Appointment History';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $pageTitle; ?> | Happy Paws</title>

    <!-- Main Pet Owner CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner.css">
    <link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/topbar.css">

    <!-- Appointment History CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner-appointment-history.css">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="pet-owner-layout">

    <!-- ==========================================
         SIDEBAR
    =========================================== -->
    <?php require APPROOT . '/views/layouts/petowner-sidebar.php'; ?>


    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->
    <main class="history-main">

        <!-- ======================================
             TOP HEADER
        ======================================= -->
        <header class="history-topbar">

            <div class="topbar-search">
                <span class="search-icon">⌕</span>

                <input
                    type="text"
                    placeholder="Search pets, records..."
                    aria-label="Search pets and records"
                >
            </div>

            <div class="topbar-actions">

                <button class="topbar-icon-button" title="Notifications">
                    ♧
                    <span class="notification-dot"></span>
                </button>

                <button class="topbar-icon-button" title="Product Store">
                    🛒
                </button>

                <div class="topbar-divider"></div>

                <button class="profile-button">
                    <div class="profile-avatar">
                        👤
                    </div>

                    <span class="profile-arrow">⌄</span>
                </button>

            </div>

        </header>


        <!-- ======================================
             PAGE CONTENT
        ======================================= -->
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


            <!-- ======================================
                 SUMMARY CARDS
            ======================================= -->
            <div class="summary-cards">

                <!-- Total Appointments -->
                <div class="summary-card">

                    <div class="summary-card-top">

                        <div>
                            <p class="summary-label">
                                Total Appointments
                            </p>

                            <div class="summary-number-row">
                                <span class="summary-number">12</span>

                                <span class="summary-small-text">
                                    all-time logged
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


                <!-- Completed -->
                <div class="summary-card">

                    <div class="summary-card-top">

                        <div>
                            <p class="summary-label">
                                Completed
                            </p>

                            <div class="summary-number-row">

                                <span class="summary-number">
                                    10
                                </span>

                                <span class="summary-percentage green-text">
                                    ↗ 83.3% rate
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


                <!-- Cancelled -->
                <div class="summary-card">

                    <div class="summary-card-top">

                        <div>
                            <p class="summary-label">
                                Cancelled
                            </p>

                            <div class="summary-number-row">

                                <span class="summary-number">
                                    2
                                </span>

                                <span class="summary-percentage red-text">
                                    16.7%
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


            <!-- ======================================
                 FILTER BAR
            ======================================= -->
            <div class="history-filter-bar">

                <!-- Search -->
                <div class="history-search">

                    <span class="filter-search-icon">⌕</span>

                    <input
                        type="text"
                        id="appointmentSearch"
                        placeholder="Search appointment history (pet name, vet, or APT ID)..."
                    >

                </div>


                <!-- Pet Filter -->
                <div class="filter-select-wrapper">

                    <select id="petFilter">
                        <option value="all">All Pets (2)</option>
                        <option value="max">Max</option>
                        <option value="bella">Bella</option>
                    </select>

                    <span class="select-arrow">⌄</span>

                </div>


                <!-- Status Filter -->
                <div class="filter-select-wrapper">

                    <select id="statusFilter">

                        <option value="all">
                            All Statuses
                        </option>

                        <option value="completed">
                            Completed
                        </option>

                        <option value="cancelled">
                            Cancelled
                        </option>

                    </select>

                    <span class="select-arrow">⌄</span>

                </div>


                <!-- Sort -->
                <button
                    class="sort-button"
                    id="sortButton"
                    data-order="newest"
                >

                    <span id="sortText">
                        Newest First
                    </span>

                    <span class="sort-icon">
                        ↕
                    </span>

                </button>


                <!-- Clear Filters -->
                <button
                    class="clear-filter-button"
                    id="clearFilters"
                    title="Clear filters"
                >
                    ◇
                </button>

            </div>


            <!-- ======================================
                 PREVIOUS APPOINTMENTS HEADING
            ======================================= -->
            <div class="appointments-heading-row">

                <div class="appointments-title">

                    <h2>
                        Previous Appointments

                        <span class="record-count">
                            12 records
                        </span>
                    </h2>

                </div>

                <div class="records-showing">
                    Showing records
                    <span id="recordStart">1</span>
                    -
                    <span id="recordEnd">4</span>
                    of
                    <span id="recordTotal">12</span>
                </div>

            </div>


            <!-- ======================================
                 APPOINTMENT LIST
            ======================================= -->
            <div id="appointmentList">


                <!-- ==================================
                     APPOINTMENT 1
                =================================== -->
                <article
                    class="appointment-card"
                    data-pet="max"
                    data-status="completed"
                    data-date="2026-09-15"
                    data-search="max golden retriever dr sarah fernando apt-000104 general consultation routine checkup"
                >

                    <!-- Date -->
                    <div class="appointment-date">

                        <span class="date-month">
                            SEP
                        </span>

                        <strong class="date-day">
                            15
                        </strong>

                        <span class="date-year">
                            2026
                        </span>

                    </div>


                    <!-- Appointment Information -->
                    <div class="appointment-information">

                        <div class="appointment-meta">

                            <span class="status-badge completed">
                                ✓ Completed
                            </span>

                            <span class="appointment-time">
                                ◷ 10:30 AM - 11:00 AM (30 min)
                            </span>

                        </div>


                        <h3>
                            General Consultation &amp; Routine Checkup
                        </h3>


                        <div class="pet-information">

                            <span class="pet-name">
                                🐕 Max
                            </span>

                            <span class="pet-details">
                                Golden Retriever, 2 yrs
                            </span>

                        </div>


                        <div class="vet-information">

                            <span class="vet-icon">
                                ♡
                            </span>

                            <strong>
                                Dr. Sarah Fernando
                            </strong>

                            <span>
                                (Senior Veterinary Surgeon)
                            </span>

                        </div>


                        <div class="clinic-information">

                            <span>⌖</span>

                            <span>
                                Room 02 • Happy Paws Clinic
                            </span>

                        </div>

                    </div>


                    <!-- Right Side -->
                    <div class="appointment-actions">

                        <div class="appointment-reference">
                            Ref:
                            <strong>APT-000104</strong>

                            <button
                                class="copy-reference"
                                data-reference="APT-000104"
                                title="Copy appointment ID"
                            >
                                ▣
                            </button>
                        </div>


                        <div class="action-buttons">

                            <button
                                class="details-button"
                                data-appointment="APT-000104"
                            >
                                View Details
                            </button>

                            <button
                                class="health-record-button"
                                data-pet="Max"
                            >
                                View Health Records
                                <span>→</span>
                            </button>

                        </div>

                    </div>

                </article>


                <!-- ==================================
                     APPOINTMENT 2
                =================================== -->
                <article
                    class="appointment-card"
                    data-pet="bella"
                    data-status="completed"
                    data-date="2026-09-08"
                    data-search="bella labrador dr michael perera apt-000103 vaccination follow up"
                >

                    <div class="appointment-date">

                        <span class="date-month">
                            SEP
                        </span>

                        <strong class="date-day">
                            08
                        </strong>

                        <span class="date-year">
                            2026
                        </span>

                    </div>


                    <div class="appointment-information">

                        <div class="appointment-meta">

                            <span class="status-badge completed">
                                ✓ Completed
                            </span>

                            <span class="appointment-time">
                                ◷ 02:00 PM - 02:30 PM (30 min)
                            </span>

                        </div>


                        <h3>
                            Vaccination &amp; Preventive Care
                        </h3>


                        <div class="pet-information">

                            <span class="pet-name">
                                🐕 Bella
                            </span>

                            <span class="pet-details">
                                Labrador, 3 yrs
                            </span>

                        </div>


                        <div class="vet-information">

                            <span class="vet-icon">
                                ♡
                            </span>

                            <strong>
                                Dr. Michael Perera
                            </strong>

                            <span>
                                (Veterinary Surgeon)
                            </span>

                        </div>


                        <div class="clinic-information">

                            <span>⌖</span>

                            <span>
                                Room 01 • Happy Paws Clinic
                            </span>

                        </div>

                    </div>


                    <div class="appointment-actions">

                        <div class="appointment-reference">
                            Ref:
                            <strong>APT-000103</strong>

                            <button
                                class="copy-reference"
                                data-reference="APT-000103"
                                title="Copy appointment ID"
                            >
                                ▣
                            </button>
                        </div>


                        <div class="action-buttons">

                            <button
                                class="details-button"
                                data-appointment="APT-000103"
                            >
                                View Details
                            </button>

                            <button
                                class="health-record-button"
                                data-pet="Bella"
                            >
                                View Health Records
                                <span>→</span>
                            </button>

                        </div>

                    </div>

                </article>


                <!-- ==================================
                     APPOINTMENT 3
                =================================== -->
                <article
                    class="appointment-card"
                    data-pet="max"
                    data-status="cancelled"
                    data-date="2026-08-26"
                    data-search="max golden retriever dr sarah fernando apt-000102 dental cancelled"
                >

                    <div class="appointment-date">

                        <span class="date-month">
                            AUG
                        </span>

                        <strong class="date-day">
                            26
                        </strong>

                        <span class="date-year">
                            2026
                        </span>

                    </div>


                    <div class="appointment-information">

                        <div class="appointment-meta">

                            <span class="status-badge cancelled">
                                × Cancelled
                            </span>

                            <span class="appointment-time">
                                ◷ 11:00 AM - 11:30 AM (30 min)
                            </span>

                        </div>


                        <h3>
                            Dental Checkup
                        </h3>


                        <div class="pet-information">

                            <span class="pet-name">
                                🐕 Max
                            </span>

                            <span class="pet-details">
                                Golden Retriever, 2 yrs
                            </span>

                        </div>


                        <div class="vet-information">

                            <span class="vet-icon">
                                ♡
                            </span>

                            <strong>
                                Dr. Sarah Fernando
                            </strong>

                            <span>
                                (Senior Veterinary Surgeon)
                            </span>

                        </div>


                        <div class="clinic-information">

                            <span>⌖</span>

                            <span>
                                Room 02 • Happy Paws Clinic
                            </span>

                        </div>

                    </div>


                    <div class="appointment-actions">

                        <div class="appointment-reference">
                            Ref:
                            <strong>APT-000102</strong>

                            <button
                                class="copy-reference"
                                data-reference="APT-000102"
                                title="Copy appointment ID"
                            >
                                ▣
                            </button>
                        </div>


                        <div class="action-buttons">

                            <button
                                class="details-button"
                                data-appointment="APT-000102"
                            >
                                View Details
                            </button>

                        </div>

                    </div>

                </article>


                <!-- ==================================
                     APPOINTMENT 4
                =================================== -->
                <article
                    class="appointment-card"
                    data-pet="bella"
                    data-status="completed"
                    data-date="2026-08-12"
                    data-search="bella labrador dr michael perera apt-000101 general consultation"
                >

                    <div class="appointment-date">

                        <span class="date-month">
                            AUG
                        </span>

                        <strong class="date-day">
                            12
                        </strong>

                        <span class="date-year">
                            2026
                        </span>

                    </div>


                    <div class="appointment-information">

                        <div class="appointment-meta">

                            <span class="status-badge completed">
                                ✓ Completed
                            </span>

                            <span class="appointment-time">
                                ◷ 09:30 AM - 10:30 AM (1 hour)
                            </span>

                        </div>


                        <h3>
                            General Consultation
                        </h3>


                        <div class="pet-information">

                            <span class="pet-name">
                                🐕 Bella
                            </span>

                            <span class="pet-details">
                                Labrador, 3 yrs
                            </span>

                        </div>


                        <div class="vet-information">

                            <span class="vet-icon">
                                ♡
                            </span>

                            <strong>
                                Dr. Michael Perera
                            </strong>

                            <span>
                                (Veterinary Surgeon)
                            </span>

                        </div>


                        <div class="clinic-information">

                            <span>⌖</span>

                            <span>
                                Room 01 • Happy Paws Clinic
                            </span>

                        </div>

                    </div>


                    <div class="appointment-actions">

                        <div class="appointment-reference">
                            Ref:
                            <strong>APT-000101</strong>

                            <button
                                class="copy-reference"
                                data-reference="APT-000101"
                                title="Copy appointment ID"
                            >
                                ▣
                            </button>
                        </div>


                        <div class="action-buttons">

                            <button
                                class="details-button"
                                data-appointment="APT-000101"
                            >
                                View Details
                            </button>

                            <button
                                class="health-record-button"
                                data-pet="Bella"
                            >
                                View Health Records
                                <span>→</span>
                            </button>

                        </div>

                    </div>

                </article>

            </div>


            <!-- No Results -->
            <div
                id="noResults"
                class="no-results"
                style="display: none;"
            >

                <div class="no-results-icon">
                    🔎
                </div>

                <h3>
                    No appointments found
                </h3>

                <p>
                    Try changing your search or filters.
                </p>

            </div>


            <!-- ======================================
                 PAGINATION
            ======================================= -->
            <div class="pagination-container">

                <button
                    class="pagination-button previous-button"
                    id="previousPage"
                    disabled
                >
                    ← Previous
                </button>


                <div class="pagination-pages">

                    <button
                        class="page-number active"
                        data-page="1"
                    >
                        1
                    </button>

                    <button
                        class="page-number"
                        data-page="2"
                    >
                        2
                    </button>

                    <button
                        class="page-number"
                        data-page="3"
                    >
                        3
                    </button>

                </div>


                <button
                    class="pagination-button"
                    id="nextPage"
                >
                    Next →
                </button>

            </div>

        </section>

    </main>

</div>


<!-- Appointment History JavaScript -->
<script src="<?php echo URLROOT; ?>/js/petowner-appointment-history.js"></script>

</body>
</html>