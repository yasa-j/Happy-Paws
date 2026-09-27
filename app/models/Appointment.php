<?php

class Appointment
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    /*
    |--------------------------------------------------------------------------
    | Create New Appointment
    |--------------------------------------------------------------------------
    */

    public function createAppointment($data)
    {
        $this->db->query(
            "INSERT INTO appointments
            (
                user_id,
                pet_id,
                vet_id,
                service_id,
                appointment_date,
                appointment_time,
                status,
                reason
            )
            VALUES
            (
                :user_id,
                :pet_id,
                :vet_id,
                :service_id,
                :appointment_date,
                :appointment_time,
                :status,
                :reason
            )"
        );


        // Bind appointment values

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':pet_id', $data['pet_id']);
        $this->db->bind(':vet_id', $data['vet_id']);
        $this->db->bind(':service_id', $data['service_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);

        // Appointment is confirmed when the user books it
        $this->db->bind(':status', 'Confirmed');

        $this->db->bind(':reason', $data['reason']);


        // Execute INSERT

        if ($this->db->execute()) {

            // Return newly created appointment ID

            return $this->db->lastInsertId();
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Check Existing Appointment
    |--------------------------------------------------------------------------
    */

    public function appointmentExists($vetId, $date, $time)
    {
        $this->db->query(
            "SELECT appointment_id
             FROM appointments
             WHERE vet_id = :vet_id
             AND appointment_date = :appointment_date
             AND appointment_time = :appointment_time
             AND status != 'Cancelled'
             LIMIT 1"
        );

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':appointment_date', $date);
        $this->db->bind(':appointment_time', $time);

        return $this->db->single();
    }

    /*
    |--------------------------------------------------------------------------
    | Check Appointment Slot For Rescheduling
    |--------------------------------------------------------------------------
    */

    public function appointmentSlotExists(
        $vetId,
        $date,
        $time,
        $appointmentId
    ) {
        $this->db->query(
            "SELECT appointment_id
            FROM appointments
            WHERE vet_id = :vet_id
            AND appointment_date = :appointment_date
            AND appointment_time = :appointment_time
            AND appointment_id != :appointment_id
            AND status != 'Cancelled'
            LIMIT 1"
        );

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':appointment_date', $date);
        $this->db->bind(':appointment_time', $time);
        $this->db->bind(':appointment_id', $appointmentId);

        return $this->db->single();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Booked Appointment Times
    |--------------------------------------------------------------------------
    |
    | Gets all already-booked times for a veterinarian
    | on a particular date.
    |
    | The current appointment being rescheduled can be excluded
    | so its current slot remains available.
    |
    */

    public function getBookedTimesForVetDate(
        $vetId,
        $date,
        $appointmentId = null
    ) {
        $sql = "
            SELECT appointment_time
            FROM appointments
            WHERE vet_id = :vet_id
            AND appointment_date = :appointment_date
            AND status != 'Cancelled'
        ";

        // If we are rescheduling an existing appointment,
        // do not count that appointment as a booked slot.
        if ($appointmentId !== null) {
            $sql .= "
                AND appointment_id != :appointment_id
            ";
        }

        $sql .= "
            ORDER BY appointment_time ASC
        ";

        $this->db->query($sql);

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':appointment_date', $date);

        if ($appointmentId !== null) {
            $this->db->bind(':appointment_id', $appointmentId);
        }

        return $this->db->resultSet();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Upcoming Appointments For User
    |--------------------------------------------------------------------------
    */

    public function getUpcomingAppointments($userId)
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

                -- Pet information
                p.name AS pet_name,
                p.species,
                p.breed,
                p.date_of_birth,

                -- Veterinarian information
                CONCAT(u.first_name, ' ', u.last_name) AS vet_name,

                -- Service information
                s.name AS service_name,
                s.description AS service_description,
                s.duration_minutes

            FROM appointments a

            LEFT JOIN pets p
                ON a.pet_id = p.pet_id

            LEFT JOIN users u
                ON a.vet_id = u.user_id

            LEFT JOIN services s
                ON a.service_id = s.service_id

            WHERE a.user_id = :user_id

            AND a.status != 'Cancelled'

            AND (
                a.appointment_date > CURDATE()

                OR (
                    a.appointment_date = CURDATE()
                    AND a.appointment_time >= CURTIME()
                )
            )

            ORDER BY
                a.appointment_date ASC,
                a.appointment_time ASC"
        );

        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }

    /*
    |--------------------------------------------------------------------------
    | Get Single Appointment For User
    |--------------------------------------------------------------------------
    */

    public function getAppointmentById($appointmentId, $userId)
    {
        $this->db->query(
            "SELECT *
            FROM appointments
            WHERE appointment_id = :appointment_id
            AND user_id = :user_id
            LIMIT 1"
        );

        $this->db->bind(':appointment_id', $appointmentId);
        $this->db->bind(':user_id', $userId);

        return $this->db->single();
    }


    /*
    |--------------------------------------------------------------------------
    | Cancel Appointment
    |--------------------------------------------------------------------------
    */

    public function cancelAppointment($appointmentId, $userId)
    {
        $this->db->query(
            "UPDATE appointments
            SET status = 'Cancelled'
            WHERE appointment_id = :appointment_id
            AND user_id = :user_id
            AND status != 'Cancelled'"
        );

        $this->db->bind(':appointment_id', $appointmentId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }


    /*
    |--------------------------------------------------------------------------
    | Reschedule Appointment
    |--------------------------------------------------------------------------
    */

    public function rescheduleAppointment(
        $appointmentId,
        $userId,
        $newDate,
        $newTime
    ) {
        $this->db->query(
            "UPDATE appointments
            SET
                appointment_date = :appointment_date,
                appointment_time = :appointment_time
            WHERE appointment_id = :appointment_id
            AND user_id = :user_id
            AND status != 'Cancelled'"
        );

        $this->db->bind(':appointment_date', $newDate);
        $this->db->bind(':appointment_time', $newTime);
        $this->db->bind(':appointment_id', $appointmentId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    
}