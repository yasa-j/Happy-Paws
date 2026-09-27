<?php

// Escape output before displaying it in HTML.
$escape = static function ($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

// Read the product data provided by the controller.
$products = $data['products'] ?? [];

$summary = array_replace([
    'total' => count($products),
    'drafts' => 0,
    'pendingChanges' => 0,
    'lowStockAlerts' => 0
], $data['summary'] ?? []);

// Build a unique category list for filtering.
$categories = [];

foreach ($products as $product) {
    if (!empty($product['category'])) {
        $categories[] = $product['category'];
    }
}

$categories = array_unique($categories);
sort($categories);

// Read and clear controller feedback messages.
$successMessage = $_SESSION['success_message'] ?? '';
$errorMessage = $_SESSION['error_message'] ?? '';

unset(
    $_SESSION['success_message'],
    $_SESSION['error_message']
);
?>
<!DOCTYPE html>
<!-- MANAGE-PRODUCTS-VIEW-CHECK-2026 -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?= $escape($data['pageTitle'] ?? 'Manage Products') ?> | HappyPaws
    </title>

    <!-- Load the existing project fonts. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Keep the shared sidebar stylesheet after the page stylesheet. -->
    <link rel="stylesheet" href="<?= $escape(URLROOT) ?>/css/manage-products.css">
    <link rel="stylesheet" href="<?= $escape(URLROOT) ?>/css/sidebar.css">

    <style>
        /* Keep database actions together without changing the page layout. */
        .delete-form {
            display: inline;
            margin: 0;
        }

        .server-edit-action,
        .server-delete-action {
            border: 0;
            background: transparent;
            font: inherit;
            font-size: 9px;
            cursor: pointer;
        }

        .server-edit-action {
            margin-right: 8px;
            color: #0f766e;
        }

        .server-delete-action {
            color: #dc2626;
        }

        .server-edit-action:hover {
            text-decoration: underline;
        }

        /* Display feedback returned by the controller. */
        .feedback-message {
            margin: 16px 0;
            padding: 12px 16px;
            border: 1px solid;
            border-radius: 8px;
        }

        .feedback-success {
            background: #ecfdf5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .feedback-error {
            background: #fef2f2;
            border-color: #fecaca;
            color: #991b1b;
        }
    </style>
</head>

<body>
<div class="app-layout">

    <!-- Shared navigation sidebar. -->
    <aside class="sidebar">
        <a class="brand" href="<?= $escape(URLROOT) ?>/dashboard/index">
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
            <a href="<?= $escape(URLROOT) ?>/dashboard/index">▦ Dashboard</a>
            <a href="<?= $escape(URLROOT) ?>/products/index">▣ Products</a>
            <a class="active" href="<?= $escape(URLROOT) ?>/manage-products/index">
                ▤ Manage Products
            </a>
            <a href="<?= $escape(URLROOT) ?>/orders/index">▧ Orders</a>
            <a href="<?= $escape(URLROOT) ?>/low-stock-alerts/index">
                △ Low Stock Alerts<i></i>
            </a>
            <a href="<?= $escape(URLROOT) ?>/reports/index">▥ Reports</a>
        </nav>

        <nav class="side-footer">
            <a href="#">◎ Profile</a>
            <a href="#">⚙ Settings</a>
        </nav>
    </aside>

    <main class="main-content">

        <!-- Top navigation bar. -->
        <header class="topbar">
            <label>
                <span>⌕</span>
                <input
                    type="search"
                    aria-label="Global search"
                    placeholder="Search products, orders, or pets..."
                >
            </label>

            <div>
                <button type="button" aria-label="Notifications">♧</button>
                <button type="button" aria-label="Help">?</button>
                <span class="avatar">SW</span>
                <span>
                    <b>Dr. Sarah Wilson</b>
                    <small>Clinic Admin</small>
                </span>
            </div>
        </header>

        <div class="page-container">

            <!-- Page heading and Add Product link. -->
            <section class="page-heading">
                <div>
                    <p>HAPPYPAWS INVENTORY / <b>MANAGEMENT</b></p>
                    <h1>Manage Products</h1>
                    <span>Add, edit or remove products from your inventory.</span>
                </div>

                <div class="heading-actions">
                    <button id="bulkMenuButton" type="button">
                        ☷ Bulk Actions⌄
                    </button>

                    <a href="<?= $escape(URLROOT) ?>/manage-products/create">
                        ＋ Add Product
                    </a>
                </div>
            </section>

            <!-- Display success and error messages from the controller. -->
            <?php if ($successMessage !== ''): ?>
                <div class="feedback-message feedback-success" role="status">
                    <?= $escape($successMessage) ?>
                </div>
            <?php endif; ?>

            <?php if ($errorMessage !== ''): ?>
                <div class="feedback-message feedback-error" role="alert">
                    <?= $escape($errorMessage) ?>
                </div>
            <?php endif; ?>

            <!-- Inventory summary cards. -->
            <section class="summary-grid">
                <article>
                    <div>
                        <small>Total Manageable SKUs</small>
                        <strong>
                            <?= (int) $summary['total'] ?>
                            <em>
                                <?= (int) $summary['drafts'] ?> Drafts / Unlisted
                            </em>
                        </strong>
                        <p class="green">◎ Inventory overview</p>
                    </div>
                    <i>▣</i>
                </article>

                <article>
                    <div>
                        <small>Price Adjustments Pending</small>
                        <strong>
                            <?= (int) $summary['pendingChanges'] ?>
                            <em class="blue">Review Changes</em>
                        </strong>
                        <p>Supplier price adjustments</p>
                    </div>
                    <i>♻</i>
                </article>

                <article>
                    <div>
                        <small>Low Stock Threshold Alerts</small>
                        <strong class="danger">
                            <?= (int) $summary['lowStockAlerts'] ?>
                            <em class="red">Action Urgent</em>
                        </strong>
                        <p>Review products requiring replenishment</p>
                    </div>
                    <i class="red-icon">♜</i>
                </article>
            </section>

            <!-- Existing selection controls. -->
            <section class="selection-bar">
                <label>
                    <input id="selectAllTop" type="checkbox">
                    Select All Visible
                </label>

                <span>Selected: <b id="selectedCount">0 items</b></span>

                <div>
                    <button id="bulkPrice" type="button">▣ Bulk Price Change</button>
                    <button id="bulkStatus" type="button">♙ Bulk Status</button>
                    <button id="quickExport" type="button">⇩ Quick Export</button>
                </div>
            </section>

            <!-- Existing search and filter controls. -->
            <section class="filter-bar">
                <label>
                    <span>⌕</span>
                    <input
                        id="manageSearch"
                        type="search"
                        aria-label="Search products"
                        placeholder="Search by product name, SKU, or brand..."
                    >
                </label>

                <select id="manageCategory" aria-label="Category">
                    <option value="all">All Categories</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $escape($category) ?>">
                            <?= $escape($category) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select id="manageStatus" aria-label="Stock status">
                    <option value="all">All Statuses</option>
                    <option value="In Stock">In Stock</option>
                    <option value="Low Stock">Low Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>

                <button id="manageFilter" type="button">⚑ Filter</button>
                <button id="manageReset" type="button">↻ Reset</button>
            </section>

            <!-- Products loaded from the database. -->
            <section class="table-card">
                <div class="table-wrapper">
                    <table id="manageTable">
                        <thead>
                            <tr>
                                <th>
                                    <input
                                        id="selectAllTable"
                                        type="checkbox"
                                        aria-label="Select all products"
                                    >
                                </th>
                                <th>SKU / ID</th>
                                <th>Product Details</th>
                                <th>Brand & Batch</th>
                                <th>Price (Rs.)</th>
                                <th>Stock Level</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="8">No products were found.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($products as $product): ?>
                            <?php
                            // Use only the numeric database ID for CRUD routes.
                            // The displayed SKU must never be used as this ID.
                            $productId = (int) (
                                $product['productId']
                                ?? $product['product_id']
                                ?? 0
                            );

                            $stock = max(0, (int) ($product['stock'] ?? 0));
                            $maximum = max(1, (int) ($product['maximum'] ?? 1));
                            $percentage = min(100, ($stock / $maximum) * 100);

                            $status = $product['status'] ?? '';
                            $statusClasses = [
                                'In Stock' => 'in-stock',
                                'Low Stock' => 'low-stock',
                                'Out of Stock' => 'out-of-stock'
                            ];

                            $statusClass = $statusClasses[$status] ?? '';
                            ?>

                            <tr
                                data-product-id="<?= $productId ?>"
                                data-category="<?= $escape($product['category'] ?? '') ?>"
                                data-status="<?= $escape($status) ?>"
                            >
                                <td>
                                    <input
                                        class="row-check"
                                        type="checkbox"
                                        value="<?= $productId ?>"
                                        aria-label="Select <?= $escape($product['name'] ?? '') ?>"
                                    >
                                </td>

                                <td>
                                    <b><?= $escape($product['id'] ?? '') ?></b>
                                </td>

                                <td>
                                    <div class="product-cell">
                                        <span>♧</span>
                                        <div>
                                            <b><?= $escape($product['name'] ?? '') ?></b>
                                            <small>
                                                <?= $escape($product['description'] ?? '') ?>
                                            </small>
                                            <em>
                                                <?= $escape($product['category'] ?? '') ?>
                                            </em>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <b><?= $escape($product['brand'] ?? '') ?></b>
                                    <small><?= $escape($product['batch'] ?? 'N/A') ?></small>
                                </td>

                                <td>
                                    <b>
                                        Rs. <?= number_format(
                                            (float) ($product['price'] ?? 0),
                                            2
                                        ) ?>
                                    </b>
                                </td>

                                <td>
                                    <b class="<?= $status !== 'In Stock' ? 'danger' : '' ?>">
                                        <?= $stock ?>
                                        <?= $escape($product['unit'] ?? 'items') ?>
                                    </b>

                                    <!-- This meter uses the controller's display maximum. -->
                                    <small>Scale: <?= $maximum ?></small>
                                    <div class="meter">
                                        <i style="width: <?= $percentage ?>%"></i>
                                    </div>
                                </td>

                                <td>
                                    <span class="status <?= $escape($statusClass) ?>">
                                        <?= $escape($status) ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if ($productId > 0): ?>

                                        <!-- Avoid the old demo Edit click handler. -->
                                        <a
                                            class="server-edit-action"
                                            href="<?= $escape(URLROOT) ?>/manage-products/edit/<?= $productId ?>"
                                        >
                                            ✎ Edit
                                        </a>

                                        <!-- Submit deletion to PHP without removing the row in JavaScript. -->
                                        <form
                                            class="delete-form"
                                            action="<?= $escape(URLROOT) ?>/manage-products/delete/<?= $productId ?>"
                                            method="POST"
                                            onsubmit="return confirm('Permanently delete this product from the database?');"
                                        >
                                            <button
                                                class="server-delete-action"
                                                type="submit"
                                                title="Delete Product"
                                                aria-label="Delete <?= $escape($product['name'] ?? '') ?>"
                                            >
                                                ▱
                                            </button>
                                        </form>

                                    <?php else: ?>

                                        <!-- Show a mapping problem instead of submitting ID zero. -->
                                        <small class="danger">
                                            Missing database ID
                                        </small>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Display the number of records currently rendered. -->
                <footer>
                    <span id="manageCount">
                        Showing <?= count($products) ?> of
                        <?= (int) $summary['total'] ?> products
                    </span>
                </footer>
            </section>
        </div>
    </main>
</div>

<!-- Request a new JavaScript URL instead of the previously cached version. -->
<script src="<?= $escape(URLROOT) ?>/js/manage-products.js?v=20260926-2"></script>

</body>
</html>