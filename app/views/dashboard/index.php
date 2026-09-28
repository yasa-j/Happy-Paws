<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($data['pageTitle'] ?? 'Dashboard') ?> | HappyPaws
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

    <!-- Dashboard stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/dashboard.css"
    >

    <!-- Shared sidebar stylesheet -->
    <link 
        rel="stylesheet"
        href="<?= URLROOT ?>/css/sidebar.css"
    >
</head>

<body>

<!-- Main dashboard layout -->
<div class="dashboard-layout">

    <!-- Sidebar navigation -->
    <aside class="sidebar">

        <!-- Website logo -->
        <a
            class="brand"
            href="<?= URLROOT ?>/dashboard/index"
        >
          <!--  <span class="brand-icon">✚</span> -->

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

        <!-- Main navigation links -->
        <nav class="side-menu">

            <a
                class="active"
                href="<?= URLROOT ?>/dashboard/index"
            >
                <span>▦</span>
                Dashboard
            </a>

            <a href="<?= URLROOT ?>/products/index">
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
                <span>△</span>
                Low Stock Alerts
                <i></i>
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

    <!-- Main dashboard content -->
    <main class="main-content">

        <!-- Top navigation bar -->
        <header class="topbar">

            <!-- Dashboard search box -->
            <label class="search-box">
                <span>⌕</span>

                <input
                    type="search"
                    id="dashboardSearch"
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

                    <div>
                        <strong>Sarah Wilson</strong>
                        
                    </div>

                    <span class="avatar">SW</span>

                </div>

            </div>

        </header>

        <div class="page-container">

            <!-- Welcome section -->
            <section class="welcome-section">

                <div>
                    <h1>
                        Welcome back
                        
                    </h1>

                    <p>
                        Here’s what’s happening at your veterinary clinic today.
                    </p>
                </div>

                <div class="welcome-actions">

                    <!-- Display the current server date -->
                    <time>
                        <?= date('l, M d, Y') ?>
                    </time>

                    <button
                        type="button"
                        id="exportButton"
                    >
                        ⇩ Export Summary
                    </button>

                </div>

            </section>

            <!-- Dashboard statistics -->
            <section class="stats-grid">

                <!-- Total products card -->
                <article class="stat-card">

                    <div>
                        <small>TOTAL PRODUCTS</small>

                        <strong>
                            <?= (int) ($data['totalProducts'] ?? 0) ?>
                        </strong>

                        <p class="green">
                            ↑ 4 added this month
                        </p>
                    </div>

                    <span class="circle-icon green-icon">▣</span>

                </article>

                <!-- Total orders card -->
                <article class="stat-card">

                    <div>
                        <small>TOTAL ORDERS</small>

                        <strong>
                            <?= (int) ($data['totalOrders'] ?? 0) ?>
                        </strong>

                        <p class="blue">
                            ● 8 completed today
                        </p>
                    </div>

                    <span class="circle-icon blue-icon">▤</span>

                </article>

                <!-- Low stock items card -->
                <article class="stat-card">

                    <div>
                        <small>LOW STOCK ITEMS</small>

                        <strong>
                            <?= (int) ($data['lowStockItems'] ?? 0) ?>
                        </strong>

                        <p class="red">
                            Requires reorder
                        </p>
                    </div>

                    <span class="circle-icon red-icon">△</span>

                </article>

                <!-- Total revenue card -->
                <article class="stat-card">

                    <div>
                        <small>TOTAL REVENUE</small>

                        <strong>
                            Rs. <?= number_format($data['totalRevenue'] ?? 0) ?>
                        </strong>

                        <p class="green">
                            ↑ 14.2% from last week
                        </p>
                    </div>

                    <span class="circle-icon green-icon">▧</span>

                </article>

            </section>

            <!-- Main dashboard information area -->
            <section class="content-grid">

                <div class="left-column">

                    <!-- Sales chart -->
                    <article class="card sales-card">

                        <div class="card-heading">

                            <div>
                                <h2>Sales Overview</h2>

                                <span class="small-tag">
                                    Pharmacy &amp; Dispensary
                                </span>
                            </div>

                            <!-- Sales chart period buttons -->
                            <div class="chart-tabs">

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

                                <button
                                    type="button"
                                    data-period="yearly"
                                >
                                    Yearly
                                </button>

                            </div>

                        </div>

                        <!-- Sales information -->
                        <div class="sales-info">

                            <div>
                                <small>Average Daily</small>
                                <b>Rs. 3,521</b>
                            </div>

                            <div>
                                <small>Peak Dispensation</small>
                                <b>Sat (Rs. 6,800)</b>
                            </div>

                            <div>
                                <small>Avg Prescriptions / Day</small>
                                <b>14.8 scripts</b>
                            </div>

                        </div>

                        <!--
                            Weekly sales data is converted to JSON and passed
                            to dashboard.js through the data-sales attribute.
                        -->
                        <div
                            class="chart-area"
                            id="salesChart"
                            data-sales='<?= htmlspecialchars(
                                json_encode($data['weeklySales'] ?? []),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>'
                        >

                            <!-- Vertical chart labels -->
                            <div class="chart-y-labels">
                                <span>Rs. 40k</span>
                                <span>Rs. 30k</span>
                                <span>Rs. 20k</span>
                                <span>Rs. 10k</span>
                                <span>Rs. 0</span>
                            </div>

                            <!-- SVG sales chart -->
                            <svg
                                viewBox="0 0 700 230"
                                preserveAspectRatio="none"
                                aria-label="Weekly sales chart"
                            >
                                <defs>
                                    <linearGradient
                                        id="salesFill"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            offset="0"
                                            stop-color="#86efac"
                                            stop-opacity=".5"
                                        />

                                        <stop
                                            offset="1"
                                            stop-color="#86efac"
                                            stop-opacity=".06"
                                        />
                                    </linearGradient>
                                </defs>

                                <polygon
                                    id="chartFill"
                                    fill="url(#salesFill)"
                                ></polygon>

                                <polyline
                                    id="chartLine"
                                    fill="none"
                                    stroke="#0f766e"
                                    stroke-width="4"
                                    vector-effect="non-scaling-stroke"
                                ></polyline>

                                <g id="chartDots"></g>
                            </svg>

                            <!-- Horizontal chart labels -->
                            <div
                                class="chart-x-labels"
                                id="chartLabels"
                            ></div>

                        </div>

                    </article>

                    <!-- Recent orders section -->
                    <article class="card orders-card">

                        <div class="card-heading">

                            <div>
                                <h2>Recent Orders</h2>

                                <span class="small-tag">
                                    Today’s Log
                                </span>
                            </div>

                            <a href="<?= URLROOT ?>/orders/index">
                                View All Orders →
                            </a>

                        </div>

                        <!-- Recent orders table -->
                        <div class="table-wrapper">

                            <table id="ordersTable">

                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer &amp; Pet</th>
                                        <th>Items Prescribed</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php foreach (($data['recentOrders'] ?? []) as $order): ?>

                                    <tr>

                                        <td>
                                            <b>
                                                <?= htmlspecialchars(
                                                    $order['id'] ?? ''
                                                ) ?>
                                            </b>
                                        </td>

                                        <td>
                                            <strong>
                                                <?= htmlspecialchars(
                                                    $order['customer'] ?? ''
                                                ) ?>
                                            </strong>

                                            <small>
                                                🐾
                                                <?= htmlspecialchars(
                                                    $order['pet'] ?? ''
                                                ) ?>
                                            </small>
                                        </td>

                                        <td>
                                            <span class="item-label">
                                                <?= htmlspecialchars(
                                                    $order['items'] ?? ''
                                                ) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <b>
                                                Rs.
                                                <?= number_format(
                                                    $order['total'] ?? 0
                                                ) ?>
                                            </b>
                                        </td>

                                        <td>
                                            <?php
                                            $orderStatus =
                                                $order['status'] ?? 'Pending';

                                            $statusClass =
                                                strtolower(
                                                    str_replace(
                                                        ' ',
                                                        '-',
                                                        $orderStatus
                                                    )
                                                );
                                            ?>

                                            <span
                                                class="status <?= htmlspecialchars($statusClass) ?>"
                                            >
                                                <?= htmlspecialchars($orderStatus) ?>
                                            </span>
                                        </td>

                                        <td>
                                            <button
                                                class="action-button"
                                                type="button"
                                                aria-label="View order"
                                            >
                                                ◎
                                            </button>
                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </article>

                </div>

                <!-- Right side dashboard column -->
                <aside class="right-column">

                    <!-- Quick action links -->
                    <article class="card quick-actions">

                        <div class="card-heading">
                            <h2>ϟ Quick Actions</h2>
                            <small>Shortcuts</small>
                        </div>

                        <!-- This link currently opens the Manage Products page -->
                        <a
                            class="quick-action primary"
                            href="<?= URLROOT ?>/manage-products/index"
                        >
                            <span>▣</span>

                            <div>
                                <b>Add Product</b>
                                <small>Register new medicine or item</small>
                            </div>

                            <i>›</i>
                        </a>

                        <a
                            class="quick-action"
                            href="<?= URLROOT ?>/manage-products/index"
                        >
                            <span>▦</span>

                            <div>
                                <b>Manage Products</b>
                                <small>Update pricing, batches, expiries</small>
                            </div>

                            <i>›</i>
                        </a>

                        <a
                            class="quick-action"
                            href="<?= URLROOT ?>/orders/index"
                        >
                            <span>▤</span>

                            <div>
                                <b>View Orders</b>
                                <small>Track and process clinic orders</small>
                            </div>

                            <i>›</i>
                        </a>

                        <a
                            class="quick-action"
                            href="<?= URLROOT ?>/low-stock-alerts/index"
                        >
                            <span>△</span>

                            <div>
                                <b>Low Stock Alerts</b>
                                <small>Review items below threshold</small>
                            </div>

                            <i>›</i>
                        </a>

                    </article>

                    <!-- Critical stock watchlist -->
                    <article class="card watchlist">

                        <div class="card-heading">
                            <h2>
                                <span>✱</span>
                                Critical Watchlist
                            </h2>

                            <b>URGENT</b>
                        </div>

                        <p>
                            Pharmaceuticals currently below safety stock
                            limits for emergency procedures.
                        </p>

                        <?php foreach (($data['criticalItems'] ?? []) as $item): ?>

                            <div class="stock-row">

                                <span>▣</span>

                                <div>
                                    <b>
                                        <?= htmlspecialchars(
                                            $item['name'] ?? ''
                                        ) ?>
                                    </b>

                                    <small>
                                        Minimum:
                                        <?= (int) ($item['minimum'] ?? 0) ?>
                                    </small>
                                </div>

                                <strong>
                                    <?= htmlspecialchars(
                                        $item['stock'] ?? ''
                                    ) ?>
                                </strong>

                            </div>

                        <?php endforeach; ?>

                        <button
                            class="reorder-button"
                            type="button"
                        >
                            🛒 Reorder All
                            <?= count($data['criticalItems'] ?? []) ?>
                            Items
                        </button>

                    </article>

                </aside>

            </section>

            <!-- Display the user count received from the database -->
            <p class="database-note">
                Registered system users:
                <b><?= (int) ($data['totalUsers'] ?? 0) ?></b>
            </p>

        </div>

        <!-- Dashboard footer -->
        <footer class="page-footer">

            <span>
                © <?= date('Y') ?> HappyPaws Veterinary Care.
                All rights reserved.
            </span>

            <nav>
                <a href="#">Documentation</a>
                <a href="#">Support</a>
                <a href="#">Privacy Policy</a>
            </nav>

        </footer>

    </main>

</div>

<!-- Dashboard JavaScript -->
<script src="<?= URLROOT ?>/js/dashboard.js"></script>

</body>
</html>