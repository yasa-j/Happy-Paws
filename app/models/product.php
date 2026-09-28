<?php

/**
 * Product Model
 *
 * Handles all database operations related to products:
 * Create, Read, Update, Delete, Search and Summary.
 */
class Product
{
    // Store the shared database connection.
    private $db;

    /**
     * Connect the model to the database.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Get all products from the database.
     */
    public function getAll()
    {
        $this->db->query(
            'SELECT *
             FROM products
             ORDER BY product_id ASC'
        );

        return $this->db->resultSet();
    }

    /**
    * Get one product using its numeric database ID.
    */
    public function getById($productId)
    {
    // Create a product_name alias for the existing edit form.
    $this->db->query(
        'SELECT *, name AS product_name
         FROM products
         WHERE product_id = :product_id
         LIMIT 1'
    );

    $this->db->bind(
        ':product_id',
        (int) $productId
    );

        return $this->db->single();
    }

    /**
     * Get one product using its SKU.
     */
    public function getBySku($sku)
    {
        $this->db->query(
            'SELECT *
             FROM products
             WHERE sku = :sku
             LIMIT 1'
        );

        $this->db->bind(
            ':sku',
            trim($sku)
        );

        return $this->db->single();
    }

    /**
     * Check whether an SKU already exists.
     *
     * The optional product ID is excluded when checking
     * an existing product during an update.
     */
    public function skuExists($sku, $excludeProductId = null)
    {
        $sql = '
            SELECT product_id
            FROM products
            WHERE sku = :sku
        ';

        if ($excludeProductId !== null) {
            $sql .= '
                AND product_id != :product_id
            ';
        }

        $sql .= ' LIMIT 1';

        $this->db->query($sql);

        $this->db->bind(
            ':sku',
            trim($sku)
        );

        if ($excludeProductId !== null) {
            $this->db->bind(
                ':product_id',
                (int) $excludeProductId
            );
        }

        return (bool) $this->db->single();
    }

/**
 * Create a new product in the main database.
 */
    public function create($data)
    {
    // Store only database-supported status values.
    $status = ((int) $data['stock_quantity'] <= 0)
        ? 'Out of Stock'
        : 'In Stock';

    // The main database uses "name", not "product_name".
    $this->db->query(
        'INSERT INTO products (
            sku,
            name,
            category,
            brand,
            description,
            price,
            stock_quantity,
            reorder_level,
            unit,
            status
        ) VALUES (
            :sku,
            :product_name,
            :category,
            :brand,
            :description,
            :price,
            :stock_quantity,
            :reorder_level,
            :unit,
            :status
        )'
    );

    // Bind the form values to the SQL query.
     $this->bindProductData($data, $status);

        return $this->db->execute();
    }

    /**
     * Update an existing product.
     */
    public function update($productId, $data)
    {
        // Calculate the new stock status automatically.
        $status = $this->calculateStatus(
            (int) $data['stock_quantity'],
            (int) $data['reorder_level']
        );

        $this->db->query(
            'UPDATE products
             SET
                sku = :sku,
                name = :product_name,
                category = :category,
                brand = :brand,
                description = :description,
                price = :price,
                stock_quantity = :stock_quantity,
                reorder_level = :reorder_level,
                unit = :unit,
                status = :status
             WHERE product_id = :product_id'
        );

        // Bind all updated product values.
        $this->bindProductData(
            $data,
            $status
        );

        // Bind the product ID used by the WHERE condition.
        $this->db->bind(
            ':product_id',
            (int) $productId
        );

        return $this->db->execute();
    }

    /**
     * Delete one product using its database ID.
     */
    public function delete($productId)
    {
        $this->db->query(
            'DELETE FROM products
             WHERE product_id = :product_id'
        );

        $this->db->bind(
            ':product_id',
            (int) $productId
        );

        return $this->db->execute();
    }

    /**
     * Search and filter product records.
     */
    public function search(
        $searchText = '',
        $category = '',
        $status = ''
    ) {
        $conditions = [];
        $parameters = [];

        // Search by SKU, product name or brand.
        if ($searchText !== '') {
            $conditions[] = '(
                sku LIKE :search_text
                OR product_name LIKE :search_text
                OR brand LIKE :search_text
            )';

            $parameters[':search_text'] =
                '%' . trim($searchText) . '%';
        }

        // Filter products using their category.
        if ($category !== '' && $category !== 'all') {
            $conditions[] = 'category = :category';
            $parameters[':category'] = $category;
        }

        // Filter products using their stock status.
        if ($status !== '' && $status !== 'all') {
            $conditions[] = 'status = :status';
            $parameters[':status'] = $status;
        }

        $sql = 'SELECT * FROM products';

        // Add the WHERE conditions only when required.
        if (!empty($conditions)) {
            $sql .= ' WHERE ' . implode(
                ' AND ',
                $conditions
            );
        }

        $sql .= ' ORDER BY product_id ASC';

        $this->db->query($sql);

        // Bind all search and filter parameters.
        foreach ($parameters as $parameter => $value) {
            $this->db->bind(
                $parameter,
                $value
            );
        }

        return $this->db->resultSet();
    }

    /**
     * Get products that have reached their reorder level.
     */
    public function getLowStockProducts()
    {
        $this->db->query(
            'SELECT *
             FROM products
             WHERE stock_quantity <= reorder_level
             ORDER BY stock_quantity ASC'
        );

        return $this->db->resultSet();
    }

    /**
     * Count every product in the database.
     */
    public function countAll()
    {
        $this->db->query(
            'SELECT COUNT(*) AS total
             FROM products'
        );

        $result = $this->db->single();

        return (int) ($result->total ?? 0);
    }

    /**
     * Get product totals grouped by stock status.
     */
    public function getSummary()
    {
        $this->db->query(
            "SELECT
                COUNT(*) AS total,
                COUNT(*) AS total_products,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'In Stock'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS in_stock,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'Low Stock'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS low_stock,

                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'Out of Stock'
                            THEN 1
                            ELSE 0
                        END
                    ),
                    0
                ) AS out_of_stock

             FROM products"
        );

        return $this->db->single();
    }

    /**
     * Bind product data to the currently prepared query.
     */
    private function bindProductData(
        $data,
        $status
    ) {
        $this->db->bind(
            ':sku',
            trim($data['sku'])
        );

        $this->db->bind(
            ':product_name',
            trim($data['product_name'])
        );

        $this->db->bind(
            ':category',
            trim($data['category'])
        );

        $this->db->bind(
            ':brand',
            trim($data['brand'] ?? '')
        );

        $this->db->bind(
            ':description',
            trim($data['description'] ?? '')
        );

        $this->db->bind(
            ':price',
            (string) number_format(
                (float) $data['price'],
                2,
                '.',
                ''
            )
        );

        $this->db->bind(
            ':stock_quantity',
            (int) $data['stock_quantity']
        );

        $this->db->bind(
            ':reorder_level',
            (int) $data['reorder_level']
        );

        $this->db->bind(
            ':unit',
            trim($data['unit'])
        );

        $this->db->bind(
            ':status',
            $status
        );
    }

    /**
     * Calculate the product status using its stock values.
     */
    private function calculateStatus(
        $stockQuantity,
        $reorderLevel
    ) {
        // A zero stock quantity means the product is depleted.
        if ($stockQuantity <= 0) {
            return 'Out of Stock';
        }

        // Stock at or below the reorder level is considered low.
        if ($stockQuantity <= $reorderLevel) {
            return 'Low Stock';
        }

        return 'In Stock';
    }
}