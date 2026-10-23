
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".product-quick-view-trigger");

    const modal = document.getElementById("productQuickView");
    const closeButton = document.getElementById("closeProductModal");

    const image = document.getElementById("quickViewImage");
    const imageFallback = document.getElementById("quickViewImageFallback");
    const name = document.getElementById("quickViewName");
    const description = document.getElementById("quickViewDescription");
    const category = document.getElementById("quickViewCategory");
    const price = document.getElementById("quickViewPrice");
    const stock = document.getElementById("quickViewStock");

    const quantityInput = document.getElementById("quickViewQuantity");
    const minusButton = document.getElementById("quantityMinus");
    const plusButton = document.getElementById("quantityPlus");

    const cartProductId = document.getElementById("cartProductId");
    const cartQuantity = document.getElementById("cartQuantity");
    const reserveProductId = document.getElementById("reserveProductId");
    const reserveQuantity = document.getElementById("reserveQuantity");

    const addToCartButton = document.getElementById("quickAddToCart");
    const reserveButton = document.getElementById("quickReserve");

    if (!modal || !closeButton) {
        console.error("Product quick-view modal or close button was not found.");
        return;
    }

    // Wait this long before opening the popup on hover.
    const HOVER_DELAY = 700;

    let hoverTimer = null;
    let activeCard = null;
    let popupOpen = false;

    function cancelHoverTimer() {
        if (hoverTimer !== null) {
            clearTimeout(hoverTimer);
            hoverTimer = null;
        }
    }

    function openProductModal(card) {
        if (!card) return;

        activeCard = card;

        const productId = card.dataset.productId || "";
        const productName = card.dataset.name || "Product";
        const productDescription = card.dataset.description || "No description available.";
        const productCategory = card.dataset.category || "";
        const productPrice = Number(card.dataset.price || 0);
        const productImage = card.dataset.image || "";
        const productStock = Math.max(0, parseInt(card.dataset.stock || "0", 10));
        const isAvailable = card.dataset.available === "1";

        name.textContent = productName;
        description.textContent = productDescription;
        category.textContent = productCategory;
        price.textContent = "Rs. " + productPrice.toFixed(2);

        stock.textContent = isAvailable
            ? productStock + " available"
            : "Currently unavailable";

        stock.classList.toggle("out-of-stock", !isAvailable);

        // Display the product image or the fallback.
        imageFallback.style.display = "none";
        image.style.display = "block";
        image.alt = productName;
        image.onerror = function () {
            image.style.display = "none";
            imageFallback.style.display = "flex";
        };

        if (productImage) {
            image.src = productImage;
        } else {
            image.style.display = "none";
            imageFallback.style.display = "flex";
        }

        // Keep quantity within the available stock.
        quantityInput.min = "1";
        quantityInput.max = String(Math.max(1, productStock));
        quantityInput.value = "1";
        quantityInput.disabled = !isAvailable;

        cartProductId.value = productId;
        reserveProductId.value = productId;
        updateQuantity();

        addToCartButton.disabled = !isAvailable;
        reserveButton.disabled = !isAvailable;

        modal.classList.add("is-open");
        modal.setAttribute("aria-hidden", "false");
        document.body.classList.add("product-modal-open");

        popupOpen = true;
    }

    function closeProductModal() {
        cancelHoverTimer();

        modal.classList.remove("is-open");
        modal.setAttribute("aria-hidden", "true");
        document.body.classList.remove("product-modal-open");

        popupOpen = false;
        activeCard = null;
    }

    function updateQuantity() {
        let quantity = parseInt(quantityInput.value, 10) || 1;
        const maxQuantity = parseInt(quantityInput.max, 10) || 1;

        quantity = Math.max(1, Math.min(quantity, maxQuantity));
        quantityInput.value = String(quantity);

        cartQuantity.value = String(quantity);
        reserveQuantity.value = String(quantity);
    }

    // Hover: open only after the cursor stays on a card.
    cards.forEach(function (card) {
        card.addEventListener("mouseenter", function () {
            // Do not open another popup while one is already open.
            if (popupOpen) return;

            cancelHoverTimer();

            hoverTimer = setTimeout(function () {
                openProductModal(card);
                hoverTimer = null;
            }, HOVER_DELAY);
        });

        card.addEventListener("mouseleave", function () {
            cancelHoverTimer();
        });

        // Keyboard access: Enter or Space opens the selected product.
        card.addEventListener("keydown", function (event) {
            if (event.key === "Enter" || event.key === " ") {
                event.preventDefault();
                cancelHoverTimer();
                openProductModal(card);
            }
        });

        // Click opens the product immediately.
        card.addEventListener("click", function (event) {
            if (event.target.closest("button, a, input, form")) return;

            if (!popupOpen) {
                cancelHoverTimer();
                openProductModal(card);
            }
        });
    });

    // Close button.
    closeButton.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();
        closeProductModal();
    });

    // Clicking the dark background closes the popup.
    modal.addEventListener("click", function (event) {
        if (event.target === modal) {
            closeProductModal();
        }
    });

    // Escape closes the popup.
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && popupOpen) {
            closeProductModal();
        }
    });

    // Quantity controls.
    minusButton.addEventListener("click", function () {
        quantityInput.value = (parseInt(quantityInput.value, 10) || 1) - 1;
        updateQuantity();
    });

    plusButton.addEventListener("click", function () {
        quantityInput.value = (parseInt(quantityInput.value, 10) || 1) + 1;
        updateQuantity();
    });

    quantityInput.addEventListener("change", updateQuantity);
    quantityInput.addEventListener("input", updateQuantity);

    // Keep the quantity correct before submitting either form.
    document.getElementById("quickAddToCartForm")
        ?.addEventListener("submit", updateQuantity);

    document.getElementById("quickReserveForm")
        ?.addEventListener("submit", updateQuantity);
});
