<?php

class StaffController extends Controller
{
    public function __construct()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Require login
    if (
        empty($_SESSION['staff_logged_in']) ||
        empty($_SESSION['staff_user_id'])
    ) {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=staffauth/login'
        );
        exit;
    }

    // Only receptionist/staff accounts can access these pages
    if (($_SESSION['staff_role'] ?? '') !== 'staff') {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=vet'
        );
        exit;
    }
}
    public function index()
    {
        $data = [
            'title' => 'Staff Dashboard'
        ];

        $this->view('staff/dashboard', $data);
    }


    public function clients()
    {
        $data = [
            'title' => 'Client Directory'
        ];

        $this->view('staff/clients', $data);
    }


    public function appointments()
    {
        $data = [
            'title' => 'Appointment Management'
        ];

        $this->view('staff/appointments', $data);
    }

    public function billing()
{
    $data = [
        'title' => 'Billing History'
    ];

    $this->view('staff/billing', $data);
}


    public function billingDetails()
    {
        $data = [
            'title' => 'Billing & Payments'
        ];

        $this->view('staff/billing-details', $data);
    }

public function notifications()
{
    $data = [
        'title' => 'Notifications'
    ];

    $this->view('staff/notifications', $data);
}
public function logout()
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
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

    session_destroy();

    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=staffauth/login'
    );

    exit;
}
}