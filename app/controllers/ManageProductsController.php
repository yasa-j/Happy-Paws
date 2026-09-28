<?php

/**
 * Manage Products Controller
 *
 * Loads inventory data and handles product CRUD operations.
 * HTML belongs in app/views/manage-products/, not in this file.
 */
class ManageProductsController extends Controller
{
    // Store the Product model instance.
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('Product');
    }

    /**
     * Display products using the Manage Products view.
     */
    public function index()
    {
        $records = $this->productModel->getAll();
        $products = [];

        foreach ($records as $product) {
            $stock = (int) $product->stock_quantity;
            $reorder = (int) $product->reorder_level;

            // Convert database objects into the existing view format.
            $products[] = [
                'productId' => (int) $product->product_id,
                'id' => $product->sku,
                //'name' => $product->product_name,
                'name' => $product->name,
                'description' => $product->description ?? '',
                'category' => $product->category,
                'brand' => $product->brand ?? '',
                'batch' => 'N/A',
                'price' => (float) $product->price,
                'stock' => $stock,
                'reorderLevel' => $reorder,

                // Display scale only; this is not a database stock limit.
                'maximum' => max(10, $stock, $reorder * 5),

                'unit' => $product->unit,
                'status' => $product->status
            ];
        }

        $totals = $this->productModel->getSummary();

        // Load the actual HTML view.
        $this->view('manage-products/index', [
            'pageTitle' => 'Manage Products',
            'products' => $products,
            'summary' => [
                'total' => (int) ($totals->total ?? 0),
                'drafts' => 0,
                'pendingChanges' => 0,
                'lowStockAlerts' =>
                    (int) ($totals->low_stock ?? 0) +
                    (int) ($totals->out_of_stock ?? 0)
            ]
        ]);
    }

    /**
     * Display an empty Add Product form.
     */
    public function create()
    {
        $this->view('manage-products/create', [
            'pageTitle' => 'Add Product',
            'errors' => [],
            'old' => []
        ]);
    }

    /**
     * Validate and save a new product.
     */
    public function store()
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->redirect('manage-products/index');
        }

        $formData = $this->readFormData();
        $errors = $this->validateProduct($formData);

        if (empty($errors)) {
            try {
                if ($this->productModel->create($formData)) {
                    $_SESSION['success_message'] =
                        'Product added successfully.';

                    $this->redirect('manage-products/index');
                }

                $errors[] = 'The product could not be saved.';
            } catch (PDOException $exception) {
                // Keep technical details in the server log.
                error_log($exception->getMessage());
                $errors[] =
                    'Database save failed. Check the SKU and try again.';
            }
        }

        // Redisplay submitted values when validation or saving fails.
        $this->view('manage-products/create', [
            'pageTitle' => 'Add Product',
            'errors' => $errors,
            'old' => $formData
        ]);
    }

    /**
     * Display the selected product in the Edit form.
     */
    public function edit($id = null)
    {
        $product = $this->findProduct($id);

        $this->view('manage-products/edit', [
            'pageTitle' => 'Edit Product',
            'product' => $product,
            'errors' => [],
            'old' => []
        ]);
    }

    /**
     * Validate and update the selected product.
     */
    public function update($id = null)
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->redirect('manage-products/index');
        }

        $product = $this->findProduct($id);
        $productId = (int) $product->product_id;

        $formData = $this->readFormData();
        $errors = $this->validateProduct($formData, $productId);

        if (empty($errors)) {
            try {
                if ($this->productModel->update($productId, $formData)) {
                    $_SESSION['success_message'] =
                        'Product updated successfully.';

                    $this->redirect('manage-products/index');
                }

                $errors[] = 'The product could not be updated.';
            } catch (PDOException $exception) {
                error_log($exception->getMessage());
                $errors[] =
                    'Database update failed. Check the values and try again.';
            }
        }

        $this->view('manage-products/edit', [
            'pageTitle' => 'Edit Product',
            'product' => $product,
            'errors' => $errors,
            'old' => $formData
        ]);
    }

    /**
     * Delete the selected product through a POST request.
     */
    public function delete($id = null)
    {
        
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            $this->redirect('manage-products/index');
        }

        $product = $this->findProduct($id);
        $productId = (int) $product->product_id;

        try {
            $deleted = $this->productModel->delete($productId);

            // Confirm that the record is no longer in the database.
            if (
                $deleted &&
                !$this->productModel->getById($productId)
            ) {
                $_SESSION['success_message'] =
                    'Product deleted successfully.';
            } else {
                $_SESSION['error_message'] =
                    'Deletion was not confirmed. The product may still exist.';
            }
        } catch (PDOException $exception) {
            // Do not bypass database constraints or delete related records.
            error_log($exception->getMessage());

            $_SESSION['error_message'] =
                'Database deletion failed. The product may be linked to other records.';
        }

        $this->redirect('manage-products/index');
    }

    /**
     * Find a product using a valid numeric database ID.
     */
    private function findProduct($id)
    {
        $productId = filter_var(
            $id,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        if ($productId === false) {
            $_SESSION['error_message'] = 'Invalid product ID.';
            $this->redirect('manage-products/index');
        }

        $product = $this->productModel->getById($productId);

        if (!$product) {
            $_SESSION['error_message'] = 'Product not found.';
            $this->redirect('manage-products/index');
        }

        return $product;
    }

    /**
     * Read scalar form values without accepting arrays.
     */
    private function readFormData()
    {
        $fields = [
            'sku',
            'product_name',
            'category',
            'brand',
            'description',
            'price',
            'stock_quantity',
            'reorder_level',
            'unit'
        ];

        $values = [];

        foreach ($fields as $field) {
            $value = $_POST[$field] ?? '';

            $values[$field] = is_string($value)
                ? trim($value)
                : '';
        }

        return $values;
    }

    /**
     * Validate product values before passing them to the model.
     */
    private function validateProduct($values, $excludeId = null)
    {
        $errors = [];

        // Validate required text fields and database column lengths.
        $requiredFields = [
            'sku' => ['SKU / Product Code', 30],
            'product_name' => ['Product name', 150],
            'category' => ['Category', 100],
            'unit' => ['Unit', 30]
        ];

        foreach ($requiredFields as $field => $settings) {
            [$label, $maximumLength] = $settings;

            if ($values[$field] === '') {
                $errors[] = $label . ' is required.';
            } elseif (mb_strlen($values[$field]) > $maximumLength) {
                $errors[] =
                    $label . ' must not exceed ' .
                    $maximumLength . ' characters.';
            }
        }

        if (mb_strlen($values['brand']) > 100) {
            $errors[] = 'Brand must not exceed 100 characters.';
        }

        // The current product may keep its own SKU during an update.
        if ($values['sku'] !== '') {
            $existing = $this->productModel->getBySku($values['sku']);

            if (
                $existing &&
                (int) $existing->product_id !== (int) $excludeId
            ) {
                $errors[] = 'This SKU is already used by another product.';
            }
        }

        // Validate the price against the DECIMAL(10,2) column.
        if (
            !preg_match('/^\d{1,8}(?:\.\d{1,2})?$/', $values['price'])
        ) {
            $errors[] =
                'Enter a non-negative price with at most two decimal places.';
        }

        // Stock values must be non-negative whole numbers.
        foreach ([
            'stock_quantity' => 'Stock quantity',
            'reorder_level' => 'Reorder level'
        ] as $field => $label) {
            $number = filter_var(
                $values[$field],
                FILTER_VALIDATE_INT,
                [
                    'options' => [
                        'min_range' => 0,
                        'max_range' => 2147483647
                    ]
                ]
            );

            if ($number === false) {
                $errors[] = $label . ' must be a valid non-negative integer.';
            }
        }

        return $errors;
    }
}