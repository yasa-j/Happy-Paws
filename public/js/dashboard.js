"use strict";

/**
 * HappyPaws Dashboard
 * Handles the sales chart, order searching, chart tabs,
 * and summary exporting.
 */

document.addEventListener("DOMContentLoaded", () => {
    drawSalesChart();
    setupDashboardSearch();
    setupChartTabs();
    setupExportButton();
});

/**
 * Draw the sales overview using the SVG elements
 * included in the Dashboard PHP view.
 */
function drawSalesChart() {
    const chart = document.getElementById("salesChart");
    const chartLine = document.getElementById("chartLine");
    const chartFill = document.getElementById("chartFill");
    const chartDots = document.getElementById("chartDots");
    const chartLabels = document.getElementById("chartLabels");

    if (!chart || !chartLine || !chartFill || !chartDots || !chartLabels) {
        return;
    }

    let sales = [];

    try {
        sales = JSON.parse(chart.dataset.sales || "[]");
    } catch (error) {
        console.error("Unable to read dashboard sales data.", error);
        return;
    }

    if (!sales.length) {
        return;
    }

    const amounts = sales.map(item => Number(item.amount) || 0);
    const maximumAmount = Math.max(...amounts, 1);

    const left = 25;
    const right = 675;
    const top = 18;
    const bottom = 205;

    const step = sales.length > 1
        ? (right - left) / (sales.length - 1)
        : 0;

    const points = sales.map((item, index) => {
        const x = left + (step * index);
        const y = bottom -
            ((Number(item.amount) / maximumAmount) * (bottom - top));

        return {
            x: x,
            y: y,
            day: item.day
        };
    });

    const pointText = points
        .map(point => `${point.x},${point.y}`)
        .join(" ");

    chartLine.setAttribute("points", pointText);

    chartFill.setAttribute(
        "points",
        `${pointText} ${right},${bottom} ${left},${bottom}`
    );

    chartDots.innerHTML = points.map(point => `
        <circle
            cx="${point.x}"
            cy="${point.y}"
            r="5"
            fill="#ffffff"
            stroke="#0f766e"
            stroke-width="3">
        </circle>
    `).join("");

    chartLabels.innerHTML = sales
        .map(item => `<span>${item.day}</span>`)
        .join("");
}

/**
 * Filter recent orders using the global dashboard search box.
 */
function setupDashboardSearch() {
    const searchInput = document.getElementById("dashboardSearch");
    const rows = document.querySelectorAll("#ordersTable tbody tr");

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener("input", event => {
        const searchText = event.target.value
            .toLowerCase()
            .trim();

        rows.forEach(row => {
            const matches = row.textContent
                .toLowerCase()
                .includes(searchText);

            row.style.display = matches ? "" : "none";
        });
    });
}

/**
 * Change the active chart period button.
 */
function setupChartTabs() {
    const buttons = document.querySelectorAll(".chart-tabs button");

    buttons.forEach(button => {
        button.addEventListener("click", () => {
            buttons.forEach(item => item.classList.remove("active"));
            button.classList.add("active");
        });
    });
}

/**
 * Open the browser print dialog for exporting the dashboard summary.
 */
function setupExportButton() {
    const exportButton = document.getElementById("exportButton");

    if (exportButton) {
        exportButton.addEventListener("click", () => {
            window.print();
        });
    }
}