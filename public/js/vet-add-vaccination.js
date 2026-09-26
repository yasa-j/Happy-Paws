document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Add Vaccination loaded.");


    // =========================================================
    // GET ELEMENTS
    // =========================================================

    const form =
        document.getElementById("vaccination-form");

    const vaccineName =
        document.getElementById("vaccine_name");

    const vaccinationType =
        document.getElementById("vaccination_type");

    const status =
        document.getElementById("status");

    const dateGiven =
        document.getElementById("date_given");

    const nextDueDate =
        document.getElementById("next_due_date");

    const defaultNextYear =
        document.getElementById("default-next-year");

    const notes =
        document.getElementById("notes");

    const notesCounter =
        document.getElementById("notes-counter");


    // =========================================================
    // DATE GIVEN - DEFAULT TO TODAY
    // =========================================================

    if (dateGiven && !dateGiven.value) {

        const today =
            new Date();

        const year =
            today.getFullYear();

        const month =
            String(
                today.getMonth() + 1
            ).padStart(2, "0");

        const day =
            String(
                today.getDate()
            ).padStart(2, "0");

        dateGiven.value =
            `${year}-${month}-${day}`;

        setNextDueDate();

    }


    // =========================================================
    // WHEN DATE GIVEN CHANGES
    // =========================================================

    if (dateGiven) {

        dateGiven.addEventListener(
            "change",
            function () {

                setNextDueDate();

            }
        );

    }


    // =========================================================
    // +1 YEAR DEFAULT BUTTON
    // =========================================================

    if (defaultNextYear) {

        defaultNextYear.addEventListener(
            "click",
            function () {

                setNextDueDate();

            }
        );

    }


    // =========================================================
    // CALCULATE NEXT DUE DATE
    // =========================================================

    function setNextDueDate() {

        if (
            !dateGiven ||
            !nextDueDate ||
            !dateGiven.value
        ) {
            return;
        }


        const selectedDate =
            new Date(
                dateGiven.value + "T00:00:00"
            );


        selectedDate.setFullYear(
            selectedDate.getFullYear() + 1
        );


        const year =
            selectedDate.getFullYear();

        const month =
            String(
                selectedDate.getMonth() + 1
            ).padStart(2, "0");

        const day =
            String(
                selectedDate.getDate()
            ).padStart(2, "0");


        nextDueDate.value =
            `${year}-${month}-${day}`;

    }


    // =========================================================
    // NOTES COUNTER
    // =========================================================

    if (notes && notesCounter) {

        notes.addEventListener(
            "input",
            function () {

                notesCounter.textContent =
                    `${this.value.length}/500`;

            }
        );

    }


    // =========================================================
    // FORM SUBMISSION
    // =========================================================

    if (form) {

        form.addEventListener(
            "submit",
            function (event) {

                let valid = true;


                clearErrors();


                // Vaccine

                if (
                    !vaccineName ||
                    !vaccineName.value
                ) {

                    showError(
                        vaccineName,
                        "Please select a vaccine."
                    );

                    valid = false;

                }


                // Date Given

                if (
                    !dateGiven ||
                    !dateGiven.value
                ) {

                    showError(
                        dateGiven,
                        "Please select the date given."
                    );

                    valid = false;

                }


                // Vaccination Type

                if (
                    !vaccinationType ||
                    !vaccinationType.value
                ) {

                    showError(
                        vaccinationType,
                        "Please select a vaccination type."
                    );

                    valid = false;

                }


                // Status

                if (
                    !status ||
                    !status.value
                ) {

                    showError(
                        status,
                        "Please select a status."
                    );

                    valid = false;

                }


                // Check dates

                if (
                    dateGiven &&
                    nextDueDate &&
                    dateGiven.value &&
                    nextDueDate.value
                ) {

                    const given =
                        new Date(
                            dateGiven.value
                        );

                    const next =
                        new Date(
                            nextDueDate.value
                        );


                    if (next < given) {

                        showError(
                            nextDueDate,
                            "Next due date cannot be before the date given."
                        );

                        valid = false;

                    }

                }


                // Stop submission if invalid

                if (!valid) {

                    event.preventDefault();

                    return;

                }


                console.log(
                    "Vaccination form submitted."
                );

            }
        );

    }


    // =========================================================
    // CLEAR ERRORS
    // =========================================================

    function clearErrors() {

        document
            .querySelectorAll(".form-group")
            .forEach(function (group) {

                group.classList.remove(
                    "input-error"
                );

            });


        document
            .querySelectorAll(".field-error")
            .forEach(function (error) {

                error.textContent = "";

            });

    }


    // =========================================================
    // SHOW ERROR
    // =========================================================

    function showError(
        input,
        message
    ) {

        if (!input) {
            return;
        }


        const group =
            input.closest(
                ".form-group"
            );


        if (!group) {
            return;
        }


        group.classList.add(
            "input-error"
        );


        const error =
            group.querySelector(
                ".field-error"
            );


        if (error) {

            error.textContent =
                message;

        }

    }

});