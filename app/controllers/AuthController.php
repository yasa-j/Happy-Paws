<?php

/**
 * Auth Controller
 * Handles user registration, login and logout
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
     * Redirect user based on their role
     */
    public function redirectByRole($role = null)
    {
        // Check whether the user is logged in
        if ($role === null && !isset($_SESSION['user_id'])) {
            $this->redirect('');
            return;
        }

        // Get role from session if not provided
        $role = $role ?? ($_SESSION['user_role'] ?? '');

        switch ($role) {

            case 'admin':
                $this->redirect('admin');
                break;

            case 'veterinarian':
                $this->redirect('dashboard');
                break;

            case 'staff':
                $this->redirect('staff');
                break;

            case 'pet_owner':
                $this->redirect('petowner/dashboard');
                break;

            default:
                $this->redirect('auth/login');
                break;
        }
    }

    // Login
    public function login() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [
                'login' => trim($_POST['login'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'login_err' => '',
                'password_err' => ''
            ];

            // Validate login field
            if (empty($data['login'])) {
                $data['login_err'] =
                    'Please enter your email or phone number.';
            }

            // Validate password
            if (empty($data['password'])) {
                $data['password_err'] =
                    'Please enter your password.';
            }

            // If there are no errors
            if (
                empty($data['login_err']) &&
                empty($data['password_err'])
            ) {

                $loggedInUser = $this->userModel->login(
                    $data['login'],
                    $data['password']
                );

                if ($loggedInUser) {

                    // Create session
                    $_SESSION['user_id'] = $loggedInUser->user_id;
                    $_SESSION['user_email'] = $loggedInUser->email;
                    $_SESSION['user_name'] =
                        $loggedInUser->first_name . ' ' .
                        $loggedInUser->last_name;

                    $_SESSION['user_role'] = $loggedInUser->role;

                    // Redirect based on role
                    $this->redirectByRole($loggedInUser->role);

                } else {

                    $_SESSION['login_error'] =
                        'Invalid email/phone number or password.';

                    $this->redirect('');
                }

            } else {

                $this->view('auth/login', $data);
            }

        } else {

            // Empty login form
            $data = [
                'login' => '',
                'password' => '',
                'login_err' => '',
                'password_err' => ''
            ];

            $this->view('auth/login', $data);
        }
    }

    // Register
    public function register() {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $data = [

                'first_name' => trim($_POST['first_name'] ?? ''),
                'last_name' => trim($_POST['last_name'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'phone_number' => trim($_POST['phone_number'] ?? ''),
                'address' => trim($_POST['address'] ?? ''),
                'password' => trim($_POST['password'] ?? ''),
                'confirm_password' => trim($_POST['confirm_password'] ?? ''),
                'terms' => isset($_POST['terms']) ? true : false,

                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'terms_err' => '',
                'register_error' => '',
                'register_success' => false
            ];


            // First name validation
            if (empty($data['first_name'])) {

                $data['first_name_err'] =
                    'Please enter your first name.';
            }


            // Last name validation
            if (empty($data['last_name'])) {

                $data['last_name_err'] =
                    'Please enter your last name.';
            }


            // Email validation
            if (empty($data['email'])) {

                $data['email_err'] =
                    'Please enter your email address.';

            } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {

                $data['email_err'] =
                    'Please enter a valid email address.';

            } elseif ($this->userModel->emailExists($data['email'])) {

                $data['email_err'] =
                    'This email address is already registered.';
            }

            // Phone validation
            if (empty($data['phone_number'])) {
                $data['phone_err'] = 'Please enter your mobile number.';

            } else {
                $phone = $data['phone_number'];

                if (!preg_match('/^7[0-9]{8}$/', $phone)) {
                    $data['phone_err'] =
                        'Please enter a valid 9-digit mobile number starting with 7.';

                } elseif ($this->userModel->phoneExists('+94' . $phone)) {
                    $data['phone_err'] =
                        'This phone number is already registered.';

                } else {
                    $data['phone_number'] = '+94' . $phone;
                }
            }


            // Address validation
            if (empty($data['address'])) {

                $data['address_err'] =
                    'Please enter your address.';
            }


            // Password validation
            if (empty($data['password'])) {

                $data['password_err'] =
                    'Please enter a password.';

            } elseif (strlen($data['password']) < 8) {

                $data['password_err'] =
                    'Password must be at least 8 characters.';

            } elseif (
                !preg_match('/[0-9]/', $data['password']) ||
                !preg_match('/[^A-Za-z0-9]/', $data['password'])
            ) {

                $data['password_err'] =
                    'Password must contain a number and a special character.';
            }


            // Confirm password
            if (empty($data['confirm_password'])) {

                $data['confirm_password_err'] =
                    'Please confirm your password.';

            } elseif (
                $data['password'] !== $data['confirm_password']
            ) {

                $data['confirm_password_err'] =
                    'Passwords do not match.';
            }


            // Terms
            if (!$data['terms']) {

                $data['terms_err'] =
                    'You must agree to the Terms of Service and Privacy Policy.';
            }


            // Check whether everything is valid
            if (
                empty($data['first_name_err']) &&
                empty($data['last_name_err']) &&
                empty($data['email_err']) &&
                empty($data['phone_err']) &&
                empty($data['address_err']) &&
                empty($data['password_err']) &&
                empty($data['confirm_password_err']) &&
                empty($data['terms_err'])
            ) {

                // Register user
                $registeredUser =
                    $this->userModel->register($data);


                if ($registeredUser) {

                    $data['register_success'] = true;

                } else {

                    $data['register_error'] =
                        'Something went wrong. Please try again.';
                }
            }


            // Show registration page
            $this->view('auth/register', $data);

        } else {

            // Show empty registration form
            $data = [

                'first_name' => '',
                'last_name' => '',
                'email' => '',
                'phone_number' => '',
                'address' => '',
                'password' => '',
                'confirm_password' => '',
                'terms' => false,

                'first_name_err' => '',
                'last_name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'terms_err' => '',
                'register_error' => '',
                'register_success' => false
            ];

            $this->view('auth/register', $data);
        }
    }


    // Logout
    public function logout()
    {
        // Get the user's role before destroying the session
        $role = $_SESSION['user_role'] ?? '';

        // Clear session data
        session_unset();
        session_destroy();

        // Redirect according to the user's previous role
        switch ($role) {

            case 'admin':
            case 'veterinarian':
            case 'staff':
                $this->redirect('staffauth/login');
                break;

            case 'pet_owner':
                $this->redirect('');
                break;

            default:
                $this->redirect('');
                break;
        }
    }
}