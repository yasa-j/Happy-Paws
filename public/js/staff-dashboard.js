document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Staff Dashboard loaded.");

    // --------------------------------------------------
    // Dashboard search
    // --------------------------------------------------

    const searchInput = document.querySelector(
        '.staff-header .search-box input'
    );

    if (searchInput) {

        searchInput.addEventListener("keyup", function () {

            const searchText = this.value.trim().toLowerCase();

            const patientRows = document.querySelectorAll(
                ".patient-row"
            );

            patientRows.forEach(function (row) {

                const text = row.textContent.toLowerCase();

                row.style.display =
                    text.includes(searchText) ? "" : "none";

            });

        });

    }


    // --------------------------------------------------
    // View More
    // --------------------------------------------------

    const viewMore = document.querySelector(".view-more");

    if (viewMore) {

        viewMore.addEventListener("click", function () {

            window.location.href =
                "index.php?url=staff/appointments";

        });

    }

});