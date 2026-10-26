/* =====================================================
   BOOK APPOINTMENT JAVASCRIPT
   One single form with three steps
   ===================================================== */


/* -----------------------------------------------------
   CURRENT STEP
   ----------------------------------------------------- */

let currentStep = 1;


/* -----------------------------------------------------
   STEP 1 → STEP 2
   ----------------------------------------------------- */

function goToStep2() {

    const pet = document.getElementById("petSelect").value;

    const service = document.querySelector(
        'input[name="service_id"]:checked'
    );

    if (pet === "") {

        alert("Please select a pet.");
        return;

    }

    if (!service) {

        alert("Please select a service.");
        return;

    }

    currentStep = 2;

    updateStep();

    document.getElementById("topBackBtn").style.display = "block";
}


/* -----------------------------------------------------
   STEP 2 → STEP 3
   ----------------------------------------------------- */

function goToStep3() {

    const veterinarian = document.querySelector(
        'input[name="vet_id"]:checked'
    );
    const appointmentTime = document.querySelector(
        'input[name="appointment_time"]:checked'
    );


    if (!veterinarian) {

        alert("Please select a veterinarian.");
        return;

    }


    if (!appointmentTime) {

        alert("Please select an appointment time.");
        return;

    }


    updateConfirmation();


    currentStep = 3;

    updateStep();

}


/* -----------------------------------------------------
   STEP 2 → STEP 1
   ----------------------------------------------------- */

function goToStep1() {

    currentStep = 1;

    updateStep();

    document.getElementById("topBackBtn").style.display = "none";

}


/* -----------------------------------------------------
   STEP 3 → STEP 2
   ----------------------------------------------------- */

function goToStep2FromStep3() {

    currentStep = 2;

    updateStep();

}


/* -----------------------------------------------------
   GENERAL STEP UPDATE
   ----------------------------------------------------- */

function updateStep() {

    /*
     * Hide all steps
     */

    document.querySelectorAll(".appointment-step").forEach(function(step) {

        step.classList.remove("active-step");

    });


    /*
     * Show selected step
     */

    document.getElementById(
        "appointmentStep" + currentStep
    ).classList.add("active-step");


    /*
     * Update step circles
     */

    for (let i = 1; i <= 3; i++) {

        const stepper = document.getElementById(
            "stepper" + i
        );

        stepper.classList.remove("active");
        stepper.classList.remove("completed");

    }


    /*
     * Current step
     */

    document.getElementById(
        "stepper" + currentStep
    ).classList.add("active");


    /*
     * Completed steps
     */

    for (let i = 1; i < currentStep; i++) {

        document.getElementById(
            "stepper" + i
        ).classList.add("completed");

    }


    /*
     * Step lines
     */

    document.getElementById("line1")
        .classList.remove("completed");

    document.getElementById("line2")
        .classList.remove("completed");


    if (currentStep >= 2) {

        document.getElementById("line1")
            .classList.add("completed");

    }


    if (currentStep >= 3) {

        document.getElementById("line2")
            .classList.add("completed");

    }


    /*
     * Change page title
     */

    const title = document.getElementById("pageTitle");

    const subtitle = document.getElementById("pageSubtitle");


    if (currentStep === 1) {

        title.textContent = "Book Appointment";

        subtitle.textContent =
            "Schedule a visit for your pet in just a few simple steps.";

    }


    if (currentStep === 2) {

        title.textContent = "Book Appointment";

        subtitle.textContent =
            "Choose your veterinarian and find an available appointment time.";

    }


    if (currentStep === 3) {

        title.textContent = "Confirm Appointment";

        subtitle.textContent =
            "Review your appointment details before you confirm your booking.";

    }


    /*
     * Back button
     */

    if (currentStep === 1) {

        document.getElementById("topBackBtn").style.display = "none";

    } else {

        document.getElementById("topBackBtn").style.display = "block";

    }


    /*
     * Scroll back to top
     */

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });

}


/* -----------------------------------------------------
   TOP BACK BUTTON
   ----------------------------------------------------- */

function goBackStep() {

    if (currentStep === 2) {

        goToStep1();

    } else if (currentStep === 3) {

        goToStep2FromStep3();

    }

}


/* -----------------------------------------------------
   UPDATE CONFIRMATION
   ----------------------------------------------------- */

function updateConfirmation() {

    /*
     * ==========================================
     * PET
     * ==========================================
     */

    const petSelect =
        document.getElementById("petSelect");


    const selectedPet =
        petSelect.options[
            petSelect.selectedIndex
        ].text;


    let petName = selectedPet;
    let breed = "";


    if (selectedPet.includes(" - ")) {

        const parts =
            selectedPet.split(" - ");

        petName = parts[0];
        breed = parts[1];

    }


    document.getElementById(
        "summaryPet"
    ).textContent = petName;


    document.getElementById(
        "summaryBreed"
    ).textContent = breed;


    /*
     * ==========================================
     * APPOINTMENT TYPE
     * ==========================================
     */

    const service =
        document.querySelector(
            'input[name="service_id"]:checked'
        );


    if (service) {

        document.getElementById(
            "summaryType"
        ).textContent =
            service.dataset.serviceName;

    }


    /*
     * ==========================================
     * REASON
     * ==========================================
     */

    const reason =
        document.getElementById(
            "reason"
        ).value;


    if (reason.trim() !== "") {

        document.getElementById(
            "summaryReason"
        ).textContent =
            reason;

    } else {

        document.getElementById(
            "summaryReason"
        ).textContent =
            "Routine health examination";

    }


    /*
     * ==========================================
     * VETERINARIAN
     * ==========================================
     *
     * The input is named vet_id,
     * not veterinarian.
     */

    const veterinarian =
        document.querySelector(
            'input[name="vet_id"]:checked'
        );


    if (veterinarian) {

        /*
         * Find the selected veterinarian card
         */

        const vetCard =
            veterinarian.closest(
                ".veterinarian-card"
            );


        /*
         * Get the veterinarian name
         * displayed inside the card.
         */

        const vetName =
            vetCard.querySelector(
                ".vet-info strong"
            ).textContent.trim();


        document.getElementById(
            "summaryVet"
        ).textContent =
            vetName;

    }


    /*
     * ==========================================
     * DATE
     * ==========================================
     */

    const appointmentDate =
        document.getElementById(
            "appointmentDate"
        );


    if (appointmentDate &&
        appointmentDate.value !== "") {

        const dateParts =
            appointmentDate.value.split("-");


        const year =
            parseInt(dateParts[0]);

        const month =
            parseInt(dateParts[1]) - 1;

        const day =
            parseInt(dateParts[2]);


        const selectedDate =
            new Date(
                year,
                month,
                day
            );


        const formattedDate =
            selectedDate.toLocaleDateString(
                "en-US",
                {
                    weekday: "long",
                    month: "short",
                    day: "numeric",
                    year: "numeric"
                }
            );


        document.getElementById(
            "summaryDate"
        ).textContent =
            formattedDate;

    }


    /*
     * ==========================================
     * TIME
     * ==========================================
     */

    const appointmentTime =
        document.querySelector(
            'input[name="appointment_time"]:checked'
        );


    if (appointmentTime) {

        document.getElementById(
            "summaryTime"
        ).textContent =
            appointmentTime.value +
            " (30 mins)";

    }

}


/* -----------------------------------------------------
   CANCEL
   ----------------------------------------------------- */

function cancelAppointment() {

    const confirmCancel =
        confirm(
            "Are you sure you want to cancel this appointment?"
        );


    if (confirmCancel) {

        window.location.href =
            URLROOT + "/petowner/dashboard";

    }

}


/* -----------------------------------------------------
   FORM SUBMIT
   ----------------------------------------------------- */

document.addEventListener("DOMContentLoaded", function() {

    const form =
        document.getElementById("appointmentForm");


    form.addEventListener("submit", function(event) {

        /*
         * Make sure the agreement checkbox is checked.
         */

        const agreement =
            document.getElementById(
                "appointmentAgreement"
            );


        if (!agreement.checked) {

            event.preventDefault();

            alert(
                "Please confirm that the appointment details are correct."
            );

            return;

        }


        /*
         * At this stage there is no database yet.
         *
         * We allow the form to submit to the controller.
         */

    });


    /*
     * Make appointment type cards selectable.
     */

    document.querySelectorAll(
        ".appointment-type-card"
    ).forEach(function(card) {

        card.addEventListener("click", function() {

            document.querySelectorAll(
                ".appointment-type-card"
            ).forEach(function(otherCard) {

                otherCard.classList.remove("selected");

            });


            card.classList.add("selected");

        });

    });


        /*
        * Veterinarian selection
        */

        document.querySelectorAll(
            ".veterinarian-card"
        ).forEach(function(card) {

            card.addEventListener("click", function() {

                document.querySelectorAll(
                    ".veterinarian-card"
                ).forEach(function(otherCard) {

                    otherCard.classList.remove("selected");

                });


                card.classList.add("selected");


                /*
                * If a date is already chosen, reload the time slots
                * for the newly selected veterinarian.
                */

                if (selectedAppointmentDate) {

                    const parts = selectedAppointmentDate.split("-");

                    const dateObject = new Date(
                        parts[0],
                        parts[1] - 1,
                        parts[2]
                    );

                    // Small delay so the radio button is checked
                    // before loadTimeSlots() reads it
                    setTimeout(function() {

                        loadTimeSlots(
                            dateObject,
                            selectedAppointmentDate
                        );

                    }, 0);

                }

            });

        });

});

/* =====================================================
   DYNAMIC APPOINTMENT CALENDAR
   ===================================================== */



let calendarDate = new Date();

let selectedAppointmentDate = null;


/* -----------------------------------------------------
   LOAD CALENDAR
   ----------------------------------------------------- */

function loadCalendar() {

    const calendarDays =
        document.getElementById("calendarDays");

    const calendarMonth =
        document.getElementById("calendarMonth");


    if (!calendarDays || !calendarMonth) {
        return;
    }


    /*
     * Clear the existing days
     */

    calendarDays.innerHTML = "";


    /*
     * Get current month and year
     */

    const year =
        calendarDate.getFullYear();

    const month =
        calendarDate.getMonth();


    /*
     * Month name
     */

    const monthName =
        calendarDate.toLocaleString(
            "default",
            {
                month: "long"
            }
        );


    calendarMonth.textContent =
        monthName + " " + year;


    /*
     * First day of the month
     */

    const firstDay =
        new Date(
            year,
            month,
            1
        ).getDay();


    /*
     * Number of days in month
     */

    const numberOfDays =
        new Date(
            year,
            month + 1,
            0
        ).getDate();


    /*
     * Today's date
     */

    const today =
        new Date();

    today.setHours(0, 0, 0, 0);


    /*
     * Empty spaces before day 1
     */

    for (
        let i = 0;
        i < firstDay;
        i++
    ) {

        const emptyDay =
            document.createElement("span");

        calendarDays.appendChild(emptyDay);

    }


    /*
     * Create each day
     */

    for (
        let day = 1;
        day <= numberOfDays;
        day++
    ) {

        const dayElement =
            document.createElement("span");


        dayElement.textContent = day;


        /*
         * Create actual date
         */

        const thisDate =
            new Date(
                year,
                month,
                day
            );

        thisDate.setHours(0, 0, 0, 0);


        /*
         * Create date string
         *
         * Example:
         * 2026-09-27
         */

        const dateString =
            year +
            "-" +
            String(month + 1).padStart(2, "0") +
            "-" +
            String(day).padStart(2, "0");


        dayElement.dataset.date =
            dateString;


        /*
         * Disable past dates
         */

        if (thisDate < today) {

            dayElement.classList.add(
                "past-date"
            );

        } else {

            /*
             * Future/today date
             */

            dayElement.classList.add(
                "available-date"
            );


            /*
             * Make date clickable
             */

            dayElement.addEventListener(
                "click",
                function() {

                    selectAppointmentDate(
                        dateString,
                        thisDate,
                        dayElement
                    );

                }
            );

        }


        /*
         * Selected date
         */

        if (
            selectedAppointmentDate ===
            dateString
        ) {

            dayElement.classList.add(
                "selected-date"
            );

        }


        calendarDays.appendChild(
            dayElement
        );

    }


    /*
     * Previous month button
     */

    const previousButton =
        document.getElementById(
            "previousMonthBtn"
        );


    /*
     * Don't allow going before
     * the current month.
     */

    const currentMonth =
        new Date(
            today.getFullYear(),
            today.getMonth(),
            1
        );


    const displayedMonth =
        new Date(
            year,
            month,
            1
        );


    if (
        displayedMonth <= currentMonth
    ) {

        previousButton.disabled = true;

    } else {

        previousButton.disabled = false;

    }

}


/* -----------------------------------------------------
   SELECT APPOINTMENT DATE
   ----------------------------------------------------- */

function selectAppointmentDate(
    dateString,
    dateObject,
    dayElement
) {

    /*
     * Save selected date
     */

    selectedAppointmentDate =
        dateString;


    /*
     * Put selected date into hidden input
     */

    const appointmentDate =
        document.getElementById(
            "appointmentDate"
        );


    if (appointmentDate) {

        appointmentDate.value =
            dateString;

    }


    /*
     * Remove old selected date
     */

    document.querySelectorAll(
        ".calendar-days .selected-date"
    ).forEach(function(day) {

        day.classList.remove(
            "selected-date"
        );

    });


    /*
     * Highlight newly selected date
     */

    dayElement.classList.add(
        "selected-date"
    );


    /*
     * Format the selected date
     *
     * Example:
     * Tue, Sep 29
     */

    const formattedDate =
        dateObject.toLocaleDateString(
            "en-US",
            {
                weekday: "short",
                month: "short",
                day: "numeric"
            }
        );


    /*
     * Find the Available Time date text
     */

    const timeDate =
        document.getElementById(
            "selectedTimeDate"
        );


    /*
     * Update the date shown above
     * the available time slots
     */

    if (timeDate) {

        timeDate.textContent =
            "For " + formattedDate;

    }


    /*
     * Load available time slots
     * for the selected date
     */

    loadTimeSlots(dateObject, dateString);

}


/* -----------------------------------------------------
   PREVIOUS MONTH
   ----------------------------------------------------- */

function goToPreviousMonth() {

    const today =
        new Date();


    const currentMonth =
        new Date(
            today.getFullYear(),
            today.getMonth(),
            1
        );


    const previousMonth =
        new Date(
            calendarDate.getFullYear(),
            calendarDate.getMonth() - 1,
            1
        );


    /*
     * Don't allow previous months
     */

    if (
        previousMonth < currentMonth
    ) {

        return;

    }


    calendarDate =
        previousMonth;


    loadCalendar();

}


/* -----------------------------------------------------
   NEXT MONTH
   ----------------------------------------------------- */

function goToNextMonth() {

    calendarDate =
        new Date(
            calendarDate.getFullYear(),
            calendarDate.getMonth() + 1,
            1
        );


    loadCalendar();

}


/* -----------------------------------------------------
   CALENDAR BUTTON EVENTS
   ----------------------------------------------------- */

document.addEventListener(
    "DOMContentLoaded",
    function() {

        const previousButton =
            document.getElementById(
                "previousMonthBtn"
            );


        const nextButton =
            document.getElementById(
                "nextMonthBtn"
            );


        if (previousButton) {

            previousButton.addEventListener(
                "click",
                goToPreviousMonth
            );

        }


        if (nextButton) {

            nextButton.addEventListener(
                "click",
                goToNextMonth
            );

        }


        /*
         * Load calendar when page opens
         */

        loadCalendar();

    }
);

/* =====================================================
   APPOINTMENT TIME SLOTS
   ===================================================== */

async function loadTimeSlots(dateObject, dateString) {

    const timeSlots = document.getElementById("timeSlots");
    if (!timeSlots) return;

    timeSlots.innerHTML = "";

    const dayOfWeek = dateObject.getDay();

    if (dayOfWeek === 0) {
        timeSlots.innerHTML =
            '<p class="clinic-closed">Clinic is closed on Sundays.</p>';
        return;
    }

    /* A vet must be chosen first */
    const vet = document.querySelector('input[name="vet_id"]:checked');

    if (!vet) {
        timeSlots.innerHTML =
            '<p class="clinic-closed">Please select a veterinarian first.</p>';
        return;
    }

    /* Ask the server which times are already booked */
    let bookedTimes = [];

    try {
        const response = await fetch(
            URLROOT + "/petowner/getBookedSlots?vet_id=" +
            encodeURIComponent(vet.value) +
            "&date=" + encodeURIComponent(dateString)
        );
        bookedTimes = await response.json();
        //console.log("vet_id:", vet.value, "date:", dateString, "booked:", bookedTimes);
    } catch (error) {
        console.error("Could not load booked slots", error);
    }

    let timePeriods = [];

    if (dayOfWeek >= 1 && dayOfWeek <= 5) {
        timePeriods = [
            { start: 9 * 60,  end: 13 * 60 },
            { start: 14 * 60, end: 17 * 60 }
        ];
    } else if (dayOfWeek === 6) {
        timePeriods = [{ start: 9 * 60, end: 13 * 60 }];
    }

    /* For today, hide times that have already passed */
    const now = new Date();
    const isToday = dateObject.toDateString() === now.toDateString();
    const nowMinutes = now.getHours() * 60 + now.getMinutes();

    let slotCount = 0;

    timePeriods.forEach(function (period) {

        for (let minutes = period.start; minutes < period.end; minutes += 30) {

            const hour24 = Math.floor(minutes / 60);
            const minute = minutes % 60;

            let displayHour = hour24 % 12;
            if (displayHour === 0) displayHour = 12;

            const amPm = hour24 >= 12 ? "PM" : "AM";

            const displayTime =
                displayHour + ":" + String(minute).padStart(2, "0") + " " + amPm;

            const databaseTime =
                String(hour24).padStart(2, "0") + ":" +
                String(minute).padStart(2, "0") + ":00";

            /* SKIP booked slots and past times */
            const slotKey =
                String(hour24).padStart(2, "0") + ":" + String(minute).padStart(2, "0");

            if (bookedTimes.includes(slotKey)) continue;
            if (isToday && minutes <= nowMinutes) continue;

            const label = document.createElement("label");
            const input = document.createElement("input");

            input.type = "radio";
            input.name = "appointment_time";
            input.value = databaseTime;
            input.required = true;

            const span = document.createElement("span");
            span.textContent = displayTime;

            label.appendChild(input);
            label.appendChild(span);

            input.addEventListener("change", function () {
                document.querySelectorAll(".time-slots label.selected-time")
                    .forEach(function (l) { l.classList.remove("selected-time"); });
                label.classList.add("selected-time");
            });

            timeSlots.appendChild(label);
            slotCount++;
        }
    });

    if (slotCount === 0) {
        timeSlots.innerHTML =
            '<p class="clinic-closed">No available times for this date. Please choose another day.</p>';
    }
}