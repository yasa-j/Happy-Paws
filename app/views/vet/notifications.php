<?php
$currentUrl = $_GET['url'] ?? 'vet/notifications';
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
        <?php echo $data['title'] ?? 'Notifications'; ?>
    </title>


    <!-- Vet Sidebar -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">

<link
    rel="stylesheet"
    href="<?php echo URLROOT; ?>/css/vet-header.css?v=2"
>
    <!-- Notifications CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-notifications.css?v=1001"
    >

</head>


<body>


<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php require APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- =====================================================
         MAIN CONTENT
         ===================================================== -->

    <main class="vet-main">


        <!-- =================================================
             TOP HEADER
             ================================================= -->

        <header class="vet-top-header">


            <div class="vet-search">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    id="notification-search"
                    placeholder="Search notifications..."
                >

            </div>


            <div class="vet-header-right">


                <!-- Notification -->

                <button
                    type="button"
                    class="header-icon-button"
                    id="header-notification-button"
                    title="Notifications"
                >

                    ♧

                    <span
                        class="header-notification-dot"
                        id="header-notification-dot"
                    ></span>

                </button>


                <!-- Settings -->

                <button
                    type="button"
                    class="header-icon-button"
                    id="settings-button"
                    title="Settings"
                >
                    ⚙
                </button>


                <div class="header-divider"></div>


                <!-- User -->

                <div class="vet-user">

    <div class="vet-user-avatar">
        <img
            src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
            alt="Profile">
    </div>

    <div class="vet-user-info">

                        <strong>
    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
</strong>

                        <span>
                            Lead Veterinarian
                        </span>

                    </div>

                </div>


            </div>

        </header>



        <!-- =================================================
             PAGE CONTENT
             ================================================= -->

        <section class="notifications-content">


            <!-- =================================================
                 PAGE TITLE
                 ================================================= -->

            <div class="notification-heading">


                <h1>
                    Notifications
                </h1>


                <button
                    type="button"
                    class="mark-all-button"
                    id="mark-all-button"
                >
                    ✓
                    Mark all as read
                </button>


            </div>



            <!-- =================================================
                 FILTER BAR
                 ================================================= -->

            <div class="notification-toolbar">


                <div class="notification-filters">


                    <button
                        type="button"
                        class="notification-filter active"
                        data-filter="all"
                    >
                        All
                        <span class="filter-count">
                            6
                        </span>
                    </button>


                    <button
                        type="button"
                        class="notification-filter"
                        data-filter="unread"
                    >
                        Unread

                        <span
                            class="filter-count unread-count"
                            id="unread-count"
                        >
                            3
                        </span>

                    </button>


                    <button
                        type="button"
                        class="notification-filter"
                        data-filter="appointment"
                    >
                        Appointments
                    </button>


                    <button
                        type="button"
                        class="notification-filter"
                        data-filter="medical"
                    >
                        Medical Records
                    </button>


                    <button
                        type="button"
                        class="notification-filter"
                        data-filter="vaccination"
                    >
                        Vaccinations
                    </button>


                    <button
                        type="button"
                        class="notification-filter"
                        data-filter="system"
                    >
                        System
                    </button>


                </div>



                <!-- Sort -->

                <div class="notification-sort">

                    <span>
                        Sort by:
                    </span>

                    <select id="notification-sort">

                        <option value="newest">
                            Newest first
                        </option>

                        <option value="oldest">
                            Oldest first
                        </option>

                    </select>

                </div>


            </div>



            <!-- =================================================
                 NOTIFICATION CARD
                 ================================================= -->

            <section class="notifications-card">


                <!-- Header -->

                <div class="notifications-card-header">


                    <div>

                        <h2>
                            Recent Notifications
                        </h2>

                        <span
                            id="notification-summary"
                        >
                            Showing 6 notifications
                        </span>

                    </div>


                    <span class="sync-status">
                        Automatic sync: On
                    </span>


                </div>



                <!-- =================================================
                     NOTIFICATION LIST
                     ================================================= -->

                <div
                    class="notification-list"
                    id="notification-list"
                >


                    <!-- =================================================
                         NOTIFICATION 1
                         ================================================= -->

                    <article
                        class="notification-item unread"
                        data-id="1"
                        data-type="appointment"
                        data-date="2026-09-24T09:45:00"
                    >


                        <div class="notification-icon appointment-icon">
                            ▣
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category appointment">
                                    APPOINTMENT
                                </span>


                                <span class="unread-dot"></span>


                                <span class="notification-time">
                                    Today, 9:45 AM
                                </span>


                            </div>


                            <h3>
                                Upcoming Appointment
                            </h3>


                            <p>
                                Luna has an appointment with you today at
                                <strong>10:30 AM.</strong>
                            </p>


                            <div class="notification-actions">


                                <button
                                    type="button"
                                    class="notification-action primary"
                                    data-action="schedule"
                                >
                                    ▣
                                    View Schedule
                                </button>


                                <button
                                    type="button"
                                    class="mark-read-button"
                                >
                                    ✓
                                    Mark as read
                                </button>


                            </div>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>



                    <!-- =================================================
                         NOTIFICATION 2
                         ================================================= -->

                    <article
                        class="notification-item unread"
                        data-id="2"
                        data-type="medical"
                        data-date="2026-09-24T08:30:00"
                    >


                        <div class="notification-icon medical-icon">
                            ☑
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category medical">
                                    MEDICAL RECORD
                                </span>


                                <span class="unread-dot"></span>


                                <span class="notification-time">
                                    Today, 8:30 AM
                                </span>


                            </div>


                            <h3>
                                Medical Record Updated
                            </h3>


                            <p>
                                A new clinical examination record has been
                                added for Buddy.
                            </p>


                            <div class="notification-actions">


                                <button
                                    type="button"
                                    class="notification-action primary"
                                    data-action="medical"
                                >
                                    ◉
                                    View Record
                                </button>


                                <button
                                    type="button"
                                    class="mark-read-button"
                                >
                                    ✓
                                    Mark as read
                                </button>


                            </div>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>



                    <!-- =================================================
                         NOTIFICATION 3
                         ================================================= -->

                    <article
                        class="notification-item unread"
                        data-id="3"
                        data-type="vaccination"
                        data-date="2026-09-23T16:20:00"
                    >


                        <div class="notification-icon vaccination-icon">
                            ⚕
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category vaccination">
                                    VACCINATION
                                </span>


                                <span class="unread-dot"></span>


                                <span class="notification-time">
                                    Yesterday, 4:20 PM
                                </span>


                            </div>


                            <h3>
                                Vaccination Due
                            </h3>


                            <p>
                                Luna's FeLV vaccination protocol
                                <strong>#VAC-2023-FVRCP</strong>
                                is due for veterinary review.
                            </p>


                            <div class="notification-actions">


                                <button
                                    type="button"
                                    class="notification-action primary"
                                    data-action="vaccination"
                                >
                                    ▣
                                    Review
                                </button>


                                <button
                                    type="button"
                                    class="mark-read-button"
                                >
                                    ✓
                                    Mark as read
                                </button>


                            </div>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>



                    <!-- =================================================
                         NOTIFICATION 4
                         ================================================= -->

                    <article
                        class="notification-item"
                        data-id="4"
                        data-type="appointment"
                        data-date="2026-09-23T14:15:00"
                    >


                        <div class="notification-icon cancelled-icon">
                            ▣
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category cancelled">
                                    APPOINTMENT
                                </span>


                                <span class="notification-time">
                                    Yesterday, 2:15 PM
                                </span>


                            </div>


                            <h3>
                                Appointment Cancelled
                            </h3>


                            <p>
                                Emily Davis cancelled Luna's checkup
                                scheduled for tomorrow.
                            </p>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>



                    <!-- =================================================
                         NOTIFICATION 5
                         ================================================= -->

                    <article
                        class="notification-item"
                        data-id="5"
                        data-type="medical"
                        data-date="2026-09-22T12:00:00"
                    >


                        <div class="notification-icon patient-icon">
                            ♣
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category medical">
                                    MEDICAL RECORD
                                </span>


                                <span class="notification-time">
                                    Sep 22, 2026
                                </span>


                            </div>


                            <h3>
                                New Patient Record
                            </h3>


                            <p>
                                A new patient profile
                                <strong>
                                    "Milo (Golden Retriever)"
                                </strong>
                                was registered by front desk.
                            </p>


                            <div class="notification-actions">


                                <button
                                    type="button"
                                    class="notification-action secondary"
                                    data-action="patient"
                                >
                                    ▣
                                    View Patient
                                </button>


                            </div>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>



                    <!-- =================================================
                         NOTIFICATION 6
                         ================================================= -->

                    <article
                        class="notification-item"
                        data-id="6"
                        data-type="system"
                        data-date="2026-09-21T10:00:00"
                    >


                        <div class="notification-icon system-icon">
                            ⚙
                        </div>


                        <div class="notification-body">


                            <div class="notification-meta">


                                <span class="notification-category system">
                                    SYSTEM
                                </span>


                                <span class="notification-time">
                                    Sep 21, 2026
                                </span>


                            </div>


                            <h3>
                                System Update
                            </h3>


                            <p>
                                Happy Paws system settings have been
                                updated successfully.
                            </p>


                        </div>


                        <button
                            type="button"
                            class="delete-notification-button"
                            title="Delete notification"
                        >
                            🗑
                        </button>


                    </article>


                </div>



                <!-- =================================================
                     EMPTY STATE
                     ================================================= -->

                <div
                    class="notification-empty"
                    id="notification-empty"
                    hidden
                >

                    <div class="empty-icon">
                        ♧
                    </div>

                    <h3>
                        No notifications found
                    </h3>

                    <p>
                        You're all caught up. There are no
                        notifications in this category.
                    </p>

                </div>


            </section>


        </section>


    </main>


</div>



<!-- =========================================================
     JAVASCRIPT
     ========================================================= -->

<script
    src="<?php echo URLROOT; ?>/js/vet-notifications.js"
></script>


</body>

</html>