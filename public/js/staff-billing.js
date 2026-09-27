document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Staff Billing loaded.");


    // --------------------------------------------------
    // Billing tabs
    // --------------------------------------------------

    const tabs =
        document.querySelectorAll(
            ".billing-tab, .tab-button"
        );


    tabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            tabs.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");

        });

    });


    // --------------------------------------------------
    // Billing search
    // --------------------------------------------------

    const searchInput =
        document.querySelector(
            ".billing-search input, .search-box input"
        );


    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchText =
                this.value.toLowerCase().trim();


            const billingRows =
                document.querySelectorAll(
                    ".billing-row, .invoice-row, .billing-table-row"
                );


            billingRows.forEach(function (row) {

                const rowText =
                    row.textContent.toLowerCase();


                row.style.display =
                    rowText.includes(searchText)
                        ? ""
                        : "none";

            });

        });

    }

});