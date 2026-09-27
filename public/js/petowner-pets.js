document.addEventListener("DOMContentLoaded", function () {

    /*
     * =====================================================
     * PET SEARCH
     * =====================================================
     */

    const searchInput = document.getElementById("petSearch");

    const petCards = document.querySelectorAll(".pet-card");

    const noSearchResults =
        document.getElementById("noSearchResults");


    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchValue =
                this.value.toLowerCase().trim();

            let visiblePets = 0;


            petCards.forEach(function (card) {

                const petName =
                    card.dataset.name || "";

                const petBreed =
                    card.dataset.breed || "";


                const matches =
                    petName.includes(searchValue) ||
                    petBreed.includes(searchValue);


                if (matches) {

                    card.style.display = "";

                    visiblePets++;

                } else {

                    card.style.display = "none";

                }

            });


            /*
             * Show "No pets found"
             * when nothing matches.
             */

            if (noSearchResults) {

                if (
                    searchValue !== "" &&
                    visiblePets === 0
                ) {

                    noSearchResults.style.display = "block";

                } else {

                    noSearchResults.style.display = "none";

                }

            }

        });

    }


    /*
     * =====================================================
     * PET MENU BUTTONS
     * =====================================================
     *
     * For now these only show a small message.
     * Actual Edit/Delete functionality can be connected
     * later.
     */

    const menuButtons =
        document.querySelectorAll(".pet-menu-btn");


    menuButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            alert("Pet options will be available here.");

        });

    });


});