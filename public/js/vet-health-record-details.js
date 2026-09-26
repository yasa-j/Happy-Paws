document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Medical Record Details loaded.");


    /*
    |--------------------------------------------------------------------------
    | Edit Pet
    |--------------------------------------------------------------------------
    */

    const editButton =
        document.getElementById("edit-pet-button");


    if (editButton) {

        editButton.addEventListener(
            "click",
            function () {

                alert(
                    "Pet information editing will be available here."
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Add Vaccination Record
    |--------------------------------------------------------------------------
    */

    const addVaccineButton =
        document.getElementById(
            "add-vaccine-button"
        );


    if (addVaccineButton) {

        addVaccineButton.addEventListener(
            "click",
            function () {

                alert(
                    "Add vaccination record form will open here."
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Add Medication
    |--------------------------------------------------------------------------
    */

    const addMedicationButton =
        document.getElementById(
            "add-medication-button"
        );


    if (addMedicationButton) {

        addMedicationButton.addEventListener(
            "click",
            function () {

                alert(
                    "Add medication form will open here."
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | View All Treatments
    |--------------------------------------------------------------------------
    */

    const viewAllTreatments =
        document.getElementById(
            "view-all-treatments"
        );


    if (viewAllTreatments) {

        viewAllTreatments.addEventListener(
            "click",
            function () {

                const treatmentItems =
                    document.querySelectorAll(
                        ".treatment-item"
                    );


                treatmentItems.forEach(
                    function (item) {

                        item.classList.add(
                            "treatment-highlight"
                        );

                    }
                );


                setTimeout(
                    function () {

                        treatmentItems.forEach(
                            function (item) {

                                item.classList.remove(
                                    "treatment-highlight"
                                );

                            }
                        );

                    },
                    1200
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    */

    const searchInput =
        document.querySelector(
            ".vet-search input"
        );


    if (searchInput) {

        searchInput.addEventListener(
            "input",
            function () {

                const searchText =
                    this.value
                        .toLowerCase()
                        .trim();


                const pageText =
                    document
                        .querySelector(
                            ".medical-detail-content"
                        )
                        .textContent
                        .toLowerCase();


                if (
                    searchText !== "" &&
                    !pageText.includes(searchText)
                ) {

                    console.log(
                        "No matching information found."
                    );

                }

            }
        );

    }

});