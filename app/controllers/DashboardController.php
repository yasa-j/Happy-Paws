<?php
/**
 * =======================================================================
 * Happy Paws - Dashboard Controller
 * =======================================================================
 * 
 * Handles authenticated user portal access, displaying pet profiles,
 * upcoming appointments, and user account status.
 * Protected by authentication guard requiring an active session.
 * =======================================================================
 */

class DashboardController extends Controller {

    /**
     * User model instance
     * @var User
     */
    private $userModel;

    /**
     * Controller constructor.
     * Enforces authentication guard: unauthenticated users are redirected to login.
     */
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }

        $this->userModel = $this->model('User');
    }

    /**
     * Default dashboard view
     */
    public function index() {
        $userId = $_SESSION['user_id'];

        // Retrieve current user details from database
        $user = $this->userModel->findUserById($userId);
        
        // Retrieve pets owned by this user
        $pets = $this->userModel->getPetsByUserId($userId);

        // Retrieve appointments for this user's pets
        $appointments = $this->userModel->getAppointmentsByUserId($userId);

        $data = [
            'title' => 'User Dashboard',
            'user' => $user,
            'pets' => $pets,
            'appointments' => $appointments,
            'flash_success' => $_SESSION['flash_success'] ?? null
        ];

        // Clear one-time flash message
        unset($_SESSION['flash_success']);

        $this->view('dashboard/index', $data);
    }
}
