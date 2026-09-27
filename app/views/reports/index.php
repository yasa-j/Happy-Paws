<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($data['pageTitle'] ?? 'Reports') ?> | HappyPaws
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

    <!-- Reports page stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/reports.css"
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
            <!-- <span class="brand-mark">✚</span> -->

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

        <p class="menu-label">INVENTORY OPERATIONS</p>

        <!-- Connected navigation links -->
        <nav class="main-menu">

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

            <a href="<?= URLROOT ?>/low-stock-alerts/index">
                <span>△</span>
                Low Stock Alerts
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/reports/index"
            >
                <span>⌁</span>
                Reports
            </a>

        </nav>

        <p class="menu-label account-label">ACCOUNT</p>

        <nav class="account-menu">

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
                    aria-label="Help"
                >
                    ?
                </button>

                <button
                    type="button"
                    aria-label="Notifications"
                >
                    ♟
                </button>

                <div class="avatar">SW</div>

                <div>
                    <strong>Dr. Sarah Wilson</strong>
                    <small>Clinic Admin</small>
                </div>

            </div>

        </header>

        <main class="content">

            <!-- Report heading and toolbar -->
            <section class="page-heading">

                <div>
                    <p class="breadcrumb">
                        HAPPYPAWS INVENTORY
                        <span>/</span>
                        ANALYTICS &amp; REPORTS
                    </p>

                    <h1>Reports</h1>

                    <p>
                        View sales, stock and overall clinic performance.
                    </p>
                </div>

                <div class="report-actions">

                    <select
                        id="dateRange"
                        aria-label="Report date range"
                    >
                        <option value="30">
                            ▣ <?= htmlspecialchars(
                                $data['dateRange'] ?? 'Last 30 Days'
                            ) ?>
                        </option>

                        <option value="7">Last 7 Days</option>
                        <option value="90">Last 90 Days</option>
                    </select>

                    <button
                        type="button"
                        class="button export-button"
                        id="exportReport"
                    >
                        ⇩ Export PDF / CSV
                    </button>

                    <button
                        type="button"
                        class="button primary-button"
                        id="generateReport"
                    >
                        ⚑ Generate Report
                    </button>

                </div>

            </section>

            <!-- Report summary cards -->
            <section class="summary-grid">

                <article class="summary-card">
                    <span class="summary-icon green">▣</span>
                    <small>TOTAL SALES</small>

                    <strong>
                        Rs.<br>
                        <?= number_format(
                            $data['summary']['sales'] ?? 0
                        ) ?>
                    </strong>

                    <p class="positive">
                        ↗ +14.2%
                        <span>vs previous month</span>
                    </p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon blue">▣</span>
                    <small>TOTAL ORDERS</small>

                    <strong>
                        <?= (int) ($data['summary']['orders'] ?? 0) ?>
                    </strong>

                    <p>
                        8 fulfilled&nbsp; • &nbsp;4 in progress
                    </p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon green">▤</span>
                    <small>TOTAL PRODUCTS SOLD</small>

                    <strong>
                        <?= (int) (
                            $data['summary']['products_sold'] ?? 0
                        ) ?>
                    </strong>

                    <p>Across 7 categories</p>
                </article>

                <article class="summary-card">
                    <span class="summary-icon red">△</span>
                    <small>LOW STOCK ITEMS</small>

                    <strong class="danger-text">
                        <?= (int) (
                            $data['summary']['low_stock'] ?? 0
                        ) ?>
                    </strong>

                    <p class="danger-pill">
                        ● Requires immediate reorder
                    </p>
                </article>

            </section>

            <section class="analytics-grid">

                <!-- Sales trend chart -->
                <article class="panel sales-panel">

                    <div class="panel-heading">

                        <div>
                            <h2>Sales Trend</h2>

                            <p>
                                Revenue growth and transaction volume over time
                            </p>
                        </div>

                        <div class="period-tabs">
                            <button
                                type="button"
                                data-period="daily"
                            >
                                Daily
                            </button>

                            <button
                                type="button"
                                class="active"
                                data-period="weekly"
                            >
                                Weekly
                            </button>

                            <button
                                type="button"
                                data-period="monthly"
                            >
                                Monthly
                            </button>
                        </div>

                    </div>

                    <div class="metric-strip">

                        <span>
                            <small>Peak Day</small>
                            <strong>Saturday (Rs. 6,800)</strong>
                        </span>

                        <span>
                            <small>Average Daily Sales</small>
                            <strong>Rs. 3,521</strong>
                        </span>

                        <span>
                            <small>Script Volume</small>
                            <strong>14.8 scripts/day</strong>
                        </span>

                    </div>

                    <div class="chart-wrap">
                        <canvas
                            id="salesChart"
                            width="760"
                            height="320"
                            aria-label="Weekly sales trend"
                        ></canvas>
                    </div>

                    <div class="chart-legend">
                        <span class="current-dot">
                            ● Current Period
                        </span>

                        <span class="previous-dot">
                            ● Previous 30 Days
                        </span>

                        <small>Updated 10 mins ago</small>
                    </div>

                </article>

                <!-- Sales by product category -->
                <article class="panel category-panel">

                    <div class="panel-heading">
                        <div>
                            <h2>Category Wise Sales</h2>

                            <p>
                                Revenue share across product departments
                            </p>
                        </div>
                    </div>

                    <div class="donut-wrap">
                        <div
                            class="donut"
                            id="categoryDonut"
                        >
                            <span>
                                Rs. 24,650
                                <small>TOTAL REVENUE</small>
                            </span>
                        </div>
                    </div>

                    <ul class="category-list">

                    <?php foreach (($data['categories'] ?? []) as $category): ?>

                        <li>
                            <i
                                style="background: <?= htmlspecialchars(
                                    $category['color'] ?? '#0f766e'
                                ) ?>"
                            ></i>

                            <span>
                                <?= htmlspecialchars(
                                    $category['name'] ?? ''
                                ) ?>
                            </span>

                            <b>
                                <?= (int) (
                                    $category['percentage'] ?? 0
                                ) ?>%
                            </b>

                            <strong>
                                Rs.
                                <?= number_format(
                                    $category['revenue'] ?? 0
                                ) ?>
                            </strong>
                        </li>

                    <?php endforeach; ?>

                    </ul>

                </article>

                <!-- Top-selling products -->
                <article class="panel products-panel">

                    <div class="panel-heading">

                        <div>
                            <h2>Top Selling Products</h2>

                            <p>
                                Highest volume veterinary pharmaceuticals
                                and supplies
                            </p>
                        </div>

                        <a href="<?= URLROOT ?>/products/index">
                            View All Inventory →
                        </a>

                    </div>

                    <div class="table-scroll">

                        <table>

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product &amp; Category</th>
                                    <th>Units Sold</th>
                                    <th>Unit Price</th>
                                    <th>Total Revenue</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                            <?php foreach (
                                ($data['topProducts'] ?? []) as
                                $index => $product
                            ): ?>

                                <?php
                                $productStatus =
                                    $product['status'] ?? 'out';

                                $statusText =
                                    $productStatus === 'in'
                                        ? 'In Stock'
                                        : (
                                            $productStatus === 'low'
                                                ? 'Low Stock'
                                                : 'Out of Stock'
                                        );
                                ?>

                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars(
                                                $product['name'] ?? ''
                                            ) ?>
                                        </strong>

                                        <small>
                                            <?= htmlspecialchars(
                                                $product['category'] ?? ''
                                            ) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= (int) (
                                            $product['units'] ?? 0
                                        ) ?>
                                        units
                                    </td>

                                    <td>
                                        Rs.
                                        <?= number_format(
                                            $product['price'] ?? 0
                                        ) ?>
                                    </td>

                                    <td>
                                        <strong>
                                            Rs.
                                            <?= number_format(
                                                $product['revenue'] ?? 0
                                            ) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <span
                                            class="status status-<?= htmlspecialchars(
                                                $productStatus
                                            ) ?>"
                                        >
                                            <?= $statusText ?>
                                        </span>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </article>

                <!-- Executive performance report -->
                <aside class="panel executive-panel">

                    <div class="panel-heading">
                        <div>
                            <h2>Executive Performance Summary</h2>
                            <p>Current reporting period overview</p>
                        </div>

                        <span>◎</span>
                    </div>

                    <div class="executive-metrics">

                        <div>
                            <small>TOTAL REVENUE</small>
                            <strong>Rs. 24,650</strong>
                        </div>

                        <div>
                            <small>PRODUCTS SOLD</small>
                            <strong>86 units</strong>
                        </div>

                        <div>
                            <small>TOTAL ORDERS</small>
                            <strong>12 orders</strong>
                        </div>

                        <div>
                            <small>LOW STOCK</small>
                            <strong class="danger-text">
                                3 items •
                            </strong>
                        </div>

                    </div>

                    <div class="insight positive-box">
                        <span>⌁</span>

                        <p>
                            <strong>Best Performing Category</strong>
                            Nutrition &amp; Food made 42% of revenue
                            with +18% monthly growth.
                        </p>
                    </div>

                    <div class="insight blue-box">
                        <span>▣</span>

                        <p>
                            <strong>Clinic Operations Note</strong>
                            94.2% prescription accuracy; veterinary
                            checkout continues.
                        </p>
                    </div>

                    <div class="insight danger-box">
                        <span>△</span>

                        <p>
                            <strong>Reorder Recommendation</strong>
                            Place supplier purchase order for Ear Drops
                            and Puppy Milk Formula before Friday.
                        </p>
                    </div>

                    <div class="prepared-by">

                        <span>
                            Last run by Dr. Sarah Wilson
                        </span>

                        <button
                            type="button"
                            id="printSummary"
                        >
                            ♨ Print Summary
                        </button>

                    </div>

                </aside>

            </section>

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

<!-- Pass report data to the JavaScript chart -->
<script>
    window.reportData = <?= json_encode(
        $data['salesTrend'] ?? [],
        JSON_HEX_TAG |
        JSON_HEX_APOS |
        JSON_HEX_AMP |
        JSON_HEX_QUOT
    ) ?>;
</script>

<!-- Reports page JavaScript -->
<script src="<?= URLROOT ?>/js/reports.js"></script>

</body>
</html>