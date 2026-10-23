
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
}
?>
