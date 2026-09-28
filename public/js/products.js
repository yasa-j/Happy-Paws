"use strict";

/**
 * HappyPaws Product Catalog
 * Handles searching, filtering, CSV exporting,
 * row actions, and pagination feedback.
 */

document.addEventListener("DOMContentLoaded", () => {
    setupProductFilters();
    setupProductReset();
    setupProductExport();
    setupProductActions();
    setupProductPagination();
});

/**
 * Return every product row currently inside the table.
 */
function getProductRows() {
    return Array.from(
        document.querySelectorAll("#productsTable tbody tr")
    );
}

/**
 * Apply text, category, and stock-status filters.
 */
function setupProductFilters() {
    const searchInput = document.getElementById("productSearch");
    const categoryFilter = document.getElementById("categoryFilter");
    const stockFilter = document.getElementById("stockFilter");
    const filterButton = document.getElementById("filterButton");

    if (
        !searchInput ||
        !categoryFilter ||
        !stockFilter ||
        !filterButton
    ) {
        return;
    }

    const applyFilters = () => {
        const searchText = searchInput.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        getProductRows().forEach(row => {
            const rowText = row.textContent.toLowerCase();

            const matchesText = rowText.includes(searchText);

            const matchesCategory =
                categoryFilter.value === "all" ||
                row.dataset.category === categoryFilter.value;

            const matchesStock =
                stockFilter.value === "all" ||
                row.dataset.status === stockFilter.value;

            const visible =
                matchesText &&
                matchesCategory &&
                matchesStock;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        updateProductCount(visibleCount);
    };

    searchInput.addEventListener("input", applyFilters);
    categoryFilter.addEventListener("change", applyFilters);
    stockFilter.addEventListener("change", applyFilters);
    filterButton.addEventListener("click", applyFilters);
}

/**
 * Clear all product filters and display every row.
 */
function setupProductReset() {
    const resetButton = document.getElementById("resetButton");

    if (!resetButton) {
        return;
    }

    resetButton.addEventListener("click", () => {
        document.getElementById("productSearch").value = "";
        document.getElementById("categoryFilter").value = "all";
        document.getElementById("stockFilter").value = "all";

        getProductRows().forEach(row => {
            row.hidden = false;
        });

        updateProductCount(getProductRows().length);
    });
}

/**
 * Export currently visible products to a CSV file.
 */
function setupProductExport() {
    const exportButton = document.getElementById("exportCsv");

    if (!exportButton) {
        return;
    }

    exportButton.addEventListener("click", () => {
        const visibleRows = getProductRows()
            .filter(row => !row.hidden);

        if (!visibleRows.length) {
            alert("There are no visible products to export.");
            return;
        }

        const headings = Array.from(
            document.querySelectorAll("#productsTable thead th")
        )
            .slice(0, -1)
            .map(cell => cell.textContent.trim());

        const records = visibleRows.map(row => {
            return Array.from(row.cells)
                .slice(0, -1)
                .map(cell => {
                    return cell.textContent
                        .replace(/\s+/g, " ")
                        .trim();
                });
        });

        const csvContent = [headings, ...records]
            .map(record => {
                return record
                    .map(convertToCsvValue)
                    .join(",");
            })
            .join("\n");

        downloadCsvFile(
            csvContent,
            "happypaws-products.csv"
        );
    });
}

/**
 * Add temporary edit and delete actions.
 * Real CRUD operations will later be handled by PHP.
 */
function setupProductActions() {
    document.querySelectorAll(".edit-button")
        .forEach(button => {
            button.addEventListener("click", () => {
                const productName = getProductName(button);

                alert(`${productName} selected for editing.`);
            });
        });

    document.querySelectorAll(".delete-button")
        .forEach(button => {
            button.addEventListener("click", () => {
                const productName = getProductName(button);

                const confirmed = confirm(
                    `Are you sure you want to delete ${productName}?`
                );

                if (!confirmed) {
                    return;
                }

                button.closest("tr").remove();

                const visibleCount = getProductRows()
                    .filter(row => !row.hidden)
                    .length;

                updateProductCount(visibleCount);
            });
        });
}

/**
 * Change the active pagination button.
 */
function setupProductPagination() {
    const buttons = document.querySelectorAll(
        "#pagination button:not([disabled])"
    );

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            const buttonText = button.textContent.trim();

            if (!/^\d+$/.test(buttonText)) {
                return;
            }

            buttons.forEach(item => {
                item.classList.remove("active");
            });

            button.classList.add("active");
        });
    });
}

/**
 * Return the name of a product belonging to an action button.
 */
function getProductName(button) {
    const productName = button
        .closest("tr")
        .querySelector(".product-cell b");

    return productName
        ? productName.textContent.trim()
        : "this product";
}

/**
 * Update the visible product count.
 */
function updateProductCount(count) {
    const countElement = document.getElementById("tableCount");

    if (countElement) {
        countElement.textContent =
            `Showing ${count} matching products`;
    }
}

/**
 * Escape an individual value before adding it to CSV.
 */
function convertToCsvValue(value) {
    const safeValue = String(value)
        .replace(/"/g, '""');

    return `"${safeValue}"`;
}

/**
 * Create and download a CSV file.
 */
function downloadCsvFile(content, filename) {
    const csvBlob = new Blob(
        [content],
        { type: "text/csv;charset=utf-8" }
    );

    const downloadUrl = URL.createObjectURL(csvBlob);
    const downloadLink = document.createElement("a");

    downloadLink.href = downloadUrl;
    downloadLink.download = filename;

    document.body.appendChild(downloadLink);
    downloadLink.click();
    downloadLink.remove();

    URL.revokeObjectURL(downloadUrl);
}