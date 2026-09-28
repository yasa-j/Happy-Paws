<?php

// Get the selected product and validation data from the controller.
$product = $data['product'] ?? null;
$errors = $data['errors'] ?? [];
$old = $data['old'] ?? [];

// Read a value from submitted data first, then from the database product.
$getValue = static function (string $field) use ($product, $old): string {
    if (array_key_exists($field, $old)) {
        return htmlspecialchars(
            (string) $old[$field],
            ENT_QUOTES,
            'UTF-8'
        );
    }

    if (is_object($product)) {
        return htmlspecialchars(
            (string) ($product->{$field} ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );
    }

    if (is_array($product)) {
        return htmlspecialchars(
            (string) ($product[$field] ?? ''),
            ENT_QUOTES,
            'UTF-8'
        );
    }

    return '';
};

// Get the product ID safely.
if (is_object($product)) {
    $productId = (int) ($product->product_id ?? 0);
} else {
    $productId = (int) ($product['product_id'] ?? 0);
}

// Get the current category and unit values.
$currentCategory = html_entity_decode($getValue('category'));
$currentUnit = html_entity_decode($getValue('unit'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Product | HappyPaws</title>

    <!-- Load the project fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Load the Manage Products and form styles -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/manage-products.css"
    >

    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/sidebar.css"
    >

    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/product-form.css"
    >
</head>

<body>

<div class="dashboard-layout">

    <!-- Main navigation sidebar -->
    <aside class="sidebar">

        <a
            class="brand"
            href="<?= URLROOT ?>/dashboard/index"
        >
            <!-- <span class="brand-icon">✚</span> -->
             <img
                class="brand-logo"
                src="<?= URLROOT ?>/images/happy_paws_logo.png"
                alt="HappyPaws Logo"
             >

            <span>
                <strong>HappyPaws</strong>
                <small>Clinic Manager</small>
            </span>
        </a>

        <p class="menu-title">MAIN MENU</p>

        <nav class="side-menu">

            <a href="<?= URLROOT ?>/dashboard/index">
                <span>▦</span>
                Dashboard
            </a>

            <a href="<?= URLROOT ?>/products/index">
                <span>▣</span>
                Products
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/manage-products/index"
            >
                <span>▤</span>
                Manage Products
            </a>

            <a href="<?= URLROOT ?>/orders/index">
                <span>▧</span>
                Orders
            </a>

            <a href="<?= URLROOT ?>/low-stock-alerts/index">
                <span>△</span>
                Low Stock Alerts
                <i></i>
            </a>

            <a href="<?= URLROOT ?>/reports/index">
                <span>▥</span>
                Reports
            </a>

        </nav>

        <nav class="side-footer">

            <a href="#">
                <span>◎</span>
                Profile
            </a>

            <a href="#">
                <span>⚙</span>
                Settings
            </a>

        </nav>

    </aside>

    <!-- Main page content -->
    <main class="main-content">

        <!-- Top navigation bar -->
        <header class="topbar">

            <label class="search-box">
                <span>⌕</span>

                <input
                    type="search"
                    placeholder="Search products, orders, or pets..."
                >
            </label>

            <div class="top-actions">

                <button
                    type="button"
                    aria-label="Notifications"
                >
                    ♧
                </button>

                <button
                    type="button"
                    aria-label="Help"
                >
                    ?
                </button>

                <div class="profile">

                    <span class="avatar">SW</span>

                    <div>
                        <strong>Sarah Wilson</strong>
                        
                    </div>

                </div>

            </div>

        </header>

        <!-- Edit Product page -->
        <section class="product-form-page">

            <div class="form-page-heading">

                <div>
                    <p class="form-breadcrumb">
                        HAPPYPAWS INVENTORY / EDIT PRODUCT
                    </p>

                    <h1>Edit Product</h1>

                    <p class="form-page-description">
                        Update the selected product information.
                    </p>
                </div>

                <a
                    class="back-button"
                    href="<?= URLROOT ?>/manage-products/index"
                >
                    ← Back to Products
                </a>

            </div>

            <!-- Display validation errors -->
            <?php if (!empty($errors)): ?>

                <div class="form-alert">

                    <strong>
                        Please correct the following errors:
                    </strong>

                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li>
                                <?= htmlspecialchars(
                                    (string) $error,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                </div>

            <?php endif; ?>

            <!-- Send the updated product data to the controller -->
            <form
                class="product-form-card"
                action="<?= URLROOT ?>/manage-products/update/<?= $productId ?>"
                method="POST"
            >

                <!-- Store the product ID inside the form -->
                <input
                    type="hidden"
                    name="product_id"
                    value="<?= $productId ?>"
                >

                <!-- Basic product information section -->
                <section class="form-section">

                    <div class="form-section-heading">

                        <span class="form-section-icon">1</span>

                        <div>
                            <h2>Basic Information</h2>

                            <p>
                                Update the product identification details.
                            </p>
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">

                            <label for="sku">
                                SKU / Product Code
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="sku"
                                name="sku"
                                value="<?= $getValue('sku') ?>"
                                placeholder="Example:  PRD-00000X"
                                required
                            >

                        </div>

                        <div class="form-field">

                            <label for="product_name">
                                Product Name
                                <span class="required">*</span>
                            </label>

                            <input
                                type="text"
                                id="product_name"
                                name="product_name"
                                value="<?= $getValue('product_name') ?>"
                                placeholder="Enter the product name"
                                required
                            >

                        </div>

                        <div class="form-field">

                            <label for="category">
                                Category
                                <span class="required">*</span>
                            </label>

                            <select
                                id="category"
                                name="category"
                                required
                            >
                                <option value="">
                                    Select a category
                                </option>

                                <?php
                                $categories = [
                                    'Food',
                                    'Medicine',
                                    'Grooming',
                                    'Accessories',
                                    'Toys'
                                    
                                ];
                                ?>

                                <?php foreach ($categories as $category): ?>

                                    <option
                                        value="<?= htmlspecialchars($category) ?>"
                                        <?= $currentCategory === $category
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        <?= htmlspecialchars($category) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-field">

                            <label for="brand">
                                Brand
                            </label>

                            <input
                                type="text"
                                id="brand"
                                name="brand"
                                value="<?= $getValue('brand') ?>"
                                placeholder="Enter the brand name"
                            >

                        </div>

                        <div class="form-field full-width">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                placeholder="Enter a short product description"
                            ><?= $getValue('description') ?></textarea>

                        </div>

                    </div>

                </section>

                <!-- Price and stock information section -->
                <section class="form-section">

                    <div class="form-section-heading">

                        <span class="form-section-icon">2</span>

                        <div>
                            <h2>Price and Inventory</h2>

                            <p>
                                Update the price, stock and reorder details.
                            </p>
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">

                            <label for="price">
                                Price
                                <span class="required">*</span>
                            </label>

                            <div class="input-with-prefix">

                                <span class="input-prefix">Rs.</span>

                                <input
                                    type="number"
                                    id="price"
                                    name="price"
                                    value="<?= $getValue('price') ?>"
                                    min="0"
                                    step="0.01"
                                    placeholder="0.00"
                                    required
                                >

                            </div>

                        </div>

                        <div class="form-field">

                            <label for="stock_quantity">
                                Stock Quantity
                                <span class="required">*</span>
                            </label>

                            <input
                                type="number"
                                id="stock_quantity"
                                name="stock_quantity"
                                value="<?= $getValue('stock_quantity') ?>"
                                min="0"
                                step="1"
                                placeholder="0"
                                required
                            >

                        </div>

                        <div class="form-field">

                            <label for="reorder_level">
                                Reorder Level
                                <span class="required">*</span>
                            </label>

                            <input
                                type="number"
                                id="reorder_level"
                                name="reorder_level"
                                value="<?= $getValue('reorder_level') ?>"
                                min="0"
                                step="1"
                                placeholder="10"
                                required
                            >

                            <p class="field-help">
                                The product becomes low stock at this level.
                            </p>

                        </div>

                        <div class="form-field">

                            <label for="unit">
                                Unit
                                <span class="required">*</span>
                            </label>

                            <select
                                id="unit"
                                name="unit"
                                required
                            >
                                <option value="">
                                    Select a unit
                                </option>

                                <?php
                                $units = [
                                    'items',
                                    'bags',
                                    'tins',
                                    'bottles',
                                    'packs',
                                    'boxes',
                                    'tubes',
                                    'vials'
                                ];
                                ?>

                                <?php foreach ($units as $unit): ?>

                                    <option
                                        value="<?= htmlspecialchars($unit) ?>"
                                        <?= $currentUnit === $unit
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        <?= ucfirst(
                                            htmlspecialchars($unit)
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                    </div>

                </section>

                <!-- Form action buttons -->
                <div class="form-actions">

                    <a
                        class="cancel-button"
                        href="<?= URLROOT ?>/manage-products/index"
                    >
                        Cancel
                    </a>

                    <button
                        class="save-product-button"
                        type="submit"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </section>

    </main>

</div>

</body>
</html>