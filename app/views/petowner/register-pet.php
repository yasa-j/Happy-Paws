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


    <style>

        /* =====================================================
           SUCCESS / ERROR MODAL
        ====================================================== */

        .hp-modal-overlay {

            position: fixed;

            inset: 0;

            background: rgba(20, 30, 45, 0.45);

            display: flex;

            align-items: center;

            justify-content: center;

            z-index: 99999;

            padding: 20px;
        }


        .hp-success-modal {

            width: 420px;

            max-width: 100%;

            background: #ffffff;

            border-radius: 20px;

            padding: 35px;

            text-align: center;

            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.18);

            animation: hpModalShow 0.25s ease;
        }


        @keyframes hpModalShow {

            from {

                opacity: 0;

                transform: translateY(15px) scale(0.97);

            }

            to {

                opacity: 1;

                transform: translateY(0) scale(1);

            }

        }


        .hp-success-icon {

            width: 72px;

            height: 72px;

            border-radius: 50%;

            background: #e6f7f3;

            color: #00796f;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto 20px;
        }


        .hp-success-icon i {

            font-size: 34px;
        }


        .hp-success-modal h2 {

            margin: 0 0 10px;

            color: #202d42;

            font-size: 26px;
        }


        .hp-success-modal p {

            margin: 0 0 25px;

            color: #718096;

            line-height: 1.6;
        }


        .hp-success-pet-id {

            background: #f5f8fa;

            border: 1px solid #e1e8ed;

            border-radius: 12px;

            padding: 14px;

            margin-bottom: 25px;
        }


        .hp-success-pet-id span {

            display: block;

            font-size: 12px;

            color: #7b8794;

            margin-bottom: 5px;

            letter-spacing: 1px;
        }


        .hp-success-pet-id strong {

            color: #203047;

            font-size: 20px;

            letter-spacing: 2px;
        }


        .hp-success-actions {

            display: flex;

            gap: 12px;

            justify-content: center;
        }


        .hp-success-actions a,
        .hp-success-actions button {

            border: none;

            border-radius: 10px;

            padding: 13px 20px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            text-decoration: none;
        }


        .hp-my-pets-button {

            background: #00796f;

            color: white;
        }


        .hp-stay-button {

            background: #eef2f4;

            color: #344054;
        }


        /* ERROR */

        .hp-error-message {

            background: #fff1f1;

            border: 1px solid #f2b8b8;

            color: #b42318;

            border-radius: 10px;

            padding: 14px 18px;

            margin-bottom: 20px;

            line-height: 1.5;
        }

    </style>

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

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       ELEMENTS
    ====================================================== */

    const form =
        document.getElementById('registerPetForm');

    const step1 =
        document.getElementById('petStep1');

    const step2 =
        document.getElementById('petStep2');

    const nextButton =
        document.getElementById('nextButton');

    const previousButton =
        document.getElementById('previousButton');

    const stepIndicator1 =
        document.getElementById('stepIndicator1');

    const stepIndicator2 =
        document.getElementById('stepIndicator2');

    const petTypeInput =
        document.getElementById('petType');

    const breedSelect =
        document.getElementById('breed');

    const genderInput =
        document.getElementById('gender');


    /* =====================================================
       BREED DATA
    ====================================================== */

    const dogBreeds = [

        'Labrador Retriever',
        'Golden Retriever',
        'German Shepherd',
        'Poodle',
        'Beagle',
        'Bulldog',
        'Rottweiler',
        'Dachshund',
        'German Shorthaired Pointer',
        'Other'

    ];


    const catBreeds = [

        'Persian',
        'Siamese',
        'British Shorthair',
        'Maine Coon',
        'Bengal',
        'Ragdoll',
        'Scottish Fold',
        'Sphynx',
        'American Shorthair',
        'Other'

    ];


    /* =====================================================
       UPDATE BREED DROPDOWN
    ====================================================== */

    function updateBreedDropdown(type) {


        // Clear current options

        breedSelect.innerHTML = '';


        // Default option

        const defaultOption =
            document.createElement('option');

        defaultOption.value = '';

        defaultOption.textContent =
            'Select breed';

        breedSelect.appendChild(defaultOption);


        // Select correct breed list

        let breeds = [];


        if (type === 'Dog') {

            breeds = dogBreeds;

        } else if (type === 'Cat') {

            breeds = catBreeds;

        }


        // Add breeds

        breeds.forEach(function (breed) {

            const option =
                document.createElement('option');

            option.value = breed;

            option.textContent = breed;

            breedSelect.appendChild(option);

        });

    }


    // Load Dog breeds initially

    updateBreedDropdown('Dog');



    /* =====================================================
       PET TYPE BUTTONS
    ====================================================== */

    const petTypeButtons =
        document.querySelectorAll('.hp-pet-type');


    petTypeButtons.forEach(function (button) {


        button.addEventListener('click', function () {


            // Remove selected state

            petTypeButtons.forEach(function (item) {

                item.classList.remove(
                    'hp-pet-type-selected'
                );

            });


            // Select clicked button

            button.classList.add(
                'hp-pet-type-selected'
            );


            // Get type

            const selectedType =
                button.dataset.type;


            // Update hidden field

            petTypeInput.value =
                selectedType;


            // Update breed dropdown

            updateBreedDropdown(
                selectedType
            );

        });

    });



    /* =====================================================
       GENDER BUTTONS
    ====================================================== */

    const genderButtons =
        document.querySelectorAll(
            '.hp-gender-button'
        );


    genderButtons.forEach(function (button) {


        button.addEventListener('click', function () {


            genderButtons.forEach(function (item) {

                item.classList.remove(
                    'hp-gender-selected'
                );

            });


            button.classList.add(
                'hp-gender-selected'
            );


            genderInput.value =
                button.dataset.gender;

        });

    });



    /* =====================================================
       NEXT BUTTON
    ====================================================== */

    nextButton.addEventListener(
        'click',
        function () {


            // Check browser validation

            if (!form.reportValidity()) {

                return;

            }


            // Hide step 1

            step1.classList.add(
                'hp-step-hidden'
            );


            // Show step 2

            step2.classList.remove(
                'hp-step-hidden'
            );


            // Update step 1

            stepIndicator1.classList.remove(
                'hp-step-active'
            );


            // Update step 2

            stepIndicator2.classList.add(
                'hp-step-active'
            );


            // Change step circle

            const circle2 =
                stepIndicator2.querySelector(
                    '.hp-step-circle'
                );


            circle2.classList.remove(
                'hp-step-inactive-circle'
            );

        }
    );



    /* =====================================================
       PREVIOUS BUTTON
    ====================================================== */

    previousButton.addEventListener(
        'click',
        function () {


            // Hide step 2

            step2.classList.add(
                'hp-step-hidden'
            );


            // Show step 1

            step1.classList.remove(
                'hp-step-hidden'
            );


            // Update indicators

            stepIndicator2.classList.remove(
                'hp-step-active'
            );


            stepIndicator1.classList.add(
                'hp-step-active'
            );


            // Restore inactive circle

            const circle2 =
                stepIndicator2.querySelector(
                    '.hp-step-circle'
                );


            circle2.classList.add(
                'hp-step-inactive-circle'
            );

        }
    );



    /* =====================================================
       PHOTO
       OPTIONAL - PREVIEW ONLY
    ====================================================== */

    const photoInput =
        document.getElementById('petPhoto');

    const photoBox =
        document.getElementById('photoUploadBox');


    photoInput.addEventListener(
        'change',
        function () {


            const file =
                this.files[0];


            if (!file) {

                return;

            }


            // Make sure it is an image

            if (!file.type.startsWith('image/')) {

                this.value = '';

                alert(
                    'Please select a valid image.'
                );

                return;

            }


            // Show local preview

            const reader =
                new FileReader();


            reader.onload =
                function (event) {


                    photoBox.style.backgroundImage =
                        'url("' +
                        event.target.result +
                        '")';


                    photoBox.style.backgroundSize =
                        'cover';


                    photoBox.style.backgroundPosition =
                        'center';


                    photoBox.querySelector(
                        'i'
                    ).style.display =
                        'none';


                    photoBox.querySelector(
                        'span'
                    ).style.display =
                        'none';

                };


            reader.readAsDataURL(file);

        }
    );



    /* =====================================================
       SUCCESS MODAL
    ====================================================== */

    const stayButton =
        document.getElementById(
            'stayOnPageButton'
        );


    if (stayButton) {


        stayButton.addEventListener(
            'click',
            function () {


                const modal =
                    document.getElementById(
                        'successModal'
                    );


                modal.style.display =
                    'none';


                // Reset form

                form.reset();


                // Restore defaults

                petTypeInput.value =
                    'Dog';

                genderInput.value =
                    'Male';


                // Restore Dog selection

                petTypeButtons.forEach(
                    function (button) {

                        button.classList.remove(
                            'hp-pet-type-selected'
                        );

                    }
                );


                petTypeButtons[0].classList.add(
                    'hp-pet-type-selected'
                );


                // Restore Male selection

                genderButtons.forEach(
                    function (button) {

                        button.classList.remove(
                            'hp-gender-selected'
                        );

                    }
                );


                genderButtons[0].classList.add(
                    'hp-gender-selected'
                );


                // Restore Dog breeds

                updateBreedDropdown('Dog');


                // Go back to Step 1

                step2.classList.add(
                    'hp-step-hidden'
                );

                step1.classList.remove(
                    'hp-step-hidden'
                );


                stepIndicator2.classList.remove(
                    'hp-step-active'
                );

                stepIndicator1.classList.add(
                    'hp-step-active'
                );


                const circle2 =
                    stepIndicator2.querySelector(
                        '.hp-step-circle'
                    );


                circle2.classList.add(
                    'hp-step-inactive-circle'
                );

            }
        );

    }

});

</script>


</body>

</html>