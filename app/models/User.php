<?php
/**
 * User Model
 * Handles database operations related to users
 */
class User {

    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }


    // Find a user using email
    public function findUserByEmail($email) {

        $this->db->query("SELECT * FROM users WHERE email = :email");

        $this->db->bind(':email', $email);

        return $this->db->single();
    }


    // Find a user using phone number
    public function findUserByPhone($phone_number) {

        $this->db->query("SELECT * FROM users WHERE phone_number = :phone_number");

        $this->db->bind(':phone_number', $phone_number);

        return $this->db->single();
    }


    // Check whether email already exists
    public function emailExists($email) {

        $this->db->query("SELECT user_id FROM users WHERE email = :email");

        $this->db->bind(':email', $email);

        $row = $this->db->single();

        return $row ? true : false;
    }


    // Check whether phone number already exists
    public function phoneExists($phone_number) {

        $this->db->query("SELECT user_id FROM users WHERE phone_number = :phone_number");

        $this->db->bind(':phone_number', $phone_number);

        $row = $this->db->single();

        return $row ? true : false;
    }


    // Register a new pet owner
    public function register($data) {

        $this->db->query(
            "INSERT INTO users
            (first_name, last_name, email, password, phone_number, address)
            VALUES
            (:first_name, :last_name, :email, :password, :phone_number, :address)"
        );

        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);

        // Hash the password before storing it
        $this->db->bind(
            ':password',
            password_hash($data['password'], PASSWORD_DEFAULT)
        );

        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':address', $data['address']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }


    // Login using email OR phone number
    public function login($login, $password) {

        // First try email
        $user = $this->findUserByEmail($login);

        // If email was not found, try phone number
        if (!$user) {

            $user = $this->findUserByPhone($login);
        }

        // Check password
        if ($user) {

            if (password_verify($password, $user->password)) {
                return $user;
            }
        }

        return false;
    }

    public function getUserById($userId)
    {
        $this->db->query(
            "SELECT user_id, first_name, last_name, email, phone_number
            FROM users
            WHERE user_id = :user_id"
        );

        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }

        /*
    |--------------------------------------------------------------------------
    | Get All Veterinarians
    |--------------------------------------------------------------------------
    */

    public function getVeterinarians()
    {
        $this->db->query(
            "SELECT user_id, first_name, last_name, status
            FROM users
            WHERE role = 'veterinarian'
            ORDER BY first_name ASC"
        );

        return $this->db->resultSet();
    }
}