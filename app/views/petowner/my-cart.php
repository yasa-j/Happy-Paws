
<?php
$escape = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

$cartItems = $cartItems ?? [];
$cartMessage = $_SESSION['cart_message'] ?? '';
unset($_SESSION['cart_message']);

$itemCount = 0;
$subtotal = 0;

foreach ($cartItems as $item) {
    $itemCount += (int)$item->quantity;
    $subtotal += (float)$item->price * (int)$item->quantity;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Cart - Happy Paws</title>

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/my-cart.css">
</head>

<body>

<?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>

<main class="petowner-main">

    <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>

    <div class="my-cart-content">

        <div class="cart-breadcrumb">
            PET OWNER PORTAL &nbsp; • &nbsp; PRODUCT STORE
            &nbsp; • &nbsp; YOUR SHOPPING CART
        </div>

        <section class="cart-heading">
            <div class="cart-heading-icon">🛒</div>

            <div>
                <h1>My Cart</h1>
                <p>Review your pet essentials before reserving them
                   for pickup at Happy Paws Clinic.</p>
            </div>

            <div class="cart-pickup-label">
                <strong>CLINIC PICKUP</strong>
                <span>Pay at the dispensary counter</span>
            </div>
        </section>

        <?php if ($cartMessage !== ''): ?>
            <div class="cart-message" role="status">
                <?php echo $escape($cartMessage); ?>
            </div>
        <?php endif; ?>

        <div class="cart-layout">

            <section class="cart-items-panel">

                <h2>Your Items
                    <span>(<?php echo $itemCount; ?> items)</span>
                </h2>

                <?php if (empty($cartItems)): ?>

                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <h3>Your cart is waiting for some goodies!</h3>
                        <p>Browse our clinic products and find something
                           for your pet.</p>

                        <a href="<?php echo URLROOT; ?>/petowner/store"
                           class="cart-primary-button">
                            Browse Products
                        </a>
                    </div>

                <?php else: ?>

                    <?php foreach ($cartItems as $item): ?>

                        <?php
                        $imagePath = trim((string)$item->image_url);

                        if ($imagePath !== '' &&
                            !preg_match('~^https?://~i', $imagePath) &&
                            strpos($imagePath, '/') !== 0) {
                            $imagePath = URLROOT . '/' . ltrim($imagePath, '/');
                        }

                        $quantity = (int)$item->quantity;
                        $price = (float)$item->price;
                        $lineTotal = $price * $quantity;

                        $available = $item->status === 'In Stock'
                            && (int)$item->stock_quantity > 0;
                        ?>

                        <article class="cart-item">

                            <div class="cart-product-image">
                                <?php if ($imagePath !== ''): ?>
                                    <img
                                        src="<?php echo $escape($imagePath); ?>"
                                        alt="<?php echo $escape($item->name); ?>"
                                        onerror="this.style.display='none';">
                                <?php else: ?>
                                    <span>🐾</span>
                                <?php endif; ?>
                            </div>

                            <div class="cart-product-details">

                                <span class="cart-category">
                                    <?php echo $escape($item->category_name); ?>
                                </span>

                                <h3><?php echo $escape($item->name); ?></h3>

                                <p class="cart-description">
                                    <?php echo $escape($item->description ?? ''); ?>
                                </p>

                                <?php if (!$available): ?>
                                    <span class="cart-stock-warning">
                                        Currently unavailable
                                    </span>
                                <?php endif; ?>

                            </div>

                            <div class="cart-price">
                                <span>Price (each)</span>
                                <strong>
                                    Rs. <?php echo number_format($price, 2); ?>
                                </strong>
                            </div>

                            <div class="cart-quantity">
                                <span>Quantity</span>

                                <form method="POST"
                                      action="<?php echo URLROOT; ?>/petowner/updateCartQuantity"
                                      class="cart-quantity-form">

                                    <input type="hidden"
                                           name="cart_item_id"
                                           value="<?php echo (int)$item->cart_item_id; ?>">

                                    <button type="button"
                                            class="quantity-change"
                                            data-step="-1"
                                            aria-label="Decrease quantity"
                                            <?php echo $quantity <= 1 ? 'disabled' : ''; ?>>
                                        −
                                    </button>

                                    <input type="number"
                                           name="quantity"
                                           class="cart-quantity-input"
                                           value="<?php echo $quantity; ?>"
                                           min="1"
                                           max="<?php echo (int)$item->stock_quantity; ?>"
                                           aria-label="Quantity for <?php echo $escape($item->name); ?>"
                                           required>

                                    <button type="button"
                                            class="quantity-change"
                                            data-step="1"
                                            aria-label="Increase quantity"
                                            <?php echo $quantity >= (int)$item->stock_quantity ? 'disabled' : ''; ?>>
                                        +
                                    </button>
                                </form>
                            </div>

                            <div class="cart-line-total">
                                <span>Total</span>
                                <strong>
                                    Rs. <?php echo number_format($lineTotal, 2); ?>
                                </strong>
                            </div>

                            <form method="POST"
                                  action="<?php echo URLROOT; ?>/petowner/removeCartItem"
                                  class="cart-remove-form"
                                  onsubmit="return confirm('Remove this product from your cart?');">

                                <input type="hidden"
                                       name="cart_item_id"
                                       value="<?php echo (int)$item->cart_item_id; ?>">

                                <button type="submit"
                                        class="cart-remove-button"
                                        aria-label="Remove <?php echo $escape($item->name); ?>">
                                    🗑
                                </button>
                            </form>

                        </article>

                    <?php endforeach; ?>

                <?php endif; ?>

                <?php if (!empty($cartItems)): ?>
                    <div class="cart-policy">
                        <span>🛡</span>
                        Items are reserved for clinic pickup only after
                        you confirm your reservation. Payment is made
                        when you collect your order.
                    </div>
                <?php endif; ?>

            </section>

            <aside class="cart-summary-column">

                <section class="cart-summary-panel">

                    <h2>Reservation Summary</h2>

                    <div class="summary-row">
                        <span>Subtotal (<?php echo $itemCount; ?> items)</span>
                        <strong>Rs. <?php echo number_format($subtotal, 2); ?></strong>
                    </div>

                    <div class="summary-row">
                        <span>Pickup fee</span>
                        <span class="free-label">FREE</span>
                    </div>

                    <div class="summary-total">
                        <strong>Total to pay at clinic</strong>
                        <strong>Rs. <?php echo number_format($subtotal, 2); ?></strong>
                    </div>

                    <button type="button"
                            class="cart-primary-button"
                            id="reserveItemsButton"
                            <?php echo empty($cartItems) ? 'disabled' : ''; ?>>
                        ▣ &nbsp; Reserve Items
                    </button>

                    <a href="<?php echo URLROOT; ?>/petowner/store"
                       class="cart-secondary-button">
                        ← &nbsp; Continue Shopping
                    </a>

                    <div class="cart-payment-note">
                        <strong>🛡 &nbsp; No online payment required</strong>
                        <p>Pay at the clinic dispensary counter when
                           you collect your reserved items.</p>
                    </div>

                </section>

                <section class="cart-visit-card">
                    <span class="cart-visit-icon">▣</span>
                    <div>
                        <h3>Need it for your next visit?</h3>
                        <p>Reserve now and collect during your next
                           appointment.</p>
                    </div>
                </section>

            </aside>

        </div>

        <footer class="cart-footer">
            <div>
                <strong>🚚 Secure clinic pickup</strong>
                <p>Your items are prepared for collection at the clinic.</p>
            </div>

            <div>
                <strong>🛡 Prescription items checked by our team</strong>
                <p>Our clinic team verifies prescription products.</p>
            </div>

            <div>
                <strong>☎ Questions? Contact Happy Paws</strong>
                <p>Ask our team about product availability.</p>
            </div>
        </footer>

    </div>

</main>

<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>
<script src="<?php echo URLROOT; ?>/js/my-cart.js"></script>

</body>
</html>
