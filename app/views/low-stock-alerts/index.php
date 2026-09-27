<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars(
            $data['pageTitle'] ?? 'Low Stock Alerts'
        ) ?> | HappyPaws
    </title>

    <!-- Existing Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Low Stock Alerts stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/low-stock-alerts.css"
    >

    <link 
        rel="stylesheet"
        href="<?= URLROOT ?>/css/sidebar.css"
    >
    
</head>

<body>

<div class="app-shell">

    <!-- Product Manager sidebar -->
    <aside class="sidebar">

        <a
            class="brand"
            href="<?= URLROOT ?>/dashboard/index"
        >
            <!--<span class="brand-mark">✚</span> -->

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

        <p class="menu-label">MAIN MENU</p>

        <!-- Connected navigation links -->
        <nav
            class="main-menu"
            aria-label="Main navigation"
        >

            <a href="<?= URLROOT ?>/dashboard/index">
                <span>▦</span>
                Dashboard
            </a>

            <a href="<?= URLROOT ?>/products/index">
                <span>▣</span>
                Products
            </a>

            <a href="<?= URLROOT ?>/manage-products/index">
                <span>▤</span>
                Manage Products
            </a>

            <a href="<?= URLROOT ?>/orders/index">
                <span>▱</span>
                Orders
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/low-stock-alerts/index"
            >
                <span>△</span>
                Low Stock Alerts
                <b>⚠</b>
            </a>

            <a href="<?= URLROOT ?>/reports/index">
                <span>⌁</span>
                Reports
            </a>

        </nav>

        <!-- Account navigation -->
        <nav
            class="account-menu"
            aria-label="Account navigation"
        >
            <a href="#">
                <span>♙</span>
                Profile
            </a>

            <a href="#">
                <span>⚙</span>
                Settings
            </a>
        </nav>

    </aside>

    <section class="workspace">

        <!-- Global application header -->
        <header class="topbar">

            <label class="global-search">
                <span>⌕</span>

                <input
                    type="search"
                    placeholder="Search products, orders, or pets..."
                >
            </label>

            <div class="topbar-actions">

                <button
                    type="button"
                    class="icon-button"
                    aria-label="Notifications"
                >
                    ♟
                    <i></i>
                </button>

                <button
                    type="button"
                    class="icon-button"
                    aria-label="Help"
                >
                    ?
                </button>

                <div class="user-avatar">SW</div>

                <div>
                    <strong>Dr. Sarah Wilson</strong>
                    <small>Clinic Admin</small>
                </div>

            </div>

        </header>

        <main class="content">

            <!-- Page heading and main actions -->
            <div class="page-heading">

                <div>
                    <p class="breadcrumb">
                        HAPPYPAWS INVENTORY
                        <span>/</span>
                        ALERTS &amp; REPLENISHMENT
                    </p>

                    <h1>Low Stock Alerts</h1>

                    <p>
                        Products that are running low or<br>
                        out of stock.
                    </p>
                </div>

                <div class="heading-actions">

                    <button
                        type="button"
                        class="button button-secondary"
                        id="exportCsvButton"
                    >
                        ⇩ Export Low Stock List
                    </button>

                    <button
                        type="button"
                        class="button button-primary"
                        id="bulkReorderButton"
                    >
                        🛒 Bulk Reorder All
                    </button>

                </div>

            </div>

            <!-- Low-stock warning banner -->
            <div
                class="warning-banner"
                id="warningBanner"
            >
                <span class="warning-icon">△</span>

                <p>
                    These items need to be restocked soon to avoid stockouts.
                </p>

                <span class="alert-count">
                    9 active alerts detected
                </span>

                <button
                    type="button"
                    id="closeBanner"
                    aria-label="Dismiss alert"
                >
                    ×
                </button>
            </div>

            <!-- Inventory summary -->
            <section
                class="summary-grid"
                aria-label="Low stock summary"
            >

                <article class="summary-card">
                    <span class="summary-icon amber">♟</span>
                    <small>Critical Low Stock</small>

                    <strong>
                        <?= (int) ($data['summary']['critical'] ?? 0) ?>
                        items
                    </strong>

                    <p class="amber-text">
                        ● Action needed within 48 hrs
                    </p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon red">●</span>
                    <small>Completely Depleted</small>

                    <strong>
                        <?= (int) ($data['summary']['depleted'] ?? 0) ?>
                        items
                    </strong>

                    <p class="red-text">
                        ● 0 in stock • Immediate reorder
                    </p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon blue">▣</span>
                    <small>Pending Vendor POs</small>

                    <strong>
                        <?= (int) (
                            $data['summary']['pending_orders'] ?? 0
                        ) ?>
                        orders
                    </strong>

                    <p class="blue-text">
                        ● Estimated arrival: Tomorrow
                    </p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon green">▣</span>
                    <small>Estimated Restock Cost</small>

                    <strong>
                        Rs.
                        <?= number_format(
                            $data['summary']['restock_cost'] ?? 0
                        ) ?>
                    </strong>

                    <p class="green-text">
                        ● Based on default reorder limits
                    </p>
                </article>

            </section>

            <!-- Search and filter controls -->
            <section class="filter-panel">

                <label class="item-search">
                    <span>⌕</span>

                    <input
                        id="stockSearch"
                        type="search"
                        placeholder="Search low stock items by name or SKU..."
                    >
                </label>

                <select
                    id="categoryFilter"
                    aria-label="Filter by category"
                >
                    <option value="all">All Categories</option>
                    <option value="Nutrition &amp; Food">
                        Nutrition &amp; Food
                    </option>
                    <option value="Dental Care">Dental Care</option>
                    <option value="Consumables">Consumables</option>
                    <option value="Pharmaceuticals">
                        Pharmaceuticals
                    </option>
                    <option value="Otic &amp; Eye Care">
                        Otic &amp; Eye Care
                    </option>
                </select>

                <select
                    id="statusFilter"
                    aria-label="Filter by alert status"
                >
                    <option value="all">All Alerts</option>
                    <option value="low">Low Stock</option>
                    <option value="out">Out of Stock</option>
                </select>

                <button
                    type="button"
                    class="button button-primary compact"
                    id="applyFilters"
                >
                    ⚑ Filter
                </button>

                <button
                    type="button"
                    class="reset-button"
                    id="resetFilters"
                >
                    Reset
                </button>

            </section>

            <?php $stockItems = $data['items'] ?? []; ?>

            <!-- Low-stock items table -->
            <section class="table-card">

                <div class="table-scroll">

                    <table>

                        <thead>
                            <tr>
                                <th>ID (SKU)</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Current Stock</th>
                                <th>Threshold</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="stockTableBody">

                        <?php foreach ($stockItems as $item): ?>

                            <?php
                            $itemStatus = $item['status'] ?? 'low';
                            ?>

                            <tr
                                data-name="<?= htmlspecialchars(
                                    strtolower($item['name'] ?? '')
                                ) ?>"
                                data-sku="<?= htmlspecialchars(
                                    strtolower($item['sku'] ?? '')
                                ) ?>"
                                data-category="<?= htmlspecialchars(
                                    $item['category'] ?? ''
                                ) ?>"
                                data-status="<?= htmlspecialchars(
                                    $itemStatus
                                ) ?>"
                            >

                                <td>
                                    <span class="sku">
                                        #<?= htmlspecialchars(
                                            $item['sku'] ?? ''
                                        ) ?>
                                    </span>
                                </td>

                                <td>
                                    <div class="product-cell">

                                        <span
                                            class="product-icon <?= $itemStatus === 'out'
                                                ? 'danger-icon'
                                                : '' ?>"
                                        >
                                            ▣
                                        </span>

                                        <span>
                                            <strong>
                                                <?= htmlspecialchars(
                                                    $item['name'] ?? ''
                                                ) ?>
                                            </strong>

                                            <small>
                                                <?= htmlspecialchars(
                                                    $item['details'] ?? ''
                                                ) ?>
                                            </small>
                                        </span>

                                    </div>
                                </td>

                                <td>
                                    <span class="category-chip">
                                        <?= htmlspecialchars(
                                            $item['category'] ?? ''
                                        ) ?>
                                    </span>
                                </td>

                                <td>
                                    <strong class="stock-number">
                                        <?= (int) (
                                            $item['current_stock'] ?? 0
                                        ) ?>

                                        <?= htmlspecialchars(
                                            $item['unit'] ?? ''
                                        ) ?>
                                    </strong>
                                </td>

                                <td>
                                    <span>
                                        Min:
                                        <?= (int) (
                                            $item['threshold'] ?? 0
                                        ) ?>

                                        <?= htmlspecialchars(
                                            $item['unit'] ?? ''
                                        ) ?>
                                    </span>

                                    <small>
                                        Reorder target:
                                        <?= (int) (
                                            $item['reorder_target'] ?? 0
                                        ) ?>

                                        <?= htmlspecialchars(
                                            $item['unit'] ?? ''
                                        ) ?>
                                    </small>
                                </td>

                                <td>
                                    <span
                                        class="status-badge status-<?= htmlspecialchars(
                                            $itemStatus
                                        ) ?>"
                                    >
                                        <?= $itemStatus === 'out'
                                            ? 'Out of Stock'
                                            : 'Low Stock' ?>
                                    </span>
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="restock-button"
                                        data-sku="<?= htmlspecialchars(
                                            $item['sku'] ?? ''
                                        ) ?>"
                                    >
                                        🛒 Restock
                                    </button>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <!-- Table footer -->
                <div class="table-footer">

                    <span id="resultCount">
                        Showing 1–<?= count($stockItems) ?>
                        of <?= count($stockItems) ?> alert items
                    </span>

                    <div
                        class="pagination"
                        aria-label="Pagination"
                    >
                        <button
                            type="button"
                            disabled
                        >
                            ‹
                        </button>

                        <button
                            type="button"
                            class="active"
                        >
                            1
                        </button>

                        <button type="button">2</button>
                        <button type="button">›</button>
                    </div>

                </div>

            </section>

            <!-- Inventory configuration message -->
            <aside class="inventory-tip">

                <span>♧</span>

                <div>
                    <strong>Clinic Inventory Tip</strong>

                    <p>
                        Set reorder levels to get notified automatically
                        when stock is low.
                    </p>
                </div>

                <a href="#">
                    Configure Reorder Thresholds →
                </a>

            </aside>

        </main>

    </section>

</div>

<!-- JavaScript feedback message -->
<div
    class="toast"
    id="toast"
    role="status"
    aria-live="polite"
></div>

<!-- Low Stock Alerts JavaScript -->
<script src="<?= URLROOT ?>/js/low-stock-alerts.js"></script>

</body>
</html>