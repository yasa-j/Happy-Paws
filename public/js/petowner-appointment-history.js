document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("appointmentSearch");
    const petFilter = document.getElementById("petFilter");
    const statusFilter = document.getElementById("statusFilter");

    const clearFilters = document.getElementById("clearFilters");
    const sortButton = document.getElementById("sortButton");
    const sortText = document.getElementById("sortText");

    const appointmentList = document.getElementById("appointmentList");
    const noResults = document.getElementById("noResults");

    const previousPage = document.getElementById("previousPage");
    const nextPage = document.getElementById("nextPage");
    const paginationPages = document.querySelector(".pagination-pages");

    const recordStart = document.getElementById("recordStart");
    const recordEnd = document.getElementById("recordEnd");
    const recordTotal = document.getElementById("recordTotal");

    const cards = Array.from(
        document.querySelectorAll(".appointment-card")
    );

    const pageSize = 4;

    let currentPage = 1;
    let sortOrder = "newest";


    // Filter appointments using the search box and dropdowns.
    function getFilteredCards() {

        const searchValue = searchInput.value.toLowerCase().trim();
        const selectedPet = petFilter.value;
        const selectedStatus = statusFilter.value.toLowerCase();

        return cards
            .filter(function (card) {

                const searchText = card.dataset.search || "";
                const pet = card.dataset.pet || "";
                const status = (card.dataset.status || "").toLowerCase();

                const matchesSearch =
                    searchText.toLowerCase().includes(searchValue);

                const matchesPet =
                    selectedPet === "all" || pet === selectedPet;

                const matchesStatus =
                    selectedStatus === "all" ||
                    status === selectedStatus;

                return matchesSearch && matchesPet && matchesStatus;
            })
            .sort(function (a, b) {

                const dateA = a.dataset.date || "";
                const dateB = b.dataset.date || "";

                const dateComparison = dateA.localeCompare(dateB);

                if (dateComparison !== 0) {
                    return sortOrder === "newest"
                        ? -dateComparison
                        : dateComparison;
                }

                return sortOrder === "newest"
                    ? b.dataset.search.localeCompare(a.dataset.search)
                    : a.dataset.search.localeCompare(b.dataset.search);
            });
    }


    // Update the visible cards, result count and pagination.
    function renderAppointments() {

        const filteredCards = getFilteredCards();

        const total = filteredCards.length;
        const pageCount = Math.ceil(total / pageSize);

        if (pageCount === 0) {
            currentPage = 1;
        } else if (currentPage > pageCount) {
            currentPage = pageCount;
        }

        const startIndex = (currentPage - 1) * pageSize;

        const pageCards = filteredCards.slice(
            startIndex,
            startIndex + pageSize
        );

        cards.forEach(function (card) {
            card.style.display = "none";
        });

        pageCards.forEach(function (card) {
            card.style.display = "grid";
            appointmentList.appendChild(card);
        });

        noResults.style.display = total === 0 ? "block" : "none";

        recordStart.textContent = total === 0 ? 0 : startIndex + 1;
        recordEnd.textContent = Math.min(startIndex + pageSize, total);
        recordTotal.textContent = total;

        renderPagination(pageCount);
    }


    // Create the correct number of page buttons.
    function renderPagination(pageCount) {

        paginationPages.innerHTML = "";

        for (let page = 1; page <= pageCount; page++) {

            const button = document.createElement("button");

            button.type = "button";
            button.className = "page-number";
            button.dataset.page = page;
            button.textContent = page;

            if (page === currentPage) {
                button.classList.add("active");
            }

            button.addEventListener("click", function () {
                currentPage = page;
                renderAppointments();
            });

            paginationPages.appendChild(button);
        }

        previousPage.disabled = currentPage <= 1;
        nextPage.disabled =
            pageCount === 0 || currentPage >= pageCount;
    }


    // Search and filters.
    searchInput.addEventListener("input", function () {
        currentPage = 1;
        renderAppointments();
    });

    petFilter.addEventListener("change", function () {
        currentPage = 1;
        renderAppointments();
    });

    statusFilter.addEventListener("change", function () {
        currentPage = 1;
        renderAppointments();
    });


    // Clear all filters.
    clearFilters.addEventListener("click", function () {

        searchInput.value = "";
        petFilter.value = "all";
        statusFilter.value = "all";

        currentPage = 1;
        renderAppointments();
    });


    // Switch between newest and oldest.
    sortButton.addEventListener("click", function () {

        sortOrder = sortOrder === "newest" ? "oldest" : "newest";

        sortButton.dataset.order = sortOrder;

        sortText.textContent =
            sortOrder === "newest" ? "Newest First" : "Oldest First";

        currentPage = 1;
        renderAppointments();
    });


    previousPage.addEventListener("click", function () {

        if (currentPage > 1) {
            currentPage--;
            renderAppointments();
        }
    });


    nextPage.addEventListener("click", function () {

        const pageCount = Math.ceil(
            getFilteredCards().length / pageSize
        );

        if (currentPage < pageCount) {
            currentPage++;
            renderAppointments();
        }
    });


    // Copy an appointment reference.
    document.querySelectorAll(".copy-reference").forEach(function (button) {

        button.addEventListener("click", async function () {

            try {

                await navigator.clipboard.writeText(
                    button.dataset.reference
                );

                button.textContent = "✓";

                setTimeout(function () {
                    button.textContent = "▣";
                }, 1200);

            } catch (error) {
                alert("Unable to copy the appointment reference.");
            }
        });
    });


    // Placeholder until the appointment details view is implemented.
    document.querySelectorAll(".details-button").forEach(function (button) {

        button.addEventListener("click", function () {

            alert(
                "Appointment details for appointment ID " +
                button.dataset.appointment +
                " will be available here."
            );
        });
    });


    // Initial page render.
    renderAppointments();

});