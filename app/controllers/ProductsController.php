<?php

/**
 * Products Controller
 *
 * Loads product records from the database and sends them
 * to the Products interface.
 *
 * URL:
 * http://localhost/Happypaws/public/products/index
 */
class ProductsController extends Controller
{
    // Store the Product model object.
    private $productModel;

    /**
     * Load the Product model when the controller is created.
     */
    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    /**
     * Display the Products page.
     */
    public function index()
    {
        /*
         * Read optional search and filter values from the URL.
         * These values will be used by the Product model.
         */
        $search = trim($_GET['search'] ?? '');
        $category = trim($_GET['category'] ?? 'all');
        $status = trim($_GET['status'] ?? 'all');

        /*
         * Get products from the database.
         * Search and filter values are included when available.
         */
        $databaseProducts = $this->productModel->search(
            $search,
            $category,
            $status
        );

        // Convert database objects into the array format required by the view.
        $products = [];

        foreach ($databaseProducts as $product) {
            $products[] = [
                // Numeric database ID used by CRUD operations.
                'productId' => (int) $product->product_id,

                // Product information displayed in the table.
                'id' => $product->sku,
                //'name' => $product->product_name,
                'name' => $product->name,
                'description' => $product->description ?? '',
                'category' => $product->category,
                'brand' => $product->brand ?? '',
                'price' => (float) $product->price,
                'stock' => (int) $product->stock_quantity,
                'unit' => $product->unit,
                'status' => $product->status,
            ];
        }

        // Get product summary values from the database.
        $databaseSummary = $this->productModel->getSummary();

        $summary = [
            'total' => (int) ($databaseSummary->total ?? 0),
            'inStock' => (int) ($databaseSummary->in_stock ?? 0),
            'lowStock' => (int) ($databaseSummary->low_stock ?? 0),
            'outOfStock' => (int) (
                $databaseSummary->out_of_stock ?? 0
            ),
        ];

        // Prepare all information required by the Products view.
        $data = [
            'pageTitle' => 'Products',
            'products' => $products,
            'summary' => $summary,

            // Keep the current search and filter values.
            'filters' => [
                'search' => $search,
                'category' => $category,
                'status' => $status,
            ],
        ];

        // Load app/views/products/index.php.
        $this->view(
            'products/index',
            $data
        );
    }
}