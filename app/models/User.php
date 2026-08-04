<?php
/**
 * User Model
 * Handles database operations related to the `User` entity from ER diagram
 */
class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Find user by email
    public function findUserByEmail($email) {
        $this->db->query("SELECT * FROM User WHERE email = :email");
        $this->db->bind(':email', $email);
        $row = $this->db->single();
        return $row;
    }

    // Login user verify password
    public function login($email, $password) {
        $user = $this->findUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    // Register user
    public function register($data) {
        $this->db->query("INSERT INTO User (first_name, last_name, email, password, phone_number, status) 
                          VALUES (:first_name, :last_name, :email, :password, :phone_number, :status)");
        
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', password_hash($data['password'], PASSWORD_DEFAULT));
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':status', 'Active');

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }
}
