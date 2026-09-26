<?php

class Appointment
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getTodayAppointments($vetId)
    {
        $this->db->query(
            "SELECT
                a.appointment_id,
                a.user_id,
                a.pet_id,
                a.vet_id,
                a.service_id,
                a.appointment_date,
                a.appointment_time,
                a.status,
                a.reason,
                a.notes,

                p.name AS pet_name,
                p.species,
                p.breed,

                u.first_name AS owner_first_name,
                u.last_name AS owner_last_name,

                s.name AS service_name

            FROM appointments a

            INNER JOIN pets p
                ON a.pet_id = p.pet_id

            INNER JOIN users u
                ON a.user_id = u.user_id

            LEFT JOIN services s
                ON a.service_id = s.service_id

            WHERE a.vet_id = :vet_id
              AND a.appointment_date = CURDATE()

            ORDER BY a.appointment_time ASC"
        );

        $this->db->bind(':vet_id', $vetId);

        return $this->db->resultSet();
    }


    public function getUpcomingAppointments($vetId)
    {
        $this->db->query(
            "SELECT
                a.appointment_id,
                a.user_id,
                a.pet_id,
                a.vet_id,
                a.service_id,
                a.appointment_date,
                a.appointment_time,
                a.status,
                a.reason,

                p.name AS pet_name,
                p.species,
                p.breed,

                u.first_name AS owner_first_name,
                u.last_name AS owner_last_name,

                s.name AS service_name

            FROM appointments a

            INNER JOIN pets p
                ON a.pet_id = p.pet_id

            INNER JOIN users u
                ON a.user_id = u.user_id

            LEFT JOIN services s
                ON a.service_id = s.service_id

            WHERE a.vet_id = :vet_id
              AND a.appointment_date > CURDATE()
              AND a.status != 'Cancelled'

            ORDER BY a.appointment_date ASC,
                     a.appointment_time ASC"
        );

        $this->db->bind(':vet_id', $vetId);

        return $this->db->resultSet();
    }
}