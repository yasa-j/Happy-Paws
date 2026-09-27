"use strict";

/**
 * HappyPaws Low Stock Alerts
 * Handles searching, filtering, CSV exporting,
 * individual restocking, and bulk reorder feedback.
 */

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("stockSearch");
    const categoryFilter = document.getElementById("categoryFilter");
    const statusFilter = document.getElementById("statusFilter");
    const applyButton = document.getElementById("applyFilters");
    const resetButton = document.getElementById("resetFilters");
    const tableBody = document.getElementById("stockTableBody");
    const resultCount = document.getElementById("resultCount");
    const closeBannerButton = document.getElementById("closeBanner");
    const exportButton = document.getElementById("exportCsvButton");
    const bulkReorderButton =
        document.getElementById("bulkReorderButton");
    const toast = document.getElementById("toast");

    if (!tableBody) {
        return;
    }

    const stockRows = Array.from(
        tableBody.querySelectorAll("tr")
    );

    let toastTimer;

    /**
     * Display a temporary feedback message.
     */
    function showToast(message) {
        if (!toast) {
            alert(message);
            return;
        }

        clearTimeout(toastTimer);

        toast.textContent = message;
        toast.classList.add("show");

        toastTimer = setTimeout(() => {
            toast.classList.remove("show");
        }, 2800);
    }

    /**
     * Remove the empty-results message.
     */
    function removeEmptyState() {
        const emptyRow = tableBody.querySelector(".empty-row");

        if (emptyRow) {
            emptyRow.remove();
        }
    }

    /**
     * Filter stock alerts using text, category, and status.
     */
    function filterStockItems() {
        removeEmptyState();

        const searchText = searchInput
            ? searchInput.value.toLowerCase().trim()
            : "";

        const selectedCategory = categoryFilter
            ? categoryFilter.value
            : "all";

        const selectedStatus = statusFilter
            ? statusFilter.value
            : "all";

        let visibleCount = 0;

        stockRows.forEach(row => {
            const matchesSearch =
                row.dataset.name.includes(searchText) ||
                row.dataset.sku.includes(searchText);

            const matchesCategory =
                selectedCategory === "all" ||
                row.dataset.category === selectedCategory;

            const matchesStatus =
                selectedStatus === "all" ||
                row.dataset.status === selectedStatus;

            const visible =
                matchesSearch &&
                matchesCategory &&
                matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        if (visibleCount === 0) {
            const emptyRow = document.createElement("tr");

            emptyRow.className = "empty-row";

            emptyRow.innerHTML = `
                <td colspan="7">
                    No low-stock products match the selected filters.
                </td>
            `;

            tableBody.appendChild(emptyRow);
        }

        if (resultCount) {
            resultCount.textContent = visibleCount === 0
                ? "No alert items found"
                : `Showing 1–${visibleCount} of ${visibleCount} alert items`;
        }
    }

    /**
     * Reset every alert filter.
     */
    function resetStockFilters() {
        if (searchInput) {
            searchInput.value = "";
        }

        if (categoryFilter) {
            categoryFilter.value = "all";
        }

        if (statusFilter) {
            statusFilter.value = "all";
        }

        filterStockItems();
    }

    /**
     * Export visible low-stock rows to CSV.
     */
    function exportLowStockItems() {
        const visibleRows = stockRows
            .filter(row => !row.hidden);

        if (!visibleRows.length) {
            showToast("There are no visible items to export.");
            return;
        }

        const headings = [
            "SKU",
            "Product",
            "Category",
            "Current Stock",
            "Threshold",
            "Status"
        ];

        const records = visibleRows.map(row => {
            const cells = row.querySelectorAll("td");

            return [0, 1, 2, 3, 4, 5].map(index => {
                return cells[index].innerText
                    .replace(/\s+/g, " ")
                    .trim();
            });
        });

        const csvContent = [headings, ...records]
            .map(record => {
                return record.map(value => {
                    const safeValue = value.replace(/"/g, '""');
                    return `"${safeValue}"`;
                }).join(",");
            })
            .join("\n");

        const blob = new Blob(
            [csvContent],
            { type: "text/csv;charset=utf-8" }
        );

        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");

        link.href = url;
        link.download = "happypaws-low-stock-alerts.csv";

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);

        showToast("Low-stock list exported successfully.");
    }

    if (searchInput) {
        searchInput.addEventListener("input", filterStockItems);
    }

    if (categoryFilter) {
        categoryFilter.addEventListener(
            "change",
            filterStockItems
        );
    }

    if (statusFilter) {
        statusFilter.addEventListener(
            "change",
            filterStockItems
        );
    }

    if (applyButton) {
        applyButton.addEventListener(
            "click",
            filterStockItems
        );
    }

    if (resetButton) {
        resetButton.addEventListener(
            "click",
            resetStockFilters
        );
    }

    if (closeBannerButton) {
        closeBannerButton.addEventListener("click", () => {
            const warningBanner =
                document.getElementById("warningBanner");

            if (warningBanner) {
                warningBanner.hidden = true;
            }
        });
    }

    if (exportButton) {
        exportButton.addEventListener(
            "click",
            exportLowStockItems
        );
    }

    if (bulkReorderButton) {
        bulkReorderButton.addEventListener("click", () => {
            const visibleCount = stockRows
                .filter(row => !row.hidden)
                .length;

            showToast(
                `${visibleCount} item${visibleCount === 1 ? "" : "s"} added to the bulk reorder draft.`
            );
        });
    }

    /**
     * Handle Restock buttons through event delegation.
     */
    tableBody.addEventListener("click", event => {
        const restockButton =
            event.target.closest(".restock-button");

        if (!restockButton) {
            return;
        }

        const sku = restockButton.dataset.sku;

        showToast(`${sku} added to the reorder draft.`);
    });
});