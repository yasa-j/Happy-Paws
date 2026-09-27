document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Vet Dashboard loaded.");


    // --------------------------------------------------
    // Dashboard search
    // --------------------------------------------------

    const searchInput =
        document.querySelector(
            ".vet-search input"
        );


    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchText =
                this.value.toLowerCase().trim();


            const scheduleRows =
                document.querySelectorAll(
                    ".schedule-row"
                );


            scheduleRows.forEach(function (row) {

                const text =
                    row.textContent.toLowerCase();


                row.style.display =
                    text.includes(searchText)
                        ? ""
                        : "none";

            });

        });

    }

});