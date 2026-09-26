<?php

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Find user by email
    public function findUserByEmail($email)
    {
        $this->db->query(
            "SELECT * FROM users WHERE email = :email"
        );

        $this->db->bind(':email', $email);

        return $this->db->single();
    }

    // Verify login
    public function login($email, $password)
    {
        $user = $this->findUserByEmail($email);

        if ($user && password_verify($password, $user->password)) {
            return $user;
        }

        return false;
    }

    // Register user
    public function register($data)
    {
        $this->db->query(
            "INSERT INTO users
            (first_name, last_name, email, password, phone_number, status)
            VALUES
            (:first_name, :last_name, :email, :password, :phone_number, :status)"
        );

        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(
            ':password',
            password_hash($data['password'], PASSWORD_DEFAULT)
        );
        $this->db->bind(':phone_number', $data['phone_number']);
        $this->db->bind(':status', 'Active');

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }
}