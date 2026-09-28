"use strict";

/**
 * HappyPaws Reports
 * Draws the sales chart and handles report period,
 * generation, CSV export, and printing.
 */

document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById("salesChart");
    const periodButtons =
        document.querySelectorAll(".period-tabs button");
    const dateRange = document.getElementById("dateRange");
    const generateButton =
        document.getElementById("generateReport");
    const exportButton =
        document.getElementById("exportReport");
    const printButton =
        document.getElementById("printSummary");
    const toast = document.getElementById("toast");

    const reportData = window.reportData || {
        labels: [],
        current: [],
        previous: []
    };

    let toastTimer;

    /**
     * Display a temporary report feedback message.
     */
    function showReportToast(message) {
        if (!toast) {
            alert(message);
            return;
        }

        clearTimeout(toastTimer);

        toast.textContent = message;
        toast.classList.add("show");

        toastTimer = setTimeout(() => {
            toast.classList.remove("show");
        }, 2600);
    }

    /**
     * Draw the sales chart using the Canvas API.
     */
    function drawSalesChart() {
        if (!canvas) {
            return;
        }

        const context = canvas.getContext("2d");

        if (!context) {
            return;
        }

        const ratio = window.devicePixelRatio || 1;
        const width = canvas.clientWidth;
        const height = canvas.clientHeight;

        const padding = {
            top: 18,
            right: 18,
            bottom: 35,
            left: 42
        };

        const allValues = [
            ...reportData.current,
            ...reportData.previous
        ].map(Number);

        const maximum = Math.max(...allValues, 8000);

        canvas.width = width * ratio;
        canvas.height = height * ratio;

        context.setTransform(
            ratio,
            0,
            0,
            ratio,
            0,
            0
        );

        context.clearRect(0, 0, width, height);

        const plotWidth =
            width - padding.left - padding.right;

        const plotHeight =
            height - padding.top - padding.bottom;

        const calculateX = index => {
            const numberOfSpaces =
                Math.max(reportData.labels.length - 1, 1);

            return padding.left +
                (plotWidth * index) / numberOfSpaces;
        };

        const calculateY = value => {
            return padding.top +
                plotHeight -
                (value / maximum) * plotHeight;
        };

        /**
         * Draw chart grid lines and labels.
         */
        context.font = "10px Inter";
        context.fillStyle = "#77827f";
        context.strokeStyle = "#e6ecef";
        context.lineWidth = 1;

        for (let value = 0; value <= maximum; value += 2000) {
            context.beginPath();

            context.moveTo(
                padding.left,
                calculateY(value)
            );

            context.lineTo(
                width - padding.right,
                calculateY(value)
            );

            context.stroke();

            const label = value === 0
                ? "0"
                : `${value / 1000}K`;

            context.fillText(
                label,
                8,
                calculateY(value) + 3
            );
        }

        /**
         * Draw one sales data series.
         */
        function drawSeries(
            values,
            color,
            dashed,
            fillArea
        ) {
            if (!values.length) {
                return;
            }

            context.save();
            context.beginPath();

            values.forEach((value, index) => {
                const x = calculateX(index);
                const y = calculateY(Number(value));

                if (index === 0) {
                    context.moveTo(x, y);
                } else {
                    context.lineTo(x, y);
                }
            });

            context.strokeStyle = color;
            context.lineWidth = 2;
            context.setLineDash(dashed ? [5, 4] : []);
            context.stroke();

            if (fillArea) {
                context.lineTo(
                    calculateX(values.length - 1),
                    padding.top + plotHeight
                );

                context.lineTo(
                    calculateX(0),
                    padding.top + plotHeight
                );

                context.closePath();

                const gradient =
                    context.createLinearGradient(
                        0,
                        padding.top,
                        0,
                        padding.top + plotHeight
                    );

                gradient.addColorStop(
                    0,
                    "rgba(15, 118, 110, 0.16)"
                );

                gradient.addColorStop(
                    1,
                    "rgba(15, 118, 110, 0)"
                );

                context.fillStyle = gradient;
                context.fill();
            }

            context.restore();
        }

        drawSeries(
            reportData.previous,
            "#38bdf8",
            true,
            false
        );

        drawSeries(
            reportData.current,
            "#0f766e",
            false,
            true
        );

        /**
         * Draw day labels and current-period points.
         */
        reportData.labels.forEach((label, index) => {
            context.fillStyle = "#77827f";
            context.textAlign = "center";

            context.fillText(
                label,
                calculateX(index),
                height - 10
            );

            if (reportData.current[index] === undefined) {
                return;
            }

            context.beginPath();

            context.arc(
                calculateX(index),
                calculateY(
                    Number(reportData.current[index])
                ),
                3,
                0,
                Math.PI * 2
            );

            context.fillStyle = "#ffffff";
            context.fill();

            context.strokeStyle = "#0f766e";
            context.lineWidth = 2;
            context.stroke();
        });
    }

    /**
     * Export the sales report as a CSV file.
     */
    function exportReportCsv() {
        const records = [
            [
                "Day",
                "Current Period",
                "Previous Period"
            ]
        ];

        reportData.labels.forEach((label, index) => {
            records.push([
                label,
                reportData.current[index] || 0,
                reportData.previous[index] || 0
            ]);
        });

        const csvContent = records
            .map(record => record.join(","))
            .join("\n");

        const blob = new Blob(
            [csvContent],
            { type: "text/csv;charset=utf-8" }
        );

        const url = URL.createObjectURL(blob);
        const link = document.createElement("a");

        link.href = url;
        link.download = "happypaws-sales-report.csv";

        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);

        showReportToast("Report exported as CSV.");
    }

    periodButtons.forEach(button => {
        button.addEventListener("click", () => {
            periodButtons.forEach(item => {
                item.classList.remove("active");
            });

            button.classList.add("active");

            showReportToast(
                `${button.textContent.trim()} sales view selected.`
            );
        });
    });

    if (generateButton) {
        generateButton.addEventListener("click", () => {
            const selectedRange = dateRange
                ? dateRange.options[dateRange.selectedIndex].text
                : "the selected period";

            showReportToast(
                `Report generated for ${selectedRange}.`
            );

            drawSalesChart();
        });
    }

    if (exportButton) {
        exportButton.addEventListener(
            "click",
            exportReportCsv
        );
    }

    if (printButton) {
        printButton.addEventListener("click", () => {
            window.print();
        });
    }

    window.addEventListener(
        "resize",
        drawSalesChart
    );

    drawSalesChart();
});