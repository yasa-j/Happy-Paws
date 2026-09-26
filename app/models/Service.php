<?php

class Service
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Active Services
    |--------------------------------------------------------------------------
    */

    public function getActiveServices()
    {
        $this->db->query(
            "SELECT *
             FROM services
             WHERE status = 'Active'
             ORDER BY service_id ASC"
        );

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get One Service By ID
    |--------------------------------------------------------------------------
    */

    public function getServiceById($serviceId)
    {
        $this->db->query(
            "SELECT *
             FROM services
             WHERE service_id = :service_id
             AND status = 'Active'
             LIMIT 1"
        );

        $this->db->bind(':service_id', $serviceId);

        return $this->db->single();
    }
}