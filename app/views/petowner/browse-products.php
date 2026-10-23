
<?php
$escape = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

$selectedCategoryName = 'All Categories';

foreach ($categories as $category) {
    if ((string)$category->category_id === (string)$selectedCategory) {
        $selectedCategoryName = $category->category_name;
        break;
    }
}

$categoryTabs = array_slice($categories, 0, 7);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Products - Happy Paws</title>

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/browse-products.css">
    
    <link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/browse-products-modal.css">

</head>

<body>

    <?php
    require_once APPROOT . '/views/layouts/petowner-sidebar.php';
    ?>

    <main class="petowner-main">

        <?php
        require_once APPROOT . '/views/layouts/petowner-topbar.php';
        ?>

        <div class="browse-products-content">

            <!-- Page heading -->
            <section class="store-heading">
                <p class="store-eyebrow">
                    <span aria-hidden="true">✚</span>
                    VERIFIED CLINIC DISPENSARY &amp; RETAIL
                </p>

                <h1>Product Store</h1>

                <p class="store-subtitle">
                    Browse pet-care products and reserve what your pet
                    needs for convenient clinic pickup.
                </p>
            </section>

            <!-- Clinic pickup information -->
            <section class="pickup-banner">

                <div class="pickup-icon" aria-hidden="true">
                    <span>▤</span>
                </div>

                <div class="pickup-description">
                    <div class="pickup-title-row">
                        <h2>Clinic Pickup Available</h2>
                        <span class="pickup-badge">
                            ZERO ONLINE PREPAYMENT
                        </span>
                    </div>

                    <p>
                        Add products to your cart and reserve them for
                        collection during your visit to Happy Paws.
                        No online payment is required.
                    </p>
                </div>

                <div class="clinic-hours">
                    <span>Clinic Hours</span>
                    <strong>Mon–Sat: 8:00 AM – 7:00 PM</strong>
                </div>

            </section>

            <!-- Search and filters -->
            <form method="GET"
                  action="<?php echo URLROOT; ?>/petowner/store"
                  class="product-filter-form"
                  id="productFilterForm">

                <div class="search-box">
                    <span aria-hidden="true">⌕</span>

                    <input type="search"
                           name="search"
                           value="<?php echo $escape($search); ?>"
                           placeholder="Search products (e.g. dog food, shampoo, dental treats)..."
                           aria-label="Search products">
                </div>

                <select name="category"
                        aria-label="Filter by category"
                        id="categorySelect">

                    <option value="">All Categories</option>

                    <?php foreach ($categories as $category): ?>
                        <option
                            value="<?php echo (int)$category->category_id; ?>"
                            <?php echo (
                                (string)$selectedCategory ===
                                (string)$category->category_id
                            ) ? 'selected' : ''; ?>>

                            <?php echo $escape($category->category_name); ?>

                        </option>
                    <?php endforeach; ?>

                </select>

                <select name="sort"
                        aria-label="Sort products"
                        id="sortSelect">

                    <option value="recommended"
                        <?php echo $sort === 'recommended' ? 'selected' : ''; ?>>
                        Sort By: Recommended
                    </option>

                    <option value="price_low"
                        <?php echo $sort === 'price_low' ? 'selected' : ''; ?>>
                        Price: Low to High
                    </option>

                    <option value="price_high"
                        <?php echo $sort === 'price_high' ? 'selected' : ''; ?>>
                        Price: High to Low
                    </option>

                    <option value="name"
                        <?php echo $sort === 'name' ? 'selected' : ''; ?>>
                        Name: A–Z
                    </option>

                </select>

                <button type="submit" class="filter-submit">
                    Apply
                </button>

            </form>

            <!-- Category tabs -->
            <nav class="category-tabs" aria-label="Product categories">

                <a class="category-tab <?php echo $selectedCategory === '' ? 'active' : ''; ?>"
                   href="<?php echo URLROOT; ?>/petowner/store">

                    All Products
                </a>

                <?php foreach ($categoryTabs as $category): ?>

                    <a class="category-tab
                        <?php echo (
                            (string)$selectedCategory ===
                            (string)$category->category_id
                        ) ? 'active' : ''; ?>"
                       href="<?php echo URLROOT; ?>/petowner/store?category=<?php echo (int)$category->category_id; ?>">

                        <?php echo $escape($category->category_name); ?>

                    </a>

                <?php endforeach; ?>

            </nav>

            <!-- Feedback message -->
            <?php if (!empty($message)): ?>
                <div class="store-message" role="status">
                    <?php echo $escape($message); ?>
                </div>
            <?php endif; ?>

            <!-- Product count -->
            <div class="product-results-heading">
                <p>
                    <?php echo count($products); ?>
                    product<?php echo count($products) === 1 ? '' : 's'; ?> found
                </p>

                <a href="<?php echo URLROOT; ?>/cart"
                   class="view-cart-link">
                    🛒 View Cart
                    <?php if ($cartCount > 0): ?>
                        <span><?php echo (int)$cartCount; ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Product cards -->
            <section class="product-grid">

                <?php if (!empty($products)): ?>

                    <?php foreach ($products as $product): ?>

                        <?php
                        $stock = (int)$product->stock_quantity;
                        $lowStock = $stock > 0 &&
                            $stock <= (int)$product->reorder_level;

                        $imagePath = trim((string)$product->image_url);

                        if ($imagePath === '') {
                            $imagePath = URLROOT . '/Assets/product-placeholder.png';
                        } elseif (
                            !preg_match('~^https?://~i', $imagePath) &&
                            strpos($imagePath, '/') !== 0
                        ) {
                            $imagePath = URLROOT . '/' . ltrim($imagePath, '/');
                        }

                        $available = $stock > 0 &&
                            $product->status === 'In Stock';
                        ?>

                        <article
                            class="product-card product-quick-view-trigger"
                            tabindex="0"
                            role="button"
                            aria-label="View details for <?php echo $escape($product->name); ?>"
                            data-product-id="<?php echo (int)$product->product_id; ?>"
                            data-name="<?php echo $escape($product->name); ?>"
                            data-description="<?php echo $escape($product->description); ?>"
                            data-category="<?php echo $escape($product->category_name); ?>"
                            data-price="<?php echo number_format((float)$product->price, 2, '.', ''); ?>"
                            data-image="<?php echo $escape($imagePath); ?>"
                            data-stock="<?php echo $stock; ?>"
                            data-available="<?php echo $available ? '1' : '0'; ?>"
                        >

                            <div class="product-image-area">

                                <span class="product-category-badge">
                                    <?php echo $escape($product->category_name); ?>
                                </span>

                                <?php if ($imagePath !== ''): ?>
                                    <img
                                        class="product-image"
                                        src="<?php echo $escape($imagePath); ?>"
                                        alt="<?php echo $escape($product->name); ?>"
                                        loading="lazy"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                                    <div class="product-image-fallback">
                                        <span>🐾</span>
                                        <span>Happy Paws</span>
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="product-card-body">

                                <div class="product-stock-row">

                                    <?php if (!$available): ?>

                                        <span class="stock-status unavailable">
                                            <span class="stock-dot"></span>
                                            Out of Stock
                                        </span>

                                    <?php elseif ($lowStock): ?>

                                        <span class="stock-status low-stock">
                                            <span class="stock-dot"></span>
                                            Low Stock (<?php echo $stock; ?> left)
                                        </span>

                                    <?php else: ?>

                                        <span class="stock-status available">
                                            <span class="stock-dot"></span>
                                            In Stock at Clinic
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <h2 class="product-name">
                                    <?php echo $escape($product->name); ?>
                                </h2>

                                <p class="product-description">
                                    <?php echo $escape($product->description); ?>
                                </p>

                                <div class="product-card-footer">

                                    <div class="product-price">
                                        <span>CLINIC PRICE</span>

                                        <strong>
                                            Rs. <?php echo number_format((float)$product->price, 2); ?>
                                        </strong>
                                    </div>

                                    <?php if ($available): ?>

                                        <form method="POST"
                                              action="<?php echo URLROOT; ?>/petowner/addToCart"
                                              class="add-to-cart-form">

                                            <input type="hidden"
                                                   name="product_id"
                                                   value="<?php echo (int)$product->product_id; ?>">

                                            <button type="submit"
                                                    class="add-to-cart-button">

                                                <span aria-hidden="true">🛒</span>
                                                Add to Cart

                                            </button>

                                        </form>

                                    <?php else: ?>

                                        <button type="button"
                                                class="add-to-cart-button disabled"
                                                disabled>
                                            Unavailable
                                        </button>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </article>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="no-products">
                        <div class="no-products-icon">🐾</div>
                        <h2>No products found</h2>

                        <p>
                            Try another search term or select a different category.
                        </p>

                        <a href="<?php echo URLROOT; ?>/petowner/store">
                            Browse All Products
                        </a>
                    </div>

                <?php endif; ?>

            </section>

            <!-- Product Quick View Modal -->
            <div
                class="product-modal-overlay"
                id="productQuickView"
                aria-hidden="true"
            >
                <div
                    class="product-modal"
                    role="dialog"
                    aria-modal="true"
                    aria-labelledby="quickViewName"
                >
                    <button
                        type="button"
                        class="product-modal-close"
                        id="closeProductModal"
                        aria-label="Close product details"
                    >&times;</button>

                    <div class="product-modal-image-wrap">
                        <img id="quickViewImage" src="" alt="">
                        <div id="quickViewImageFallback" class="quick-image-fallback">
                            🐾 Happy Paws
                        </div>
                    </div>

                    <div class="product-modal-details">
                        <span id="quickViewCategory" class="quick-view-category"></span>

                        <h2 id="quickViewName"></h2>

                        <p id="quickViewDescription"></p>

                        <div id="quickViewStock" class="quick-view-stock"></div>

                        <div class="quick-view-price">
                            <span>CLINIC PRICE</span>
                            <strong id="quickViewPrice"></strong>
                        </div>

                        <label for="quickViewQuantity">Quantity</label>
                        <div class="quick-quantity-control">
                            <button type="button" id="quantityMinus" aria-label="Decrease quantity">−</button>
                            <input
                                type="number"
                                id="quickViewQuantity"
                                value="1"
                                min="1"
                                max="1"
                                inputmode="numeric"
                            >
                            <button type="button" id="quantityPlus" aria-label="Increase quantity">+</button>
                        </div>

                        <div class="quick-view-actions">
                            <form
                                method="POST"
                                action="<?php echo URLROOT; ?>/petowner/addProductToCart"
                                id="quickAddToCartForm"
                            >
                                <input type="hidden" name="product_id" id="cartProductId">
                                <input type="hidden" name="quantity" id="cartQuantity" value="1">

                                <button type="submit" id="quickAddToCart" class="quick-cart-button">
                                    🛒 Add to Cart
                                </button>
                            </form>

                            <form
                                method="POST"
                                action="<?php echo URLROOT; ?>/petowner/reserveProduct"
                                id="quickReserveForm"
                            >
                                <input type="hidden" name="product_id" id="reserveProductId">
                                <input type="hidden" name="quantity" id="reserveQuantity" value="1">

                                <button type="submit" id="quickReserve" class="quick-reserve-button">
                                    Reserve Product
                                </button>
                            </form>
                        </div>

                        <p class="quick-view-note">
                            Reserved products are collected at the Happy Paws clinic.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Pickup policy -->
            <footer class="store-footer">
                All reserved products are kept safely at the Happy Paws
                clinic reception counter for up to 24 hours after a
                reservation is confirmed. Product availability and pricing
                are subject to clinic stock verification.
            </footer>

        </div>

    </main>
    
    <script src="<?php echo URLROOT; ?>/js/petowner.js"></script>
    <script src="<?php echo URLROOT; ?>/js/browse-products.js"></script>
    <script src="<?php echo URLROOT; ?>/js/browse-products-modal.js"></script>

</body>
</html>
