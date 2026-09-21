<?php
/**
 * Admin Controller
 * Handles System Admin Dashboard and sub-view navigation
 */
class AdminController extends Controller {

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function getCommonData() {
        $adminName = $_SESSION['user_name'] ?? 'Sarah Jenkins';
        return [
            'adminName' => $adminName,
            'adminRole' => 'System Administrator',
            'adminAvatar' => URLROOT . '/public/images/admin_avatar.png',
            'staffList' => [
                [
                    'id' => 'STF-001',
                    'name' => 'Dr. Michael Vance',
                    'role' => 'Lead Veterinarian',
                    'status' => 'Active',
                    'email' => 'm.vance@happypaws.com',
                    'phone' => '+1 (408) 555-0144',
                    'joined' => '2023-04-12',
                    'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=120&q=80'
                ],
                [
                    'id' => 'STF-002',
                    'name' => 'Dr. Elena Rostova',
                    'role' => 'Surgeon Specialist',
                    'status' => 'Active',
                    'email' => 'e.rostova@happypaws.com',
                    'phone' => '+1 (408) 555-0188',
                    'joined' => '2023-08-19',
                    'avatar' => 'https://images.unsplash.com/photo-1594824813566-88855ce78905?auto=format&fit=crop&w=120&q=80'
                ],
                [
                    'id' => 'STF-003',
                    'name' => 'James Harrison',
                    'role' => 'Vet Technician',
                    'status' => 'On Duty',
                    'email' => 'j.harrison@happypaws.com',
                    'phone' => '+1 (408) 555-0211',
                    'joined' => '2024-01-10',
                    'avatar' => 'https://images.unsplash.com/photo-1537368910025-700350fe46c7?auto=format&fit=crop&w=120&q=80'
                ],
                [
                    'id' => 'STF-004',
                    'name' => 'Sophia Martinez',
                    'role' => 'Clinic Manager',
                    'status' => 'Active',
                    'email' => 's.martinez@happypaws.com',
                    'phone' => '+1 (408) 555-0199',
                    'joined' => '2022-11-05',
                    'avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=120&q=80'
                ],
                [
                    'id' => 'STF-005',
                    'name' => 'David Kim',
                    'role' => 'Receptionist',
                    'status' => 'On Leave',
                    'email' => 'd.kim@happypaws.com',
                    'phone' => '+1 (408) 555-0322',
                    'joined' => '2024-05-20',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=120&q=80'
                ]
            ],
            'clinicInfo' => [
                'name' => 'Happy Paws Veterinary & Care Center',
                'address' => '124 Healthcare Avenue, Suite 300, San Jose, CA 95128',
                'phone' => '+1 (800) 555-PAWS / +1 (408) 555-0199',
                'email' => 'contact@happypaws.com',
                'hours' => 'Mon - Sat: 8:00 AM - 8:00 PM | Sun: 10:00 AM - 4:00 PM',
                'emergency_phone' => '+1 (800) 999-PETS (24/7 Hotline)',
                'license_no' => 'VET-CA-2026-98124',
                'total_vets' => 8,
                'total_rooms' => 12
            ]
        ];
    }

    // Main Dashboard action
    public function index() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'System Admin Dashboard',
            'activePage' => 'dashboard',
            'appointmentsReport' => [
                'total' => 342,
                'completed' => 285,
                'pending' => 42,
                'cancelled' => 15,
                'recent' => [
                    ['id' => 'APT-1049', 'pet' => 'Bella (Golden Retriever)', 'owner' => 'Emily Watson', 'vet' => 'Dr. Michael Vance', 'date' => '2026-09-21 10:30 AM', 'status' => 'Completed'],
                    ['id' => 'APT-1050', 'pet' => 'Milo (Tabby Cat)', 'owner' => 'Robert Chen', 'vet' => 'Dr. Elena Rostova', 'date' => '2026-09-21 11:15 AM', 'status' => 'In Progress'],
                    ['id' => 'APT-1051', 'pet' => 'Rocky (German Shepherd)', 'owner' => 'Sarah Connor', 'vet' => 'Dr. Michael Vance', 'date' => '2026-09-21 01:00 PM', 'status' => 'Scheduled'],
                    ['id' => 'APT-1052', 'pet' => 'Luna (Persian Cat)', 'owner' => 'David Miller', 'vet' => 'Dr. Elena Rostova', 'date' => '2026-09-21 02:30 PM', 'status' => 'Scheduled'],
                    ['id' => 'APT-1053', 'pet' => 'Coco (Poodle)', 'owner' => 'Amanda Brooks', 'vet' => 'James Harrison', 'date' => '2026-09-21 04:00 PM', 'status' => 'Scheduled']
                ]
            ],
            'revenueReport' => [
                'total_month' => '$48,920.00',
                'growth' => '+14.2%',
                'consultation_rev' => '$22,450.00',
                'surgery_rev' => '$18,300.00',
                'pharmacy_rev' => '$8,170.00',
                'monthly' => [
                    ['month' => 'May', 'amount' => '$38,400'],
                    ['month' => 'Jun', 'amount' => '$41,200'],
                    ['month' => 'Jul', 'amount' => '$44,800'],
                    ['month' => 'Aug', 'amount' => '$46,100'],
                    ['month' => 'Sep', 'amount' => '$48,920']
                ]
            ],
            'staffPerformance' => [
                'top_doctor' => 'Dr. Michael Vance (98% Satisfaction)',
                'total_hours' => 1240,
                'avg_rating' => 4.9,
                'performers' => [
                    ['name' => 'Dr. Michael Vance', 'consultations' => 112, 'rating' => '4.9 ★', 'productivity' => '96%'],
                    ['name' => 'Dr. Elena Rostova', 'consultations' => 94, 'rating' => '4.8 ★', 'productivity' => '94%'],
                    ['name' => 'James Harrison', 'consultations' => 78, 'rating' => '4.9 ★', 'productivity' => '92%'],
                    ['name' => 'Sophia Martinez', 'consultations' => 140, 'rating' => '5.0 ★', 'productivity' => '98%']
                ]
            ]
        ]);

        $this->view('admin/dashboard', $data);
    }

    // Staff Management action
    public function staff() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Staff Management',
            'activePage' => 'staff'
        ]);
        $this->view('admin/staff', $data);
    }

    // Staff Accounts action
    public function accounts() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Staff Accounts',
            'activePage' => 'accounts'
        ]);
        $this->view('admin/accounts', $data);
    }

    // Clinic Management action
    public function clinic() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Clinic Management',
            'activePage' => 'clinic'
        ]);
        $this->view('admin/clinic', $data);
    }

    // Clinic Information action
    public function clinicInfo() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Clinic Information',
            'activePage' => 'clinic_info'
        ]);
        $this->view('admin/clinic_info', $data);
    }

    // Reports action
    public function reports() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Reports Overview',
            'activePage' => 'reports'
        ]);
        $this->view('admin/reports', $data);
    }

    // View Reports action
    public function viewReports() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'View Reports',
            'activePage' => 'view_reports'
        ]);
        $this->view('admin/view_reports', $data);
    }

    // Settings action
    public function settings() {
        $data = array_merge($this->getCommonData(), [
            'title' => 'Admin Settings',
            'activePage' => 'settings'
        ]);
        $this->view('admin/settings', $data);
    }
}
