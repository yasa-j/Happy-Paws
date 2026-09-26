<?php

class Vaccination
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    // Get all vaccinations for a pet
    public function getByPetId($petId)
    {
        $this->db->query(
            "SELECT *
             FROM vaccinations
             WHERE pet_id = :pet_id
             ORDER BY administered_date DESC"
        );

        $this->db->bind(':pet_id', $petId);

        return $this->db->resultSet();
    }

    // Get one vaccination
    public function getById($vaccinationId)
    {
        $this->db->query(
            "SELECT *
             FROM vaccinations
             WHERE vaccination_id = :vaccination_id"
        );

        $this->db->bind(':vaccination_id', $vaccinationId);

        return $this->db->single();
    }

    // Create vaccination
    public function create($data)
    {
        $this->db->query(
            "INSERT INTO vaccinations
            (
                pet_id,
                vet_id,
                vaccine_name,
                manufacturer,
                vaccination_type,
                administered_date,
                next_due_date,
                batch_number,
                status,
                notes
            )
            VALUES
            (
                :pet_id,
                :vet_id,
                :vaccine_name,
                :manufacturer,
                :vaccination_type,
                :administered_date,
                :next_due_date,
                :batch_number,
                :status,
                :notes
            )"
        );

        $this->db->bind(':pet_id', $data['pet_id']);
        $this->db->bind(':vet_id', $data['vet_id']);
        $this->db->bind(':vaccine_name', $data['vaccine_name']);
        $this->db->bind(':manufacturer', $data['manufacturer']);
        $this->db->bind(':vaccination_type', $data['vaccination_type']);
        $this->db->bind(':administered_date', $data['administered_date']);
        $this->db->bind(':next_due_date', $data['next_due_date']);
        $this->db->bind(':batch_number', $data['batch_number']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':notes', $data['notes']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    // Update vaccination
    public function update($data)
    {
        $this->db->query(
            "UPDATE vaccinations
             SET
                vaccine_name = :vaccine_name,
                manufacturer = :manufacturer,
                vaccination_type = :vaccination_type,
                administered_date = :administered_date,
                next_due_date = :next_due_date,
                batch_number = :batch_number,
                status = :status,
                notes = :notes
             WHERE vaccination_id = :vaccination_id"
        );

        $this->db->bind(':vaccine_name', $data['vaccine_name']);
        $this->db->bind(':manufacturer', $data['manufacturer']);
        $this->db->bind(':vaccination_type', $data['vaccination_type']);
        $this->db->bind(':administered_date', $data['administered_date']);
        $this->db->bind(':next_due_date', $data['next_due_date']);
        $this->db->bind(':batch_number', $data['batch_number']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':notes', $data['notes']);
        $this->db->bind(':vaccination_id', $data['vaccination_id']);

        return $this->db->execute();
    }

    // Delete vaccination
    public function delete($vaccinationId)
    {
        $this->db->query(
            "DELETE FROM vaccinations
             WHERE vaccination_id = :vaccination_id"
        );

        $this->db->bind(':vaccination_id', $vaccinationId);

        return $this->db->execute();
    }
}