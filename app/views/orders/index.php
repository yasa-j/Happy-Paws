<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($data['pageTitle'] ?? 'Orders') ?> | HappyPaws
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

    <!-- Orders page stylesheet -->
    <link
        rel="stylesheet"
        href="<?= URLROOT ?>/css/orders.css"
    >
</head>

<body>

<!-- Main application layout -->
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

        <!-- Connected navigation links -->
        <nav class="side-menu">

            <a href="<?= URLROOT ?>/dashboard/index">
                ▦ Dashboard
            </a>

            <a href="<?= URLROOT ?>/products/index">
                ▣ Products
            </a>

            <a href="<?= URLROOT ?>/manage-products/index">
                ▤ Manage Products
            </a>

            <a
                class="active"
                href="<?= URLROOT ?>/orders/index"
            >
                🛒 Orders
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

    <!-- Main order content -->
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
                    <b>Dr. Sarah Wilson</b>
                    <small>Clinic Admin</small>
                </span>
            </div>

        </header>

        <div class="page-container">

            <!-- Page heading and order actions -->
            <section class="page-heading">

                <div>
                    <p>
                        HAPPYPAWS INVENTORY /
                        <b>DISPENSARY &amp; ORDERS</b>
                    </p>

                    <h1>Orders</h1>

                    <span>View and manage customer orders.</span>
                </div>

                <div class="heading-actions">

                    <button
                        type="button"
                        id="exportOrders"
                    >
                        ⇩ Export Orders
                    </button>

                    <!-- New Order will be connected during CRUD development -->
                    <a href="#">＋ New Order</a>

                </div>

            </section>

            <!-- Order summary cards -->
            <section class="summary-grid">

                <article>
                    <div>
                        <small>TOTAL ORDERS</small>

                        <strong>
                            <?= (int) ($data['summary']['total'] ?? 0) ?>
                        </strong>

                        <em>↗ +3 today</em>
                    </div>

                    <i>▣</i>
                </article>

                <article>
                    <div>
                        <small>COMPLETED ORDERS</small>

                        <strong>
                            <?= (int) ($data['summary']['completed'] ?? 0) ?>
                        </strong>

                        <em class="green">66.7% fulfilled</em>
                    </div>

                    <i class="green-icon">✓</i>
                </article>

                <article>
                    <div>
                        <small>IN PROCESSING</small>

                        <strong>
                            <?= (int) ($data['summary']['processing'] ?? 0) ?>
                        </strong>

                        <em class="blue">Lab &amp; Dispensary</em>
                    </div>

                    <i class="blue-icon">↻</i>
                </article>

                <article>
                    <div>
                        <small>PENDING REVIEW</small>

                        <strong>
                            <?= (int) ($data['summary']['pending'] ?? 0) ?>
                        </strong>

                        <em>Pickup counter</em>
                    </div>

                    <i class="red-icon">▧</i>
                </article>

            </section>

            <!-- Order search and filters -->
            <section class="filter-card">

                <label>
                    <span>⌕</span>

                    <input
                        id="orderSearch"
                        type="search"
                        placeholder="Search by order ID or customer..."
                    >
                </label>

                <select id="orderStatus">
                    <option value="all">All Statuses</option>
                    <option value="Completed">Completed</option>
                    <option value="Processing">Processing</option>
                    <option value="Pending">Pending</option>
                </select>

                <input
                    id="orderDate"
                    type="date"
                >

                <button
                    type="button"
                    id="orderFilter"
                >
                    ⚑ Filter
                </button>

                <button
                    type="button"
                    id="orderReset"
                >
                    Reset
                </button>

            </section>

            <?php $orders = $data['orders'] ?? []; ?>

            <!-- Customer order table -->
            <section class="table-card">

                <div class="table-wrapper">

                    <table id="ordersTable">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Customer &amp; Patient</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($orders as $order): ?>

                            <?php
                            $orderStatus = $order['status'] ?? 'Pending';

                            $statusClass = strtolower(
                                str_replace(' ', '-', $orderStatus)
                            );
                            ?>

                            <tr data-status="<?= htmlspecialchars($orderStatus) ?>">

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
                                            $order['date'] ?? ''
                                        ) ?>
                                    </strong>

                                    <small>
                                        <?= htmlspecialchars(
                                            $order['time'] ?? ''
                                        ) ?>
                                    </small>
                                </td>

                                <td>
                                    <div class="customer-cell">

                                        <span>
                                            <?= htmlspecialchars(
                                                $order['initials'] ?? ''
                                            ) ?>
                                        </span>

                                        <div>
                                            <b>
                                                <?= htmlspecialchars(
                                                    $order['customer'] ?? ''
                                                ) ?>
                                            </b>

                                            <small>
                                                ♧
                                                <?= htmlspecialchars(
                                                    ($order['pet'] ?? '') .
                                                    ' (' .
                                                    ($order['animal'] ?? '') .
                                                    ')'
                                                ) ?>
                                            </small>
                                        </div>

                                    </div>
                                </td>

                                <td>
                                    <b>
                                        Rs.
                                        <?= number_format(
                                            $order['total'] ?? 0,
                                            2
                                        ) ?>
                                    </b>
                                </td>

                                <td>
                                    <span
                                        class="status <?= htmlspecialchars(
                                            $statusClass
                                        ) ?>"
                                    >
                                        <?= htmlspecialchars($orderStatus) ?>
                                    </span>
                                </td>

                                <td>
                                    <button
                                        type="button"
                                        class="view-order"
                                        aria-label="View order"
                                    >
                                        ◎
                                    </button>

                                    <button
                                        type="button"
                                        class="delete-order"
                                        aria-label="Delete order"
                                    >
                                        ▱
                                    </button>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <!-- Table footer -->
                <footer>

                    <span id="orderCount">
                        Showing 1–<?= count($orders) ?> of
                        <?= (int) ($data['summary']['total'] ?? 0) ?>
                        orders
                    </span>

                    <label>
                        Rows per page:

                        <select>
                            <option>5</option>
                            <option>10</option>
                            <option>20</option>
                        </select>
                    </label>

                    <nav id="orderPages">

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
                        <button type="button">3</button>
                        <button type="button">›</button>

                    </nav>

                </footer>

            </section>

        </div>

    </main>

</div>

<!-- Orders page JavaScript -->
<script src="<?= URLROOT ?>/js/orders.js"></script>

</body>
</html>