<?php

class HealthRecord
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Pet Health Summary
    |--------------------------------------------------------------------------
    */

    public function getPetHealthSummary($petId, $userId)
    {
        $this->db->query(
            "SELECT
                p.pet_id,
                p.name,
                p.species,
                p.breed,
                p.gender,
                p.date_of_birth,
                p.weight_kg,
                p.microchip_number,
                p.allergies

            FROM pets p

            WHERE p.pet_id = :pet_id
            AND p.user_id = :user_id

            LIMIT 1"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Medical History
    |--------------------------------------------------------------------------
    */

    public function getMedicalHistory($petId, $userId)
    {
        $this->db->query(
            "SELECT
                mr.record_id,
                mr.visit_date,
                mr.diagnosis,
                mr.treatment,
                mr.prescription,
                mr.follow_up_date,
                mr.notes,

                CONCAT(u.first_name, ' ', u.last_name) AS vet_name,

                a.reason AS appointment_reason,

                s.name AS service_name,
                s.category AS service_category

            FROM medical_records mr

            INNER JOIN pets p
                ON mr.pet_id = p.pet_id

            LEFT JOIN users u
                ON mr.vet_id = u.user_id

            LEFT JOIN appointments a
                ON mr.appointment_id = a.appointment_id

            LEFT JOIN services s
                ON a.service_id = s.service_id

            WHERE mr.pet_id = :pet_id
            AND p.user_id = :user_id

            ORDER BY mr.visit_date DESC"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Vaccination Records
    |--------------------------------------------------------------------------
    */

    public function getVaccinations($petId, $userId)
    {
        $this->db->query(
            "SELECT
                v.vaccination_id,
                v.vaccine_name,
                v.administered_date,
                v.next_due_date,
                v.batch_number,
                v.status,
                v.notes,

                CONCAT(u.first_name, ' ', u.last_name) AS vet_name

            FROM vaccinations v

            INNER JOIN pets p
                ON v.pet_id = p.pet_id

            LEFT JOIN users u
                ON v.vet_id = u.user_id

            WHERE v.pet_id = :pet_id
            AND p.user_id = :user_id

            ORDER BY v.administered_date DESC"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Prescription Records
    |--------------------------------------------------------------------------
    |
    | Prescriptions are stored inside medical_records.prescription.
    |
    */

    public function getPrescriptions($petId, $userId)
    {
        $this->db->query(
            "SELECT
                mr.record_id,
                mr.visit_date,
                mr.prescription,
                mr.diagnosis,

                CONCAT(u.first_name, ' ', u.last_name) AS vet_name

            FROM medical_records mr

            INNER JOIN pets p
                ON mr.pet_id = p.pet_id

            LEFT JOIN users u
                ON mr.vet_id = u.user_id

            WHERE mr.pet_id = :pet_id
            AND p.user_id = :user_id
            AND mr.prescription IS NOT NULL
            AND TRIM(mr.prescription) != ''

            ORDER BY mr.visit_date DESC"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Last Medical Visit
    |--------------------------------------------------------------------------
    */

    public function getLastMedicalVisit($petId, $userId)
    {
        $this->db->query(
            "SELECT
                mr.visit_date,
                CONCAT(u.first_name, ' ', u.last_name) AS vet_name

            FROM medical_records mr

            INNER JOIN pets p
                ON mr.pet_id = p.pet_id

            LEFT JOIN users u
                ON mr.vet_id = u.user_id

            WHERE mr.pet_id = :pet_id
            AND p.user_id = :user_id

            ORDER BY mr.visit_date DESC

            LIMIT 1"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Vaccination Summary
    |--------------------------------------------------------------------------
    */

    public function getVaccinationSummary($petId, $userId)
    {
        $this->db->query(
            "SELECT
                COUNT(*) AS vaccination_count

            FROM vaccinations v

            INNER JOIN pets p
                ON v.pet_id = p.pet_id

            WHERE v.pet_id = :pet_id
            AND p.user_id = :user_id"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Next Vaccination
    |--------------------------------------------------------------------------
    */

    public function getNextVaccination($petId, $userId)
    {
        $this->db->query(
            "SELECT
                vaccine_name,
                next_due_date

            FROM vaccinations v

            INNER JOIN pets p
                ON v.pet_id = p.pet_id

            WHERE v.pet_id = :pet_id
            AND p.user_id = :user_id
            AND v.next_due_date >= CURDATE()

            ORDER BY v.next_due_date ASC

            LIMIT 1"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }
}