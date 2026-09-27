document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("appointmentSearch");
    const petFilter = document.getElementById("petFilter");
    const statusFilter = document.getElementById("statusFilter");

    const clearFilters = document.getElementById("clearFilters");

    const sortButton = document.getElementById("sortButton");
    const sortText = document.getElementById("sortText");

    const appointmentList =
        document.getElementById("appointmentList");

    const noResults =
        document.getElementById("noResults");

    const cards = Array.from(
        document.querySelectorAll(".appointment-card")
    );

    const previousPage =
        document.getElementById("previousPage");

    const nextPage =
        document.getElementById("nextPage");

    const pageButtons =
        document.querySelectorAll(".page-number");

    const recordStart =
        document.getElementById("recordStart");

    const recordEnd =
        document.getElementById("recordEnd");

    const recordTotal =
        document.getElementById("recordTotal");


    /*
    ========================================================
    FILTER APPOINTMENTS
    ========================================================
    */

    function filterAppointments() {

        const searchValue =
            searchInput.value
                .toLowerCase()
                .trim();

        const selectedPet =
            petFilter.value;

        const selectedStatus =
            statusFilter.value;


        let visibleCards = [];


        cards.forEach(function (card) {

            const searchText =
                card.dataset.search.toLowerCase();

            const pet =
                card.dataset.pet;

            const status =
                card.dataset.status;


            const matchesSearch =
                searchText.includes(searchValue);

            const matchesPet =
                selectedPet === "all" ||
                pet === selectedPet;

            const matchesStatus =
                selectedStatus === "all" ||
                status === selectedStatus;


            if (
                matchesSearch &&
                matchesPet &&
                matchesStatus
            ) {

                visibleCards.push(card);

            }

        });


        updateResults(visibleCards);
    }


    /*
    ========================================================
    DISPLAY RESULTS
    ========================================================
    */

    function updateResults(visibleCards) {

        cards.forEach(function (card) {
            card.style.display = "none";
        });


        if (visibleCards.length === 0) {

            noResults.style.display = "block";

            recordStart.textContent = "0";
            recordEnd.textContent = "0";
            recordTotal.textContent = "0";

            return;
        }


        noResults.style.display = "none";


        visibleCards.forEach(function (card) {
            card.style.display = "grid";
        });


        recordStart.textContent = "1";

        recordEnd.textContent =
            visibleCards.length;

        recordTotal.textContent =
            visibleCards.length;
    }


    /*
    ========================================================
    SEARCH
    ========================================================
    */

    searchInput.addEventListener(
        "input",
        filterAppointments
    );


    /*
    ========================================================
    PET FILTER
    ========================================================
    */

    petFilter.addEventListener(
        "change",
        filterAppointments
    );


    /*
    ========================================================
    STATUS FILTER
    ========================================================
    */

    statusFilter.addEventListener(
        "change",
        filterAppointments
    );


    /*
    ========================================================
    CLEAR FILTERS
    ========================================================
    */

    clearFilters.addEventListener(
        "click",
        function () {

            searchInput.value = "";

            petFilter.value = "all";

            statusFilter.value = "all";

            filterAppointments();
        }
    );


    /*
    ========================================================
    SORT APPOINTMENTS
    ========================================================
    */

    sortButton.addEventListener(
        "click",
        function () {

            const currentOrder =
                sortButton.dataset.order;


            if (currentOrder === "newest") {

                sortButton.dataset.order =
                    "oldest";

                sortText.textContent =
                    "Oldest First";

                sortCards("oldest");

            } else {

                sortButton.dataset.order =
                    "newest";

                sortText.textContent =
                    "Newest First";

                sortCards("newest");
            }

        }
    );


    function sortCards(order) {

        const sortedCards =
            [...cards].sort(function (a, b) {

                const dateA =
                    new Date(a.dataset.date);

                const dateB =
                    new Date(b.dataset.date);


                if (order === "newest") {
                    return dateB - dateA;
                }

                return dateA - dateB;
            });


        sortedCards.forEach(function (card) {
            appointmentList.appendChild(card);
        });


        filterAppointments();
    }


    /*
    ========================================================
    COPY APPOINTMENT REFERENCE
    ========================================================
    */

    document
        .querySelectorAll(".copy-reference")
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const reference =
                        button.dataset.reference;


                    if (
                        navigator.clipboard &&
                        navigator.clipboard.writeText
                    ) {

                        navigator.clipboard.writeText(
                            reference
                        );

                        button.textContent = "✓";

                        setTimeout(
                            function () {
                                button.textContent = "▣";
                            },
                            1200
                        );
                    }

                }
            );

        });


    /*
    ========================================================
    VIEW DETAILS
    ========================================================
    */

    document
        .querySelectorAll(".details-button")
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const appointmentId =
                        button.dataset.appointment;

                    alert(
                        "Appointment details for " +
                        appointmentId +
                        " will be available here."
                    );

                }
            );

        });


    /*
    ========================================================
    VIEW HEALTH RECORDS
    ========================================================
    */

    document
        .querySelectorAll(".health-record-button")
        .forEach(function (button) {

            button.addEventListener(
                "click",
                function () {

                    const pet =
                        button.dataset.pet;

                    alert(
                        "Health records for " +
                        pet +
                        " will be available here."
                    );

                }
            );

        });


    /*
    ========================================================
    PAGINATION
    ========================================================
    */

    pageButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                pageButtons.forEach(
                    function (page) {
                        page.classList.remove(
                            "active"
                        );
                    }
                );

                button.classList.add("active");

                const page =
                    button.dataset.page;


                if (page === "1") {

                    previousPage.disabled = true;
                    nextPage.disabled = false;

                } else if (page === "3") {

                    previousPage.disabled = false;
                    nextPage.disabled = true;

                } else {

                    previousPage.disabled = false;
                    nextPage.disabled = false;
                }

            }
        );

    });


    /*
    ========================================================
    PREVIOUS PAGE
    ========================================================
    */

    previousPage.addEventListener(
        "click",
        function () {

            const activePage =
                document.querySelector(
                    ".page-number.active"
                );

            const currentPage =
                Number(activePage.dataset.page);


            if (currentPage > 1) {

                const newPage =
                    currentPage - 1;

                document
                    .querySelector(
                        `.page-number[data-page="${newPage}"]`
                    )
                    .click();

            }

        }
    );


    /*
    ========================================================
    NEXT PAGE
    ========================================================
    */

    nextPage.addEventListener(
        "click",
        function () {

            const activePage =
                document.querySelector(
                    ".page-number.active"
                );

            const currentPage =
                Number(activePage.dataset.page);


            if (currentPage < 3) {

                const newPage =
                    currentPage + 1;

                document
                    .querySelector(
                        `.page-number[data-page="${newPage}"]`
                    )
                    .click();

            }

        }
    );


    /*
    ========================================================
    INITIAL LOAD
    ========================================================
    */

    filterAppointments();

});