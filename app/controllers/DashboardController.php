<?php

/**
 * Dashboard Controller
 * URL: http://localhost/paws/public/dashboard/index
 */
class DashboardController extends Controller
{
    // Store the shared database connection.
    private $db;

    /**
     * Initialize the database connection.
     */
    public function __construct()
    {
        // Get the singleton database instance.
        $this->db = Database::getInstance();
    }

    /**
     * Display the dashboard page.
     */
    public function index()
    {
        // Get the total number of registered users.
        $this->db->query('SELECT COUNT(*) AS total_users FROM users');
        $userResult = $this->db->single();

        // Prepare all data required by the dashboard view.
        $data = [
            'pageTitle' => 'Dashboard',

            // Database value.
            'totalUsers' => (int) ($userResult->total_users ?? 0),

            // Temporary dashboard values.
            // These can be connected to database tables later.
            'totalProducts' => 48,
            'totalOrders' => 12,
            'lowStockItems' => 3,
            'totalRevenue' => 24650,

            // Temporary weekly sales data for the chart.
            'weeklySales' => [
                ['day' => 'Mon', 'amount' => 10000],
                ['day' => 'Tue', 'amount' => 14000],
                ['day' => 'Wed', 'amount' => 18500],
                ['day' => 'Thu', 'amount' => 26000],
                ['day' => 'Fri', 'amount' => 33000],
                ['day' => 'Sat', 'amount' => 38000],
                ['day' => 'Sun', 'amount' => 25000],
            ],

            // Temporary recent order records.
            'recentOrders' => [
                [
                    'id' => '#ORD-9421',
                    'customer' => 'Emily Stone',
                    'pet' => 'Milo',
                    'items' => 'Rabies Vaccine',
                    'total' => 4200,
                    'status' => 'Completed'
                ],
                [
                    'id' => '#ORD-9420',
                    'customer' => 'Marcus Vance',
                    'pet' => 'Luna',
                    'items' => 'Amoxicillin Drops',
                    'total' => 1850,
                    'status' => 'Completed'
                ],
                [
                    'id' => '#ORD-9419',
                    'customer' => 'Priya Sharma',
                    'pet' => 'Bella',
                    'items' => 'Orthopedic Joint Supplement',
                    'total' => 6400,
                    'status' => 'Processing'
                ],
                [
                    'id' => '#ORD-9418',
                    'customer' => 'David Miller',
                    'pet' => 'Charlie',
                    'items' => 'Prescription Dental Chews',
                    'total' => 3100,
                    'status' => 'Pending'
                ],
            ],

            // Temporary critical stock records.
            'criticalItems' => [
                [
                    'name' => 'Amoxicillin 250mg',
                    'stock' => '4 vials',
                    'minimum' => 20
                ],
                [
                    'name' => 'Canine Dewormer Tablets',
                    'stock' => '2 boxes',
                    'minimum' => 15
                ],
                [
                    'name' => 'Sterile Surgical Gauze 10x10',
                    'stock' => '5 packs',
                    'minimum' => 25
                ],
            ],
        ];

        // Load app/views/dashboard/index.php and pass the dashboard data.
        $this->view('dashboard/index', $data);
    }
}