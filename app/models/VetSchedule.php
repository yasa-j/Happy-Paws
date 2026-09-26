<?php

/**
 * Vet Schedule Model
 *
 * Handles veterinarian weekly schedules
 * and veterinarian unavailable dates/times.
 */
class VetSchedule
{
    private $db;


    public function __construct()
    {
        $this->db = Database::getInstance();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Weekly Schedule
    |--------------------------------------------------------------------------
    |
    | Gets the normal working schedule of a veterinarian
    | for a particular day.
    |
    | Example:
    | Monday
    | 09:00 - 13:00
    | 14:00 - 17:00
    |
    */

    public function getScheduleByVetAndDay($vetId, $dayOfWeek)
    {
        $this->db->query(
            "SELECT *
             FROM vet_schedules
             WHERE vet_id = :vet_id
             AND day_of_week = :day_of_week
             AND status = 'Available'
             ORDER BY start_time ASC"
        );

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':day_of_week', $dayOfWeek);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Get Vet Unavailability
    |--------------------------------------------------------------------------
    |
    | Gets any unavailable periods for a veterinarian
    | on a particular date.
    |
    | This supports both:
    |
    | Full day leave
    |
    | and
    |
    | Partial leave
    |
    */

    public function getUnavailabilityByVetAndDate($vetId, $date)
    {
        $this->db->query(
            "SELECT *
             FROM vet_unavailability
             WHERE vet_id = :vet_id
             AND unavailable_date = :unavailable_date
             ORDER BY start_time ASC"
        );

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':unavailable_date', $date);

        return $this->db->resultSet();
    }


    /*
    |--------------------------------------------------------------------------
    | Check Whether Vet Is Unavailable
    |--------------------------------------------------------------------------
    |
    | Used later when checking whether a particular
    | 30-minute appointment slot is unavailable.
    |
    */

    public function isTimeUnavailable($vetId, $date, $time)
    {
        $this->db->query(
            "SELECT *
             FROM vet_unavailability
             WHERE vet_id = :vet_id
             AND unavailable_date = :unavailable_date
             AND start_time <= :appointment_time
             AND end_time > :appointment_time"
        );

        $this->db->bind(':vet_id', $vetId);
        $this->db->bind(':unavailable_date', $date);
        $this->db->bind(':appointment_time', $time);

        return $this->db->single();
    }
}