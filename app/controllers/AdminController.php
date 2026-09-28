<?php

class AdminController extends Controller {

    private $adminModel;

    public function __construct() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Make sure someone is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/login');
        }

        // Make sure the logged-in user is an admin
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            $this->redirect('/dashboard');
        }

        // Load Admin model
        $this->adminModel = $this->model('Admin');
    }

    /**
     * Get common data used by every admin page.
     */
    private function getCommonData() {

        $userId = $_SESSION['user_id'];

        // Get actual admin from database
        $admin = $this->adminModel->getAdminById($userId);

        if (!$admin) {
            session_destroy();
            $this->redirect('/auth/login');
        }

        return [
            'admin' => $admin,
            'adminName' => $admin->first_name . ' ' . $admin->last_name,
            'adminRole' => 'System Administrator',
            'adminAvatar' => URLROOT . '/public/images/admin_avatar.png'
        ];
    }


    /**
     * Load the shared admin layout.
     */
    private function adminView($page, $data = []) {

        $data = array_merge(
            $this->getCommonData(),
            $data
        );

        // Tell admin.php which content page to load
        $data['adminContent'] = $page;

        $this->view('admin/admin', $data);
    }

    public function dashboard()
{
    $data = [
        'title' => 'Admin Dashboard'
    ];

    $this->view('admin/dashboard', $data);
}

    public function index(){

        $staffList = $this->adminModel->getStaffList();
        
        $data = [
            'title' => 'System Admin Dashboard',
            'activePage' => 'dashboard',
            // Staff information
            'staffList' => $staffList,
            'totalStaff' => 
                $this->adminModel->getTotalStaff(),
            'veterinarianCount' => 
                $this->adminModel->getVeterinarianCount(),
            'staffCount' => 
                $this->adminModel->getStaffCount(),
            'activeStaffCount' => 
                $this->adminModel->getActiveStaffCount(),
            // Clinic information
            'clinicInfo' => 
                $this->adminModel->getClinicInfo(),
            // Appointment information
            'appointmentsReport' => 
                $this->adminModel->getAppointmentReport(),
            // Revenue information
            'revenueReport' => 
                $this->adminModel->getRevenueReport()
        ];

        $this->adminView('dashboard', $data);
    }

    public function staff() {

        $staffList = $this->adminModel->getStaffList();

        $data = [
            'title' => 'Staff Management',
            'activePage' => 'staff',
            'staffList' => $staffList,
            'totalStaff' => 
                $this->adminModel->getTotalStaff(),
            'veterinarianCount' =>
                $this->adminModel->getVeterinarianCount(),
            'staffCount' =>
                $this->adminModel->getStaffCount(),
            'activeStaffCount' =>
                $this->adminModel->getActiveStaffCount()
        ];

        $this->adminView('staff', $data);
    }

    public function accounts() {

        $accounts = $this->adminModel->getStaffAccounts();

        $data = [
            'title' => 'Staff Accounts',
            'activePage' => 'accounts',
            'accounts' => $accounts
        ];

        $this->adminView('accounts', $data);
    }

    public function clinic() {

        $data = [
            'title' => 'Clinic Management',
            'activePage' => 'clinic'
        ];

        $this->adminView('clinic', $data);
    }

    public function clinicInfo(){
    
        $clinicInfo = $this->adminModel->getClinicInfo();

        $data = [
            'title' => 'Clinic Information',
            'activePage' => 'clinic_info',
            'clinicInfo' => $clinicInfo
        ];

        $this->adminView('clinic_info', $data);
    }

    public function reports() {

        $data = [
            'title' => 'Reports Overview',
            'activePage' => 'reports'
        ];

        $this->adminView('reports', $data);
    }

    public function viewReports() {

        $data = [
            'title' => 'View Reports',
            'activePage' => 'view_reports'
        ];

        $this->adminView('view_reports', $data);
    }

    public function settings() {

        $data = [
            'title' => 'Admin Settings',
            'activePage' => 'settings'
        ];

        $this->adminView('settings', $data);
    }

    public function addStaff(){

        $data = [
            'title' => 'Add New Staff',
            'activePage' => 'staff'
        ];

        $this->adminView('add_staff', $data);
    }

    public function createStaff(){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->addStaff();
        }

        $userModel = $this->model('User');

        $data = [
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
            'email' => trim($_POST['email']),
            'phone_number' => trim($_POST['phone_number']),
            'password' => $_POST['password'],
            'role' => $_POST['role'],
            'address' => trim($_POST['address'] ?? '')
        ];

        // Check whether email already exists
        if ($userModel->findUserByEmail($data['email'])) {
            $data['error'] = 'A user with this email address already exists.';
            
            $this->adminView('add_staff', $data);
            return;
        }

        // Create the user
        $userId = $userModel->register($data);

        if ($userId) {
            $this->staff();
            return;
        }

        $data['error'] = 'Unable to create the staff member.';
        $this->adminView('add_staff', $data);
    }

    //gets the id from the url and finds the user and sends the data to edit form
    public function editStaff($userId){

        $userModel = $this->model('User');
        $staff = $userModel->findUserById($userId);

        if (!$staff) {
            redirect('admin/staff');
            return;
        }

        $data = [
            'title' => 'Edit Staff Member',
            'activePage' => 'staff',
            'staff' => $staff
        ];

        $this->adminView('edit_Staff', $data);
    }

    public function updateStaff($userId){

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->staff();
            return;
        }

        $userModel = $this->model('User');

        $data = [
            'user_id'      => $userId,
            'first_name'   => trim($_POST['first_name']),
            'last_name'    => trim($_POST['last_name']),
            'email'        => trim($_POST['email']),
            'phone_number' => trim($_POST['phone_number']),
            'role'         => $_POST['role'],
            'status'       => $_POST['status']
        ];

        if ($userModel->updateStaff($data)) {
            $this->staff();
            return;
        } 
        else {
            die('Unable to update staff member.');
        }
    }

    public function removeStaff($userId){

        $userModel = $this->model('User');
        $staff = $userModel->findUserById($userId);

        if (!$staff) {
            redirect('admin/staff');
            return;
        }

        if ($staff->role === 'veterinarian') {
            // Veterinarians are kept in the database
            // but their account is deactivated.
            $userModel->deactivateStaff($userId);

        } 
        else {
            // Regular staff can be permanently removed.
            $userModel->deleteStaff($userId);
        }
        $this->redirect('admin/staff');
    }
}