document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Vet Schedule loaded.");


    /*
    |--------------------------------------------------------------------------
    | Calendar Elements
    |--------------------------------------------------------------------------
    */

    const calendarMonth =
        document.getElementById("calendar-month");

    const calendarDays =
        document.getElementById("calendar-days");

    const previousMonthButton =
        document.getElementById("previous-month");

    const nextMonthButton =
        document.getElementById("next-month");

    const todayButton =
        document.getElementById("calendar-today");

    const selectedDateText =
        document.getElementById("selected-date-text");

    const appointmentTotal =
        document.getElementById("appointment-total");


    /*
    |--------------------------------------------------------------------------
    | Initial Date
    |--------------------------------------------------------------------------
    |
    | This starts at October 25, 2027 to match your UI screenshot.
    |
    */

const today = new Date();

let currentDate = new Date(
    today.getFullYear(),
    today.getMonth(),
    1
);

let selectedDate = new Date(
    today.getFullYear(),
    today.getMonth(),
    today.getDate()
);


    /*
    |--------------------------------------------------------------------------
    | Dummy appointment data
    |--------------------------------------------------------------------------
    |
    | Later these values will come from your database.
    |
    */

    const appointments = {

        "2027-10-25": [
            {
                time: "09:00",
                duration: "30 min",
                pet: "Buddy",
                owner: "John Smith",
                purpose: "Annual Checkup",
                status: "Completed"
            },

            {
                time: "09:45",
                duration: "15 min",
                pet: "Luna",
                owner: "Emily Davis",
                purpose: "Vaccination",
                status: "Checked In"
            },

            {
                time: "10:30",
                duration: "45 min",
                pet: "Bella",
                owner: "Michael Johnson",
                purpose: "Dental Exam",
                status: "Pending"
            }
        ],

        "2027-10-26": [
            {
                time: "09:00",
                duration: "30 min",
                pet: "Max",
                owner: "David Brown",
                purpose: "Check-up",
                status: "Pending"
            }
        ],

        "2027-10-28": [
            {
                time: "10:00",
                duration: "30 min",
                pet: "Coco",
                owner: "Emma Wilson",
                purpose: "Vaccination",
                status: "Pending"
            }
        ],

        "2027-10-29": [
            {
                time: "11:00",
                duration: "45 min",
                pet: "Rocky",
                owner: "James Miller",
                purpose: "Dental Exam",
                status: "Pending"
            }
        ]

    };


    /*
    |--------------------------------------------------------------------------
    | Calendar Status
    |--------------------------------------------------------------------------
    */

    const calendarStatus = {

        "2027-10-01": "available",
        "2027-10-02": "available",

        "2027-10-04": "busy",

        "2027-10-06": "booked",

        "2027-10-11": "available",

        "2027-10-13": "busy",

        "2027-10-18": "available",

        "2027-10-20": "booked",

        "2027-10-26": "available",

        "2027-10-29": "busy"

    };


    /*
    |--------------------------------------------------------------------------
    | Month Names
    |--------------------------------------------------------------------------
    */

    const monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December"
    ];


    /*
    |--------------------------------------------------------------------------
    | Render Calendar
    |--------------------------------------------------------------------------
    */

    function renderCalendar() {

        calendarDays.innerHTML = "";


        const year =
            currentDate.getFullYear();

        const month =
            currentDate.getMonth();


        /*
        | Update month title
        */

        calendarMonth.textContent =
            monthNames[month] + " " + year;


        /*
        | First day of month
        */

        const firstDay =
            new Date(year, month, 1).getDay();


        /*
        | Number of days in month
        */

        const daysInMonth =
            new Date(year, month + 1, 0).getDate();


        /*
        | Number of days in previous month
        */

        const previousMonthDays =
            new Date(year, month, 0).getDate();


        /*
        | Total calendar cells
        */

        const totalCells =
            Math.ceil(
                (firstDay + daysInMonth) / 7
            ) * 7;


        /*
        | Create calendar cells
        */

        for (let i = 0; i < totalCells; i++) {

            const dayElement =
                document.createElement("div");

            dayElement.classList.add("calendar-day");


            /*
            | Previous month dates
            */

            if (i < firstDay) {

                const day =
                    previousMonthDays -
                    firstDay +
                    i +
                    1;

                dayElement.textContent = day;

                dayElement.classList.add(
                    "other-month"
                );

            }


            /*
            | Current month dates
            */

            else if (
                i < firstDay + daysInMonth
            ) {

                const day =
                    i - firstDay + 1;

                dayElement.textContent = day;


                /*
                | Create date
                */

                const cellDate =
                    new Date(
                        year,
                        month,
                        day
                    );


                /*
                | Date key
                */

                const dateKey =
                    formatDateKey(cellDate);


                /*
                | Check selected date
                */

                if (
                    isSameDate(
                        cellDate,
                        selectedDate
                    )
                ) {

                    dayElement.classList.add(
                        "selected"
                    );

                }


                /*
                | Check today
                */

                const today =
                    new Date();

                if (
                    isSameDate(
                        cellDate,
                        today
                    )
                ) {

                    dayElement.classList.add(
                        "today"
                    );

                }


                /*
                | Add status dot
                */

                if (calendarStatus[dateKey]) {

                    const dot =
                        document.createElement("span");

                    dot.classList.add(
                        "day-dot",
                        calendarStatus[dateKey]
                    );

                    dayElement.appendChild(dot);

                }


                /*
                | Add click event
                */

                dayElement.addEventListener(
                    "click",
                    function () {

                        selectedDate =
                            new Date(
                                year,
                                month,
                                day
                            );

                        renderCalendar();

                        updateAppointments();

                    }
                );

            }


            /*
            | Next month dates
            */

            else {

                const day =
                    i -
                    (
                        firstDay +
                        daysInMonth
                    ) +
                    1;

                dayElement.textContent = day;

                dayElement.classList.add(
                    "other-month"
                );

            }


            calendarDays.appendChild(
                dayElement
            );

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Previous Month
    |--------------------------------------------------------------------------
    */

    previousMonthButton.addEventListener(
        "click",
        function () {

            currentDate.setMonth(
                currentDate.getMonth() - 1
            );

            renderCalendar();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Next Month
    |--------------------------------------------------------------------------
    */

    nextMonthButton.addEventListener(
        "click",
        function () {

            currentDate.setMonth(
                currentDate.getMonth() + 1
            );

            renderCalendar();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Today Button
    |--------------------------------------------------------------------------
    */

    todayButton.addEventListener(
        "click",
        function () {

            const today =
                new Date();

            currentDate =
                new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    1
                );

            selectedDate =
                new Date(
                    today.getFullYear(),
                    today.getMonth(),
                    today.getDate()
                );

            renderCalendar();

            updateAppointments();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Update Appointment Information
    |--------------------------------------------------------------------------
    */

    function updateAppointments() {

        const dateKey =
            formatDateKey(selectedDate);


        /*
        | Format selected date
        */

        const formattedDate =
            selectedDate.toLocaleDateString(
                "en-GB",
                {
                    weekday: "long",
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                }
            );


        /*
        | Update date text
        */

        selectedDateText.textContent =
            formattedDate;


        /*
        | Get appointments
        */

        const selectedAppointments =
            appointments[dateKey] || [];


        /*
        | Update total
        */

        appointmentTotal.textContent =
            selectedAppointments.length;


        /*
        | Find appointment container
        */

        const appointmentList =
            document.getElementById(
                "appointment-list"
            );


        /*
        | No appointments
        */

        if (
            selectedAppointments.length === 0
        ) {

            appointmentList.innerHTML = `
                <div class="no-appointments-message">
                    <div class="no-appointments-icon">
                        📅
                    </div>

                    <h3>No appointments</h3>

                    <p>
                        There are no appointments
                        scheduled for this date.
                    </p>
                </div>
            `;

            return;

        }


        /*
        | Clear current appointments
        */

        appointmentList.innerHTML = "";


        /*
        | Create appointment cards
        */

        selectedAppointments.forEach(
            function (appointment) {

                const card =
                    document.createElement("div");

                card.classList.add(
                    "appointment-card"
                );


                /*
                | Status class
                */

                let statusClass =
                    "pending";

                if (
                    appointment.status ===
                    "Completed"
                ) {

                    statusClass =
                        "completed";

                }

                else if (
                    appointment.status ===
                    "Checked In"
                ) {

                    statusClass =
                        "checked";

                }


                /*
                | Purpose line breaks
                */

                const purpose =
                    appointment.purpose;


                /*
                | Appointment HTML
                */

                card.innerHTML = `

                    <div class="appointment-time">

                        <strong>
                            ${appointment.time}
                        </strong>

                        <span>
                            ${appointment.duration}
                        </span>

                    </div>


                    <div class="appointment-pet-image paw">

                        🐾

                    </div>


                    <div class="appointment-pet-info">

                        <h3>
                            ${appointment.pet}
                        </h3>

                        <p>
                            Owner:
                            <br>
                            ${appointment.owner}
                        </p>

                    </div>


                    <div class="appointment-purpose">

                        ${purpose}

                    </div>


                    <div class="appointment-status ${statusClass}">

                        ${appointment.status}

                    </div>

                `;


                appointmentList.appendChild(
                    card
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Format Date
    |--------------------------------------------------------------------------
    */

    function formatDateKey(date) {

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


        return (
            year +
            "-" +
            month +
            "-" +
            day
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Compare Dates
    |--------------------------------------------------------------------------
    */

    function isSameDate(
        firstDate,
        secondDate
    ) {

        return (
            firstDate.getFullYear() ===
            secondDate.getFullYear()

            &&

            firstDate.getMonth() ===
            secondDate.getMonth()

            &&

            firstDate.getDate() ===
            secondDate.getDate()
        );

    }


    /*
    |--------------------------------------------------------------------------
    | No Appointment Message CSS
    |--------------------------------------------------------------------------
    */

    const style =
        document.createElement("style");

    style.textContent = `

        .no-appointments-message {

            min-height: 260px;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            text-align: center;

            color: #687477;

        }

        .no-appointments-icon {

            font-size: 35px;

            margin-bottom: 12px;

        }

        .no-appointments-message h3 {

            font-size: 16px;

            color: #344247;

            margin-bottom: 5px;

        }

        .no-appointments-message p {

            font-size: 12px;

            color: #788589;

        }

    `;

    document.head.appendChild(style);


    /*
    |--------------------------------------------------------------------------
    | Initial Render
    |--------------------------------------------------------------------------
    */

    renderCalendar();

    updateAppointments();

});