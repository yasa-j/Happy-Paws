/* =====================================================
   HAPPY PAWS - PET OWNER SIDEBAR JAVASCRIPT
   ===================================================== */


/*
 * This function opens and closes the sidebar dropdowns.
 *
 * Example:
 * toggleDropdown('petsDropdown');
 */

function toggleDropdown(dropdownId) {

    // Get the dropdown using its ID
    const dropdown = document.getElementById(dropdownId);

    // If the dropdown doesn't exist, stop
    if (!dropdown) {
        return;
    }

    // Add or remove the "show" class
    dropdown.classList.toggle("show");
}

/* =========================================================
   MY PETS SEARCH
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("petSearch");
    const petsGrid = document.getElementById("petsGrid");
    const noResults = document.getElementById("noPetSearchResults");

    // If this page does not contain the pet search,
    // stop here.
    if (!searchInput || !petsGrid) {
        return;
    }


    searchInput.addEventListener("input", function () {

        const searchValue = searchInput.value
            .toLowerCase()
            .trim();

        const petCards = petsGrid.querySelectorAll(".pet-card");

        let visiblePets = 0;


        petCards.forEach(function (card) {

            const petName = card.dataset.name || "";
            const petBreed = card.dataset.breed || "";

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


        // Show "No pets found" message
        if (visiblePets === 0) {

            noResults.style.display = "block";

        } else {

            noResults.style.display = "none";

        }

    });

});