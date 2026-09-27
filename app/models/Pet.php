<?php

class Pet
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    /*
    |--------------------------------------------------------------------------
    | Add New Pet
    |--------------------------------------------------------------------------
    */

    public function addPet($data)
    {
        $this->db->query(
            "INSERT INTO pets
            (
                user_id,
                name,
                species,
                breed,
                gender,
                date_of_birth,
                weight_kg,
                color,
                microchip_number,
                allergies
            )
            VALUES
            (
                :user_id,
                :name,
                :species,
                :breed,
                :gender,
                :date_of_birth,
                :weight_kg,
                :color,
                :microchip_number,
                :allergies
            )"
        );


        // Bind the values

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':species', $data['species']);
        $this->db->bind(':breed', $data['breed']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':weight_kg', $data['weight_kg']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':microchip_number', $data['microchip_number']);
        $this->db->bind(':allergies', $data['allergies']);


        // Execute INSERT

        if ($this->db->execute()) {

            // Return the newly created pet ID

            return $this->db->lastInsertId();
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Get Pets By Owner
    |--------------------------------------------------------------------------
    */

    public function getPetsByOwner($userId)
    {
        $this->db->query(
            "SELECT *
             FROM pets
             WHERE user_id = :user_id
             ORDER BY created_at DESC"
        );

        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get One Pet By ID
    |--------------------------------------------------------------------------
    */

    public function getPetById($petId, $userId)
    {
        $this->db->query(
            "SELECT *
             FROM pets
             WHERE pet_id = :pet_id
             AND user_id = :user_id
             LIMIT 1"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }


    /*
    |--------------------------------------------------------------------------
    | Update Pet
    |--------------------------------------------------------------------------
    */

    public function updatePet($data)
    {
        $this->db->query(
            "UPDATE pets
             SET
                name = :name,
                species = :species,
                breed = :breed,
                gender = :gender,
                date_of_birth = :date_of_birth,
                weight_kg = :weight_kg,
                color = :color,
                microchip_number = :microchip_number,
                allergies = :allergies
             WHERE pet_id = :pet_id
             AND user_id = :user_id"
        );


        // Bind the updated values

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':species', $data['species']);
        $this->db->bind(':breed', $data['breed']);
        $this->db->bind(':gender', $data['gender']);
        $this->db->bind(':date_of_birth', $data['date_of_birth']);
        $this->db->bind(':weight_kg', $data['weight_kg']);
        $this->db->bind(':color', $data['color']);
        $this->db->bind(':microchip_number', $data['microchip_number']);
        $this->db->bind(':allergies', $data['allergies']);

        // Bind IDs

        $this->db->bind(':pet_id', $data['pet_id']);
        $this->db->bind(':user_id', $data['user_id']);


        // Execute UPDATE

        return $this->db->execute();
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Pet
    |--------------------------------------------------------------------------
    */

    public function deletePet($petId, $userId)
    {
        $this->db->query(
            "DELETE FROM pets
            WHERE pet_id = :pet_id
            AND user_id = :user_id"
        );

        $this->db->bind(':pet_id', $petId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }
}

    
