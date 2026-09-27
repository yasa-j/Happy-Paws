<?php

class PetOwnerController extends Controller
{
    private $petModel;
    private $userModel;
    private $serviceModel;
    private $appointmentModel;
    private $vetScheduleModel;

    public function __construct()
    {
        // Load the Pet model
        $this->petModel = $this->model('Pet');
        // Load the User model
        $this->userModel = $this->model('User');
        // Load the Service model
        $this->serviceModel = $this->model('Service');
        // Load the Appointment model
        $this->appointmentModel = $this->model('Appointment');
        // Load the Veterinarian Schedule model
        $this->vetScheduleModel = $this->model('VetSchedule');
    }
    /*
     * Pet Owner Dashboard
     */
    public function dashboard()
    {
        // Get the logged-in user's name from the session
        $userName = $_SESSION['user_name'] ?? 'Pet Owner';

        // Get the current hour
        $hour = date('H');

        // Set greeting according to the time of day
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good Morning,';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Good Afternoon,';
        } else {
            $greeting = 'Good Evening,';
        }

        $data = [
            'activePage' => 'dashboard',

            // Dynamic logged-in user's name
            'userName' => $userName,

            // Dynamic greeting
            'greeting' => $greeting,

            // Dashboard values for now
            'petCount' => 2,
            'upcomingAppointments' => 1,
            'vaccinationsDue' => 1,
            'newNotifications' => 3
        ];

        $this->view('petowner/dashboard', $data);
    }


    /*
     * My Pets
     *
     * Gets the pets belonging to the currently logged-in user.
     */
    public function pets()
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get this user's pets from the database
        $pets = $this->petModel->getPetsByOwner($userId);

        // Send the pets to the view
        $data = [
            'title' => 'My Pets',
            'activePage' => 'pets',
            'pets' => $pets
        ];

        $this->view('petowner/pets', $data);
    }
        /*
     * Register New Pet
     *
     * Displays the form and saves the pet to the database
     * when the form is submitted.
     */
    public function registerPet()
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Show form / handle form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $userId = $_SESSION['user_id'];

            // Get form data
            $name = trim($_POST['petName'] ?? '');

            $species = $_POST['petType'] ?? '';

            $breed = trim($_POST['breed'] ?? '');

            $gender = $_POST['gender'] ?? '';

            $dateOfBirth = !empty($_POST['dateOfBirth'])
                ? $_POST['dateOfBirth']
                : null;

            $weight = isset($_POST['weight']) && $_POST['weight'] !== ''
                ? (float) $_POST['weight']
                : null;


            // Optional fields
            $color = !empty($_POST['color'])
                ? trim($_POST['color'])
                : null;

            $microchipNumber = !empty($_POST['microchipNumber'])
                ? trim($_POST['microchipNumber'])
                : null;

            $allergies = !empty($_POST['allergies'])
                ? trim($_POST['allergies'])
                : null;


            // Basic validation
            $errors = [];

            if ($name == '') {
                $errors[] = 'Please enter the pet name.';
            }

            if ($species != 'Dog' && $species != 'Cat') {
                $errors[] = 'Please select Dog or Cat.';
            }

            if ($breed == '') {
                $errors[] = 'Please enter the breed.';
            }

            if ($gender != 'Male' && $gender != 'Female') {
                $errors[] = 'Please select the pet gender.';
            }


            // If there are validation errors
            if (!empty($errors)) {

                $data = [
                    'activePage' => 'pets',
                    'errors' => $errors
                ];

                $this->view('petowner/register-pet', $data);
                return;
            }


            // Prepare data for the Pet model
            $petData = [
                'user_id' => $userId,
                'name' => $name,
                'species' => $species,
                'breed' => $breed,
                'gender' => $gender,
                'date_of_birth' => $dateOfBirth,
                'weight_kg' => $weight,
                'color' => $color,
                'microchip_number' => $microchipNumber,
                'allergies' => $allergies
            ];


            /*
            * Photo is intentionally not included.
            * The photo field is only for the UI and is not saved.
            */

            $saved = $this->petModel->addPet($petData);


            // Pet successfully registered
            if ($saved) {

                // Store success information in the session
                $_SESSION['pet_success'] = true;
                $_SESSION['registered_pet_name'] = $name;
                $_SESSION['registered_pet_id'] = $saved;

                // Redirect back to the register pet page
                header('Location: ' . URLROOT . '/petowner/registerPet');
                exit;
            }


            // Database insertion failed
            $data = [
                'activePage' => 'pets',
                'errors' => [
                    'Something went wrong while registering the pet. Please try again.'
                ]
            ];

            $this->view('petowner/register-pet', $data);
            return;
        }


        // Normal GET request

        // Get the logged-in user's details
        $userId = $_SESSION['user_id'];

        $user = $this->userModel->getUserById($userId);


        // Check if a pet was just registered
        $petSuccess = $_SESSION['pet_success'] ?? false;
        $registeredPetName = $_SESSION['registered_pet_name'] ?? '';
        $registeredPetId = $_SESSION['registered_pet_id'] ?? '';

        // Clear the success message after reading it
        unset($_SESSION['pet_success']);
        unset($_SESSION['registered_pet_name']);
        unset($_SESSION['registered_pet_id']);

        $data = [
            'activePage' => 'pets',

            'petSuccess' => $petSuccess,

            'registeredPetName' => $registeredPetName,

            'registeredPetId' => $registeredPetId,

            'user' => $user
        ];

        $this->view('petowner/register-pet', $data);
    }

    /*View Pet Details*/
    public function viewPet($petId)
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get the selected pet
        $pet = $this->petModel->getPetById($petId, $userId);

        // If pet does not exist or does not belong to this user
        if (!$pet) {
            header('Location: ' . URLROOT . '/petowner/pets');
            exit;
        }

        // Send pet information to the profile page
        $data = [
            'activePage' => 'pets',
            'pet' => $pet
        ];

        $this->view('petowner/view-pet', $data);
    }

    /*Delete Pet*/
    public function deletePet($petId)
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Delete only if the pet belongs to this user
        $deleted = $this->petModel->deletePet($petId, $userId);

        if ($deleted) {

            // Store success message
            $_SESSION['pet_delete_success'] = true;

            // Go back to My Pets
            header('Location: ' . URLROOT . '/petowner/pets');
            exit;
        }

        // If deletion failed
        header('Location: ' . URLROOT . '/petowner/pets');
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | Edit Pet
    |--------------------------------------------------------------------------
    |
    | Shows the edit form and updates the selected pet.
    |
    */
    public function editPet($petId)
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get the selected pet
        $pet = $this->petModel->getPetById($petId, $userId);

        // If pet does not exist or does not belong to this user
        if (!$pet) {
            header('Location: ' . URLROOT . '/petowner/pets');
            exit;
        }

        /*
        * Handle form submission
        */
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get form data
            $name = trim($_POST['petName'] ?? '');

            $species = $_POST['petType'] ?? '';

            $breed = trim($_POST['breed'] ?? '');

            $gender = $_POST['gender'] ?? '';

            $dateOfBirth = !empty($_POST['dateOfBirth'])
                ? $_POST['dateOfBirth']
                : null;

            $weight = !empty($_POST['weight'])
                ? $_POST['weight']
                : null;

            $color = !empty($_POST['color'])
                ? trim($_POST['color'])
                : null;

            $microchipNumber = !empty($_POST['microchipNumber'])
                ? trim($_POST['microchipNumber'])
                : null;

            $allergies = !empty($_POST['allergies'])
                ? trim($_POST['allergies'])
                : null;


            // Basic validation
            $errors = [];

            if ($name == '') {
                $errors[] = 'Please enter the pet name.';
            }

            if ($species != 'Dog' && $species != 'Cat') {
                $errors[] = 'Please select Dog or Cat.';
            }

            if ($breed == '') {
                $errors[] = 'Please enter the breed.';
            }

            if ($gender != 'Male' && $gender != 'Female') {
                $errors[] = 'Please select the pet gender.';
            }


            // If validation errors exist
            if (!empty($errors)) {

                $data = [
                    'activePage' => 'pets',
                    'pet' => $pet,
                    'errors' => $errors
                ];

                $this->view('petowner/edit-pet', $data);
                return;
            }


            // Prepare updated pet data
            $petData = [
                'pet_id' => $petId,
                'user_id' => $userId,
                'name' => $name,
                'species' => $species,
                'breed' => $breed,
                'gender' => $gender,
                'date_of_birth' => $dateOfBirth,
                'weight_kg' => $weight,
                'color' => $color,
                'microchip_number' => $microchipNumber,
                'allergies' => $allergies
            ];


            // Update database
            $updated = $this->petModel->updatePet($petData);


            if ($updated) {

                // Store success message
                $_SESSION['pet_edit_success'] = true;
                $_SESSION['edited_pet_name'] = $name;

                // Go back to My Pets
                header('Location: ' . URLROOT . '/petowner/pets');
                exit;
            }


            // Database update failed
            $data = [
                'activePage' => 'pets',
                'pet' => $pet,
                'errors' => [
                    'Something went wrong while updating the pet. Please try again.'
                ]
            ];

            $this->view('petowner/edit-pet', $data);
            return;
        }


        /*
        * Normal GET request
        *
        * Show the edit form.
        */
        $data = [
            'activePage' => 'pets',
            'pet' => $pet,
            'errors' => []
        ];

        $this->view('petowner/edit-pet', $data);
    }

    public function bookAppointment()
    {
        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get the logged-in user's details
        $user = $this->userModel->getUserById($userId);


        /*
        |--------------------------------------------------------------------------
        | Handle Appointment Form Submission
        |--------------------------------------------------------------------------
        */

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Get the submitted appointment data

            $appointmentData = [
                'user_id' => $userId,
                'pet_id' => trim($_POST['pet_id'] ?? ''),
                'service_id' => trim($_POST['service_id'] ?? ''),
                'vet_id' => trim($_POST['vet_id'] ?? ''),
                'appointment_date' => trim($_POST['appointment_date'] ?? ''),
                'appointment_time' => trim($_POST['appointment_time'] ?? ''),
                'reason' => trim($_POST['reason'] ?? ''),
                'status' => 'Confirmed'
            ];


            /*
            |--------------------------------------------------------------------------
            | Check Required Fields
            |--------------------------------------------------------------------------
            */

            if (
                empty($appointmentData['pet_id']) ||
                empty($appointmentData['service_id']) ||
                empty($appointmentData['vet_id']) ||
                empty($appointmentData['appointment_date']) ||
                empty($appointmentData['appointment_time'])
            ) {

                // Reload the booking page with database data

                $data = [
                    'pets' => $this->petModel->getPetsByOwner($userId),
                    'services' => $this->serviceModel->getActiveServices(),
                    'veterinarians' => $this->userModel->getVeterinarians(),
                    'user' => $user
                ];
                $this->view('petowner/bookAppointment', $data);
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Check For Double Booking
            |--------------------------------------------------------------------------
            */

            $existingAppointment = $this->appointmentModel->appointmentExists(
                $appointmentData['vet_id'],
                $appointmentData['appointment_date'],
                $appointmentData['appointment_time']
            );


            if ($existingAppointment) {

                // Reload the booking page with database data

                $data = [
                    'pets' => $this->petModel->getPetsByOwner($userId),
                    'services' => $this->serviceModel->getActiveServices(),
                    'veterinarians' => $this->userModel->getVeterinarians(),
                    'user' => $user
                ];

                $this->view('petowner/bookAppointment', $data);
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | Create Appointment
            |--------------------------------------------------------------------------
            */

            $appointmentId = $this->appointmentModel->createAppointment(
                $appointmentData
            );


            if ($appointmentId) {

                // Appointment successfully created

                echo "<script>
                    alert('Appointment booked successfully!');
                    window.location.href = '" . URLROOT . "/petowner/upcomingAppointments';
                </script>";

                exit;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Load Appointment Booking Page
        |--------------------------------------------------------------------------
        */

        // Get this owner's pets
        $pets = $this->petModel->getPetsByOwner($userId);

        // Get all active services
        $services = $this->serviceModel->getActiveServices();

        // Get all veterinarians
        $veterinarians = $this->userModel->getVeterinarians();


        /*
        |--------------------------------------------------------------------------
        | Send Database Data To The View
        |--------------------------------------------------------------------------
        */

        $data = [
            'pets' => $pets,
            'services' => $services,
            'veterinarians' => $veterinarians,
            'user' => $user
        ];


        $this->view('petowner/bookAppointment', $data);
    }

    public function upcomingAppointments()
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get this user's upcoming appointments from database
        $dbAppointments = $this->appointmentModel->getUpcomingAppointments($userId);

        // Convert database objects into the format used by the UI
        $appointments = [];

        foreach ($dbAppointments as $appointment) {

            $appointments[] = [
                'id' => 'APT-' . str_pad($appointment->appointment_id, 6, '0', STR_PAD_LEFT),

                'date' => date('d', strtotime($appointment->appointment_date)),
                'month' => strtoupper(date('M', strtotime($appointment->appointment_date))),
                'year' => date('Y', strtotime($appointment->appointment_date)),

                'time' => date('h:i A', strtotime($appointment->appointment_time)),

                // Calculate end time using service duration
                'end_time' => date(
                    'h:i A',
                    strtotime(
                        '+' . ($appointment->duration_minutes ?? 30) . ' minutes',
                        strtotime($appointment->appointment_time)
                    )
                ),

                'duration' => ($appointment->duration_minutes ?? 30) . ' min slot',

                'title' => $appointment->service_name ?? 'Veterinary Appointment',

                'description' => $appointment->service_description
                    ?? ($appointment->reason ?? 'Veterinary consultation'),

                'pet_name' => $appointment->pet_name ?? 'Pet',

                'pet_type' => $appointment->breed
                    ?? ($appointment->species ?? 'Pet'),

                'pet_age' => !empty($appointment->date_of_birth)
                    ? (
                        date_diff(
                            date_create($appointment->date_of_birth),
                            date_create($appointment->appointment_date)
                        )->y . ' yrs'
                    )
                    : 'Age not available',
                
                'appointment_id' => $appointment->appointment_id,
                'vet_id' => $appointment->vet_id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,

                'vet' => $appointment->vet_name ?? 'Veterinarian',

                'vet_role' => 'Veterinarian',

                'room' => 'Room 02',

                'location' => 'Main Clinic',

                'status' => $appointment->status
            ];
        }


        // Number of upcoming appointments
        $appointmentCount = count($appointments);

        // First appointment is the next appointment
        $nextAppointment = !empty($appointments)
            ? $appointments[0]
            : null;


        // Send data to view
        $data = [
            'title' => 'Upcoming Appointments',

            'activePage' => 'appointments',

            'activeSubPage' => 'upcoming',

            'appointments' => $appointments,

            'appointmentCount' => $appointmentCount,

            'nextAppointment' => $nextAppointment
        ];


        // Load upcoming appointments page
        $this->view('petowner/upcomingAppointments', $data);
    }

    /*
    |--------------------------------------------------------------------------
    | Get Reschedule Availability
    |--------------------------------------------------------------------------
    |
    | Gets available 30-minute appointment slots for the veterinarian
    | of the appointment being rescheduled.
    |
    */

    public function getRescheduleAvailability()
    {
        // Make sure the user is logged in

        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'User not logged in.'
            ]);

            exit;
        }


        // Get logged-in user ID

        $userId = $_SESSION['user_id'];


        // Get submitted values

        $appointmentId = $_GET['appointment_id'] ?? null;

        $date = $_GET['date'] ?? null;


        // Check required values

        if (!$appointmentId || !$date) {

            echo json_encode([
                'success' => false,
                'message' => 'Appointment and date are required.'
            ]);

            exit;
        }


        // Load Appointment model

        $appointmentModel = $this->model('Appointment');


        // Get the appointment

        $appointment = $appointmentModel->getAppointmentById(
            $appointmentId,
            $userId
        );


        // Make sure appointment belongs to logged-in user

        if (!$appointment) {

            echo json_encode([
                'success' => false,
                'message' => 'Appointment not found.'
            ]);

            exit;
        }


        // Get veterinarian ID

        $vetId = $appointment->vet_id;


        /*
        |--------------------------------------------------------------------------
        | Get Day Of Week
        |--------------------------------------------------------------------------
        */

        $dayOfWeek = date(
            'l',
            strtotime($date)
        );


        /*
        |--------------------------------------------------------------------------
        | Get Vet Weekly Schedule
        |--------------------------------------------------------------------------
        */

        $schedule = $this->vetScheduleModel
            ->getScheduleByVetAndDay(
                $vetId,
                $dayOfWeek
            );


        /*
        |--------------------------------------------------------------------------
        | Get Vet Unavailability
        |--------------------------------------------------------------------------
        */

        $unavailability = $this->vetScheduleModel
            ->getUnavailabilityByVetAndDate(
                $vetId,
                $date
            );


        /*
        |--------------------------------------------------------------------------
        | Get Already Booked Times
        |--------------------------------------------------------------------------
        |
        | Exclude the appointment currently being rescheduled.
        |
        */

        $bookedAppointments = $appointmentModel
            ->getBookedTimesForVetDate(
                $vetId,
                $date,
                $appointmentId
            );


        /*
        |--------------------------------------------------------------------------
        | Create Array Of Booked Times
        |--------------------------------------------------------------------------
        */

        $bookedTimes = [];

        foreach ($bookedAppointments as $booked) {

            $bookedTimes[] = date(
                'H:i',
                strtotime($booked->appointment_time)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Create Available Slots
        |--------------------------------------------------------------------------
        */

        $availableSlots = [];


        foreach ($schedule as $period) {

            $startTime = strtotime(
                $date . ' ' . $period->start_time
            );

            $endTime = strtotime(
                $date . ' ' . $period->end_time
            );


            /*
            |--------------------------------------------------------------------------
            | Generate 30 Minute Slots
            |--------------------------------------------------------------------------
            */

            while ($startTime < $endTime) {

                $slotTime = date(
                    'H:i',
                    $startTime
                );


                /*
                |--------------------------------------------------------------------------
                | Check Booked Appointment
                |--------------------------------------------------------------------------
                */

                if (in_array($slotTime, $bookedTimes)) {

                    $startTime += 30 * 60;

                    continue;
                }


                /*
                |--------------------------------------------------------------------------
                | Check Unavailability
                |--------------------------------------------------------------------------
                */

                $isUnavailable = false;


                foreach ($unavailability as $blocked) {

                    $blockedStart = strtotime(
                        $date . ' ' . $blocked->start_time
                    );

                    $blockedEnd = strtotime(
                        $date . ' ' . $blocked->end_time
                    );


                    if (
                        $startTime >= $blockedStart &&
                        $startTime < $blockedEnd
                    ) {

                        $isUnavailable = true;

                        break;
                    }
                }


                if (!$isUnavailable) {

                    $availableSlots[] = [
                        'value' => $slotTime,
                        'display' => date(
                            'h:i A',
                            $startTime
                        )
                    ];
                }


                /*
                |--------------------------------------------------------------------------
                | Move To Next 30 Minute Slot
                |--------------------------------------------------------------------------
                */

                $startTime += 30 * 60;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Return JSON
        |--------------------------------------------------------------------------
        */

        echo json_encode([
            'success' => true,
            'date' => $date,
            'vet_id' => $vetId,
            'slots' => $availableSlots
        ]);

        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Reschedule Appointment
    |--------------------------------------------------------------------------
    */

    public function rescheduleAppointment()
    {
        // Make sure user is logged in

        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }


        // Get logged-in user's ID

        $userId = $_SESSION['user_id'];


        // Get submitted appointment details

        $appointmentId = $_POST['appointment_id'] ?? null;

        $newDate = $_POST['appointment_date'] ?? null;

        $newTime = $_POST['appointment_time'] ?? null;


        // Make sure all values were submitted

        if (!$appointmentId || !$newDate || !$newTime) {

            header('Location: ' . URLROOT . '/petowner/upcomingAppointments');
            exit;
        }


        // Load Appointment model

        $appointmentModel = $this->model('Appointment');


        // Make sure this appointment belongs to this user

        $appointment = $appointmentModel->getAppointmentById(
            $appointmentId,
            $userId
        );


        if (!$appointment) {

            header('Location: ' . URLROOT . '/petowner/upcomingAppointments');
            exit;
        }


        // Update appointment date and time

        $updated = $appointmentModel->rescheduleAppointment(
            $appointmentId,
            $userId,
            $newDate,
            $newTime
        );


        if ($updated) {

            // Success message

            $_SESSION['success_message'] =
                'Appointment rescheduled successfully.';

        } else {

            // Error message

            $_SESSION['error_message'] =
                'Unable to reschedule the appointment.';
        }


        // Return to upcoming appointments

        header(
            'Location: ' .
            URLROOT .
            '/petowner/upcomingAppointments'
        );

        exit;
    }

    public function cancelAppointment()
    {
        // Make sure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/');
            exit;
        }

        $userId = $_SESSION['user_id'];

        // Get appointment ID from the form
        $appointmentId = $_POST['appointment_id'] ?? null;

        if (!$appointmentId) {

            $_SESSION['error_message'] =
                'Invalid appointment.';

            header(
                'Location: ' .
                URLROOT .
                '/petowner/upcomingAppointments'
            );

            exit;
        }


        // Load Appointment model
        $appointmentModel = $this->model('Appointment');


        // Make sure this appointment belongs to this user
        $appointment =
            $appointmentModel->getAppointmentById(
                $appointmentId,
                $userId
            );


        if (!$appointment) {

            $_SESSION['error_message'] =
                'Appointment not found.';

            header(
                'Location: ' .
                URLROOT .
                '/petowner/upcomingAppointments'
            );

            exit;
        }


        // Cancel the appointment
        $cancelled =
            $appointmentModel->cancelAppointment(
                $appointmentId,
                $userId
            );


        if ($cancelled) {

            $_SESSION['success_message'] =
                'Appointment cancelled successfully.';

        } else {

            $_SESSION['error_message'] =
                'Unable to cancel the appointment.';
        }


        // Return to upcoming appointments
        header(
            'Location: ' .
            URLROOT .
            '/petowner/upcomingAppointments'
        );

        exit;
    }


    public function appointmentHistory()
    {
        $data = [
        'pageTitle' => 'Appointment History'
        ];

        $this->view('petowner/appointment-history', $data);
    }

    public function healthRecords()
    {
        // Sample pet information
        // This will later come from the database.
        $pet = [
            'name' => 'Max',
            'breed' => 'Golden Retriever',
            'gender' => 'Male',
            'age' => '3 years old',
            'weight' => '31.4 kg',
            'microchip' => '#985141002',
            'status' => 'Active Care Plan',
            'image' => URLROOT . '/public/images/max.jpg'
        ];

        // Sample medical history
        $medicalHistory = [
            [
                'title' => 'General Health Checkup',
                'category' => 'Routine Examination',
                'date' => '12 September 2026',
                'vet' => 'Dr. Sarah Fernando',
                'specialization' => 'General Veterinarian',
                'reason' => 'Annual routine health examination and wellness consultation.',
                'diagnosis' => 'Excellent physical condition. Clear eyes, ears, and lungs. Heart rate normal (94 bpm). Coat healthy and lustrous.',
                'treatment' => 'Flea & tick topical preventative administered during visit.',
                'followup' => 'Follow-up: 12 months'
            ],

            [
                'title' => 'Sick Visit & Dietary Consultation',
                'category' => 'Internal Medicine',
                'date' => '20 June 2026',
                'vet' => 'Dr. Nimal Silva',
                'specialization' => 'Internal Medicine',
                'reason' => 'Mild lethargy and loss of appetite for 2 days. Pet ate non-food debris during park walk.',
                'diagnosis' => 'Mild acute gastroenteritis secondary to dietary indiscretion. No abdominal obstruction detected.',
                'treatment' => 'Subcutaneous hydration fluids administered; prescribed prebiotic paste and Amoxicillin course.',
                'followup' => 'Outcome: Fully Resolved'
            ]
        ];

        // Sample vaccination records
        $vaccinations = [
            [
                'name' => 'Rabies',
                'date' => '12 October 2025',
                'nextDue' => '12 October 2026',
                'status' => 'Upcoming'
            ],
            [
                'name' => 'DHPP',
                'date' => '15 March 2026',
                'nextDue' => '15 March 2027',
                'status' => 'Active'
            ],
            [
                'name' => 'Leptospirosis',
                'date' => '15 March 2026',
                'nextDue' => '15 March 2027',
                'status' => 'Active'
            ],
            [
                'name' => 'Bordetella',
                'date' => '20 April 2026',
                'nextDue' => '20 April 2027',
                'status' => 'Active'
            ]
        ];

        // Sample prescriptions
        $prescriptions = [
            [
                'medicine' => 'Amoxicillin',
                'dosage' => '250mg',
                'date' => '20 June 2026',
                'vet' => 'Dr. Nimal Silva',
                'status' => 'Completed'
            ],
            [
                'medicine' => 'Prebiotic Paste',
                'dosage' => '5ml daily',
                'date' => '20 June 2026',
                'vet' => 'Dr. Nimal Silva',
                'status' => 'Completed'
            ]
        ];

        $data = [
            'activePage' => 'health-records',
            'pet' => $pet,
            'medicalHistory' => $medicalHistory,
            'vaccinations' => $vaccinations,
            'prescriptions' => $prescriptions
        ];

        $this->view('petowner/health-records', $data);
    }
}

