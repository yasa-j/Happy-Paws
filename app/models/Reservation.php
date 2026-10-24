
<?php
class Reservation
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /*
     * Create a new product reservation.
     * Stock reduction and reservation creation happen together.
     */
    public function createReservation($userId, $productId, $quantity)
    {
        $userId = (int)$userId;
        $productId = (int)$productId;
        $quantity = (int)$quantity;

        if ($userId <= 0 || $productId <= 0 || $quantity <= 0) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            // Lock the product row while checking its stock.
            $this->db->query("
                SELECT product_id, name, price, stock_quantity, status
                FROM products
                WHERE product_id = :product_id
                FOR UPDATE
            ");
            $this->db->bind(':product_id', $productId);
            $product = $this->db->single();

            if (
                !$product ||
                $product->status !== 'In Stock' ||
                (int)$product->stock_quantity < $quantity
            ) {
                $this->db->rollBack();
                return false;
            }

            $unitPrice = (float)$product->price;
            $totalAmount = $unitPrice * $quantity;

            // Create the reservation with a 24-hour expiry.
            $this->db->query("
                INSERT INTO product_orders
                    (user_id, total_amount, status, reservation_expires_at)
                VALUES
                    (:user_id, :total_amount, 'Reserved',
                     DATE_ADD(NOW(), INTERVAL 24 HOUR))
            ");
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':total_amount', $totalAmount);
            $this->db->execute();

            $orderId = $this->db->lastInsertId();

            // Save the reserved product details.
            $this->db->query("
                INSERT INTO order_items
                    (order_id, product_id, product_name_snapshot,
                     quantity, unit_price, subtotal)
                VALUES
                    (:order_id, :product_id, :product_name,
                     :quantity, :unit_price, :subtotal)
            ");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':product_id', $productId);
            $this->db->bind(':product_name', $product->name);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':unit_price', $unitPrice);
            $this->db->bind(':subtotal', $totalAmount);
            $this->db->execute();

            // Reduce stock only if enough stock remains.
            $this->db->query("
                UPDATE products
                SET stock_quantity = stock_quantity - :quantity
                WHERE product_id = :product_id
                  AND stock_quantity >= :quantity
            ");
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':product_id', $productId);
            $this->db->execute();

            if ($this->db->rowCount() !== 1) {
                throw new Exception('Unable to update product stock.');
            }

            $this->db->commit();

            return $orderId;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /*
     * Restore stock and mark expired reservations.
     * The status is changed before stock is restored, inside the
     * same transaction, to prevent restoring the same stock twice.
     */
    public function expireReservations()
    {
        try {
            $this->db->beginTransaction();

            $this->db->query("
                SELECT order_id
                FROM product_orders
                WHERE status IN (
                    'Reserved',
                    'Processing',
                    'Ready for Collection'
                )
                AND reservation_expires_at IS NOT NULL
                AND reservation_expires_at <= NOW()
                FOR UPDATE
            ");

            $expiredOrders = $this->db->resultSet();

            foreach ($expiredOrders as $order) {
                // Only restore stock if this reservation is changed
                // from an active status to Expired successfully.
                $this->db->query("
                    UPDATE product_orders
                    SET status = 'Expired'
                    WHERE order_id = :order_id
                      AND status IN (
                          'Reserved',
                          'Processing',
                          'Ready for Collection'
                      )
                      AND reservation_expires_at <= NOW()
                ");
                $this->db->bind(':order_id', $order->order_id);
                $this->db->execute();

                if ($this->db->rowCount() === 1) {
                    $this->restoreReservationStock($order->order_id);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /*
     * Cancel a reservation belonging to the specified pet owner.
     */
    public function cancelReservation($orderId, $userId)
    {
        $orderId = (int)$orderId;
        $userId = (int)$userId;

        if ($orderId <= 0 || $userId <= 0) {
            return false;
        }

        try {
            // Process expired reservations first so their stock is
            // restored by the expiry logic, not by cancellation.
            $this->expireReservations();

            $this->db->beginTransaction();

            $this->db->query("
                SELECT order_id
                FROM product_orders
                WHERE order_id = :order_id
                  AND user_id = :user_id
                  AND status IN (
                      'Reserved',
                      'Processing',
                      'Ready for Collection'
                  )
                  AND (
                      reservation_expires_at IS NULL
                      OR reservation_expires_at > NOW()
                  )
                FOR UPDATE
            ");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':user_id', $userId);
            $reservation = $this->db->single();

            if (!$reservation) {
                $this->db->rollBack();
                return false;
            }

            $this->db->query("
                UPDATE product_orders
                SET status = 'Cancelled'
                WHERE order_id = :order_id
                  AND user_id = :user_id
                  AND status IN (
                      'Reserved',
                      'Processing',
                      'Ready for Collection'
                  )
                  AND (
                      reservation_expires_at IS NULL
                      OR reservation_expires_at > NOW()
                  )
            ");
            $this->db->bind(':order_id', $orderId);
            $this->db->bind(':user_id', $userId);
            $this->db->execute();

            if ($this->db->rowCount() !== 1) {
                throw new Exception('Reservation could not be cancelled.');
            }

            // Stock is restored only after a successful cancellation.
            $this->restoreReservationStock($orderId);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /*
     * Add the quantities from a reservation back to product stock.
     * Call this only after changing the reservation's status.
     */
    private function restoreReservationStock($orderId)
    {
        $this->db->query("
            SELECT product_id, quantity
            FROM order_items
            WHERE order_id = :order_id
        ");
        $this->db->bind(':order_id', (int)$orderId);
        $items = $this->db->resultSet();

        foreach ($items as $item) {
            $this->db->query("
                UPDATE products
                SET stock_quantity = stock_quantity + :quantity
                WHERE product_id = :product_id
            ");
            $this->db->bind(':quantity', (int)$item->quantity);
            $this->db->bind(':product_id', (int)$item->product_id);
            $this->db->execute();
        }
    }

    /*
     * Return reservation rows for one pet owner.
     * Each reservation may appear in multiple rows if it has
     * multiple products.
     */
    public function getReservationsByUser($userId)
    {
        $this->db->query("
            SELECT
                po.order_id,
                po.user_id,
                po.order_date,
                po.total_amount,
                po.status,
                po.payment_status,
                po.reservation_expires_at,
                po.collected_at,
                oi.order_item_id,
                oi.product_id,
                oi.product_name_snapshot,
                oi.quantity,
                oi.unit_price,
                oi.subtotal,
                p.image_url
            FROM product_orders po
            LEFT JOIN order_items oi
                ON po.order_id = oi.order_id
            LEFT JOIN products p
                ON oi.product_id = p.product_id
            WHERE po.user_id = :user_id
            ORDER BY
                po.order_date DESC,
                po.order_id DESC,
                oi.order_item_id ASC
        ");

        $this->db->bind(':user_id', (int)$userId);
        return $this->db->resultSet();
    }

    /*
     * Return summary counts for the reservation page.
     */
    public function getReservationSummary($userId)
    {
        $this->db->query("
            SELECT
                COUNT(*) AS total_reservations,

                COALESCE(SUM(
                    CASE
                        WHEN status IN (
                            'Reserved',
                            'Processing',
                            'Ready for Collection'
                        )
                        AND (
                            reservation_expires_at IS NULL
                            OR reservation_expires_at >= NOW()
                        )
                        THEN 1 ELSE 0
                    END
                ), 0) AS active_reservations,

                COALESCE(SUM(
                    CASE
                        WHEN status = 'Ready for Collection'
                        AND (
                            reservation_expires_at IS NULL
                            OR reservation_expires_at >= NOW()
                        )
                        THEN 1 ELSE 0
                    END
                ), 0) AS ready_for_collection,

                COALESCE(SUM(
                    CASE
                        WHEN status = 'Processing'
                        AND (
                            reservation_expires_at IS NULL
                            OR reservation_expires_at >= NOW()
                        )
                        THEN 1 ELSE 0
                    END
                ), 0) AS processing_reservations,

                COALESCE(SUM(
                    CASE
                        WHEN status = 'Expired'
                        OR (
                            status IN (
                                'Reserved',
                                'Processing',
                                'Ready for Collection'
                            )
                            AND reservation_expires_at < NOW()
                        )
                        THEN 1 ELSE 0
                    END
                ), 0) AS expired_reservations,

                COALESCE(SUM(
                    CASE WHEN status = 'Cancelled'
                    THEN 1 ELSE 0 END
                ), 0) AS cancelled_reservations,

                COALESCE(SUM(
                    CASE WHEN status = 'Collected'
                    THEN 1 ELSE 0 END
                ), 0) AS collected_reservations,

                COALESCE(SUM(
                    CASE
                        WHEN status IN (
                            'Reserved',
                            'Processing',
                            'Ready for Collection'
                        )
                        AND (
                            reservation_expires_at IS NULL
                            OR reservation_expires_at >= NOW()
                        )
                        THEN total_amount ELSE 0
                    END
                ), 0) AS active_value

            FROM product_orders
            WHERE user_id = :user_id
        ");

        $this->db->bind(':user_id', (int)$userId);
        return $this->db->single();
    }

    // Get completed purchases for one pet owner.
    // Each purchase can have multiple product rows.
    public function getPurchaseHistoryByUser(
        $userId,
        $search = '',
        $period = 'all',
        $sort = 'newest'
    ) {
        $conditions = "
            WHERE po.user_id = :user_id
            AND po.status = 'Collected'
        ";

        if ($search !== '') {
            $conditions .= "
                AND (
                    CAST(po.order_id AS CHAR) LIKE :search
                    OR oi.product_name_snapshot LIKE :search
                )
            ";
        }

        // Filter using the collection date when available.
        switch ($period) {
            case 'month':
                $conditions .= "
                    AND COALESCE(po.collected_at, po.order_date)
                        >= DATE_FORMAT(CURDATE(), '%Y-%m-01')
                ";
                break;

            case '3months':
                $conditions .= "
                    AND COALESCE(po.collected_at, po.order_date)
                        >= DATE_SUB(CURDATE(), INTERVAL 3 MONTH)
                ";
                break;

            case '6months':
                $conditions .= "
                    AND COALESCE(po.collected_at, po.order_date)
                        >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
                ";
                break;

            case 'year':
                $conditions .= "
                    AND YEAR(COALESCE(po.collected_at, po.order_date))
                        = YEAR(CURDATE())
                ";
                break;
        }

        $orderBy = 'COALESCE(po.collected_at, po.order_date) DESC';

        if ($sort === 'oldest') {
            $orderBy = 'COALESCE(po.collected_at, po.order_date) ASC';
        } elseif ($sort === 'total_high') {
            $orderBy = 'po.total_amount DESC';
        } elseif ($sort === 'total_low') {
            $orderBy = 'po.total_amount ASC';
        }

        $this->db->query("
            SELECT
                po.order_id,
                po.user_id,
                po.order_date,
                po.collected_at,
                po.total_amount,
                po.status,
                po.payment_status,
                po.payment_method,
                oi.order_item_id,
                oi.product_id,
                oi.product_name_snapshot,
                oi.quantity,
                oi.unit_price,
                oi.subtotal,
                p.image_url,
                p.description
            FROM product_orders po
            LEFT JOIN order_items oi
                ON po.order_id = oi.order_id
            LEFT JOIN products p
                ON oi.product_id = p.product_id
            $conditions
            ORDER BY $orderBy, po.order_id DESC, oi.order_item_id ASC
        ");

        $this->db->bind(':user_id', (int)$userId);

        if ($search !== '') {
            $this->db->bind(':search', '%' . $search . '%');
        }

        return $this->db->resultSet();
    }


    // Get summary information for completed purchases.
    public function getPurchaseHistorySummary($userId)
    {
        $this->db->query("
            SELECT
                COUNT(*) AS total_purchases,
                COALESCE(SUM(total_amount), 0) AS total_spent,
                MAX(COALESCE(collected_at, order_date)) AS last_collection
            FROM product_orders
            WHERE user_id = :user_id
            AND status = 'Collected'
        ");

        $this->db->bind(':user_id', (int)$userId);
        $summary = $this->db->single();

        $this->db->query("
            SELECT COALESCE(SUM(oi.quantity), 0) AS products_collected
            FROM product_orders po
            INNER JOIN order_items oi
                ON po.order_id = oi.order_id
            WHERE po.user_id = :user_id
            AND po.status = 'Collected'
        ");

        $this->db->bind(':user_id', (int)$userId);
        $items = $this->db->single();

        $summary->products_collected = (int)$items->products_collected;

        return $summary;
    }
}
