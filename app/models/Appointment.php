<?php

class Appointment
{
    private $db;

    public function __construct()
    {
        // Create the database connection
        // Kept exactly as in the member's code
        $this->db = new Database();
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE NEW APPOINTMENT
    |--------------------------------------------------------------------------
    | Creates a new appointment for a pet owner.
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

        // Bind appointment information
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':pet_id', $data['pet_id']);
        $this->db->bind(':vet_id', $data['vet_id']);
        $this->db->bind(':service_id', $data['service_id']);
        $this->db->bind(':appointment_date', $data['appointment_date']);
        $this->db->bind(':appointment_time', $data['appointment_time']);

        // New appointments are created as Confirmed
        $this->db->bind(':status', 'Confirmed');

        $this->db->bind(':reason', $data['reason']);

        // Execute the INSERT query
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK WHETHER APPOINTMENT EXISTS
    |--------------------------------------------------------------------------
    | Checks whether a veterinarian already has an appointment
    | at the selected date and time.
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
    | CHECK APPOINTMENT SLOT WHEN RESCHEDULING
    |--------------------------------------------------------------------------
    | Checks whether another appointment already uses the selected
    | veterinarian, date and time.
    |
    | The current appointment itself is excluded using appointment_id.
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
    | GET BOOKED TIMES FOR A VET
    |--------------------------------------------------------------------------
    | Returns all booked appointment times for a veterinarian
    | on a particular date.
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

        // When rescheduling, exclude the current appointment
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
    | GET UPCOMING APPOINTMENTS FOR PET OWNER
    |--------------------------------------------------------------------------
    | Gets future appointments belonging to a particular pet owner.
    |
    | This is the MEMBER'S method.
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
                p.name AS pet_name,
                p.species,
                p.breed,
                p.date_of_birth,
                CONCAT(u.first_name, ' ', u.last_name) AS vet_name,
                s.name AS service_name,
                s.description AS service_description,
                s.duration_minutes
            FROM appointments a
            LEFT JOIN pets p ON a.pet_id = p.pet_id
            LEFT JOIN users u ON a.vet_id = u.user_id
            LEFT JOIN services s ON a.service_id = s.service_id
            WHERE a.user_id = :user_id
            AND a.status != 'Cancelled'
            AND (
                a.appointment_date > CURDATE()
                OR (
                    a.appointment_date = CURDATE()
                    AND a.appointment_time >= CURTIME()
                )
            )
            ORDER BY a.appointment_date ASC, a.appointment_time ASC"
        );

        $this->db->bind(':user_id', $userId);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | GET APPOINTMENT BY ID
    |--------------------------------------------------------------------------
    | Gets one appointment belonging to a specific pet owner.
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
    | CANCEL APPOINTMENT
    |--------------------------------------------------------------------------
    | Changes the appointment status to Cancelled.
    | The appointment is not deleted from the database.
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
    | RESCHEDULE APPOINTMENT
    |--------------------------------------------------------------------------
    | Updates the date and time of an existing appointment.
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


    /*
    |--------------------------------------------------------------------------
    | VETERINARIAN - GET TODAY'S APPOINTMENTS
    |--------------------------------------------------------------------------
    | Gets all appointments scheduled for today for the logged-in
    | veterinarian.
    |
    | This method was added for the Veterinarian side.
    */

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


    /*
    |--------------------------------------------------------------------------
    | VETERINARIAN - GET UPCOMING APPOINTMENTS
    |--------------------------------------------------------------------------
    | Gets future appointments for the logged-in veterinarian.
    |
    | IMPORTANT:
    | This method is called getUpcomingAppointmentsForVet()
    | because the member already has a method called
    | getUpcomingAppointments().
    */

    public function getUpcomingAppointmentsForVet($vetId)
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