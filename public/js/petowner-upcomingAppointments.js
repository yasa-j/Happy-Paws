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

            const appointmentData =
                this.getAttribute("data-appointment-details");


            if (!appointmentData) {
                return;
            }


            const appointment =
                JSON.parse(appointmentData);


            openAppointmentDetails(appointment);

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

/* =========================================================
   APPOINTMENT DETAILS
   ========================================================= */

function openAppointmentDetails(appointment)
{

    const modal =
        document.getElementById(
            "appointmentDetailsModal"
        );


    if (!modal) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Fill appointment information
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        "detailsTitle"
    ).textContent =
        appointment.title || "Appointment";


    document.getElementById(
        "detailsReference"
    ).textContent =
        "Ref: " + (appointment.id || "");


    document.getElementById(
        "detailsDate"
    ).textContent =
        appointment.date +
        " " +
        appointment.month +
        " " +
        appointment.year;


    document.getElementById(
        "detailsTime"
    ).textContent =
        appointment.time +
        " - " +
        appointment.end_time;


    document.getElementById(
        "detailsPet"
    ).textContent =
        appointment.pet_name || "-";


    document.getElementById(
        "detailsPetType"
    ).textContent =
        appointment.pet_type || "-";


    document.getElementById(
        "detailsVet"
    ).textContent =
        appointment.vet || "-";


    document.getElementById(
        "detailsLocation"
    ).textContent =
        appointment.location || "-";


    document.getElementById(
        "detailsRoom"
    ).textContent =
        appointment.room || "-";


    document.getElementById(
        "detailsDuration"
    ).textContent =
        appointment.duration || "-";


    document.getElementById(
        "detailsDescription"
    ).textContent =
        appointment.description || "-";


    /*
    |--------------------------------------------------------------------------
    | Save appointment ID for Cancel
    |--------------------------------------------------------------------------
    */

    document.getElementById(
        "detailsCancelAppointmentId"
    ).value =
        appointment.appointment_id;


    /*
    |--------------------------------------------------------------------------
    | Reschedule button
    |--------------------------------------------------------------------------
    */

    const rescheduleButton =
        document.getElementById(
            "detailsRescheduleBtn"
        );


    rescheduleButton.onclick = function () {

        closeAppointmentDetails();


        openRescheduleModal(
            appointment.appointment_id,
            appointment.appointment_date,
            appointment.appointment_time,
            appointment.vet_id,
            appointment.vet
        );

    };


    /*
    |--------------------------------------------------------------------------
    | Show modal
    |--------------------------------------------------------------------------
    */

    modal.style.display = "flex";

}


/* =========================================================
   CLOSE APPOINTMENT DETAILS
   ========================================================= */

function closeAppointmentDetails()
{

    const modal =
        document.getElementById(
            "appointmentDetailsModal"
        );


    if (modal) {

        modal.style.display = "none";

    }

}

document.addEventListener("DOMContentLoaded", function () {

    const detailsCancelForm =
        document.getElementById(
            "detailsCancelForm"
        );


    if (detailsCancelForm) {

        detailsCancelForm.addEventListener(
            "submit",
            function (event) {

                const confirmed =
                    confirm(
                        "Are you sure you want to cancel this appointment?"
                    );


                if (!confirmed) {

                    event.preventDefault();

                }

            }
        );

    }

});

function closeAppointmentDetails() {

    const modal = document.getElementById("appointmentDetailsModal");

    if (modal) {
        modal.style.setProperty("display", "none", "important");
    }

}