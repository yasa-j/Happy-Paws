/* =========================================================
   HAPPY PAWS
   REGISTER PET
   ONE FORM - TWO STEPS
   ========================================================= */


document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const form = document.getElementById("registerPetForm");

    const step1 = document.getElementById("petStep1");
    const step2 = document.getElementById("petStep2");

    const stepIndicator1 =
        document.getElementById("stepIndicator1");

    const stepIndicator2 =
        document.getElementById("stepIndicator2");

    const nextButton =
        document.getElementById("nextButton");

    const previousButton =
        document.getElementById("previousButton");


    /* =====================================================
       PET TYPE
    ===================================================== */

    const petTypeButtons =
        document.querySelectorAll(".hp-pet-type");

    const petTypeInput =
        document.getElementById("petType");


    petTypeButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            petTypeButtons.forEach(function (item) {

                item.classList.remove(
                    "hp-pet-type-selected"
                );

            });


            this.classList.add(
                "hp-pet-type-selected"
            );


            petTypeInput.value =
                this.dataset.type;


            /*
             * Change breed options according to
             * Dog or Cat.
             */

            updateBreedOptions(
                this.dataset.type
            );

        });

    });


    /* =====================================================
       GENDER
    ===================================================== */

    const genderButtons =
        document.querySelectorAll(".hp-gender-button");

    const genderInput =
        document.getElementById("gender");


    genderButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            genderButtons.forEach(function (item) {

                item.classList.remove(
                    "hp-gender-selected"
                );

            });


            this.classList.add(
                "hp-gender-selected"
            );


            genderInput.value =
                this.dataset.gender;

        });

    });


    /* =====================================================
       NEUTERED / SPAYED
    ===================================================== */

    const yesNoButtons =
        document.querySelectorAll(".hp-yes-no-button");

    const neuteredInput =
        document.getElementById("neutered");


    yesNoButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            yesNoButtons.forEach(function (item) {

                item.classList.remove(
                    "hp-yes-no-selected"
                );

            });


            this.classList.add(
                "hp-yes-no-selected"
            );


            neuteredInput.value =
                this.dataset.value;

        });

    });


    /* =====================================================
       PHOTO PREVIEW
    ===================================================== */

    const photoInput =
        document.getElementById("petPhoto");

    const photoUploadBox =
        document.getElementById("photoUploadBox");


    photoInput.addEventListener("change", function () {

        const file = this.files[0];


        if (!file) {
            return;
        }


        const reader = new FileReader();


        reader.onload = function (event) {

            photoUploadBox.style.backgroundImage =
                "url('" + event.target.result + "')";


            photoUploadBox.style.border =
                "2px solid #007b73";


            const icon =
                photoUploadBox.querySelector("i");

            const text =
                photoUploadBox.querySelector("span");


            if (icon) {
                icon.style.display = "none";
            }


            if (text) {
                text.style.display = "none";
            }

        };


        reader.readAsDataURL(file);

    });


    /* =====================================================
       NEXT BUTTON
       STEP 1 → STEP 2
    ===================================================== */

    nextButton.addEventListener("click", function () {


        if (!validateStep1()) {
            return;
        }


        /* Hide Step 1 */

        step1.classList.add(
            "hp-step-hidden"
        );


        /* Show Step 2 */

        step2.classList.remove(
            "hp-step-hidden"
        );


        /* Update step indicator */

        stepIndicator1.classList.remove(
            "hp-step-active"
        );


        stepIndicator2.classList.add(
            "hp-step-active"
        );


        /* Change Step 1 circle */

        const firstCircle =
            stepIndicator1.querySelector(
                ".hp-step-circle"
            );


        firstCircle.innerHTML =
            '<i class="fa-solid fa-check"></i>';


        firstCircle.style.background =
            "#22c55e";


        /* Change Step 2 circle */

        const secondCircle =
            stepIndicator2.querySelector(
                ".hp-step-circle"
            );


        secondCircle.classList.remove(
            "hp-step-inactive-circle"
        );


        /* Scroll to top */

        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });

    });


    /* =====================================================
       PREVIOUS BUTTON
       STEP 2 → STEP 1
    ===================================================== */

    previousButton.addEventListener(
        "click",
        function () {


            /* Hide Step 2 */

            step2.classList.add(
                "hp-step-hidden"
            );


            /* Show Step 1 */

            step1.classList.remove(
                "hp-step-hidden"
            );


            /* Update indicator */

            stepIndicator2.classList.remove(
                "hp-step-active"
            );


            stepIndicator1.classList.add(
                "hp-step-active"
            );


            /* Restore Step 1 number */

            const firstCircle =
                stepIndicator1.querySelector(
                    ".hp-step-circle"
                );


            firstCircle.innerHTML = "1";


            firstCircle.style.background =
                "";


            /* Restore Step 2 circle */

            const secondCircle =
                stepIndicator2.querySelector(
                    ".hp-step-circle"
                );


            secondCircle.classList.add(
                "hp-step-inactive-circle"
            );


            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });

        }
    );


    /* =====================================================
       FINAL FORM SUBMISSION
    ===================================================== */

    form.addEventListener(
        "submit",
        function (event) {

            /*
             * Prevent actual PHP/database submission.
             */

            event.preventDefault();


            if (!validateStep2()) {
                return;
            }


            /*
             * Collect all form information.
             * This is only for demonstration.
             */

            const petInformation = {

                name:
                    document.getElementById(
                        "petName"
                    ).value,

                type:
                    document.getElementById(
                        "petType"
                    ).value,

                breed:
                    document.getElementById(
                        "breed"
                    ).value,

                gender:
                    document.getElementById(
                        "gender"
                    ).value,

                dateOfBirth:
                    document.getElementById(
                        "dateOfBirth"
                    ).value,

                weight:
                    document.getElementById(
                        "weight"
                    ).value,

                neutered:
                    document.getElementById(
                        "neutered"
                    ).value,

                allergies:
                    document.getElementById(
                        "allergies"
                    ).value,

                emergencyName:
                    document.getElementById(
                        "contactName"
                    ).value,

                emergencyNumber:
                    document.getElementById(
                        "contactNumber"
                    ).value

            };


            console.log(
                "Happy Paws - Registered Pet:",
                petInformation
            );


            /*
             * Demo success message.
             */

            alert(
                "Pet registered successfully!\n\n" +
                "Pet ID: HP-000125"
            );

        }
    );

});


/* =========================================================
   VALIDATE STEP 1
   ========================================================= */

function validateStep1()
{

    const petName =
        document.getElementById(
            "petName"
        ).value.trim();


    const breed =
        document.getElementById(
            "breed"
        ).value;


    const dateOfBirth =
        document.getElementById(
            "dateOfBirth"
        ).value;


    const weight =
        document.getElementById(
            "weight"
        ).value;


    if (petName === "") {

        alert(
            "Please enter your pet's name."
        );

        document.getElementById(
            "petName"
        ).focus();

        return false;
    }


    if (breed === "") {

        alert(
            "Please select a breed."
        );

        document.getElementById(
            "breed"
        ).focus();

        return false;
    }


    if (dateOfBirth === "") {

        alert(
            "Please select your pet's date of birth."
        );

        document.getElementById(
            "dateOfBirth"
        ).focus();

        return false;
    }


    if (weight === "") {

        alert(
            "Please enter your pet's weight."
        );

        document.getElementById(
            "weight"
        ).focus();

        return false;
    }


    return true;
}


/* =========================================================
   VALIDATE STEP 2
   ========================================================= */

function validateStep2()
{

    const contactName =
        document.getElementById(
            "contactName"
        ).value.trim();


    const contactNumber =
        document.getElementById(
            "contactNumber"
        ).value.trim();


    if (contactName === "") {

        alert(
            "Please enter an emergency contact name."
        );

        document.getElementById(
            "contactName"
        ).focus();

        return false;
    }


    if (contactNumber === "") {

        alert(
            "Please enter an emergency contact number."
        );

        document.getElementById(
            "contactNumber"
        ).focus();

        return false;
    }


    return true;
}


/* =========================================================
   BREED OPTIONS
   ========================================================= */

function updateBreedOptions(type)
{

    const breed =
        document.getElementById("breed");


    breed.innerHTML = "";


    const defaultOption =
        document.createElement("option");


    defaultOption.value = "";

    defaultOption.textContent =
        "Select breed";


    breed.appendChild(
        defaultOption
    );


    let breeds = [];


    if (type === "Dog") {

        breeds = [

            "Labrador Retriever",
            "Golden Retriever",
            "German Shepherd",
            "Poodle",
            "Beagle",
            "Bulldog",
            "Rottweiler",
            "Other"

        ];

    } else {

        breeds = [

            "Persian",
            "Siamese",
            "Maine Coon",
            "British Shorthair",
            "Ragdoll",
            "Bengal",
            "Other"

        ];

    }


    breeds.forEach(function (breedName) {

        const option =
            document.createElement("option");


        option.value =
            breedName;


        option.textContent =
            breedName;


        breed.appendChild(
            option
        );

    });

}