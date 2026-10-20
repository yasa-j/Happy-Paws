<?php

/*
|--------------------------------------------------------------------------
| Register New Pet
|--------------------------------------------------------------------------
|
| This page uses the currently logged-in user.
|
| The photo input is optional but is NOT saved to the database.
|
*/

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register New Pet - Happy Paws</title>


    <!-- Pet Owner CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/petowner.css"
    >


    <!-- Topbar CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/topbar.css"
    >


    <!-- Register Pet CSS -->

    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/register-pet.css"
    >


    <!-- Font Awesome -->

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    

</head>


<body>


<div class="hp-register-page">


    <!-- =====================================================
         SIDEBAR
    ====================================================== -->

    <?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>


    <!-- =====================================================
         MAIN CONTENT
    ====================================================== -->

    <main class="hp-register-main">


        <!-- TOPBAR -->

        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <div class="hp-register-content">


            <!-- PAGE TITLE -->

            <h1 class="hp-page-title">
                Register New Pet
            </h1>


            <!-- ERROR MESSAGE -->

            <?php if (!empty($data['petError'])): ?>

                <div class="hp-error-message">

                    <?php echo $data['petError']; ?>

                </div>

            <?php endif; ?>


            <!-- =================================================
                 ONE SINGLE FORM
            ================================================== -->

            <form
                id="registerPetForm"
                class="hp-register-form"
                method="POST"
                action="<?php echo URLROOT; ?>/petowner/registerPet"
            >


                <!-- =================================================
                     STEP INDICATOR
                ================================================== -->

                <div class="hp-stepper">


                    <!-- STEP 1 -->

                    <div
                        class="hp-step hp-step-active"
                        id="stepIndicator1"
                    >

                        <div class="hp-step-circle">
                            1
                        </div>

                        <span>
                            Basic Info
                        </span>

                    </div>


                    <div class="hp-step-line"></div>


                    <!-- STEP 2 -->

                    <div
                        class="hp-step"
                        id="stepIndicator2"
                    >

                        <div class="hp-step-circle hp-step-inactive-circle">
                            2
                        </div>

                        <span>
                            Medical Info
                        </span>

                    </div>

                </div>



                <!-- =================================================
                     STEP 1
                ================================================== -->

                <section
                    id="petStep1"
                    class="hp-step-content"
                >

                    <div class="hp-basic-card">


                        <div class="hp-basic-layout">


                            <!-- PHOTO -->

                            <div class="hp-photo-column">

                                <label
                                    for="petPhoto"
                                    class="hp-photo-upload"
                                    id="photoUploadBox"
                                >

                                    <i class="fa-solid fa-camera"></i>

                                    <span>
                                        Upload Photo
                                    </span>


                                    <!--
                                        Optional only.

                                        The photo is NOT saved to
                                        the database.
                                    -->

                                    <input
                                        type="file"
                                        id="petPhoto"
                                        name="petPhoto"
                                        accept="image/*"
                                    >

                                </label>

                            </div>



                            <!-- BASIC FIELDS -->

                            <div class="hp-basic-fields">


                                <!-- PET NAME -->

                                <div class="hp-form-group hp-full-width">

                                    <label for="petName">
                                        Pet Name
                                    </label>

                                    <input
                                        type="text"
                                        id="petName"
                                        name="petName"
                                        placeholder="e.g. Bella"
                                        required
                                    >

                                </div>



                                <!-- PET TYPE -->

                                <div class="hp-form-group hp-full-width">

                                    <label>
                                        Pet Type
                                    </label>


                                    <div class="hp-pet-types">


                                        <!-- DOG -->

                                        <button
                                            type="button"
                                            class="hp-pet-type hp-pet-type-selected"
                                            data-type="Dog"
                                        >

                                            <i class="fa-solid fa-dog"></i>

                                            <span>
                                                Dog
                                            </span>

                                        </button>



                                        <!-- CAT -->

                                        <button
                                            type="button"
                                            class="hp-pet-type"
                                            data-type="Cat"
                                        >

                                            <i class="fa-solid fa-cat"></i>

                                            <span>
                                                Cat
                                            </span>

                                        </button>

                                    </div>


                                    <input
                                        type="hidden"
                                        id="petType"
                                        name="petType"
                                        value="Dog"
                                    >

                                </div>



                                <!-- BREED + GENDER -->

                                <div class="hp-two-columns">


                                    <!-- BREED -->

                                    <div class="hp-form-group">

                                        <label for="breed">
                                            Breed
                                        </label>


                                        <select
                                            id="breed"
                                            name="breed"
                                            required
                                        >

                                            <option value="">
                                                Select breed
                                            </option>

                                        </select>

                                    </div>



                                    <!-- GENDER -->

                                    <div class="hp-form-group">

                                        <label>
                                            Gender
                                        </label>


                                        <div class="hp-gender">


                                            <button
                                                type="button"
                                                class="hp-gender-button hp-gender-selected"
                                                data-gender="Male"
                                            >
                                                Male
                                            </button>


                                            <button
                                                type="button"
                                                class="hp-gender-button"
                                                data-gender="Female"
                                            >
                                                Female
                                            </button>

                                        </div>


                                        <input
                                            type="hidden"
                                            id="gender"
                                            name="gender"
                                            value="Male"
                                        >

                                    </div>

                                </div>



                                <!-- DATE + WEIGHT -->

                                <div class="hp-two-columns">


                                    <!-- DATE OF BIRTH -->

                                    <div class="hp-form-group">

                                        <label for="dateOfBirth">
                                            Date of Birth
                                        </label>

                                        <input
                                            type="date"
                                            id="dateOfBirth"
                                            name="dateOfBirth"
                                        >

                                    </div>



                                    <!-- WEIGHT -->

                                    <div class="hp-form-group">

                                        <label for="weight">
                                            Weight
                                        </label>


                                        <div class="hp-weight">

                                            <input
                                                type="number"
                                                id="weight"
                                                name="weight"
                                                placeholder="0.0"
                                                min="0"
                                                step="0.1"
                                            >

                                            <span>
                                                kg
                                            </span>

                                        </div>

                                    </div>

                                </div>



                                <!-- COLOR + MICROCHIP -->

                                <div class="hp-two-columns">


                                    <!-- COLOR -->

                                    <div class="hp-form-group">

                                        <label for="color">

                                            Color

                                            <span>
                                                (Optional)
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="color"
                                            name="color"
                                            placeholder="e.g. Golden, Black & White"
                                        >

                                    </div>



                                    <!-- MICROCHIP -->

                                    <div class="hp-form-group">

                                        <label for="microchipNumber">

                                            Microchip Number

                                            <span>
                                                (Optional)
                                            </span>

                                        </label>

                                        <input
                                            type="text"
                                            id="microchipNumber"
                                            name="microchipNumber"
                                            placeholder="Enter microchip number"
                                        >

                                    </div>

                                </div>


                            </div>

                        </div>



                        <!-- STEP 1 FOOTER -->

                        <div class="hp-basic-footer">

                            <div></div>


                            <button
                                type="button"
                                id="nextButton"
                                class="hp-next-button"
                            >

                                <span>
                                    Next
                                </span>

                                <i class="fa-solid fa-arrow-right"></i>

                            </button>

                        </div>

                    </div>

                </section>



                <!-- =================================================
                     STEP 2
                ================================================== -->

                <section
                    id="petStep2"
                    class="hp-step-content hp-step-hidden"
                >


                    <div class="hp-medical-layout">


                        <!-- MEDICAL CARD -->

                        <div class="hp-medical-card">


                            <!-- HEADER -->

                            <div class="hp-medical-header">

                                <div class="hp-medical-title">

                                    <i class="fa-solid fa-notes-medical"></i>

                                    <h2>
                                        Medical Information
                                    </h2>

                                </div>


                                <p>
                                    Help us understand a few important details
                                    about your pet. You can always update this
                                    information later.
                                </p>

                            </div>



                            <!-- BODY -->

                            <div class="hp-medical-body">


                                <!-- ALLERGIES ONLY -->

                                <div class="hp-medical-group">

                                    <label for="allergies">

                                        Known Allergies

                                        <span>
                                            (Optional)
                                        </span>

                                    </label>


                                    <textarea
                                        id="allergies"
                                        name="allergies"
                                        placeholder="List any known food or medication allergies..."
                                    ></textarea>

                                </div>

                            </div>



                            <!-- FOOTER -->

                            <div class="hp-medical-footer">


                                <!-- PREVIOUS -->

                                <button
                                    type="button"
                                    id="previousButton"
                                    class="hp-previous-button"
                                >

                                    <i class="fa-solid fa-arrow-left"></i>

                                    <span>
                                        Previous
                                    </span>

                                </button>



                                <!-- REGISTER -->

                                <button
                                    type="submit"
                                    class="hp-register-button"
                                >

                                    <i class="fa-solid fa-paw"></i>

                                    <span>
                                        Register Pet
                                    </span>

                                </button>

                            </div>


                        </div>



                        <!-- =================================================
                             RIGHT SIDE
                        ================================================== -->

                        <div class="hp-medical-right">


                            <!-- OWNER CARD -->

                            <div class="hp-owner-card">


                                <div class="hp-owner-header">


                                    <div class="hp-owner-icon">

                                        <i class="fa-regular fa-user"></i>

                                    </div>


                                    <div>

                                        <h3>

                                            <?php

                                            echo htmlspecialchars(
                                                ($data['user']->first_name ?? '')
                                                . ' ' .
                                                ($data['user']->last_name ?? '')
                                            );

                                            ?>

                                        </h3>


                                        <span>
                                            Registered Pet Owner
                                        </span>

                                    </div>

                                </div>



                                <!-- USER EMAIL + PHONE -->

                                <div class="hp-owner-details">


                                    <div>

                                        <i class="fa-regular fa-envelope"></i>

                                        <span>

                                            <?php

                                            echo htmlspecialchars(
                                                $data['user']->email ?? ''
                                            );

                                            ?>

                                        </span>

                                    </div>


                                    <div>

                                        <i class="fa-solid fa-phone"></i>

                                        <span>

                                            <?php

                                            echo htmlspecialchars(
                                                $data['user']->phone_number ?? ''
                                            );

                                            ?>

                                        </span>

                                    </div>

                                </div>



                                <div class="hp-owner-security">

                                    <i class="fa-solid fa-lock"></i>

                                    <span>
                                        Owner information is automatically
                                        linked securely to this pet profile.
                                    </span>

                                </div>


                            </div>


                        </div>

                    </div>

                </section>


            </form>


        </div>

    </main>

</div>



<!-- =====================================================
     SUCCESS POPUP
====================================================== -->

<?php if (!empty($data['petSuccess'])): ?>

    <div
        class="hp-modal-overlay"
        id="successModal"
    >

        <div class="hp-success-modal">


            <div class="hp-success-icon">

                <i class="fa-solid fa-check"></i>

            </div>


            <h2>
                Pet Registered Successfully!
            </h2>


            <p>

                <strong>
                    <?php echo htmlspecialchars($data['registeredPetName']); ?>
                </strong>

                has been successfully added to your pets.

            </p>


            <div class="hp-success-pet-id">

                <span>
                    PET ID
                </span>

                <strong>

                    HP-<?php echo str_pad(
                        $data['registeredPetId'],
                        5,
                        '0',
                        STR_PAD_LEFT
                    ); ?>

                </strong>

            </div>


            <div class="hp-success-actions">


                <!-- GO TO MY PETS -->

                <a
                    href="<?php echo URLROOT; ?>/petowner/pets"
                    class="hp-my-pets-button"
                >
                    Go to My Pets
                </a>


                <!-- STAY -->

                <button
                    type="button"
                    class="hp-stay-button"
                    id="stayOnPageButton"
                >
                    Register Another
                </button>


            </div>

        </div>

    </div>

<?php endif; ?>



<!-- =====================================================
     JAVASCRIPT
====================================================== -->

<script src="<?php echo URLROOT; ?>/js/register-pet.js" defer></script>
<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>


</body>

</html>