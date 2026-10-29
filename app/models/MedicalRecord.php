<?php

class MedicalRecord
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get all medical records for a pet
    public function getByPetId($petId)
    {
        $this->db->query(
            "SELECT
                mr.*,
                CONCAT(u.first_name, ' ', u.last_name) AS vet_name
             FROM medical_records mr
             LEFT JOIN users u ON mr.vet_id = u.user_id
             WHERE mr.pet_id = :pet_id
             ORDER BY mr.visit_date DESC"
        );

        $this->db->bind(':pet_id', $petId);

        return $this->db->resultSet();
    }

    // Get one medical record
    public function getById($recordId)
    {
        $this->db->query(
            "SELECT
                mr.*,
                CONCAT(u.first_name, ' ', u.last_name) AS vet_name
             FROM medical_records mr
             LEFT JOIN users u ON mr.vet_id = u.user_id
             WHERE mr.record_id = :record_id"
        );

        $this->db->bind(':record_id', $recordId);

        return $this->db->single();
    }

    // Create a medical record
    public function create($data)
    {
        $this->db->query("
            INSERT INTO medical_records (
                pet_id,
                vet_id,
                appointment_id,
                visit_date,
                diagnosis,
                treatment,
                prescription,
                follow_up_date,
                notes,
                medicine_name,
                medicine_dose,
                medicine_frequency,
                medicine_duration,
                status
            ) VALUES (
                :pet_id,
                :vet_id,
                :appointment_id,
                :visit_date,
                :diagnosis,
                :treatment,
                :prescription,
                :follow_up_date,
                :notes,
                :medicine_name,
                :medicine_dose,
                :medicine_frequency,
                :medicine_duration,
                :status
            )
        ");

        $this->db->bind(':pet_id', $data['pet_id']);
        $this->db->bind(':vet_id', $data['vet_id']);

        $this->db->bind(
            ':appointment_id',
            !empty($data['appointment_id'])
                ? $data['appointment_id']
                : null
        );

        $this->db->bind(':visit_date', $data['visit_date']);
        $this->db->bind(':diagnosis', $data['diagnosis']);
        $this->db->bind(':treatment', $data['treatment']);

        $this->db->bind(
            ':prescription',
            $data['prescription'] ?? null
        );

        $this->db->bind(
            ':follow_up_date',
            !empty($data['follow_up_date'])
                ? $data['follow_up_date']
                : null
        );

        $this->db->bind(
            ':notes',
            $data['notes'] ?? null
        );

        $this->db->bind(
            ':medicine_name',
            !empty($data['medicine_name'])
                ? $data['medicine_name']
                : null
        );

        $this->db->bind(
            ':medicine_dose',
            !empty($data['medicine_dose'])
                ? $data['medicine_dose']
                : null
        );

        $this->db->bind(
            ':medicine_frequency',
            !empty($data['medicine_frequency'])
                ? $data['medicine_frequency']
                : null
        );

        $this->db->bind(
            ':medicine_duration',
            !empty($data['medicine_duration'])
                ? $data['medicine_duration']
                : null
        );
        
        $this->db->bind(
    ':status',
    $data['status'] ?? 'Completed'
);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    // Update an existing medical record
   public function update($data)
{
    $this->db->query(
        "UPDATE medical_records
         SET
            visit_date = :visit_date,
            diagnosis = :diagnosis,
            treatment = :treatment,
            prescription = :prescription,
            follow_up_date = :follow_up_date,
            notes = :notes,
            medicine_name = :medicine_name,
            medicine_dose = :medicine_dose,
            medicine_frequency = :medicine_frequency,
            medicine_duration = :medicine_duration,
            status = :status
         WHERE record_id = :record_id
           AND pet_id = :pet_id"
    );

    $this->db->bind(':visit_date', $data['visit_date']);
    $this->db->bind(':diagnosis', $data['diagnosis']);
    $this->db->bind(':treatment', $data['treatment']);
    $this->db->bind(':prescription', $data['prescription'] ?: null);
    $this->db->bind(
        ':follow_up_date',
        !empty($data['follow_up_date']) ? $data['follow_up_date'] : null
    );
    $this->db->bind(':notes', $data['notes'] ?: null);
    $this->db->bind(':medicine_name', $data['medicine_name'] ?: null);
    $this->db->bind(':medicine_dose', $data['medicine_dose'] ?: null);
    $this->db->bind(':medicine_frequency', $data['medicine_frequency'] ?: null);
    $this->db->bind(':medicine_duration', $data['medicine_duration'] ?: null);
    $this->db->bind(':status', $data['status']);
    $this->db->bind(':record_id', $data['record_id']);
    $this->db->bind(':pet_id', $data['pet_id']);

    return $this->db->execute();
}

    // Delete a medical record
    public function delete($recordId, $petId)
    {
        $this->db->query(
            "DELETE FROM medical_records
             WHERE record_id = :record_id
               AND pet_id = :pet_id"
        );

        $this->db->bind(':record_id', $recordId);
        $this->db->bind(':pet_id', $petId);

        return $this->db->execute();
    }

    // Get medicines for a pet
    public function getMedicinesByPetId($petId)
    {
        $this->db->query("
            SELECT
                record_id,
                pet_id,
                medicine_name,
                medicine_dose,
                medicine_frequency,
                medicine_duration,
                visit_date
            FROM medical_records
            WHERE pet_id = :pet_id
              AND medicine_name IS NOT NULL
              AND medicine_name != ''
            ORDER BY visit_date DESC
        ");

        $this->db->bind(':pet_id', $petId);

        return $this->db->resultSet();
    }
}