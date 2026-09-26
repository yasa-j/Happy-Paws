document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Staff Clients loaded.");


    const searchInput =
        document.querySelector(".clients-search input");


    if (!searchInput) {
        return;
    }


    searchInput.addEventListener("input", function () {

        const searchText =
            this.value.toLowerCase().trim();


        const clientRows =
            document.querySelectorAll(
                ".client-row, .client-card"
            );


        clientRows.forEach(function (client) {

            const clientText =
                client.textContent.toLowerCase();


            if (clientText.includes(searchText)) {

                client.style.display = "";

            } else {

                client.style.display = "none";

            }

        });

    });

});