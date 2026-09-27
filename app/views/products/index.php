<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($data['pageTitle'] ?? 'Products') ?> | HappyPaws
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

    <link 
        rel="stylesheet"
        href="<?= URLROOT ?>/css/sidebar.css"
    >

    <!-- Products page stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/products.css"
    >
</head>

<body>

<!-- Main page layout -->
<div class="app-layout">

    <!-- Sidebar navigation -->
    <aside class="sidebar">

        <!-- HappyPaws logo -->
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
            <strong>HappyPaws</strong>
        </a>

        <!-- Main navigation links -->
        <nav class="side-menu">

            <a href="<?= URLROOT ?>/dashboard/index">
                <span>▦</span>
                Dashboard
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/products/index"
            >
                <span>▣</span>
                Products
            </a>

            <a href="<?= URLROOT ?>/manage-products/index">
                <span>◈</span>
                Manage Products
            </a>

            <a href="<?= URLROOT ?>/orders/index">
                <span>▤</span>
                Orders
            </a>

            <a href="<?= URLROOT ?>/low-stock-alerts/index">
                <span>♧</span>
                Low Stock Alerts
            </a>

            <a href="<?= URLROOT ?>/reports/index">
                <span>▥</span>
                Reports
            </a>

        </nav>

        <!-- Additional sidebar links -->
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

    <!-- Main products content -->
    <main class="main-content">

        <!-- Top navigation bar -->
        <header class="topbar">

            <!-- Global search box -->
            <label class="global-search">
                <span>⌕</span>

                <input
                    type="search"
                    placeholder="Search products, orders, or pets..."
                >
            </label>

            <!-- Notification, help and profile area -->
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

                    <span>
                        <b>Dr. Sarah Wilson</b>
                        <small>Clinic Admin</small>
                    </span>

                </div>

            </div>

        </header>

        <div class="page-container">

            <!-- Page heading and actions -->
            <section class="page-heading">

                <div>
                    <p>
                        HAPPYPAWS INVENTORY /
                        <b>CATALOG</b>
                    </p>

                    <h1>Products</h1>

                    <span>
                        View and manage all pharmaceutical, nutritional,
                        and surgical items in clinic inventory.
                    </span>
                </div>

                <div class="heading-actions">

                    <button
                        type="button"
                        id="exportCsv"
                    >
                        ⇩ Export CSV
                    </button>

                    <!-- Open the Manage Products page -->
                    <a href="<?= URLROOT ?>/manage-products/index">
                        ＋ Add New Product
                    </a>

                </div>

            </section>

            <!-- Inventory summary cards -->
            <section class="summary-grid">

                <!-- Total products -->
                <article>
                    <div>
                        <small>Total Catalog Items</small>

                        <strong>
                            <?= (int) ($data['summary']['total'] ?? 0) ?>
                        </strong>

                        <p>Across 7 veterinary sectors</p>
                    </div>

                    <i>▣</i>
                </article>

                <!-- Products currently in stock -->
                <article>
                    <div>
                        <small>In Stock</small>

                        <strong>
                            <?= (int) ($data['summary']['inStock'] ?? 0) ?>
                            <em>79.1%</em>
                        </strong>

                        <p class="success">
                            ● Ready for dispensing
                        </p>
                    </div>

                    <i class="green">✓</i>
                </article>

                <!-- Low-stock products -->
                <article>
                    <div>
                        <small>Low Stock Warning</small>

                        <strong>
                            <?= (int) ($data['summary']['lowStock'] ?? 0) ?>
                            <em class="amber">Reorder</em>
                        </strong>

                        <p class="warning">
                            ▼ Under 5 units left
                        </p>
                    </div>

                    <i class="orange">△</i>
                </article>

                <!-- Out-of-stock products -->
                <article>
                    <div>
                        <small>Depleted Stock</small>

                        <strong class="danger">
                            <?= (int) ($data['summary']['outOfStock'] ?? 0) ?>
                            <em class="red">Critical</em>
                        </strong>

                        <p class="danger">
                            ● Requires purchase order
                        </p>
                    </div>

                    <i class="red-icon">🛒</i>
                </article>

            </section>

            <!-- Product search and filter controls -->
            <section class="filter-card">

                <label class="catalog-search">
                    <span>⌕</span>

                    <input
                        id="productSearch"
                        type="search"
                        placeholder="Search by product name, SKU, or brand..."
                    >
                </label>

                <!-- Category filter -->
                <select id="categoryFilter">

                    <option value="all">
                        All Categories
                    </option>

                    <?php
                    $products = $data['products'] ?? [];
                    $categories = array_unique(
                        array_column($products, 'category')
                    );
                    ?>

                    <?php foreach ($categories as $category): ?>

                        <option value="<?= htmlspecialchars($category) ?>">
                            <?= htmlspecialchars($category) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

                <!-- Stock-level filter -->
                <select id="stockFilter">
                    <option value="all">All Stock Levels</option>
                    <option value="In Stock">In Stock</option>
                    <option value="Low Stock">Low Stock</option>
                    <option value="Out of Stock">Out of Stock</option>
                </select>

                <button
                    type="button"
                    class="filter-button"
                    id="filterButton"
                >
                    ⚑ Filter
                </button>

                <button
                    type="button"
                    class="reset-button"
                    id="resetButton"
                >
                    ↻ Reset
                </button>

            </section>

            <!-- Product catalog table -->
            <section class="table-card">

                <div class="table-wrapper">

                    <table id="productsTable">

                        <thead>
                            <tr>
                                <th>SKU / ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Stock Level</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($products as $product): ?>

                            <tr
                                data-category="<?= htmlspecialchars(
                                    $product['category'] ?? ''
                                ) ?>"
                                data-status="<?= htmlspecialchars(
                                    $product['status'] ?? ''
                                ) ?>"
                            >

                                <!-- Product ID -->
                                <td>
                                    <?= htmlspecialchars(
                                        $product['id'] ?? ''
                                    ) ?>
                                </td>

                                <!-- Product name and description -->
                                <td>
                                    <div class="product-cell">

                                        <span>♧</span>

                                        <div>
                                            <b>
                                                <?= htmlspecialchars(
                                                    $product['name'] ?? ''
                                                ) ?>
                                            </b>

                                            <small>
                                                <?= htmlspecialchars(
                                                    $product['description'] ?? ''
                                                ) ?>
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <!-- Product category -->
                                <td>
                                    <span class="category-tag">
                                        <?= htmlspecialchars(
                                            $product['category'] ?? ''
                                        ) ?>
                                    </span>
                                </td>

                                <!-- Product brand -->
                                <td>
                                    <?= htmlspecialchars(
                                        $product['brand'] ?? ''
                                    ) ?>
                                </td>

                                <!-- Product price -->
                                <td>
                                    <b>
                                        Rs.
                                        <?= number_format(
                                            $product['price'] ?? 0
                                        ) ?>
                                    </b>
                                </td>

                                <!-- Product stock quantity -->
                                <td>
                                    <?php
                                    $stockQuantity =
                                        (int) ($product['stock'] ?? 0);
                                    ?>

                                    <b class="<?= $stockQuantity <= 4
                                        ? 'danger'
                                        : '' ?>"
                                    >
                                        <?= $stockQuantity ?>
                                    </b>

                                    <small>
                                        <?= htmlspecialchars(
                                            $product['unit'] ?? ''
                                        ) ?>
                                    </small>
                                </td>

                                <!-- Product status -->
                                <td>
                                    <?php
                                    $productStatus =
                                        $product['status'] ?? 'Out of Stock';

                                    $statusClass = strtolower(
                                        str_replace(
                                            ' ',
                                            '-',
                                            $productStatus
                                        )
                                    );
                                    ?>

                                    <span
                                        class="status <?= htmlspecialchars(
                                            $statusClass
                                        ) ?>"
                                    >
                                        <?= htmlspecialchars($productStatus) ?>
                                    </span>
                                </td>

                                <!-- Product actions -->
                                <td>
                                    <button
                                        type="button"
                                        class="edit-button"
                                        title="Edit"
                                    >
                                        ✎
                                    </button>

                                    <button
                                        type="button"
                                        class="delete-button"
                                        title="Delete"
                                    >
                                        ▱
                                    </button>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <!-- Table pagination area -->
                <div class="table-footer">

                    <span id="tableCount">
                        Showing 1 to <?= count($products) ?>
                        of <?= (int) ($data['summary']['total'] ?? 0) ?>
                        products
                    </span>

                    <label>
                        Items per page:

                        <select id="pageSize">
                            <option>10</option>
                            <option>20</option>
                            <option>50</option>
                        </select>
                    </label>

                    <nav id="pagination">

                        <button
                            type="button"
                            disabled
                        >
                            Previous
                        </button>

                        <button
                            type="button"
                            class="active"
                        >
                            1
                        </button>

                        <button type="button">2</button>
                        <button type="button">3</button>
                        <button type="button">…</button>
                        <button type="button">6</button>
                        <button type="button">Next</button>

                    </nav>

                </div>

            </section>

        </div>

    </main>

</div>

<!-- Products page JavaScript -->
<script src="<?= URLROOT ?>/js/products.js"></script>

</body>
</html>