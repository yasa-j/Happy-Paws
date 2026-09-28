"use strict";

/**
 * HappyPaws Manage Products
 *
 * Handles product selection, searching, filtering,
 * bulk interface actions and CSV exporting.
 *
 * Edit navigation and database deletion are handled
 * by the PHP links and forms in index.php.
 */
document.addEventListener(
    "DOMContentLoaded",
    initializeManageProducts
);

/**
 * Initialize all Manage Products interactions.
 */
function initializeManageProducts() {
    setupSelection();
    setupFilters();
    setupBulkActions();
    setupExport();
}

/**
 * Connect both Select All checkboxes and keep
 * the selected product counter synchronized.
 */
function setupSelection() {
    const topCheckbox =
        document.getElementById("selectAllTop");

    const tableCheckbox =
        document.getElementById("selectAllTable");

    // Stop when the required elements are unavailable.
    if (!topCheckbox || !tableCheckbox) {
        return;
    }

    const selectVisibleRows = (checked) => {
        getRowCheckboxes().forEach((checkbox) => {
            const row = checkbox.closest("tr");

            if (row && !row.hidden) {
                checkbox.checked = checked;
            }
        });

        updateSelectedCount();
    };

    topCheckbox.addEventListener("change", () => {
        tableCheckbox.checked = topCheckbox.checked;
        selectVisibleRows(topCheckbox.checked);
    });

    tableCheckbox.addEventListener("change", () => {
        topCheckbox.checked = tableCheckbox.checked;
        selectVisibleRows(tableCheckbox.checked);
    });

    getRowCheckboxes().forEach((checkbox) => {
        checkbox.addEventListener(
            "change",
            updateSelectedCount
        );
    });
}

/**
 * Apply text, category and status filters
 * to the products table.
 */
function setupFilters() {
    const searchInput =
        document.getElementById("manageSearch");

    const categorySelect =
        document.getElementById("manageCategory");

    const statusSelect =
        document.getElementById("manageStatus");

    const filterButton =
        document.getElementById("manageFilter");

    const resetButton =
        document.getElementById("manageReset");

    const countLabel =
        document.getElementById("manageCount");

    // Stop when the filter controls are unavailable.
    if (
        !searchInput ||
        !categorySelect ||
        !statusSelect ||
        !filterButton ||
        !resetButton
    ) {
        return;
    }

    const applyFilters = () => {
        const searchValue =
            searchInput.value.toLowerCase().trim();

        let visibleCount = 0;

        getRows().forEach((row) => {
            const matchesSearch =
                row.textContent
                    .toLowerCase()
                    .includes(searchValue);

            const matchesCategory =
                categorySelect.value === "all" ||
                row.dataset.category ===
                    categorySelect.value;

            const matchesStatus =
                statusSelect.value === "all" ||
                row.dataset.status === statusSelect.value;

            const isVisible =
                matchesSearch &&
                matchesCategory &&
                matchesStatus;

            row.hidden = !isVisible;

            if (isVisible) {
                visibleCount++;
            }
        });

        if (countLabel) {
            countLabel.textContent =
                `Showing ${visibleCount} matching products`;
        }

        updateSelectedCount();
    };

    searchInput.addEventListener(
        "input",
        applyFilters
    );

    categorySelect.addEventListener(
        "change",
        applyFilters
    );

    statusSelect.addEventListener(
        "change",
        applyFilters
    );

    filterButton.addEventListener(
        "click",
        applyFilters
    );

    resetButton.addEventListener("click", () => {
        searchInput.value = "";
        categorySelect.value = "all";
        statusSelect.value = "all";

        getRows().forEach((row) => {
            row.hidden = false;
        });

        if (countLabel) {
            countLabel.textContent =
                `Showing ${getRows().length} products`;
        }

        updateSelectedCount();
    });
}

/**
 * Add the demonstration bulk price and status controls.
 *
 * These bulk controls update only the visible interface.
 * Individual CRUD operations use the PHP controller.
 */
function setupBulkActions() {
    const bulkPriceButton =
        document.getElementById("bulkPrice");

    const bulkStatusButton =
        document.getElementById("bulkStatus");

    if (bulkPriceButton) {
        bulkPriceButton.addEventListener("click", () => {
            if (!requireSelection()) {
                return;
            }

            const price = prompt(
                "Enter the new price (Rs.):"
            );

            if (
                price === null ||
                price.trim() === "" ||
                Number(price) < 0
            ) {
                return;
            }

            getSelectedRows().forEach((row) => {
                row.cells[4].innerHTML =
                    `<b>Rs. ${Number(price).toLocaleString()}</b>`;
            });
        });
    }

    if (bulkStatusButton) {
        bulkStatusButton.addEventListener("click", () => {
            if (!requireSelection()) {
                return;
            }

            const status = prompt(
                "Enter status: In Stock, Low Stock, or Out of Stock"
            );

            const validStatuses = [
                "In Stock",
                "Low Stock",
                "Out of Stock"
            ];

            if (!validStatuses.includes(status)) {
                alert("Invalid status.");
                return;
            }

            getSelectedRows().forEach((row) => {
                const statusClass = status
                    .toLowerCase()
                    .replaceAll(" ", "-");

                row.dataset.status = status;

                row.cells[6].innerHTML =
                    `<span class="status ${statusClass}">${status}</span>`;
            });
        });
    }
}

/**
 * Export selected products or all visible products
 * into a CSV file.
 */
function setupExport() {
    const exportButton =
        document.getElementById("quickExport");

    if (!exportButton) {
        return;
    }

    exportButton.addEventListener("click", () => {
        let rows = getSelectedRows();

        // Export visible rows when no rows are selected.
        if (rows.length === 0) {
            rows = getRows().filter(
                (row) => !row.hidden
            );
        }

        if (rows.length === 0) {
            alert("No products are available to export.");
            return;
        }

        const csvRows = rows.map((row) => {
            return Array.from(row.cells)
                .slice(1, -1)
                .map((cell) => {
                    const value = cell.textContent
                        .replace(/\s+/g, " ")
                        .trim()
                        .replaceAll('"', '""');

                    return `"${value}"`;
                })
                .join(",");
        });

        const csvContent = csvRows.join("\n");

        const file = new Blob(
            [csvContent],
            {
                type: "text/csv;charset=utf-8"
            }
        );

        const downloadLink =
            document.createElement("a");

        downloadLink.href =
            URL.createObjectURL(file);

        downloadLink.download =
            "managed-products.csv";

        downloadLink.click();

        URL.revokeObjectURL(downloadLink.href);
    });
}

/**
 * Return all valid product rows.
 */
function getRows() {
    return Array.from(
        document.querySelectorAll(
            "#manageTable tbody tr"
        )
    ).filter((row) => {
        return row.querySelector(".row-check");
    });
}

/**
 * Return all product row checkboxes.
 */
function getRowCheckboxes() {
    return Array.from(
        document.querySelectorAll(".row-check")
    );
}

/**
 * Return all selected product rows.
 */
function getSelectedRows() {
    return getRows().filter((row) => {
        const checkbox =
            row.querySelector(".row-check");

        return checkbox && checkbox.checked;
    });
}

/**
 * Update the selected-items counter.
 */
function updateSelectedCount() {
    const selectedCount =
        document.getElementById("selectedCount");

    if (selectedCount) {
        selectedCount.textContent =
            `${getSelectedRows().length} items`;
    }
}

/**
 * Prevent a bulk action when no product is selected.
 */
function requireSelection() {
    if (getSelectedRows().length === 0) {
        alert("Select at least one product first.");
        return false;
    }

    return true;
}