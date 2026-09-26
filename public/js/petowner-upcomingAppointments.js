/* =========================================================
   HAPPY PAWS
   UPCOMING APPOINTMENTS JAVASCRIPT
   ========================================================= */


/* ---------------------------------------------------------
   PAGE LOAD
   --------------------------------------------------------- */



document.addEventListener("DOMContentLoaded", function () {

    setupAppointmentSearch();

    setupCopyReference();

    setupAppointmentButtons();

    setupFilterButtons();

    setupSuccessPopup();

});


/* ---------------------------------------------------------
   SEARCH APPOINTMENTS
   --------------------------------------------------------- */

function setupAppointmentSearch() {

    const searchInput =
        document.getElementById("appointmentSearch");

    const appointmentCards =
        document.querySelectorAll(".appointment-list-card");

    const noResults =
        document.getElementById("noAppointmentsMessage");


    if (!searchInput) {
        return;
    }


    searchInput.addEventListener("input", function () {

        const searchValue =
            this.value.toLowerCase().trim();

        let visibleAppointments = 0;


        appointmentCards.forEach(function (card) {

            const cardText =
                card.textContent.toLowerCase();


            if (cardText.includes(searchValue)) {

                card.style.display = "grid";

                visibleAppointments++;

            } else {

                card.style.display = "none";

            }

        });


        if (noResults) {

            if (visibleAppointments === 0) {

                noResults.style.display = "block";

            } else {

                noResults.style.display = "none";

            }

        }

    });

}


/* ---------------------------------------------------------
   COPY APPOINTMENT REFERENCE
   --------------------------------------------------------- */

function setupCopyReference() {

    const copyButtons =
        document.querySelectorAll(".copy-reference");


    copyButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const reference =
                this.getAttribute("data-reference");


            if (
                navigator.clipboard &&
                reference
            ) {

                navigator.clipboard.writeText(reference)
                    .then(function () {

                        button.textContent = "✓";

                        setTimeout(function () {

                            button.textContent = "□";

                        }, 1500);

                    });

            }

        });

    });

}


/* ---------------------------------------------------------
   APPOINTMENT BUTTONS
   --------------------------------------------------------- */

function setupAppointmentButtons() {

    const viewButtons =
        document.querySelectorAll(
            ".view-pass-button, .view-details-button"
        );


    viewButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const appointmentId =
                this.getAttribute("data-appointment");


            alert(
                "Appointment details for " +
                appointmentId +
                "\n\nThis will open the Appointment Pass/Details page once that page is connected."
            );

        });

    });


    /*
    |--------------------------------------------------------------------------
    | IMPORTANT
    |--------------------------------------------------------------------------
    |
    | Reschedule buttons are NOT handled here anymore.
    |
    | They use:
    |
    | openRescheduleModal(...)
    |
    | directly from upcomingAppointments.php.
    |
    */


    


    cancelButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            const appointmentId =
                this.getAttribute("data-appointment");


            const confirmCancel =
                confirm(
                    "Are you sure you want to cancel appointment " +
                    appointmentId +
                    "?"
                );


            if (confirmCancel) {

                alert(
                    "Appointment " +
                    appointmentId +
                    " would be cancelled here once database functionality is connected."
                );

            }

        });

    });

}


/* ---------------------------------------------------------
   FILTER BUTTONS
   --------------------------------------------------------- */

function setupFilterButtons() {

    const petFilterButton =
        document.getElementById("petFilterButton");


    if (petFilterButton) {

        petFilterButton.addEventListener(
            "click",
            function () {

                alert(
                    "Pet filter will be connected when appointment data is loaded from the database."
                );

            }
        );

    }


    const sortButton =
        document.getElementById("sortButton");


    if (sortButton) {

        sortButton.addEventListener(
            "click",
            function () {

                alert(
                    "Sorting options will be connected later."
                );

            }
        );

    }

}


/* ---------------------------------------------------------
   SUCCESS POPUP
   --------------------------------------------------------- */

function setupSuccessPopup() {

    const popup =
        document.getElementById("successPopup");


    const closeButton =
        document.getElementById("successPopupClose");


    /*
    |--------------------------------------------------------------------------
    | Stop if there is no success popup
    |--------------------------------------------------------------------------
    */

    if (!popup) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Close button
    |--------------------------------------------------------------------------
    */

    if (closeButton) {

        closeButton.addEventListener(
            "click",
            function () {

                popup.style.display = "none";

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Automatically close after 3 seconds
    |--------------------------------------------------------------------------
    */

    setTimeout(function () {

        if (popup) {

            popup.style.display = "none";

        }

    }, 3000);

}

/* ---------------------------------------------------------
   CANCEL APPOINTMENT CONFIRMATION
   --------------------------------------------------------- */

function confirmCancelAppointment() {

    return confirm(
        "Are you sure you want to cancel this appointment?\n\n" +
        "This appointment slot will become available again."
    );

}

