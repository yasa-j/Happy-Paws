<?php

class PetOwnerController extends Controller
{
    private $petModel;
    private $userModel;
    private $serviceModel;
    private $appointmentModel;
    private $vetScheduleModel;
    private $healthRecordModel;

    public function __construct()
    {
        // Check whether the user is logged in
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('');
        }
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
        // Load the Health Record model
        $this->healthRecordModel = $this->model('HealthRecord');
        // Load the Notification model
        $this->notificationModel = $this->model('Notification');
    }
    
    /*
    * Pet Owner Dashboard
    */

    public function dashboard()
    {
        // Logged-in owner
        $userId = (int) $_SESSION['user_id'];
        $userName = $_SESSION['user_name'] ?? 'Pet Owner';

        // Greeting based on current time
        $hour = (int) date('H');

        if ($hour >= 5 && $hour < 12) {
            $greeting = 'Good Morning,';
        } elseif ($hour >= 12 && $hour < 17) {
            $greeting = 'Good Afternoon,';
        } else {
            $greeting = 'Good Evening,';
        }

        /*
        * 1. REGISTERED PETS
        */

        // Retrieve only this owner's pets
        $pets = $this->petModel->getPetsByOwner($userId);

        $petCount = count($pets);
        $dogCount = 0;
        $catCount = 0;

        foreach ($pets as $pet) {
            $species = strtolower(trim($pet->species ?? ''));

            if ($species === 'dog') {
                $dogCount++;
            } elseif ($species === 'cat') {
                $catCount++;
            }
        }

        /*
        * 2. UPCOMING APPOINTMENTS
        */

        // Existing model returns this owner's future,
        // non-cancelled appointments in date/time order.
        $allUpcomingAppointments =
            $this->appointmentModel->getUpcomingAppointments($userId);

        // Include today and the following six calendar days.
        $today = date('Y-m-d');
        $sevenDayEnd = date('Y-m-d', strtotime('+6 days'));

        $upcomingAppointmentCount = 0;

        // Prepare seven daily totals for the bar chart.
        $appointmentDailyCounts = [];

        for ($i = 0; $i < 7; $i++) {
            $day = date('Y-m-d', strtotime("+$i days"));

            $appointmentDailyCounts[$day] = [
                'date' => $day,
                'label' => date('D', strtotime($day)),
                'count' => 0
            ];
        }

        foreach ($allUpcomingAppointments as $appointment) {
            $appointmentDate = $appointment->appointment_date;

            if (
                $appointmentDate >= $today &&
                $appointmentDate <= $sevenDayEnd
            ) {
                $upcomingAppointmentCount++;

                if (isset($appointmentDailyCounts[$appointmentDate])) {
                    $appointmentDailyCounts[$appointmentDate]['count']++;
                }
            }
        }

        // Keep the existing variable used by the dashboard.
        $upcomingAppointments = $upcomingAppointmentCount;

        /*
        * 3. VACCINATION ATTENTION
        */

        $vaccinationsDue = 0;
        $overdueVaccinations = 0;
        $vaccinationsDueSoon = 0;

        $today = date('Y-m-d');
        $vaccinationCutoff = date('Y-m-d', strtotime('+30 days'));

        foreach ($pets as $pet) {
            $petVaccinations = $this->healthRecordModel
                ->getVaccinations($pet->pet_id, $userId);

            foreach ($petVaccinations as $vaccination) {
                // Ignore records without a due date.
                if (empty($vaccination->next_due_date)) {
                    continue;
                }

                $dueDate = $vaccination->next_due_date;

                if ($dueDate < $today) {
                    // Due date has already passed.
                    $overdueVaccinations++;
                } elseif ($dueDate <= $vaccinationCutoff) {
                    // Due today or within the next 30 days.
                    $vaccinationsDueSoon++;
                }
            }
        }

        // Total records requiring vaccination attention.
        $vaccinationsDue =
            $overdueVaccinations + $vaccinationsDueSoon;

        /*
        * 4. NOTIFICATIONS
        */

        // Count actual unread notifications in this owner's inbox.
        $newNotifications =
            $this->notificationModel->getUnreadCount($userId);

        // Get this owner's non-archived notifications.
        $ownerNotifications =
            $this->notificationModel->getNotificationsByUser(
                $userId,
                false
            );

        // Count unread notifications by their actual category.
        $notificationBreakdown = [];

        foreach ($ownerNotifications as $notification) {
            if ((int) $notification->is_read !== 0) {
                continue;
            }

            $type = trim($notification->notification_type ?? '');

            if ($type === '') {
                $type = 'Other';
            }

            if (!isset($notificationBreakdown[$type])) {
                $notificationBreakdown[$type] = 0;
            }

            $notificationBreakdown[$type]++;
        }

        /*
        * SELECTED PET
        */

        $selectedPet = null;

        // Only select a pet if it belongs to this owner.
        $requestedPetId = isset($_GET['pet_id'])
            ? (int) $_GET['pet_id']
            : 0;

        if (!empty($pets)) {
            if ($requestedPetId > 0) {
                foreach ($pets as $pet) {
                    if ((int) $pet->pet_id === $requestedPetId) {
                        $selectedPet = $pet;
                        break;
                    }
                }
            }

            // Default to the first registered pet.
            if ($selectedPet === null) {
                $selectedPet = $pets[0];
            }
        }

        /*
        * SELECTED PET HEALTH INFORMATION
        */

        $petHealthSummary = null;
        $vaccinations = [];
        $medicalHistory = [];
        $nextAppointment = null;

        if ($selectedPet !== null) {
            $selectedPetId = (int) $selectedPet->pet_id;

            $petHealthSummary = $this->healthRecordModel
                ->getPetHealthSummary($selectedPetId, $userId);

            $vaccinations = $this->healthRecordModel
                ->getVaccinations($selectedPetId, $userId);

            $medicalHistory = $this->healthRecordModel
                ->getMedicalHistory($selectedPetId, $userId);

            $nextAppointment = $this->appointmentModel
                ->getNextAppointmentForPet($selectedPetId, $userId);
        }

        /*
        * SEND DATA TO DASHBOARD VIEW
        */

        $data = [
            'activePage' => 'dashboard',
            'userName' => $userName,
            'greeting' => $greeting,

            // Summary card values
            'petCount' => $petCount,
            'dogCount' => $dogCount,
            'catCount' => $catCount,

            'upcomingAppointments' => $upcomingAppointments,
            'appointmentDailyCounts' => $appointmentDailyCounts,

            'vaccinationsDue' => $vaccinationsDue,
            'overdueVaccinations' => $overdueVaccinations,
            'vaccinationsDueSoon' => $vaccinationsDueSoon,

            'newNotifications' => $newNotifications,
            'notificationBreakdown' => $notificationBreakdown,

            // Existing dashboard information
            'pets' => $pets,
            'selectedPet' => $selectedPet,
            'petHealthSummary' => $petHealthSummary,
            'vaccinations' => $vaccinations,
            'medicalHistory' => $medicalHistory,
            'nextAppointment' => $nextAppointment,
            'allUpcomingAppointments' => $allUpcomingAppointments
        ];

        $this->view('petowner/dashboard', $data);
    }


    /*
    * Pet Owner Notifications
    */
    public function notifications()
    {
        // Get the logged-in pet owner's ID
        $userId = (int) $_SESSION['user_id'];

        $userName = $_SESSION['user_name'] ?? 'Pet Owner';

        // Determine the selected tab
        $tab = $_GET['tab'] ?? 'inbox';

        if (!in_array($tab, ['inbox', 'history'], true)) {
            $tab = 'inbox';
        }

        // Allowed notification categories
        $allowedTypes = [
            'appointment',
            'vaccination',
            'reserved_product',
            'clinic_notice'
        ];

        // Validate the selected category
        $type = $_GET['type'] ?? '';

        if (!in_array($type, $allowedTypes, true)) {
            $type = '';
        }

        // Load the selected inbox or history records
        $isArchived = ($tab === 'history');

        $notifications = $this->notificationModel
            ->getNotificationsByUser(
                $userId,
                $isArchived,
                $type !== '' ? $type : null
            );

        // Retrieve notification counts
        $unreadCount = $this->notificationModel
            ->getUnreadCount($userId);

        $historyCount = $this->notificationModel
            ->getHistoryCount($userId);

        // Retrieve unread counts by category
        $categoryCounts = [];

        foreach ($allowedTypes as $notificationType) {
            $categoryCounts[$notificationType] =
                $this->notificationModel
                    ->getUnreadCountByType(
                        $userId,
                        $notificationType
                    );
        }

        // Data passed to the view
        $data = [
            'activePage' => 'notifications',
            'userName' => $userName,
            'tab' => $tab,
            'type' => $type,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'historyCount' => $historyCount,
            'categoryCounts' => $categoryCounts
        ];

        // Load the Notifications page
        $this->view('petowner/notifications', $data);

    }

    /*
    * Mark one notification as read
    */
    public function markNotificationRead()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('petowner/notifications');
            return;
        }

        $userId = (int) $_SESSION['user_id'];

        $notificationId = filter_input(
            INPUT_POST,
            'notification_id',
            FILTER_VALIDATE_INT
        );

        if ($notificationId && $notificationId > 0) {
            $this->notificationModel->markAsRead(
                $notificationId,
                $userId
            );
        }

        $this->redirect('petowner/notifications');
    }

    /*
    * Mark all inbox notifications as read
    */
    public function markAllNotificationsRead()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('petowner/notifications');
            return;
        }

        $userId = (int) $_SESSION['user_id'];

        $this->notificationModel
            ->markAllAsRead($userId);

        $this->redirect('petowner/notifications');
    }

    /*
    * Archive a notification
    */
    public function archiveNotification()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('petowner/notifications');
            return;
        }

        $userId = (int) $_SESSION['user_id'];

        $notificationId = filter_input(
            INPUT_POST,
            'notification_id',
            FILTER_VALIDATE_INT
        );

        if ($notificationId && $notificationId > 0) {
            $this->notificationModel->archiveNotification(
                $notificationId,
                $userId
            );
        }

        $this->redirect('petowner/notifications');
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
    * Pet Owner Profile
    *
    * Displays the profile information of the currently
    * logged-in pet owner.
    */
    public function profile()
    {
        // Make sure a user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in user's ID
        $userId = $_SESSION['user_id'];

        // Get the user's information from the database
        $user = $this->userModel->getUserById($userId);

        // Get all pets belonging to this user
        $pets = $this->petModel->getPetsByOwner($userId);

        // If the user record cannot be found
        if (!$user) {
            header('Location: ' . URLROOT . '/petowner/dashboard');
            exit;
        }

        // Send the database information to the view
        $data = [
            'title' => 'My Profile',
            'activePage' => 'profile',
            'user' => $user,
            'pets' => $pets
        ];

        // Load the profile page
        $this->view('petowner/profile', $data);
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
            'activePage' => 'register-pet',

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
                    'activePage' => 'book-appointment'
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
                    'activePage' => 'book-appointment'
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
            'user' => $user,
            'activePage' => 'book-appointment'
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


    /*
    |--------------------------------------------------------------------------
    | Appointment History
    |--------------------------------------------------------------------------
    |
    | Loads appointment history and statistics for the logged-in owner.
    |
    */
    public function appointmentHistory()
    {
        // Make sure the user is logged in.
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT . '/users/login');
            exit;
        }

        // Get the logged-in owner's ID.
        $userId = (int) $_SESSION['user_id'];

        // Retrieve only this owner's historical appointments.
        $dbAppointments =
            $this->appointmentModel->getAppointmentHistory($userId);

        // Retrieve this owner's appointment statistics.
        $summary =
            $this->appointmentModel->getAppointmentHistorySummary($userId);

        // Prepare appointment data for the view.
        $appointments = [];

        foreach ($dbAppointments as $appointment) {

            $appointmentDate = $appointment->appointment_date;

            $duration = (int) (
                $appointment->duration_minutes ?? 30
            );

            $startTimestamp = strtotime(
                $appointmentDate . ' ' . $appointment->appointment_time
            );

            $endTimestamp = strtotime(
                '+' . $duration . ' minutes',
                $startTimestamp
            );

            // Calculate the pet's age at the appointment date.
            $petAge = 'Age unavailable';

            if (!empty($appointment->date_of_birth)) {

                $birthDate = new DateTime(
                    $appointment->date_of_birth
                );

                $visitDate = new DateTime(
                    $appointmentDate
                );

                $age = $birthDate->diff($visitDate)->y;

                $petAge = $age . ($age === 1 ? ' year' : ' years');
            }

            // Format the appointment reference.
            $reference = 'APT-' . str_pad(
                $appointment->appointment_id,
                6,
                '0',
                STR_PAD_LEFT
            );

            $petName = $appointment->pet_name ?? 'Pet';
            $vetName = trim($appointment->vet_name ?? '');
            $serviceName = $appointment->service_name
                ?? 'Veterinary Appointment';

            $status = $appointment->status ?? 'Unknown';

            // Build searchable text for the history page.
            $searchText = implode(' ', [
                $reference,
                $petName,
                $appointment->breed ?? '',
                $appointment->species ?? '',
                $vetName,
                $serviceName,
                $status
            ]);

            $appointments[] = [
                'appointment_id' => (int) $appointment->appointment_id,
                'id' => $reference,

                'pet_id' => (int) $appointment->pet_id,
                'pet_name' => $petName,
                'species' => $appointment->species ?? 'Pet',
                'breed' => $appointment->breed ?? '',
                'pet_age' => $petAge,

                'vet' => $vetName !== ''
                    ? $vetName
                    : 'Veterinarian',

                'title' => $serviceName,

                'description' => $appointment->service_description
                    ?? ($appointment->reason ?? ''),

                'date' => date('d', strtotime($appointmentDate)),
                'month' => strtoupper(
                    date('M', strtotime($appointmentDate))
                ),
                'year' => date('Y', strtotime($appointmentDate)),

                'appointment_date' => $appointmentDate,

                'time' => date('h:i A', $startTimestamp),
                'end_time' => date('h:i A', $endTimestamp),

                'duration' => $duration,
                'status' => $status,

                'search_text' => $searchText
            ];
        }

        // Prepare summary values.
        $totalAppointments = (int) (
            $summary->total_appointments ?? 0
        );

        $completedAppointments = (int) (
            $summary->completed_appointments ?? 0
        );

        $cancelledAppointments = (int) (
            $summary->cancelled_appointments ?? 0
        );

        $completedRate = $totalAppointments > 0
            ? round(
                ($completedAppointments / $totalAppointments) * 100,
                1
            )
            : 0;

        $cancelledRate = $totalAppointments > 0
            ? round(
                ($cancelledAppointments / $totalAppointments) * 100,
                1
            )
            : 0;

        // Get the owner's pets for the filter dropdown.
        $pets = $this->petModel->getPetsByOwner($userId);

        $data = [
            'pageTitle' => 'Appointment History',
            'activePage' => 'appointments',
            'activeSubPage' => 'history',

            'appointments' => $appointments,
            'pets' => $pets,

            'totalAppointments' => $totalAppointments,
            'completedAppointments' => $completedAppointments,
            'cancelledAppointments' => $cancelledAppointments,

            'completedRate' => $completedRate,
            'cancelledRate' => $cancelledRate
        ];

        $this->view('petowner/appointment-history', $data);
    }

    public function healthRecords()
    {
        // Make sure the user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URLROOT);
            exit;
        }

        $userId = $_SESSION['user_id'];

        /*
        |--------------------------------------------------------------------------
        | Get Owner's Pets
        |--------------------------------------------------------------------------
        */

        $pets = $this->petModel->getPetsByOwner($userId);


        /*
        |--------------------------------------------------------------------------
        | Select Pet
        |--------------------------------------------------------------------------
        |
        | If a pet_id is provided in the URL, use it.
        | Otherwise, show the owner's first registered pet.
        |
        */

        $selectedPetId = isset($_GET['pet_id'])
            ? (int)$_GET['pet_id']
            : null;


        if ($selectedPetId !== null) {

            $selectedPet = $this->healthRecordModel
                ->getPetHealthSummary($selectedPetId, $userId);

            // Prevent access to another owner's pet
            if (!$selectedPet) {
                $selectedPetId = null;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | If no valid pet was selected
        |--------------------------------------------------------------------------
        */

        if ($selectedPetId === null && !empty($pets)) {

            $selectedPetId = $pets[0]->pet_id;

            $selectedPet = $this->healthRecordModel
                ->getPetHealthSummary($selectedPetId, $userId);
        }


        /*
        |--------------------------------------------------------------------------
        | No Pets
        |--------------------------------------------------------------------------
        */

        if (!$selectedPet) {

            $data = [
                'activePage' => 'health-records',
                'pets' => $pets,
                'pet' => null,
                'medicalHistory' => [],
                'vaccinations' => [],
                'prescriptions' => [],
                'lastVisit' => null,
                'vaccinationSummary' => null,
                'nextVaccination' => null
            ];

            $this->view('petowner/health-records', $data);

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Get Real Health Records
        |--------------------------------------------------------------------------
        */

        $medicalHistory = $this->healthRecordModel
            ->getMedicalHistory($selectedPetId, $userId);

        $vaccinations = $this->healthRecordModel
            ->getVaccinations($selectedPetId, $userId);

        $prescriptions = $this->healthRecordModel
            ->getPrescriptions($selectedPetId, $userId);

        $lastVisit = $this->healthRecordModel
            ->getLastMedicalVisit($selectedPetId, $userId);

        $vaccinationSummary = $this->healthRecordModel
            ->getVaccinationSummary($selectedPetId, $userId);

        $nextVaccination = $this->healthRecordModel
            ->getNextVaccination($selectedPetId, $userId);


        /*
        |--------------------------------------------------------------------------
        | Send Data To View
        |--------------------------------------------------------------------------
        */

        $data = [
            'activePage' => 'health-records',

            'pets' => $pets,

            'pet' => $selectedPet,

            'medicalHistory' => $medicalHistory,

            'vaccinations' => $vaccinations,

            'prescriptions' => $prescriptions,

            'lastVisit' => $lastVisit,

            'vaccinationSummary' => $vaccinationSummary,

            'nextVaccination' => $nextVaccination
        ];


        $this->view('petowner/health-records', $data);
    }


    /*
    * Add these methods inside your existing PetownerController class.
    * Do not create a second class with the same name.
    */

    public function store()
    {
    
       
        if (
            !isset($_SESSION['user_id']) ||
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }


        $productModel = $this->model('Product');
        $cartModel = $this->model('Cart');

        $search = trim($_GET['search'] ?? '');
        $categoryId = trim($_GET['category'] ?? '');
        $sort = $_GET['sort'] ?? 'recommended';

        if (
            $categoryId !== '' &&
            !ctype_digit($categoryId)
        ) {
            $categoryId = '';
        }

        $data = [
            'products' => $productModel->getProducts(
                $search,
                $categoryId,
                $sort
            ),
            'categories' => $productModel->getCategories(),
            'search' => $search,
            'selectedCategory' => $categoryId,
            'sort' => $sort,
            'cartCount' => $cartModel->getItemCount(
                (int)$_SESSION['user_id']
            ),
            'message' => $_SESSION['product_store_message'] ?? '',
            'activePage' => 'store'
        ];

        unset($_SESSION['product_store_message']);

        $this->view('petowner/browse-products', $data);
    }

    public function addProductToCart()
    {
        
        if (
            !isset($_SESSION['user_id']) ||
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }


        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URLROOT . '/petowner/store');
            exit;
        }

        $productId = filter_input(
            INPUT_POST,
            'product_id',
            FILTER_VALIDATE_INT
        );

        $cartModel = $this->model('Cart');

        $success = $productId && $productId > 0
            ? $cartModel->addItem(
                (int)$_SESSION['user_id'],
                $productId,
                1
            )
            : false;

        $_SESSION['product_store_message'] = $success
            ? 'Product added to your cart.'
            : 'Unable to add this product. Please check its availability.';

        header('Location: ' . URLROOT . '/petowner/store');
        exit;
    }

    // Display the My Cart page.
    public function cart()
    {
        $userId = (int)$_SESSION['user_id'];

        $cartModel = $this->model('Cart');

        $cartItems = $cartModel->getCartItems($userId);

        $data = [
            'title' => 'My Cart',
            'activePage' => 'cart',
            'cartItems' => $cartItems,
            'cartCount' => $cartModel->getItemCount($userId)
        ];

        $this->view('petowner/my-cart', $data);
    }


    // Update a cart item's quantity.
    public function updateCartQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('petowner/cart');
            return;
        }

        $userId = (int)$_SESSION['user_id'];
        $cartItemId = filter_input(
            INPUT_POST,
            'cart_item_id',
            FILTER_VALIDATE_INT
        );
        $quantity = filter_input(
            INPUT_POST,
            'quantity',
            FILTER_VALIDATE_INT
        );

        $cartModel = $this->model('Cart');

        if (
            $cartItemId && $cartItemId > 0 &&
            $quantity && $quantity > 0
        ) {
            $success = $cartModel->updateQuantity(
                $userId,
                $cartItemId,
                $quantity
            );

            $_SESSION['cart_message'] = $success
                ? 'Cart quantity updated.'
                : 'Unable to update quantity. Please check product availability and stock.';
        } else {
            $_SESSION['cart_message'] = 'Please enter a valid quantity.';
        }

        $this->redirect('petowner/cart');
    }


    // Remove a cart item.
    public function removeCartItem()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('petowner/cart');
            return;
        }

        $userId = (int)$_SESSION['user_id'];

        $cartItemId = filter_input(
            INPUT_POST,
            'cart_item_id',
            FILTER_VALIDATE_INT
        );

        $cartModel = $this->model('Cart');

        if ($cartItemId && $cartItemId > 0) {
            $success = $cartModel->removeItem(
                $userId,
                $cartItemId
            );

            $_SESSION['cart_message'] = $success
                ? 'Product removed from your cart.'
                : 'Unable to remove this product.';
        }

        $this->redirect('petowner/cart');
    }


    /*
     * =========================================================
     * RESERVED PRODUCTS
     * =========================================================
     */

    // Display reservations belonging to the logged-in pet owner.
    public function reserved()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }

        $userId = $_SESSION['user_id'];

        $reservationModel = $this->model('Reservation');
        $cartModel = $this->model('Cart');

        // Expire old reservations and restore their stock.
        $reservationModel->expireReservations();

        $reservations = $reservationModel->getReservationsByUser($userId);
        $summary = $reservationModel->getReservationSummary($userId);
        $cartCount = $cartModel->getItemCount($userId);

        $message = '';

        if (isset($_SESSION['reservation_message'])) {
            $message = $_SESSION['reservation_message'];
            unset($_SESSION['reservation_message']);
        }

        $this->view('petowner/reserved-products', [
            'activePage' => 'reserved',
            'reservations' => $reservations,
            'summary' => $summary,
            'cartCount' => $cartCount,
            'message' => $message
        ]);
    }

    // Display completed purchases for the logged-in pet owner.
    public function purchased()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }

        $userId = (int)$_SESSION['user_id'];

        $reservationModel = $this->model('Reservation');
        $cartModel = $this->model('Cart');

        $search = trim($_GET['search'] ?? '');
        $period = $_GET['period'] ?? 'all';
        $sort = $_GET['sort'] ?? 'newest';

        // Accept only supported filter values.
        $allowedPeriods = ['all', 'month', '3months', '6months', 'year'];
        $allowedSorts = ['newest', 'oldest', 'total_high', 'total_low'];

        if (!in_array($period, $allowedPeriods, true)) {
            $period = 'all';
        }

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'newest';
        }

        $purchases = $reservationModel->getPurchaseHistoryByUser(
            $userId,
            $search,
            $period,
            $sort
        );

        $summary = $reservationModel->getPurchaseHistorySummary($userId);
        $cartCount = $cartModel->getItemCount($userId);

        $this->view('petowner/purchase-history', [
            'activePage' => 'purchased',
            'purchases' => $purchases,
            'summary' => $summary,
            'cartCount' => $cartCount,
            'search' => $search,
            'period' => $period,
            'sort' => $sort
        ]);
    }

    // Create a reservation from the Browse Products page.
    public function reserveProduct()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URLROOT . '/petowner/store');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $productId = isset($_POST['product_id'])
            ? (int)$_POST['product_id']
            : 0;
        $quantity = isset($_POST['quantity'])
            ? (int)$_POST['quantity']
            : 1;

        if ($productId <= 0 || $quantity <= 0) {
            $_SESSION['reservation_message'] =
                'Please select a valid product and quantity.';
            header('Location: ' . URLROOT . '/petowner/store');
            exit;
        }

        $reservationModel = $this->model('Reservation');

        $reservationId = $reservationModel->createReservation(
            $userId,
            $productId,
            $quantity
        );

        if ($reservationId !== false) {
            $_SESSION['reservation_message'] =
                'Your product has been reserved successfully. '
                . 'Please collect it within 24 hours.';
            header('Location: ' . URLROOT . '/petowner/reserved');
            exit;
        }

        $_SESSION['reservation_message'] =
            'Reservation failed. Please check the available stock and try again.';

        header('Location: ' . URLROOT . '/petowner/store');
        exit;
    }

    // Cancel an active reservation belonging to the logged-in owner.
    public function cancelReservation()
    {
        if (
            !isset($_SESSION['user_role']) ||
            $_SESSION['user_role'] !== 'pet_owner'
        ) {
            header('Location: ' . URLROOT);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . URLROOT . '/petowner/reserved');
            exit;
        }

        $userId = (int)$_SESSION['user_id'];
        $orderId = isset($_POST['order_id'])
            ? (int)$_POST['order_id']
            : 0;

        if ($orderId <= 0) {
            $_SESSION['reservation_message'] =
                'Invalid reservation selected.';
            header('Location: ' . URLROOT . '/petowner/reserved');
            exit;
        }

        $reservationModel = $this->model('Reservation');

        if ($reservationModel->cancelReservation($orderId, $userId)) {
            $_SESSION['reservation_message'] =
                'Your reservation has been cancelled successfully.';
        } else {
            $_SESSION['reservation_message'] =
                'This reservation cannot be cancelled. It may already be '
                . 'cancelled, expired, collected, or unavailable.';
        }

        header('Location: ' . URLROOT . '/petowner/reserved');
        exit;
    }

}

