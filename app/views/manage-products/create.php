<?php

// Get validation errors received from the controller.
$errors = $data['errors'] ?? [];

// Get previously submitted values.
$old = $data['old'] ?? [];

/**
 * Safely display a previously submitted form value.
 */
$oldValue = static function ($field) use ($old) {
    return htmlspecialchars(
        (string) ($old[$field] ?? ''),
        ENT_QUOTES,
        'UTF-8'
    );
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($data['pageTitle'] ?? 'Add Product') ?>
        | HappyPaws
    </title>

    <!-- Google Fonts -->
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

    <!-- Existing Manage Products stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/manage-products.css"
    >

    <!-- Shared sidebar stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/sidebar.css"
    >

    <!-- Add Product form stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/product-form.css"
    >
</head>

<body>

<div class="app-layout">

    <!-- Sidebar navigation -->
    <aside class="sidebar">

        <a
            class="brand"
            href="<?= URLROOT ?>/dashboard/index"
        >
            <!-- <span>✚</span> -->

            <img
             class="brand-logo"
             src="<?= URLROOT ?>/images/happy_paws_logo.png"
             alt="HappyPaws Logo"
            >

            <div>
                <b>HappyPaws</b>
                <small>Clinic Manager</small>
            </div>
        </a>

        <p>MAIN MENU</p>

        <nav class="side-menu">

            <a href="<?= URLROOT ?>/dashboard/index">
                ▦ Dashboard
            </a>

            <a href="<?= URLROOT ?>/products/index">
                ▣ Products
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/manage-products/index"
            >
                ▤ Manage Products
            </a>

            <a href="<?= URLROOT ?>/orders/index">
                ▧ Orders
            </a>

            <a href="<?= URLROOT ?>/low-stock-alerts/index">
                △ Low Stock Alerts
                <i></i>
            </a>

            <a href="<?= URLROOT ?>/reports/index">
                ▥ Reports
            </a>

        </nav>

        <nav class="side-footer">
            <a href="#">◎ Profile</a>
            <a href="#">⚙ Settings</a>
        </nav>

    </aside>

    <!-- Main content area -->
    <main class="main-content">

        <!-- Application top bar -->
        <header class="topbar">

            <label>
                <span>⌕</span>

                <input
                    type="search"
                    placeholder="Search products, orders, or pets..."
                >
            </label>

            <div>
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

                <span class="avatar">SW</span>

                <span>
                    <b>Sarah Wilson</b>
                    
                </span>
            </div>

        </header>

        <div class="page-container product-form-page">

            <!-- Page heading -->
            <section class="form-page-heading">

                <div>
                    <p>
                        HAPPYPAWS INVENTORY /
                        <b>ADD PRODUCT</b>
                    </p>

                    <h1>Add New Product</h1>

                    <span>
                        Register a new product in the clinic inventory.
                    </span>
                </div>

                <a
                    class="back-button"
                    href="<?= URLROOT ?>/manage-products/index"
                >
                    ← Back to Products
                </a>

            </section>

            <!-- Display general validation message -->
            <?php if (!empty($errors)): ?>

                <div class="form-alert" role="alert">
                    <strong>Please correct the highlighted fields.</strong>

                    <span>
                        The product was not added to the database.
                    </span>
                </div>

            <?php endif; ?>

            <!-- Add Product form -->
            <form
                class="product-form-card"
                action="<?= URLROOT ?>/manage-products/store"
                method="POST"
            >

                <!-- Basic product information -->
                <section class="form-section">

                    <div class="form-section-heading">
                        <span>1</span>

                        <div>
                            <h2>Basic Information</h2>
                            <p>
                                Enter the product identification details.
                            </p>
                        </div>
                    </div>

                    <div class="form-grid">

                        <!-- SKU -->
                        <div class="form-field">

                            <label for="sku">
                                SKU / Product Code
                                <b>*</b>
                            </label>

                            <input
                                class="<?= isset($errors['sku'])
                                    ? 'input-error'
                                    : '' ?>"
                                type="text"
                                id="sku"
                                name="sku"
                                value="<?= $oldValue('sku') ?>"
                                placeholder="Example:  PRD-00000X"
                                maxlength="30"
                                required
                            >

                            <?php if (isset($errors['sku'])): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars($errors['sku']) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Product name -->
                        <div class="form-field">

                            <label for="product_name">
                                Product Name
                                <b>*</b>
                            </label>

                            <input
                                class="<?= isset($errors['product_name'])
                                    ? 'input-error'
                                    : '' ?>"
                                type="text"
                                id="product_name"
                                name="product_name"
                                value="<?= $oldValue('product_name') ?>"
                                placeholder="Enter the product name"
                                maxlength="150"
                                required
                            >

                            <?php if (isset($errors['product_name'])): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars(
                                        $errors['product_name']
                                    ) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Product category -->
                        <div class="form-field">

                            <label for="category">
                                Category
                                <b>*</b>
                            </label>

                            <select
                                class="<?= isset($errors['category'])
                                    ? 'input-error'
                                    : '' ?>"
                                id="category"
                                name="category"
                                required
                            >
                                <option value="">Select a category</option>

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
                                        value="<?= htmlspecialchars(
                                            $category
                                        ) ?>"
                                        <?= ($old['category'] ?? '') ===
                                            $category
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        <?= htmlspecialchars($category) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <?php if (isset($errors['category'])): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars(
                                        $errors['category']
                                    ) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Product brand -->
                        <div class="form-field">

                            <label for="brand">
                                Brand
                            </label>

                            <input
                                type="text"
                                id="brand"
                                name="brand"
                                value="<?= $oldValue('brand') ?>"
                                placeholder="Enter the brand name"
                                maxlength="100"
                            >

                        </div>

                        <!-- Product description -->
                        <div class="form-field full-width">

                            <label for="description">
                                Description
                            </label>

                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                placeholder="Enter a short product description"
                            ><?= $oldValue('description') ?></textarea>

                        </div>

                    </div>

                </section>

                <!-- Price and inventory information -->
                <section class="form-section">

                    <div class="form-section-heading">
                        <span>2</span>

                        <div>
                            <h2>Price and Inventory</h2>
                            <p>
                                Enter the product price and stock information.
                            </p>
                        </div>
                    </div>

                    <div class="form-grid three-columns">

                        <!-- Product price -->
                        <div class="form-field">

                            <label for="price">
                                Price (Rs.)
                                <b>*</b>
                            </label>

                            <input
                                class="<?= isset($errors['price'])
                                    ? 'input-error'
                                    : '' ?>"
                                type="number"
                                id="price"
                                name="price"
                                value="<?= $oldValue('price') ?>"
                                placeholder="0.00"
                                min="0"
                                step="0.01"
                                required
                            >

                            <?php if (isset($errors['price'])): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars($errors['price']) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Stock quantity -->
                        <div class="form-field">

                            <label for="stock_quantity">
                                Stock Quantity
                                <b>*</b>
                            </label>

                            <input
                                class="<?= isset(
                                    $errors['stock_quantity']
                                )
                                    ? 'input-error'
                                    : '' ?>"
                                type="number"
                                id="stock_quantity"
                                name="stock_quantity"
                                value="<?= $oldValue('stock_quantity') ?>"
                                placeholder="0"
                                min="0"
                                step="1"
                                required
                            >

                            <?php if (
                                isset($errors['stock_quantity'])
                            ): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars(
                                        $errors['stock_quantity']
                                    ) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Reorder level -->
                        <div class="form-field">

                            <label for="reorder_level">
                                Reorder Level
                                <b>*</b>
                            </label>

                            <input
                                class="<?= isset(
                                    $errors['reorder_level']
                                )
                                    ? 'input-error'
                                    : '' ?>"
                                type="number"
                                id="reorder_level"
                                name="reorder_level"
                                value="<?= $oldValue('reorder_level') ?>"
                                placeholder="10"
                                min="0"
                                step="1"
                                required
                            >

                            <?php if (
                                isset($errors['reorder_level'])
                            ): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars(
                                        $errors['reorder_level']
                                    ) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                        <!-- Unit label -->
                        <div class="form-field">

                            <label for="unit">
                                Unit
                                <b>*</b>
                            </label>

                            <select
                                class="<?= isset($errors['unit'])
                                    ? 'input-error'
                                    : '' ?>"
                                id="unit"
                                name="unit"
                                required
                            >
                                <?php
                                $units = [
                                    'items',
                                    'bags',
                                    'tins',
                                    'bottles',
                                    'packs',
                                    'boxes',
                                    'vials',
                                    'tubes',
                                ];
                                ?>

                                <?php foreach ($units as $unit): ?>

                                    <option
                                        value="<?= htmlspecialchars($unit) ?>"
                                        <?= ($old['unit'] ?? 'items') === $unit
                                            ? 'selected'
                                            : '' ?>
                                    >
                                        <?= ucfirst(
                                            htmlspecialchars($unit)
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                            <?php if (isset($errors['unit'])): ?>
                                <small class="error-message">
                                    <?= htmlspecialchars($errors['unit']) ?>
                                </small>
                            <?php endif; ?>

                        </div>

                    </div>

                </section>

                <!-- Form buttons -->
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
                        ＋ Save Product
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>
</html>