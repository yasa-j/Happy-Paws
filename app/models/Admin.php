<?php

class Admin {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Get an admin user by ID
     */
    public function getAdminById($userId) {
        $this->db->query("
            SELECT user_id,
                   first_name,
                   last_name,
                   email,
                   phone_number,
                   role,
                   status,
                   address
            FROM users
            WHERE user_id = :user_id
              AND role = 'admin'
            LIMIT 1
        ");

        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }

    /**
     * Get all staff members and veterinarians.
     *
     * The users table currently contains:
     * - veterinarian
     * - staff
     *
     * System administrators are excluded.
     */
    public function getStaffList() {
        $this->db->query("
            SELECT
                user_id,
                first_name,
                last_name,
                email,
                phone_number,
                role,
                status,
                address
            FROM users
            WHERE role IN ('veterinarian', 'staff')
            ORDER BY user_id
        ");

        return $this->db->resultSet();
    }

    /**
     * Get total number of staff members and veterinarians.
     */
    public function getTotalStaff() {
        $this->db->query("
            SELECT COUNT(*) AS total
            FROM users
            WHERE role IN ('veterinarian', 'staff')
        ");

        return $this->db->single()->total;
    }

    /**
     * Get number of veterinarians.
     */
    public function getVeterinarianCount() {
        $this->db->query("
            SELECT COUNT(*) AS total
            FROM users
            WHERE role = 'veterinarian'
        ");

        return $this->db->single()->total;
    }

    /**
     * Get number of other staff members.
     */
    public function getStaffCount() {
        $this->db->query("
            SELECT COUNT(*) AS total
            FROM users
            WHERE role = 'staff'
        ");

        return $this->db->single()->total;
    }

    /**
     * Get number of active staff members.
     */
    public function getActiveStaffCount() {
        $this->db->query("
            SELECT COUNT(*) AS total
            FROM users
            WHERE role IN ('veterinarian', 'staff')
              AND status = 'Active'
        ");

        return $this->db->single()->total;
    }

    /**
     * Get all users for account management.
     */
    public function getStaffAccounts() {
        $this->db->query("
            SELECT
                user_id,
                first_name,
                last_name,
                email,
                role,
                status
            FROM users
            WHERE role IN ('veterinarian', 'staff')
            ORDER BY first_name ASC, last_name ASC
        ");
        return $this->db->resultSet();
    }

    /**
     * Temporary clinic information
     * TODO: Replace with database query when clinic table is created.
     */
    public function getClinicInfo(){
        
        return [
            'name' => 'Happy Paws Veterinary & Care Center',
            'address' => '124 Healthcare Avenue, Colombo, Sri Lanka',
            'phone' => '+94 70 555 1234',
            'email' => 'contact@happypaws.lk',
            'hours' => 'Monday - Saturday: 8:00 AM - 8:00 PM',
            'emergency_phone' => '+94 70 555 1234',
            'license_no' => 'VET-SL-2026-98124'
        ];
    }

    /**
     * Temporary appointment report.
     * TODO: Replace with database queries / reporting logic.
     */
    public function getAppointmentReport(){

        return [
            'total' => 25,
            'completed' => 10,
            'pending' => 5,
            'confirmed' => 8,
            'cancelled' => 2,
            'recent' => [
                [   'id' => 'APT001',
                    'pet' => 'Buddy',
                    'owner' => 'John Perera',
                    'vet' => 'Dr. Silva',
                    'date' => '2026-09-26 10:00 AM',
                    'status' => 'Confirmed'],

                [   'id' => 'APT002',
                    'pet' => 'Luna',
                    'owner' => 'Sarah Fernando',
                    'vet' => 'Dr. Perera',
                    'date' => '2026-09-26 11:30 AM',
                    'status' => 'Pending'],

                [   'id' => 'APT003',
                    'pet' => 'Max',
                    'owner' => 'Kasun Jayasuriya',
                    'vet' => 'Dr. Silva',
                    'date' => '2026-09-25 02:00 PM',
                    'status' => 'Completed'
                ]
            ]
        ];
    }

    /**
     * Temporary revenue report.
     * TODO: Replace with database query when billing/payment tables are created.
     */
    public function getRevenueReport(){

        return [
            'total_month' => 'Rs. 32,500',
            'consultation_rev' => 'Rs. 18,000',
            'surgery_rev' => 'Rs. 9,500',
            'pharmacy_rev' => 'Rs. 5,000'
        ];
    }
}