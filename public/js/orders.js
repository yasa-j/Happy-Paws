"use strict";

/**
 * HappyPaws Orders
 * Handles searching, status filtering, resetting,
 * CSV exporting, row actions, and pagination feedback.
 */

document.addEventListener("DOMContentLoaded", () => {
    setupOrderFilters();
    setupOrderReset();
    setupOrderExport();
    setupOrderActions();
    setupOrderPagination();
});

/**
 * Return all current order rows.
 */
function getOrderRows() {
    return Array.from(
        document.querySelectorAll("#ordersTable tbody tr")
    );
}

/**
 * Filter orders using search text and order status.
 */
function setupOrderFilters() {
    const searchInput = document.getElementById("orderSearch");
    const statusFilter = document.getElementById("orderStatus");
    const filterButton = document.getElementById("orderFilter");

    if (!searchInput || !statusFilter || !filterButton) {
        return;
    }

    const applyFilters = () => {
        const searchText = searchInput.value
            .toLowerCase()
            .trim();

        let visibleCount = 0;

        getOrderRows().forEach(row => {
            const matchesText = row.textContent
                .toLowerCase()
                .includes(searchText);

            const matchesStatus =
                statusFilter.value === "all" ||
                row.dataset.status === statusFilter.value;

            const visible = matchesText && matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }
        });

        updateOrderCount(visibleCount);
    };

    searchInput.addEventListener("input", applyFilters);
    statusFilter.addEventListener("change", applyFilters);
    filterButton.addEventListener("click", applyFilters);
}

/**
 * Clear every order filter.
 */
function setupOrderReset() {
    const resetButton = document.getElementById("orderReset");

    if (!resetButton) {
        return;
    }

    resetButton.addEventListener("click", () => {
        const searchInput = document.getElementById("orderSearch");
        const statusFilter = document.getElementById("orderStatus");
        const dateInput = document.getElementById("orderDate");

        if (searchInput) {
            searchInput.value = "";
        }

        if (statusFilter) {
            statusFilter.value = "all";
        }

        if (dateInput) {
            dateInput.value = "";
        }

        getOrderRows().forEach(row => {
            row.hidden = false;
        });

        updateOrderCount(getOrderRows().length);
    });
}

/**
 * Export visible order records as a CSV file.
 */
function setupOrderExport() {
    const exportButton = document.getElementById("exportOrders");

    if (!exportButton) {
        return;
    }

    exportButton.addEventListener("click", () => {
        const visibleRows = getOrderRows()
            .filter(row => !row.hidden);

        if (!visibleRows.length) {
            alert("There are no orders to export.");
            return;
        }

        const headings = [
            "Order ID",
            "Date",
            "Customer and Patient",
            "Total Amount",
            "Status"
        ];

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
        link.download = "happypaws-orders.csv";

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);
    });
}

/**
 * Connect View and Delete buttons to order rows.
 */
function setupOrderActions() {
    document.querySelectorAll(".view-order")
        .forEach(button => {
            button.addEventListener("click", () => {
                alert(`${getOrderId(button)} selected.`);
            });
        });

    document.querySelectorAll(".delete-order")
        .forEach(button => {
            button.addEventListener("click", () => {
                const orderId = getOrderId(button);

                const confirmed = confirm(
                    `Are you sure you want to delete ${orderId}?`
                );

                if (!confirmed) {
                    return;
                }

                button.closest("tr").remove();

                const visibleCount = getOrderRows()
                    .filter(row => !row.hidden)
                    .length;

                updateOrderCount(visibleCount);
            });
        });
}

/**
 * Change the active pagination button.
 */
function setupOrderPagination() {
    const buttons = document.querySelectorAll(
        "#orderPages button:not([disabled])"
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
 * Return the ID of an order belonging to an action button.
 */
function getOrderId(button) {
    const row = button.closest("tr");

    return row
        ? row.cells[0].textContent.trim()
        : "this order";
}

/**
 * Update the number of displayed orders.
 */
function updateOrderCount(count) {
    const countElement = document.getElementById("orderCount");

    if (countElement) {
        countElement.textContent =
            `Showing ${count} matching orders`;
    }
}