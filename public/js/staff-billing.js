document.addEventListener("DOMContentLoaded", function () {


console.log("Happy Paws Staff Billing loaded.");

const tabs = document.querySelectorAll(".billing-tab, .tab-button");
const searchInput = document.querySelector(
    ".billing-search input, .search-box input"
);

const billingRows = document.querySelectorAll(
    ".billing-row, .invoice-row, .billing-table-row"
);

const dateFilterButton = document.querySelector(".date-filter-button");
const resultCount = document.querySelector(".result-count");

let activeStatus = "all";
let dateFilterEnabled = false;

// Get an invoice's status from its CSS class or status text.
function getInvoiceStatus(row) {

    const statusElement = row.querySelector(
        ".payment-status, .billing-status, .status"
    );

    const statusText = statusElement
        ? statusElement.textContent.toLowerCase().trim()
        : row.textContent.toLowerCase();

    if (statusText.includes("refunded")) return "refunded";
    if (statusText.includes("pending")) return "pending";
    if (statusText.includes("paid")) return "paid";

    return "";
}

// Read the invoice date when a date element is available.
function getInvoiceDate(row) {

    const dateElement = row.querySelector(
        ".billing-date, .invoice-date, .date"
    );

    if (dateElement) {
        const parsedDate = new Date(dateElement.textContent.trim());

        if (!isNaN(parsedDate.getTime())) {
            return parsedDate;
        }
    }

    return null;
}

// Filter invoices using the search, status, and date.
function filterInvoices() {

    const searchText = searchInput
        ? searchInput.value.toLowerCase().trim()
        : "";

    let visibleCount = 0;

    billingRows.forEach(function (row) {

        const rowText = row.textContent.toLowerCase();
        const matchesSearch = rowText.includes(searchText);

        const status = getInvoiceStatus(row);
        const matchesStatus =
            activeStatus === "all" || status === activeStatus;

        let matchesDate = true;

        if (dateFilterEnabled) {

            const invoiceDate = getInvoiceDate(row);

            if (invoiceDate) {

                const today = new Date();
                const thirtyDaysAgo = new Date();

                today.setHours(23, 59, 59, 999);
                thirtyDaysAgo.setDate(today.getDate() - 30);
                thirtyDaysAgo.setHours(0, 0, 0, 0);

                matchesDate =
                    invoiceDate >= thirtyDaysAgo &&
                    invoiceDate <= today;
            }
        }

        const shouldShow =
            matchesSearch && matchesStatus && matchesDate;

        row.style.display = shouldShow ? "" : "none";

        if (shouldShow) {
            visibleCount++;
        }

    });

    if (resultCount) {
        resultCount.textContent =
            "Showing " + visibleCount + " results";
    }
}

// Status tabs.
tabs.forEach(function (tab) {

    tab.addEventListener("click", function () {

        const label = this.textContent.toLowerCase().trim();

        if (label.includes("paid")) {
            activeStatus = "paid";
        } else if (label.includes("pending")) {
            activeStatus = "pending";
        } else if (label.includes("refunded")) {
            activeStatus = "refunded";
        } else {
            activeStatus = "all";
        }

        tabs.forEach(function (item) {
            item.classList.remove("active");
        });

        this.classList.add("active");

        filterInvoices();
    });

});

// Search invoices.
if (searchInput) {
    searchInput.addEventListener("input", filterInvoices);
}

// Toggle the date filter.
if (dateFilterButton) {

    dateFilterButton.addEventListener("click", function () {

        dateFilterEnabled = !dateFilterEnabled;

        this.classList.toggle("active", dateFilterEnabled);

        filterInvoices();
    });

}

// Initial result count.
filterInvoices();


});
