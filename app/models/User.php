<?php
/**
 * =======================================================================
 * Happy Paws - User Model
 * =======================================================================
 * 
 * Handles database operations for the `users` table, including user
 * authentication, account registration, profile lookups, and associated
 * pet / appointment relationships.
 * =======================================================================
 */

class User {
    /**
     * Database singleton connection instance
     * @var Database
     */
    private $db;

    /**
     * Initialize model with database connection
     */
    public function __construct() {
        $this->db = Database::getInstance();
    }

    /**
     * Find a user record by email address
     * 
     * @param string $email The user email to look up
     * @return object|false Returns user row object or false if not found
     */
    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM users WHERE email = :email LIMIT 1");
        $this->db->bind(':email', $email);
        return $this->db->single();
    }

    /**
     * Find a user record by unique user ID
     * 
     * @param int $id The primary key user_id
     * @return object|false Returns user row object or false if not found
     */
    public function findUserById($id) {
        $this->db->query("SELECT * FROM users WHERE user_id = :id LIMIT 1");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    /**
     * Authenticate user credentials
     * 
     * Verifies that the email exists, the account status is Active,
     * and the plaintext password matches the bcrypt hash.
     * 
     * @param string $email User email
     * @param string $password Plaintext password submitted in form
     * @return object|false Returns authenticated user object on success, false on failure
     */
    public function login($email, $password) {
        $user = $this->findUserByEmail($email);

        if (!$user) {
            return false; // Email does not exist
        }

        // Check if account is active
        if ($user->status !== 'Active') {
            return false; // Suspended or inactive account
        }

        // Verify bcrypt hash
        if (password_verify($password, $user->password)) {
            return $user;
        }

        return false; // Invalid password
    }

    /**
     * Register a new user account
     * 
     * @param array $data Associative array containing user registration inputs
     * @return int|false Returns newly inserted user_id or false on error
     */
    public function register($data) {
        $this->db->query("INSERT INTO users (first_name, last_name, email, password, phone_number, role, status, address) 
                          VALUES (:first_name, :last_name, :email, :password, :phone_number, :role, :status, :address)");
        
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':phone_number', $data['phone_number'] ?? null);
        $this->db->bind(':role', $data['role'] ?? 'pet_owner');
        $this->db->bind(':status', 'Active');
        $this->db->bind(':address', $data['address'] ?? null);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Fetch all pets registered under a specific user (owner)
     * 
     * @param int $userId Owner user_id
     * @return array List of pet objects
     */

    /**
     * might change getPetsByUserId() to getAppointmentsByUserId() becasue
     * it makes more sense than what we have here
     */
    public function getPetsByUserId($userId) {
        $this->db->query("SELECT * FROM pets WHERE user_id = :user_id ORDER BY created_at DESC");
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    /**
     * Fetch appointments for a user's pets with joined pet, vet, and service information
     * 
     * @param int $userId User ID of the owner
     * @return array List of appointment objects
     */
    public function getAppointmentsByUserId($userId) {
        $sql = "SELECT a.*, p.name AS pet_name, p.species, s.name AS service_name, s.price AS service_price,
                       CONCAT(v.first_name, ' ', v.last_name) AS vet_name
                FROM appointments a
                JOIN pets p ON a.pet_id = p.pet_id
                LEFT JOIN services s ON a.service_id = s.service_id
                LEFT JOIN users v ON a.vet_id = v.user_id
                WHERE a.user_id = :user_id
                ORDER BY a.appointment_date ASC, a.appointment_time ASC";
        
        $this->db->query($sql);
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }
}
