
document.addEventListener("DOMContentLoaded", function () {
    const quantityButtons = document.querySelectorAll(".quantity-change");
    const quantityInputs = document.querySelectorAll(".cart-quantity-input");
    const reserveButton = document.getElementById("reserveItemsButton");

    quantityButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            const form = button.closest(".cart-quantity-form");
            if (!form) return;

            const input = form.querySelector(".cart-quantity-input");
            const min = Number(input.min) || 1;
            const max = Number(input.max) || 999999;
            const step = Number(button.dataset.step) || 0;

            let quantity = Number(input.value) || min;
            quantity = Math.max(min, Math.min(max, quantity + step));

            input.value = quantity;
            form.requestSubmit();
        });
    });

    quantityInputs.forEach(function (input) {
        input.addEventListener("change", function () {
            const min = Number(input.min) || 1;
            const max = Number(input.max) || 999999;

            let quantity = Number(input.value) || min;
            quantity = Math.max(min, Math.min(max, quantity));
            input.value = quantity;

            input.form.requestSubmit();
        });
    });

    if (reserveButton) {
        reserveButton.addEventListener("click", function () {
            alert(
                "The reservation workflow has not been connected yet. " +
                "Your cart items are still saved."
            );
        });
    }
});
