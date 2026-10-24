<?php
$purchases = $data['purchases'] ?? [];
$summary = $data['summary'];
$search = $data['search'] ?? '';
$period = $data['period'] ?? 'all';
$sort = $data['sort'] ?? 'newest';

$groupedPurchases = [];

foreach ($purchases as $item) {
    $orderId = (int)$item->order_id;

    if (!isset($groupedPurchases[$orderId])) {
        $groupedPurchases[$orderId] = [
            'order_id' => $orderId,
            'order_date' => $item->order_date,
            'collected_at' => $item->collected_at,
            'total_amount' => $item->total_amount,
            'payment_status' => $item->payment_status,
            'payment_method' => $item->payment_method,
            'items' => []
        ];
    }

    if (!empty($item->order_item_id)) {
        $groupedPurchases[$orderId]['items'][] = $item;
    }
}

function purchaseDate($date)
{
    if (empty($date)) {
        return 'Date not recorded';
    }

    return date('d M Y', strtotime($date));
}

function purchaseDateTime($date)
{
    if (empty($date)) {
        return 'Time not recorded';
    }

    return date('d F Y • h:i A', strtotime($date));
}

function purchaseMoney($amount)
{
    return 'Rs. ' . number_format((float)$amount, 2);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Purchase History | HappyPaws</title>

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/purchase-history.css">
</head>
<body>

<?php require APPROOT . '/views/layouts/petowner-sidebar.php'; ?>

<div class="main-content">

    <?php require APPROOT . '/views/layouts/petowner-topbar.php'; ?>

    <main class="purchase-page">

        <div class="purchase-heading">
            <div class="breadcrumb">
                <span>PET OWNER PORTAL</span>
                <span class="breadcrumb-dot">•</span>
                <span>PRODUCT STORE</span>
                <span class="breadcrumb-dot">•</span>
                <span class="breadcrumb-current">PURCHASE HISTORY</span>
            </div>

            <h1>Purchase History</h1>

            <p class="purchase-description">
                View your previous pet-care purchases and products
                collected from the HappyPaws clinic.
            </p>
        </div>

        <!-- Summary cards -->
        <section class="purchase-summary">

            <article class="purchase-summary-card">
                <div class="summary-icon purchases-icon">▤</div>
                <div>
                    <p>Total Purchases</p>
                    <div class="summary-value">
                        <?php echo (int)$summary->total_purchases; ?>
                    </div>
                    <span>orders fulfilled</span>
                </div>
            </article>

            <article class="purchase-summary-card">
                <div class="summary-icon products-icon">▣</div>
                <div>
                    <p>Products Collected</p>
                    <div class="summary-value">
                        <?php echo (int)$summary->products_collected; ?>
                    </div>
                    <span>items dispensed</span>
                </div>
            </article>

            <article class="purchase-summary-card">
                <div class="summary-icon collection-icon">▣</div>
                <div>
                    <p>Last Collection</p>
                    <div class="summary-last-date">
                        <?php
                        echo !empty($summary->last_collection)
                            ? htmlspecialchars(
                                purchaseDate($summary->last_collection)
                            )
                            : 'No collections yet';
                        ?>
                    </div>
                </div>
            </article>

        </section>

        <!-- Search and filters -->
        <form class="purchase-filter-bar"
              method="GET"
              action="<?php echo URLROOT; ?>/petowner/purchased">

            <div class="purchase-search">
                <span class="search-symbol">⌕</span>

                <input
                    type="search"
                    name="search"
                    value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="Search by product name or Purchase ID">
            </div>

            <div class="purchase-filter-options">

                <div class="period-buttons">
                    <?php
                    $periods = [
                        'all' => 'All Time',
                        'month' => 'This Month',
                        '3months' => 'Last 3 Months',
                        '6months' => 'Last 6 Months',
                        'year' => 'This Year'
                    ];
                    ?>

                    <?php foreach ($periods as $value => $label): ?>
                        <button
                            type="submit"
                            name="period"
                            value="<?php echo $value; ?>"
                            class="period-button <?php
                                echo $period === $value ? 'selected' : '';
                            ?>">
                            <?php echo htmlspecialchars($label); ?>
                        </button>
                    <?php endforeach; ?>
                </div>

                <select name="sort" aria-label="Sort purchases">
                    <option value="newest"
                        <?php echo $sort === 'newest' ? 'selected' : ''; ?>>
                        Sort: Newest First
                    </option>
                    <option value="oldest"
                        <?php echo $sort === 'oldest' ? 'selected' : ''; ?>>
                        Sort: Oldest First
                    </option>
                    <option value="total_high"
                        <?php echo $sort === 'total_high' ? 'selected' : ''; ?>>
                        Sort: Highest Total
                    </option>
                    <option value="total_low"
                        <?php echo $sort === 'total_low' ? 'selected' : ''; ?>>
                        Sort: Lowest Total
                    </option>
                </select>

            </div>
        </form>

        <!-- Purchase records -->
        <section class="purchase-records">

            <div class="purchase-records-heading">
                <h2>
                    Your Purchases
                    <span class="record-count">
                        <?php echo count($groupedPurchases); ?> records
                    </span>
                </h2>

                <span class="records-caption">
                    Showing <?php echo count($groupedPurchases); ?>
                    completed records
                </span>
            </div>

            <?php if (empty($groupedPurchases)): ?>

                <div class="purchase-empty-state">
                    <div class="empty-purchase-icon">▤</div>
                    <h3>No completed purchases found</h3>
                    <p>
                        Collected products will appear here once your
                        reservations have been marked as collected.
                    </p>

                    <?php if ($search !== '' || $period !== 'all'): ?>
                        <a href="<?php echo URLROOT; ?>/petowner/purchased">
                            Clear filters
                        </a>
                    <?php else: ?>
                        <a href="<?php echo URLROOT; ?>/petowner/store">
                            Browse Products
                        </a>
                    <?php endif; ?>
                </div>

            <?php else: ?>

                <?php foreach ($groupedPurchases as $purchase): ?>

                    <article class="purchase-card">

                        <header class="purchase-card-header">
                            <div class="purchase-identification">
                                <h3>
                                    #PUR-<?php
                                    echo str_pad(
                                        (string)$purchase['order_id'],
                                        6,
                                        '0',
                                        STR_PAD_LEFT
                                    );
                                    ?>
                                </h3>

                                <span class="purchase-separator">•</span>

                                <span class="purchase-date">
                                    ◷
                                    <?php
                                    echo htmlspecialchars(
                                        purchaseDateTime(
                                            $purchase['collected_at']
                                                ?: $purchase['order_date']
                                        )
                                    );
                                    ?>
                                </span>
                            </div>

                            <span class="collected-badge">
                                <span>✓</span> Collected
                            </span>
                        </header>

                        <div class="purchase-location-row">
                            <span>⌖ HappyPaws Clinic</span>
                            <span>
                                <?php
                                echo !empty($purchase['payment_status'])
                                    ? 'Payment: ' . htmlspecialchars(
                                        $purchase['payment_status']
                                    )
                                    : '';
                                ?>
                            </span>
                        </div>

                        <div class="purchase-items">

                            <?php foreach ($purchase['items'] as $item): ?>

                                <div class="purchase-item">

                                    <div class="purchase-product-image">
                                        <?php if (!empty($item->image_url)): ?>
                                            <img
                                                src="<?php echo htmlspecialchars($item->image_url); ?>"
                                                alt="<?php echo htmlspecialchars($item->product_name_snapshot); ?>">
                                        <?php else: ?>
                                            <span>🐾</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="purchase-product-info">
                                        <h4>
                                            <?php echo htmlspecialchars(
                                                $item->product_name_snapshot
                                            ); ?>
                                        </h4>

                                        <p>
                                            <?php echo (int)$item->quantity; ?>
                                            ×
                                            <?php echo purchaseMoney(
                                                $item->unit_price
                                            ); ?>
                                        </p>
                                    </div>

                                    <div class="purchase-item-total">
                                        <?php echo purchaseMoney($item->subtotal); ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <footer class="purchase-card-footer">

                            <div class="purchase-total">
                                <span>Total</span>
                                <strong>
                                    <?php echo purchaseMoney(
                                        $purchase['total_amount']
                                    ); ?>
                                </strong>

                                <?php if (!empty($purchase['payment_method'])): ?>
                                    <small>
                                        <?php echo htmlspecialchars(
                                            $purchase['payment_method']
                                        ); ?>
                                    </small>
                                <?php endif; ?>
                            </div>

                            <button
                                type="button"
                                class="purchase-details-button"
                                onclick="showPurchaseDetails(<?php
                                    echo (int)$purchase['order_id'];
                                ?>)">
                                View Receipt / Details
                            </button>

                        </footer>

                        <div
                            class="purchase-details-content"
                            id="purchase-details-<?php
                                echo (int)$purchase['order_id'];
                            ?>"
                            hidden>

                            <h4>Purchase Details</h4>

                            <p>
                                Purchase ID:
                                PUR-<?php echo str_pad(
                                    (string)$purchase['order_id'],
                                    6,
                                    '0',
                                    STR_PAD_LEFT
                                ); ?>
                            </p>

                            <p>
                                Original order date:
                                <?php echo htmlspecialchars(
                                    purchaseDateTime($purchase['order_date'])
                                ); ?>
                            </p>

                            <p>
                                Collection date:
                                <?php echo htmlspecialchars(
                                    purchaseDateTime($purchase['collected_at'])
                                ); ?>
                            </p>

                            <p>
                                Payment status:
                                <?php echo htmlspecialchars(
                                    $purchase['payment_status'] ?: 'Not recorded'
                                ); ?>
                            </p>

                            <p>
                                Total:
                                <?php echo purchaseMoney(
                                    $purchase['total_amount']
                                ); ?>
                            </p>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </main>
</div>

<script>
function showPurchaseDetails(orderId) {
    const details = document.getElementById(
        'purchase-details-' + orderId
    );

    if (!details) {
        return;
    }

    details.hidden = !details.hidden;

    if (!details.hidden) {
        details.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }
}
</script>

<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>
<script src="<?php echo URLROOT; ?>/js/purchase-history.js"></script>

</body>
</html>