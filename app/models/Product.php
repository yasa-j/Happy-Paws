
<?php

class Product
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get active categories for the category filters.
    public function getCategories()
    {
        $this->db->query("
            SELECT category_id, category_name
            FROM product_categories
            WHERE status = 'Active'
            ORDER BY category_name ASC
        ");

        return $this->db->resultSet();
    }

    // Get products with optional search, category and sorting.
    public function getProducts($search = '', $categoryId = '', $sort = 'recommended')
    {
        $sql = "
            SELECT
                p.product_id,
                p.category_id,
                p.name,
                p.description,
                p.price,
                p.stock_quantity,
                p.image_url,
                p.status,
                p.reorder_level,
                c.category_name
            FROM products p
            INNER JOIN product_categories c
                ON p.category_id = c.category_id
            WHERE p.status != 'Discontinued'
              AND c.status = 'Active'
        ";

        if ($search !== '') {
            $sql .= "
                AND (
                    p.name LIKE :search
                    OR p.description LIKE :search
                    OR c.category_name LIKE :search
                )
            ";
        }

        if ($categoryId !== '' && ctype_digit((string)$categoryId)) {
            $sql .= " AND p.category_id = :category_id ";
        }

        // Only allow predefined sorting options.
        switch ($sort) {
            case 'price_low':
                $sql .= " ORDER BY p.price ASC, p.name ASC";
                break;

            case 'price_high':
                $sql .= " ORDER BY p.price DESC, p.name ASC";
                break;

            case 'name':
                $sql .= " ORDER BY p.name ASC";
                break;

            default:
                $sql .= " ORDER BY p.name ASC";
                break;
        }

        $this->db->query($sql);

        if ($search !== '') {
            $this->db->bind(':search', '%' . $search . '%');
        }

        if ($categoryId !== '' && ctype_digit((string)$categoryId)) {
            $this->db->bind(':category_id', (int)$categoryId);
        }

        return $this->db->resultSet();
    }

    // Retrieve one product for cart validation.
    public function getProductById($productId)
    {
        $this->db->query("
            SELECT product_id, name, price, stock_quantity, status
            FROM products
            WHERE product_id = :product_id
            LIMIT 1
        ");

        $this->db->bind(':product_id', $productId);

        return $this->db->single();
    }
}
?>
