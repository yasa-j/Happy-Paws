
<?php
// Group the database rows by reservation.
// A reservation can contain more than one product.
$groupedReservations = [];

if (!empty($data['reservations'])) {
    foreach ($data['reservations'] as $item) {
        $orderId = $item->order_id;

        if (!isset($groupedReservations[$orderId])) {
            $groupedReservations[$orderId] = [
                'order_id' => $item->order_id,
                'order_date' => $item->order_date,
                'total_amount' => $item->total_amount,
                'status' => $item->status,
                'reservation_expires_at' => $item->reservation_expires_at,
                'collected_at' => $item->collected_at,
                'items' => []
            ];
        }

        if (!empty($item->order_item_id)) {
            $groupedReservations[$orderId]['items'][] = $item;
        }
    }
}

$summary = $data['summary'];
$cartCount = isset($data['cartCount']) ? (int)$data['cartCount'] : 0;
$message = isset($data['message']) ? $data['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reserved Products | HappyPaws</title>

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/reserved-products.css">
</head>
<body>

<?php require APPROOT . '/views/layouts/petowner-sidebar.php'; ?>

<div class="main-content">

    <?php require APPROOT . '/views/layouts/petowner-topbar.php'; ?>

    <main class="reserved-page">

        <div class="page-heading">
            <div>
                <p class="eyebrow">PRODUCT STORE</p>
                <h1>Reserved Products</h1>
                <p class="page-description">
                    Keep track of the products you've reserved for collection
                    at the clinic.
                </p>
            </div>

            <a class="browse-button"
               href="<?php echo URLROOT; ?>/petowner/store">
                + Browse Products
            </a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="reservation-message">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <section class="reservation-summary">

            <div class="summary-card">
                <div class="summary-icon total-icon">▤</div>
                <div>
                    <p>Total Reservations</p>
                    <h2><?php echo (int)$summary->total_reservations; ?></h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon active-icon">✓</div>
                <div>
                    <p>Active Reservations</p>
                    <h2><?php echo (int)$summary->active_reservations; ?></h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon ready-icon">⌂</div>
                <div>
                    <p>Ready for Collection</p>
                    <h2><?php echo (int)$summary->ready_for_collection; ?></h2>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon expired-icon">◷</div>
                <div>
                    <p>Expired / Cancelled</p>
                    <h2>
                        <?php
                        echo (int)$summary->expired_reservations
                           + (int)$summary->cancelled_reservations;
                        ?>
                    </h2>
                </div>
            </div>

        </section>

        <section class="reservations-section">

            <div class="section-heading">
                <div>
                    <h2>Your Reservations</h2>
                    <p>View reservation details and collection status.</p>
                </div>

                <span class="reservation-count">
                    <?php echo count($groupedReservations); ?> reservations
                </span>
            </div>

            <?php if (empty($groupedReservations)): ?>

                <div class="empty-reservations">
                    <div class="empty-icon">🛍️</div>
                    <h2>No reservations yet</h2>
                    <p>
                        Products you reserve from the store will appear here.
                        You can collect them during your clinic visit.
                    </p>
                    <a class="browse-button"
                       href="<?php echo URLROOT; ?>/petowner/store">
                        Explore Products
                    </a>
                </div>

            <?php else: ?>

                <?php foreach ($groupedReservations as $reservation): ?>

                    <?php
                    $status = $reservation['status'];

                    $statusClass = 'status-default';

                    if ($status === 'Reserved') {
                        $statusClass = 'status-reserved';
                    } elseif ($status === 'Processing') {
                        $statusClass = 'status-processing';
                    } elseif ($status === 'Ready for Collection') {
                        $statusClass = 'status-ready';
                    } elseif ($status === 'Collected') {
                        $statusClass = 'status-collected';
                    } elseif ($status === 'Cancelled') {
                        $statusClass = 'status-cancelled';
                    } elseif ($status === 'Expired') {
                        $statusClass = 'status-expired';
                    }

                    $expiresAt = $reservation['reservation_expires_at'];

                    $canCancel = in_array(
                        $status,
                        ['Reserved', 'Processing', 'Ready for Collection'],
                        true
                    );

                    if (!empty($expiresAt) && strtotime($expiresAt) <= time()) {
                        $canCancel = false;
                    }
                    ?>

                    <article class="reservation-card">

                        <div class="reservation-card-header">
                            <div>
                                <span class="reservation-number">
                                    RESERVATION #<?php
                                    echo (int)$reservation['order_id'];
                                    ?>
                                </span>

                                <p class="reservation-date">
                                    Reserved on
                                    <?php
                                    echo !empty($reservation['order_date'])
                                        ? date(
                                            'd M Y, h:i A',
                                            strtotime($reservation['order_date'])
                                        )
                                        : '—';
                                    ?>
                                </p>
                            </div>

                            <span class="status-badge <?php echo $statusClass; ?>">
                                <?php echo htmlspecialchars($status); ?>
                            </span>
                        </div>

                        <div class="reservation-items">

                            <?php foreach ($reservation['items'] as $item): ?>

                                <div class="reserved-product">

                                    <div class="reserved-product-image">
                                        <?php if (!empty($item->image_url)): ?>
                                            <img
                                                src="<?php
                                                echo htmlspecialchars($item->image_url);
                                                ?>"
                                                alt="<?php
                                                echo htmlspecialchars(
                                                    $item->product_name_snapshot
                                                );
                                                ?>">
                                        <?php else: ?>
                                            <span>🐾</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="reserved-product-info">
                                        <h3>
                                            <?php
                                            echo htmlspecialchars(
                                                $item->product_name_snapshot
                                            );
                                            ?>
                                        </h3>

                                        <p>
                                            Quantity:
                                            <?php echo (int)$item->quantity; ?>
                                        </p>

                                        <p>
                                            Unit price:
                                            Rs. <?php
                                            echo number_format(
                                                (float)$item->unit_price,
                                                2
                                            );
                                            ?>
                                        </p>
                                    </div>

                                    <div class="reserved-product-price">
                                        Rs. <?php
                                        echo number_format(
                                            (float)$item->subtotal,
                                            2
                                        );
                                        ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                        <div class="reservation-card-footer">

                            <div class="reservation-expiry">

                                <?php if ($status === 'Collected'): ?>

                                    <span class="expiry-label">Collected</span>
                                    <p>
                                        <?php
                                        echo !empty($reservation['collected_at'])
                                            ? date(
                                                'd M Y, h:i A',
                                                strtotime(
                                                    $reservation['collected_at']
                                                )
                                            )
                                            : 'Collection completed';
                                        ?>
                                    </p>

                                <?php elseif ($status === 'Expired'): ?>

                                    <span class="expiry-label">Reservation expired</span>
                                    <p>This reservation is no longer active.</p>

                                <?php elseif ($status === 'Cancelled'): ?>

                                    <span class="expiry-label">Reservation cancelled</span>
                                    <p>This reservation has been cancelled.</p>

                                
                                <?php elseif (!empty($expiresAt)): ?>

                                    <span class="expiry-label">Collection deadline</span>

                                    <p>
                                        <?php
                                        echo date(
                                            'd M Y, h:i A',
                                            strtotime($expiresAt)
                                        );
                                        ?>
                                    </p>

                                    <?php if ($canCancel): ?>
                                        <p
                                            class="reservation-countdown"
                                            data-expiry="<?php
                                            echo htmlspecialchars(
                                                date('Y-m-d H:i:s', strtotime($expiresAt))
                                            );
                                            ?>">
                                            Calculating time remaining...
                                        </p>
                                    <?php endif; ?>

                                <?php else: ?>

                                    <span class="expiry-label">Collection deadline</span>
                                    <p>Not available</p>

                                <?php endif; ?>


                            </div>

                            <div class="reservation-total">
                                <span>Total</span>
                                <strong>
                                    Rs. <?php
                                    echo number_format(
                                        (float)$reservation['total_amount'],
                                        2
                                    );
                                    ?>
                                </strong>
                            </div>

                            <?php if ($canCancel): ?>

                                <form
                                    action="<?php
                                    echo URLROOT;
                                    ?>/petowner/cancelReservation"
                                    method="POST"
                                    class="cancel-reservation-form"
                                    onsubmit="return confirm(
                                        'Are you sure you want to cancel this reservation?'
                                    );">

                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="<?php
                                        echo (int)$reservation['order_id'];
                                        ?>">

                                    <button type="submit" class="cancel-button">
                                        Cancel Reservation
                                    </button>

                                </form>

                            <?php endif; ?>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </main>
</div>

<script src="<?php echo URLROOT; ?>/js/reserved-products.js"></script>
<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>


</body>
</html>
