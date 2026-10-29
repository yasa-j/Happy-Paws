
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll(".appointment-tab");
    const rows = Array.from(document.querySelectorAll(".appointment-row"));
    const pageButtons = document.querySelectorAll(".pagination-number");
    const arrowButtons = document.querySelectorAll(".pagination-arrow");
    const showingText = document.querySelector(".appointment-showing");

    const rowsPerPage = 4;
    let currentPage = 1;
    let currentFilter = "all";

    // Get the status of an appointment
    function getStatus(row) {
        const badge = row.querySelector(".status-badge");

        if (!badge) {
            return "";
        }

        return badge.textContent.trim().toLowerCase();
    }

    // Return appointments matching the selected filter
    function getFilteredRows() {
        if (currentFilter === "all") {
            return rows;
        }

        return rows.filter(function (row) {
            return getStatus(row) === currentFilter;
        });
    }

    // Display the appointments for the selected page
    function renderAppointments() {
        const filteredRows = getFilteredRows();
        const totalPages = Math.max(
            1,
            Math.ceil(filteredRows.length / rowsPerPage)
        );

        currentPage = Math.min(currentPage, totalPages);

        rows.forEach(function (row) {
            row.style.display = "none";
        });

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = Math.min(
            startIndex + rowsPerPage,
            filteredRows.length
        );

        filteredRows.slice(startIndex, endIndex).forEach(function (row) {
            row.style.display = "grid";
        });

        // Update the "Showing" text
        if (showingText) {
            if (filteredRows.length === 0) {
                showingText.textContent = "NO APPOINTMENTS FOUND";
            } else {
                showingText.textContent =
                    "SHOWING " +
                    (startIndex + 1) +
                    "-" +
                    endIndex +
                    " OF " +
                    filteredRows.length +
                    " APPOINTMENTS";
            }
        }

        // Update page number buttons
        pageButtons.forEach(function (button) {
            const page = Number(button.textContent.trim());

            button.classList.toggle("active", page === currentPage);

            button.style.display =
                page <= totalPages ? "flex" : "none";
        });

        // Disable pagination arrows when necessary
        if (arrowButtons.length >= 2) {
            arrowButtons[0].disabled = currentPage <= 1;
            arrowButtons[arrowButtons.length - 1].disabled =
                currentPage >= totalPages;
        }
    }

    // Filter appointments when a status tab is clicked
    tabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            tabs.forEach(function (item) {
                item.classList.remove("active");
            });

            tab.classList.add("active");

            const label = tab.textContent.trim().toLowerCase();

            const filters = {
                "all appointments": "all",
                "completed": "completed",
                "checked in": "checked in",
                "pending": "pending",
                "cancelled": "cancelled"
            };

            currentFilter = filters[label] || "all";
            currentPage = 1;

            renderAppointments();
        });
    });

    // Navigate using the numbered buttons
    pageButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const page = Number(button.textContent.trim());

            if (!Number.isNaN(page) && page > 0) {
                currentPage = page;
                renderAppointments();
            }
        });
    });

    // Navigate using the previous/next arrows
    if (arrowButtons.length >= 2) {
        arrowButtons[0].addEventListener("click", function () {
            if (currentPage > 1) {
                currentPage--;
                renderAppointments();
            }
        });

        arrowButtons[arrowButtons.length - 1].addEventListener(
            "click",
            function () {
                const totalPages = Math.max(
                    1,
                    Math.ceil(getFilteredRows().length / rowsPerPage)
                );

                if (currentPage < totalPages) {
                    currentPage++;
                    renderAppointments();
                }
            }
        );
    }

    // View Details links
    document.querySelectorAll(".view-details").forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            const row = link.closest(".appointment-row");
            const petName =
                row?.querySelector(".pet-details strong")?.textContent.trim()
                || "Unknown pet";

            alert(
                "Appointment details for " +
                petName +
                "\n\nDetailed appointment information is not connected yet."
            );
        });
    });

    renderAppointments();
});
