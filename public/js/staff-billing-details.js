document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Billing Details loaded.");


    // --------------------------------------------------
    // Payment method selection
    // --------------------------------------------------

    const paymentOptions =
        document.querySelectorAll(
            ".payment-method, .payment-option"
        );


    paymentOptions.forEach(function (option) {

        option.addEventListener("click", function () {

            paymentOptions.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");

        });

    });


    // --------------------------------------------------
    // Print invoice
    // --------------------------------------------------

    const printButton =
        document.querySelector(
            ".print-button, .print-invoice"
        );


    if (printButton) {

        printButton.addEventListener("click", function () {

            window.print();

        });

    }


    // --------------------------------------------------
    // Preview PDF
    // --------------------------------------------------

    const previewButton =
        document.querySelector(
            ".preview-pdf, .preview-button"
        );


    if (previewButton) {

        previewButton.addEventListener("click", function () {

            alert("Invoice preview will be available here.");

        });

    }


    // --------------------------------------------------
    // Cancel transaction
    // --------------------------------------------------

    const cancelButton =
        document.querySelector(
            ".cancel-button, .cancel-transaction"
        );


    if (cancelButton) {

        cancelButton.addEventListener("click", function () {

            const confirmed =
                confirm(
                    "Are you sure you want to cancel this transaction?"
                );


            if (confirmed) {

                window.history.back();

            }

        });

    }

});