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
        Edit Vaccination - Happy Paws
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
        href="<?php echo URLROOT; ?>/css/vet-edit-vaccination.css?v=1000">

</head>


<body>


<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php
    require_once APPROOT . '/views/layouts/vet_sidebar.php';
    ?>


    <main class="vet-main">


        <!-- =====================================================
             TOP HEADER
             ===================================================== -->

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
                    ♧

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
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">
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



        <!-- =====================================================
             PAGE CONTENT
             ===================================================== -->

        <section class="edit-vaccination-page">


            <!-- PAGE HEADER -->

            <div class="edit-page-header">


                <div>

                    <h1>
                        Edit Vaccination Record
                    </h1>

                    <p>
                        Update immunization details, lot verification,
                        and clinical notes for
                        <?php echo htmlspecialchars($pet['name']); ?>.
                    </p>

                </div>


                <div class="certified-badge">
                    ✓ Certified by Dr. Sarah Lee
                </div>

            </div>



            <!-- =================================================
                 PET CARD
                 ================================================= -->

            <section class="edit-pet-card">


                <div class="edit-pet-image">
                    🐱
                </div>


                <div class="edit-pet-info">

                    <div class="edit-pet-name">

                        <?php echo htmlspecialchars($pet['name']); ?>

                        <span>
                            ● Indoor
                        </span>

                    </div>


                    <div class="edit-pet-details">

                        <?php echo htmlspecialchars($pet['breed']); ?>

                        •
                        <?php echo htmlspecialchars($pet['gender']); ?>

                        •
                        Owner:
                        <?php echo htmlspecialchars($pet['owner']); ?>

                    </div>


                    <div class="edit-pet-stats">

                        <span>
                            ⚖
                            <?php echo htmlspecialchars($pet['weight']); ?>
                        </span>

                        <span>
                            ♙
                            <?php echo htmlspecialchars($pet['age']); ?>
                        </span>

                    </div>

                </div>


                <div class="passport-status">

                    <small>
                        PASSPORT STATUS
                    </small>

                    <strong>
                        ✓ Fully<br>
                        Immunized
                    </strong>

                </div>

            </section>



            <!-- =================================================
                 FORM
                 ================================================= -->

            <form
                action="<?php echo URLROOT; ?>/index.php?url=vet/updateVaccination"
                method="POST"
                id="edit-vaccination-form"
            >


                <input
                    type="hidden"
                    name="vaccination_id"
                    value="<?php echo $vaccination['id']; ?>"
                >



                <section class="vaccination-form-card">


                    <!-- FORM HEADER -->

                    <div class="form-card-header">


                        <div class="form-title-icon">
                            💉
                        </div>


                        <div>

                            <h2>
                                Vaccination Information
                            </h2>

                            <p>
                                Modify vaccine details, schedule,
                                and lot information.
                            </p>

                        </div>


                        <span class="last-modified">
                            ◷ Last modified
                        </span>

                    </div>



                    <!-- FORM GRID -->

                    <div class="form-grid">


                        <!-- VACCINE -->

                        <div class="form-group">


                            <label for="vaccine">
                                Vaccine Name
                                <span>*</span>
                            </label>


                            <select
                                id="vaccine"
                                name="vaccine"
                                required
                            >

                                <option
                                    value="FVRCP (Core)"
                                    <?php
                                    echo $vaccination['vaccine'] === 'FVRCP (Core)'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    FVRCP (Core) - Rhinotracheitis, Calicivirus, Panleukopenia
                                </option>


                                <option
                                    value="Rabies"
                                    <?php
                                    echo $vaccination['vaccine'] === 'Rabies'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Rabies
                                </option>


                                <option
                                    value="FeLV (Lifestyle)"
                                    <?php
                                    echo $vaccination['vaccine'] === 'FeLV (Lifestyle)'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    FeLV (Lifestyle)
                                </option>


                                <option
                                    value="Feline Panleukopenia"
                                    <?php
                                    echo $vaccination['vaccine'] === 'Feline Panleukopenia'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Feline Panleukopenia
                                </option>


                                <option
                                    value="Feline Herpesvirus"
                                    <?php
                                    echo $vaccination['vaccine'] === 'Feline Herpesvirus'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Feline Herpesvirus
                                </option>

                            </select>

                        </div>



                        <!-- MANUFACTURER -->

                        <div class="form-group">


                            <label for="manufacturer">
                                Manufacturer
                            </label>


                            <input
                                type="text"
                                id="manufacturer"
                                name="manufacturer"
                                value="<?php echo htmlspecialchars($vaccination['manufacturer']); ?>"
                                placeholder="e.g. Zoetis, Merck"
                            >

                        </div>



                        <!-- DATE GIVEN -->

                        <div class="form-group">


                            <label for="date_given">
                                Date Given
                                <span>*</span>
                            </label>


                            <input
                                type="date"
                                id="date_given"
                                name="date_given"
                                value="<?php echo htmlspecialchars($vaccination['date_given']); ?>"
                                required
                            >

                        </div>



                        <!-- NEXT DUE -->

                        <div class="form-group">


                            <label for="next_due">
                                Next Due Date
                                <span>*</span>

                                <button
                                    type="button"
                                    id="one-year-button"
                                    class="year-preset"
                                >
                                    + 1 Year Preset
                                </button>

                            </label>


                            <input
                                type="date"
                                id="next_due"
                                name="next_due"
                                value="<?php echo htmlspecialchars($vaccination['next_due']); ?>"
                                required
                            >

                        </div>



                        <!-- TYPE -->

                        <div class="form-group">


                            <label for="type">
                                Vaccination Type
                                <span>*</span>
                            </label>


                            <select
                                id="type"
                                name="type"
                                required
                            >

                                <option
                                    value="Core"
                                    <?php
                                    echo $vaccination['type'] === 'Core'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Core (Essential for all felines)
                                </option>


                                <option
                                    value="Lifestyle"
                                    <?php
                                    echo $vaccination['type'] === 'Lifestyle'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Lifestyle
                                </option>


                                <option
                                    value="Booster"
                                    <?php
                                    echo $vaccination['type'] === 'Booster'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Booster
                                </option>


                                <option
                                    value="Other"
                                    <?php
                                    echo $vaccination['type'] === 'Other'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Other
                                </option>

                            </select>

                        </div>



                        <!-- STATUS -->

                        <div class="form-group">


                            <label for="status">
                                Status
                                <span>*</span>
                            </label>


                            <select
                                id="status"
                                name="status"
                                required
                            >

                                <option
                                    value="Completed"
                                    <?php
                                    echo $vaccination['status'] === 'Completed'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Completed (Administered)
                                </option>


                                <option
                                    value="Due Now"
                                    <?php
                                    echo $vaccination['status'] === 'Due Now'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Due Now
                                </option>


                                <option
                                    value="Overdue"
                                    <?php
                                    echo $vaccination['status'] === 'Overdue'
                                        ? 'selected'
                                        : '';
                                    ?>
                                >
                                    Overdue
                                </option>

                            </select>

                        </div>



                        <!-- LOT -->

                        <div class="form-group">


                            <label for="lot_number">
                                Lot / Batch Number
                            </label>


                            <input
                                type="text"
                                id="lot_number"
                                name="lot_number"
                                value="<?php echo htmlspecialchars($vaccination['lot_number']); ?>"
                                placeholder="Enter lot number"
                            >

                        </div>



                        <!-- NOTES -->

                        <div class="form-group full-width">


                            <div class="notes-label-row">

                                <label for="notes">
                                    Administering Notes & Observations
                                </label>

                                <span id="character-count">
                                    0/500
                                </span>

                            </div>


                            <textarea
                                id="notes"
                                name="notes"
                                maxlength="500"
                                rows="5"
                                placeholder="Enter any additional notes..."
                            ><?php echo htmlspecialchars($vaccination['notes']); ?></textarea>


                            <small>
                                Include injection site, patient demeanor,
                                or immediate post-vaccine vital checks.
                            </small>

                        </div>

                    </div>

                </section>



                <!-- =================================================
                     BOTTOM ACTIONS
                     ================================================= -->

                <div class="form-actions">


                    <a
                        href="<?php echo URLROOT; ?>/index.php?url=vet/vaccinationDetails/<?php echo $vaccination['id']; ?>"
                        class="delete-record-button"
                    >
                        🗑 Delete Record
                    </a>


                    <div class="right-actions">


                        <a
                            href="<?php echo URLROOT; ?>/index.php?url=vet/vaccinationDetails/<?php echo $vaccination['id']; ?>"
                            class="cancel-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="save-button"
                        >
                            ✓ Save Changes
                        </button>

                    </div>

                </div>


            </form>


        </section>

    </main>

</div>



<script>

document.addEventListener(
    "DOMContentLoaded",
    function () {


        /* =====================================================
           CHARACTER COUNTER
           ===================================================== */

        const notes =
            document.getElementById("notes");

        const counter =
            document.getElementById("character-count");


        function updateCounter() {

            if (notes && counter) {

                counter.textContent =
                    notes.value.length + "/500";

            }

        }


        if (notes) {

            notes.addEventListener(
                "input",
                updateCounter
            );

            updateCounter();

        }



        /* =====================================================
           ONE YEAR PRESET
           ===================================================== */

        const dateGiven =
            document.getElementById("date_given");

        const nextDue =
            document.getElementById("next_due");

        const oneYearButton =
            document.getElementById("one-year-button");


        if (oneYearButton) {

            oneYearButton.addEventListener(
                "click",
                function () {

                    if (!dateGiven.value) {

                        alert(
                            "Please select the Date Given first."
                        );

                        return;
                    }


                    const date =
                        new Date(
                            dateGiven.value + "T00:00:00"
                        );


                    date.setFullYear(
                        date.getFullYear() + 1
                    );


                    const year =
                        date.getFullYear();


                    const month =
                        String(
                            date.getMonth() + 1
                        ).padStart(2, "0");


                    const day =
                        String(
                            date.getDate()
                        ).padStart(2, "0");


                    nextDue.value =
                        year +
                        "-" +
                        month +
                        "-" +
                        day;

                }
            );

        }



        /* =====================================================
           FORM VALIDATION
           ===================================================== */

        const form =
            document.getElementById(
                "edit-vaccination-form"
            );


        if (form) {

            form.addEventListener(
                "submit",
                function (event) {

                    if (
                        !dateGiven.value ||
                        !nextDue.value
                    ) {

                        event.preventDefault();

                        alert(
                            "Please complete all required fields."
                        );

                    }

                }
            );

        }

    }
);

</script>


</body>

</html>