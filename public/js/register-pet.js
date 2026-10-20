

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


