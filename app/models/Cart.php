
<?php

class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function addItem($userId, $productId, $quantity = 1)
    {
        // Never allow zero or negative quantities.
        if ($quantity < 1) {
            return false;
        }

        // Check current stock before adding to the cart.
        $this->db->query("
            SELECT stock_quantity, status
            FROM products
            WHERE product_id = :product_id
            LIMIT 1
        ");

        $this->db->bind(':product_id', $productId);
        $product = $this->db->single();

        if (
            !$product ||
            $product->status !== 'In Stock' ||
            $product->stock_quantity < $quantity
        ) {
            return false;
        }

        // Check whether the product is already in the cart.
        $this->db->query("
            SELECT quantity
            FROM cart_items
            WHERE user_id = :user_id
              AND product_id = :product_id
            LIMIT 1
        ");

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':product_id', $productId);

        $existingItem = $this->db->single();

        $newQuantity = $quantity;

        if ($existingItem) {
            $newQuantity += (int)$existingItem->quantity;
        }

        // Do not allow the cart quantity to exceed available stock.
        if ($newQuantity > (int)$product->stock_quantity) {
            return false;
        }

        if ($existingItem) {
            $this->db->query("
                UPDATE cart_items
                SET quantity = :quantity,
                    updated_at = CURRENT_TIMESTAMP
                WHERE user_id = :user_id
                  AND product_id = :product_id
            ");

            $this->db->bind(':quantity', $newQuantity);
            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
        } else {
            $this->db->query("
                INSERT INTO cart_items
                    (user_id, product_id, quantity)
                VALUES
                    (:user_id, :product_id, :quantity)
            ");

            $this->db->bind(':user_id', $userId);
            $this->db->bind(':product_id', $productId);
            $this->db->bind(':quantity', $newQuantity);
        }

        return $this->db->execute();
    }

    public function getItemCount($userId)
    {
        $this->db->query("
            SELECT COALESCE(SUM(quantity), 0) AS item_count
            FROM cart_items
            WHERE user_id = :user_id
        ");

        $this->db->bind(':user_id', $userId);

        $result = $this->db->single();

        return (int)$result->item_count;
    }

    // Get all cart items belonging to one pet owner.
    public function getCartItems($userId)
    {
        $this->db->query("
            SELECT
                ci.cart_item_id,
                ci.product_id,
                ci.quantity,
                p.name,
                p.description,
                p.price,
                p.stock_quantity,
                p.image_url,
                p.status,
                c.category_name
            FROM cart_items ci
            INNER JOIN products p
                ON ci.product_id = p.product_id
            INNER JOIN product_categories c
                ON p.category_id = c.category_id
            WHERE ci.user_id = :user_id
            ORDER BY ci.added_at DESC
        ");

        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    // Update the quantity of an owner's cart item.
    public function updateQuantity($userId, $cartItemId, $quantity)
    {
        if ($quantity < 1) {
            return false;
        }

        // Confirm that the item belongs to this owner.
        $this->db->query("
            SELECT
                ci.product_id,
                p.stock_quantity,
                p.status
            FROM cart_items ci
            INNER JOIN products p
                ON ci.product_id = p.product_id
            WHERE ci.cart_item_id = :cart_item_id
            AND ci.user_id = :user_id
            LIMIT 1
        ");

        $this->db->bind(':cart_item_id', $cartItemId);
        $this->db->bind(':user_id', $userId);

        $item = $this->db->single();

        if (
            !$item ||
            $item->status !== 'In Stock' ||
            $quantity > (int)$item->stock_quantity
        ) {
            return false;
        }

        $this->db->query("
            UPDATE cart_items
            SET quantity = :quantity,
                updated_at = CURRENT_TIMESTAMP
            WHERE cart_item_id = :cart_item_id
            AND user_id = :user_id
        ");

        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':cart_item_id', $cartItemId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }


    // Remove one item belonging to the logged-in owner.
    public function removeItem($userId, $cartItemId)
    {
        $this->db->query("
            DELETE FROM cart_items
            WHERE cart_item_id = :cart_item_id
            AND user_id = :user_id
        ");

        $this->db->bind(':cart_item_id', $cartItemId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }
}
?>
