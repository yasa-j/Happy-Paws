
<?php

class ProductStoreController extends Controller
{
    private $productModel;
    private $cartModel;

    public function __construct()
    {
        // Require a logged-in pet owner.
        if (
            !isset($_SESSION['user_id']) ||
            !isset($_SESSION['role']) ||
            $_SESSION['role'] !== 'Pet Owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }

        $this->productModel = $this->model('Product');
        $this->cartModel = $this->model('Cart');
    }

    // Display the product catalogue.
    public function index()
    {
        $search = trim($_GET['search'] ?? '');
        $categoryId = trim($_GET['category'] ?? '');
        $sort = $_GET['sort'] ?? 'recommended';

        // Ignore invalid category values.
        if (
            $categoryId !== '' &&
            !ctype_digit($categoryId)
        ) {
            $categoryId = '';
        }

        $data = [
            'products' => $this->productModel->getProducts(
                $search,
                $categoryId,
                $sort
            ),
            'categories' => $this->productModel->getCategories(),
            'search' => $search,
            'selectedCategory' => $categoryId,
            'sort' => $sort,
            'cartCount' => $this->cartModel->getItemCount(
                (int)$_SESSION['user_id']
            ),
            'message' => $_SESSION['product_store_message'] ?? ''
        ];

        unset($_SESSION['product_store_message']);

        $this->view('petowner/browse-products', $data);
    }

    // Add one product to the logged-in owner's cart.
    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URLROOT . '/productstore');
            exit;
        }

        // Validate the submitted product ID.
        $productId = filter_input(
            INPUT_POST,
            'product_id',
            FILTER_VALIDATE_INT
        );

        if (!$productId || $productId < 1) {
            $_SESSION['product_store_message'] =
                'Please select a valid product.';
        } else {
            $success = $this->cartModel->addItem(
                (int)$_SESSION['user_id'],
                $productId,
                1
            );

            $_SESSION['product_store_message'] = $success
                ? 'Product added to your cart.'
                : 'Unable to add this product. Please check its stock.';
        }

        // Redirect after POST to prevent duplicate submissions.
        header('Location: ' . URLROOT . '/productstore');
        exit;
    }
}
?>
