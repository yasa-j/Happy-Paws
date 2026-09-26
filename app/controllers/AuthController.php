<?php
/**
 * Auth Controller
 * Handles user registration, login and logout
 */
class AuthController extends Controller {

    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('User');
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

                $data['login_err'] = 'Please enter your email or phone number.';
            }


            // Validate password
            if (empty($data['password'])) {

                $data['password_err'] = 'Please enter your password.';
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

                    // Redirect to pet owner dashboard
                    $this->redirect('petowner/dashboard');

                } else {

                    // Store login error temporarily
                    $_SESSION['login_error'] =
                        'Invalid email/phone number or password.';

                    // Go back to the landing page
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

                $data['phone_err'] =
                    'Please enter your mobile number.';

            } else {

                // Remove spaces
                $phone = str_replace(' ', '', $data['phone_number']);

                // Accept 9 digit number after +94
                if (!preg_match('/^[0-9]{9}$/', $phone)) {

                    $data['phone_err'] =
                        'Please enter a valid mobile number.';
                } else {

                    // Store phone number as +94XXXXXXXXX
                    $data['phone_number'] = '+94' . $phone;

                    if ($this->userModel->phoneExists($data['phone_number'])) {

                        $data['phone_err'] =
                            'This mobile number is already registered.';
                    }
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
        session_unset();
        session_destroy();

        header("Location: " . URLROOT);
        exit;
    }
    }