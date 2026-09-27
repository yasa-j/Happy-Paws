<?php
/**
 * =======================================================================
 * Happy Paws - Authentication Controller
 * =======================================================================
 * 
 * Handles user authentication workflows including:
 *   - Login form presentation and processing
 *   - Session lifecycle creation and destruction (Logout)
 *   - Credential validation and role assignment
 * =======================================================================
 */

class AuthController extends Controller {

    /**
     * User model instance
     * @var User
     */
    private $userModel;

    /**
     * Instantiate model
     */
    public function __construct() {
        $this->userModel = $this->model('User');
    }

    /**
     * Handle user login requests (GET to view form, POST to authenticate)
     */
    public function login() {
        // If user is already authenticated, redirect to the dashboard directly
        if (isset($_SESSION['user_id'])) {
            $this->redirect('dashboard');
        }

        // Process POST form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and read input fields
            $email = trim($_POST['email'] ?? '');
            $password = trim($_POST['password'] ?? '');
            $source = $_POST['source'] ?? 'auth'; // 'home' or 'auth'

            $data = [
                'email' => $email,
                'password' => $password,
                'source' => $source,
                'email_err' => '',
                'password_err' => ''
            ];

            // Validate email
            if (empty($email)) {
                $data['email_err'] = 'Please enter your email address.';
            }

            // Validate password
            if (empty($password)) {
                $data['password_err'] = 'Please enter your password.';
            }

            // If no validation errors, attempt authentication
            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($email, $password);

                if ($loggedInUser) {
                    // Initialize authenticated session variables
                    $_SESSION['user_id'] = $loggedInUser->user_id;
                    $_SESSION['user_email'] = $loggedInUser->email;
                    $_SESSION['user_name'] = $loggedInUser->first_name . ' ' . $loggedInUser->last_name;
                    $_SESSION['user_first_name'] = $loggedInUser->first_name;
                    $_SESSION['user_role'] = $loggedInUser->role;
                    $_SESSION['flash_success'] = 'Welcome back, ' . $loggedInUser->first_name . '!';

                    // Clear any lingering login errors
                    unset($_SESSION['login_error']);

                    // Redirect to the protected dashboard
                    $this->redirect('dashboard');
                } else {
                    $errorMsg = 'Invalid email or password. Please verify your credentials.';
                    
                    // If login was attempted from the home page hero card, return there with error
                    if ($source === 'home') {
                        $_SESSION['login_error'] = $errorMsg;
                        $_SESSION['login_email_attempt'] = $email;
                        $this->redirect('home#login');
                    } else {
                        $data['password_err'] = $errorMsg;
                        $this->view('auth/login', $data);
                    }
                }
            } else {
                // Validation errors present
                if ($source === 'home') {
                    $_SESSION['login_error'] = !empty($data['email_err']) ? $data['email_err'] : $data['password_err'];
                    $_SESSION['login_email_attempt'] = $email;
                    $this->redirect('home#login');
                } else {
                    $this->view('auth/login', $data);
                }
            }
        } else {
            // Render blank login view for GET request
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('auth/login', $data);
        }
    }

    /**
     * Terminate the user session and log out
     */
    public function logout() {
        // Clear all session variables
        $_SESSION = [];

        // Destroy session cookie if set
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Destroy session storage
        session_destroy();

        // Redirect user to home page with a logout notice
        $this->redirect('home');
    }
}
