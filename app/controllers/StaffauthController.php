<?php

class StaffauthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        // Start session if it has not already been started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Load User model
        $this->userModel = $this->model('User');
    }

    public function login()
    {
        // Show login page
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

            $data = [
                'title' => 'Staff Login',
                'error' => ''
            ];

            $this->view('staff/login', $data);
            return;
        }

        // Get form values
        $email = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Check empty fields
        if ($email === '' || $password === '') {

            $data = [
                'title' => 'Staff Login',
                'error' => 'Please enter your email and password.'
            ];

            $this->view('staff/login', $data);
            return;
        }

        // Check database
        $user = $this->userModel->login($email, $password);

        // Invalid login
        if (!$user) {

            $data = [
                'title' => 'Staff Login',
                'error' => 'Invalid email or password.'
            ];

            $this->view('staff/login', $data);
            return;
        }

        // Check account status
        if (strtolower($user->status) !== 'active') {

            $data = [
                'title' => 'Staff Login',
                'error' => 'Your account is not active.'
            ];

            $this->view('staff/login', $data);
            return;
        }

        // Save login information
        $_SESSION['staff_logged_in'] = true;
        $_SESSION['staff_user_id'] = $user->user_id;
        $_SESSION['staff_username'] = $user->email;
        $_SESSION['staff_role'] = $user->role;
        $_SESSION['staff_name'] =
            $user->first_name . ' ' . $user->last_name;

        // Redirect according to role
        if ($user->role === 'veterinarian') {

            $this->redirect('index.php?url=vet');
            return;
        }

        if ($user->role === 'staff') {

            $this->redirect('index.php?url=staff');
            return;
        }

        if ($user->role === 'admin') {

            $this->redirect('index.php?url=staff');
            return;
        }

        // Other roles are not allowed through staff login
        session_unset();

        $data = [
            'title' => 'Staff Login',
            'error' => 'This account does not have staff access.'
        ];

        $this->view('staff/login', $data);
    }
    public function logout()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    session_unset();
    session_destroy();

    $this->redirect('staffauth/login');
}
}