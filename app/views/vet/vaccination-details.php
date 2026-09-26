<?php

$vaccination = $data['vaccination'];
$pet = $data['pet'];

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
        Vaccination Details - Happy Paws
    </title>


    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
    >


    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    


    <link
        rel="stylesheet"
       href="<?php echo URLROOT; ?>/css/vet-vaccination-details.css?v=999">

</head>


<body>


<div class="vet-page">


    <?php
    require_once APPROOT . '/views/layouts/vet_sidebar.php';
    ?>


    <main class="vet-main">


        <!-- HEADER -->

        <header class="vet-topbar">

            <div class="vet-search">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    placeholder="Search appointments, patients..."
                >

            </div>


            <div class="vet-header-right">

            <a 
    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications" 
    class="header-action"
>
    <img
        src="<?php echo URLROOT; ?>/images/sidebar-icons/notification.png"
        alt="Notifications"
    >

    <span class="notification-dot"></span>
</a>


                <button
                    type="button"
                    class="header-action"
                >
                    ⚙
                </button>


                <div class="header-divider"></div>


                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                    class="vet-profile"
                >

                    <img
                        src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                        alt="Profile"
                    >

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



        <!-- MAIN PAGE -->

        <section class="vaccination-details-page">


            <!-- PAGE HEADER -->

            <div class="page-header">


                <div>

                    <div class="page-label">
                        ● VACCINATION RECORD
                    </div>


                    <h1>
                        Vaccination Details
                    </h1>


                    <p>
                        View and manage the clinical immunization
                        record for <?php echo $pet['name']; ?>.
                    </p>

                </div>


                <div class="page-actions">


                    <button
                        type="button"
                        class="delete-button"
                        id="delete-vaccination-button"
                    >
                        🗑 Delete Vaccination
                    </button>


                    <a
                        href="<?php echo URLROOT; ?>/index.php?url=vet/editVaccination/<?php echo $vaccination['id']; ?>"
                        class="edit-button"
                    >
                        ✎ Edit Vaccination
                    </a>

                </div>

            </div>



            <!-- PET CARD -->

            <section class="pet-card">


                <div class="pet-avatar">
                    🐱
                </div>


                <div class="pet-info">

                    <div class="pet-name">

                        <?php echo $pet['name']; ?>

                        <span>
                            🏠 Indoor Cat
                        </span>

                        <span>
                            ✓ Up to Date
                        </span>

                    </div>


                    <p>

                        <?php echo $pet['breed']; ?>

                        •
                        <?php echo $pet['gender']; ?>

                        • Owner:
                        <?php echo $pet['owner']; ?>

                    </p>

                </div>


                <div class="pet-stats">


                    <div>

                        <span>
                            PATIENT AGE
                        </span>

                        <strong>
                            <?php echo $pet['age']; ?>
                        </strong>

                    </div>


                    <div>

                        <span>
                            WEIGHT
                        </span>

                        <strong>
                            <?php echo $pet['weight']; ?>
                        </strong>

                    </div>

                </div>

            </section>



            <!-- VACCINATION CARD -->

            <section class="details-card">


                <div class="details-heading">

                    <div class="details-icon">
                        💉
                    </div>


                    <div>

                        <h2>
                            Vaccination Information
                        </h2>

                        <p>
                            Record ID:
                            #VAC-<?php echo $vaccination['id']; ?>

                            • Administered at Happy Paws Main Clinic
                        </p>

                    </div>

                </div>



                <!-- STATUS -->

                <div class="status-pill">

                    <?php if ($vaccination['status'] === 'Completed'): ?>

                        ✓ Completed

                    <?php elseif ($vaccination['status'] === 'Due Now'): ?>

                        △ Due Now

                    <?php else: ?>

                        ! Overdue

                    <?php endif; ?>

                </div>



                <!-- INFORMATION -->

                <div class="vaccination-grid">


                    <div class="info-box full">

                        <span>
                            💉 Vaccine Name
                        </span>

                        <strong>
                            <?php echo $vaccination['vaccine']; ?>
                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Manufacturer
                        </span>

                        <strong>
                            <?php echo $vaccination['manufacturer']; ?>
                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Vaccination Type
                        </span>

                        <strong>
                            <?php echo $vaccination['type']; ?>
                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            📅 Date Given
                        </span>

                        <strong>
                            <?php echo $vaccination['date_given']; ?>
                        </strong>

                    </div>


                    <div class="info-box next-due">

                        <span>
                            📅 Next Due Date
                        </span>

                        <strong>
                            <?php echo $vaccination['next_due']; ?>
                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Lot / Batch Number
                        </span>

                        <strong>
                            <?php echo $vaccination['lot_number']; ?>
                        </strong>

                    </div>


                    <div class="info-box">

                        <span>
                            Administered By
                        </span>

                        <strong>
                            <?php echo $vaccination['administered_by']; ?>
                        </strong>

                    </div>


                </div>

            </section>



            <!-- NOTES -->

            <section class="notes-card">


                <h2>
                    Notes
                </h2>


                <div class="notes-content">

                    <?php
                    echo nl2br(
                        htmlspecialchars(
                            $vaccination['notes']
                        )
                    );
                    ?>

                </div>

            </section>



            <!-- BACK -->

            <div class="bottom-action">

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/healthRecordDetails/1"
                    class="back-record-button"
                >
                    ← Back to Medical Record
                </a>

            </div>


        </section>

    </main>

</div>



<!-- DELETE CONFIRMATION -->

<div
    class="delete-confirmation"
    id="delete-confirmation"
>


    <div class="confirmation-box">


        <div class="confirmation-icon">
            🗑
        </div>


        <h2>
            Delete Vaccination?
        </h2>


        <p>
            Are you sure you want to delete
            <?php echo $vaccination['vaccine']; ?>?
            This action cannot be undone.
        </p>


        <div class="confirmation-actions">


            <button
                type="button"
                id="cancel-delete"
                class="cancel-delete"
            >
                Cancel
            </button>


            <a
                href="<?php echo URLROOT; ?>/index.php?url=vet/deleteVaccination/<?php echo $vaccination['id']; ?>"
                class="confirm-delete"
            >
                Delete Vaccination
            </a>

        </div>

    </div>

</div>



<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const deleteButton =
            document.getElementById(
                "delete-vaccination-button"
            );

        const confirmation =
            document.getElementById(
                "delete-confirmation"
            );

        const cancelDelete =
            document.getElementById(
                "cancel-delete"
            );


        deleteButton.addEventListener(
            "click",
            function () {

                confirmation.classList.add(
                    "show"
                );

            }
        );


        cancelDelete.addEventListener(
            "click",
            function () {

                confirmation.classList.remove(
                    "show"
                );

            }
        );

    }
);

</script>


</body>

</html>