<?php

/*
|--------------------------------------------------------------------------
| Start Session
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


class VetController extends Controller
{
private $vaccinationModel;
private $appointmentModel;

public function __construct()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
     // Require login
    if (
        empty($_SESSION['staff_logged_in']) ||
        empty($_SESSION['staff_user_id'])
    ) {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=staffauth/login'
        );
        exit;
    }

    // Only veterinarians can access Vet pages
    if (($_SESSION['staff_role'] ?? '') !== 'veterinarian') {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=staff'
        );
        exit;
    }

    $this->vaccinationModel = $this->model('Vaccination');
    $this->appointmentModel = $this->model('Appointment');
}
    /*
    |--------------------------------------------------------------------------
    | Vet Dashboard
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $data = [
            'title' => 'Vet Dashboard'
        ];

        $this->view(
            'vet/dashboard',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Schedule
    |--------------------------------------------------------------------------
    */

    public function schedule()
    {
        $data = [
            'title' => 'Schedule'
        ];

        $this->view(
            'vet/schedule',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Health Records
    |--------------------------------------------------------------------------
    */

   public function healthRecords()
{
    $vetId = $_SESSION['staff_user_id'] ?? null;

    if (!$vetId) {
        $this->redirect('staffauth/login');
        return;
    }

    $todayAppointments =
        $this->appointmentModel->getTodayAppointments($vetId);

    $upcomingAppointments =
        $this->appointmentModel->getUpcomingAppointments($vetId);

    $data = [
        'title' => 'Health Records',
        'todayAppointments' => $todayAppointments,
        'upcomingAppointments' => $upcomingAppointments
    ];

    $this->view('vet/health-records', $data);
}


    /*
    |--------------------------------------------------------------------------
    | Medical Record Details
    |--------------------------------------------------------------------------
    */

    public function healthRecordDetails($petId)
    {

     // Get vaccinations from database
$vaccinationsFromDatabase =
    $this->vaccinationModel->getByPetId($petId);

$vaccinations = [];

foreach ($vaccinationsFromDatabase as $vaccination) {

    $vaccinations[] = [

        'id' => $vaccination->vaccination_id,

        'date' => !empty($vaccination->administered_date)
            ? date(
                'M d, Y',
                strtotime($vaccination->administered_date)
            )
            : '--',

        'vaccine' => $vaccination->vaccine_name,

        'status' => $vaccination->status,

        'next_due' => !empty($vaccination->next_due_date)
            ? date(
                'M d, Y',
                strtotime($vaccination->next_due_date)
            )
            : '--',

        'status_class' =>
            strtolower($vaccination->status) === 'completed'
                ? 'completed'
                : 'due'
    ];
}


        /*
        |--------------------------------------------------------------------------
        | Page Data
        |--------------------------------------------------------------------------
        */

        $data = [

            'title' => 'Luna - Medical Record',


            /*
            |--------------------------------------------------------------------------
            | Pet
            |--------------------------------------------------------------------------
            */

            'pet' => [

                'id' => $petId,

                'name' => 'Luna',

                'type' => 'Cat',

                'breed' => 'Persian Cat',

                'gender' => 'Female',

                'age' => '3 Years',

                'weight' => '4.2 kg',

                'owner' => 'Emily Tan',

                'image' => 'cat'

            ],


            /*
            |--------------------------------------------------------------------------
            | Vaccinations
            |--------------------------------------------------------------------------
            */

            'vaccinations' =>
                $vaccinations,


            /*
            |--------------------------------------------------------------------------
            | Allergies
            |--------------------------------------------------------------------------
            */

            'allergies' => [

                'Penicillin',

                'Certain Pollens',

                'Flea Saliva (Mild)'

            ],


            /*
            |--------------------------------------------------------------------------
            | Medications
            |--------------------------------------------------------------------------
            */

            'medications' => [

                [
                    'name' => 'Amoxicillin Drops',

                    'dose' => '0.5ml',

                    'frequency' =>
                        'Twice daily (AM/PM)',

                    'duration' =>
                        '14 days (Ends Nov 5)',

                    'status' => 'ONGOING'
                ],


                [
                    'name' => 'Monthly Preventative',

                    'dose' => '1 Tube Topical',

                    'frequency' =>
                        '1st of every month',

                    'duration' => '',

                    'status' => 'ONGOING'
                ]

            ],


            /*
            |--------------------------------------------------------------------------
            | Treatments
            |--------------------------------------------------------------------------
            */

            'treatments' => [

                [
                    'title' =>
                        'Routine Dental Cleaning',

                    'description' =>
                        'Scale and polish under general anesthesia. Two minor extractions (premolars).',

                    'doctor' =>
                        'Dr. Sarah Jenkins',

                    'date' =>
                        'Sep 15, 2023'
                ],


                [
                    'title' =>
                        'Minor Wound Care',

                    'description' =>
                        'Superficial scratch on left forelimb. Cleaned and topical antibiotic applied.',

                    'doctor' =>
                        'Dr. Michael Chen',

                    'date' =>
                        'May 02, 2023'
                ]

            ]

        ];


        $this->view(
            'vet/health-record-details',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ADD VACCINATION
    |--------------------------------------------------------------------------
    */

    public function addVaccination($petId = 1)
    {

        $data = [

            'title' =>
                'Add Vaccination Record',


            'pet' => [

                 'id' => $petId,

                'name' => 'Luna',

                'type' => 'Cat',

                'breed' => 'Persian Cat',

                'gender' => 'Female',

                'owner' => 'Emily Tan',

                'age' => '3 Years',

                'weight' => '4.2 kg'

            ]

        ];


        $this->view(
            'vet/add-vaccination',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SAVE NEW VACCINATION
    |--------------------------------------------------------------------------
    */

   public function saveVaccination()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=vet/healthRecords'
        );
        exit;
    }

    // Make sure a veterinarian is logged in
    if (
        !isset($_SESSION['staff_logged_in']) ||
        !isset($_SESSION['staff_role']) ||
        $_SESSION['staff_role'] !== 'veterinarian'
    ) {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=staffauth/login'
        );
        exit;
    }

    // Pet selected from the form
    $petId = (int)($_POST['pet_id'] ?? 0);

    // Logged-in veterinarian
    $vetId = (int)($_SESSION['staff_user_id'] ?? 0);

    // Form values
    $vaccineName = trim($_POST['vaccine_name'] ?? '');
    $manufacturer = trim($_POST['manufacturer'] ?? '');
    $vaccinationType = trim($_POST['vaccination_type'] ?? '');
    $dateGiven = $_POST['date_given'] ?? '';
    $nextDueDate = $_POST['next_due_date'] ?? '';
    $status = trim($_POST['status'] ?? '');
    $notes = trim($_POST['notes'] ?? '');

    // Your current form does not have a batch number field
    $batchNumber = '';

    // Validate required fields
    if (
        $petId <= 0 ||
        $vetId <= 0 ||
        $vaccineName === '' ||
        $dateGiven === '' ||
        $vaccinationType === '' ||
        $status === ''
    ) {
        die('Please fill in all required vaccination fields.');
    }

    // Prepare data for database
    $vaccinationData = [
        'pet_id' => $petId,
        'vet_id' => $vetId,
        'vaccine_name' => $vaccineName,
        'manufacturer' => $manufacturer,
        'vaccination_type' => $vaccinationType,
        'administered_date' => $dateGiven,
        'next_due_date' => $nextDueDate !== ''
            ? $nextDueDate
            : null,
        'batch_number' => $batchNumber,
        'status' => $status,
        'notes' => $notes
    ];

    // INSERT into vaccinations table
    $vaccinationId =
        $this->vaccinationModel->create($vaccinationData);

    if (!$vaccinationId) {
        die('Failed to save vaccination to the database.');
    }

    // Go back to this pet's medical record
    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=vet/healthRecordDetails/' .
        $petId
    );

    exit;
}

    /*
    |--------------------------------------------------------------------------
    | VACCINATION DETAILS
    |--------------------------------------------------------------------------
    */

   public function vaccinationDetails($vaccinationId)
{
    $vaccination = $this->vaccinationModel->getById($vaccinationId);

    if (!$vaccination) {
        die('Vaccination record not found.');
    }

    $data = [
        'title' => 'Vaccination Details',

        'vaccination' => [
            'id' => $vaccination->vaccination_id,
            'vaccine' => $vaccination->vaccine_name,
            'type' => $vaccination->vaccination_type ?? '',
            'status' => $vaccination->status,

            'date_given' => !empty($vaccination->administered_date)
                ? date('M d, Y', strtotime($vaccination->administered_date))
                : '--',

            'next_due' => !empty($vaccination->next_due_date)
                ? date('M d, Y', strtotime($vaccination->next_due_date))
                : '--',

            'manufacturer' => $vaccination->manufacturer ?? '',
            'lot_number' => $vaccination->batch_number ?? '',

            'administered_by' => $_SESSION['staff_name'] ?? 'Veterinarian',

            'notes' => $vaccination->notes ?? ''
        ],

        'pet' => [
            'id' => $vaccination->pet_id,
            'name' => 'Luna',
            'type' => 'Cat',
            'breed' => 'Persian Cat',
            'gender' => 'Female',
            'owner' => 'Emily Tan',
            'age' => '3 Years',
            'weight' => '4.2 kg'
        ]
    ];

    $this->view('vet/vaccination-details', $data);
}


    /*
    |--------------------------------------------------------------------------
    | EDIT VACCINATION
    |--------------------------------------------------------------------------
    */

   public function editVaccination($vaccinationId)
{
    $vaccination = $this->vaccinationModel->getById($vaccinationId);

    if (!$vaccination) {
        die('Vaccination record not found.');
    }

    $data = [
        'title' => 'Edit Vaccination',

        'vaccination' => [
            'id' => $vaccination->vaccination_id,
            'vaccine' => $vaccination->vaccine_name,
            'manufacturer' => $vaccination->manufacturer ?? '',
            'date_given' => $vaccination->administered_date,
            'next_due' => $vaccination->next_due_date,
            'type' => $vaccination->vaccination_type ?? '',
            'status' => $vaccination->status,
            'lot_number' => $vaccination->batch_number ?? '',
            'notes' => $vaccination->notes ?? ''
        ],

        'pet' => [
            'id' => $vaccination->pet_id,
            'name' => 'Luna',
            'type' => 'Cat',
            'breed' => 'Persian Cat',
            'gender' => 'Female',
            'owner' => 'Emily Tan',
            'age' => '3 Years',
            'weight' => '4.2 kg'
        ]
    ];

    $this->view('vet/edit-vaccination', $data);
}


    /*
    |--------------------------------------------------------------------------
    | UPDATE VACCINATION
    |--------------------------------------------------------------------------
    | IMPORTANT:
    | There is ONLY ONE updateVaccination() method.
    |--------------------------------------------------------------------------
    */

    public function updateVaccination()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=vet/healthRecords'
        );
        exit;
    }

    // Make sure veterinarian is logged in
    if (
        !isset($_SESSION['staff_logged_in']) ||
        !isset($_SESSION['staff_role']) ||
        $_SESSION['staff_role'] !== 'veterinarian'
    ) {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=staffauth/login'
        );
        exit;
    }

    $vaccinationId = (int)($_POST['vaccination_id'] ?? 0);

    if ($vaccinationId <= 0) {
        die('Invalid vaccination ID.');
    }

    $data = [
        'vaccination_id' => $vaccinationId,
        'vaccine_name' => trim($_POST['vaccine'] ?? ''),
        'manufacturer' => trim($_POST['manufacturer'] ?? ''),
        'vaccination_type' => trim($_POST['type'] ?? ''),
        'administered_date' => $_POST['date_given'] ?? '',
        'next_due_date' => $_POST['next_due'] ?? '',
        'batch_number' => trim($_POST['lot_number'] ?? ''),
        'status' => trim($_POST['status'] ?? ''),
        'notes' => trim($_POST['notes'] ?? '')
    ];

    if (
        $data['vaccine_name'] === '' ||
        $data['administered_date'] === '' ||
        $data['next_due_date'] === '' ||
        $data['vaccination_type'] === '' ||
        $data['status'] === ''
    ) {
        die('Please complete all required fields.');
    }

    // UPDATE database
    $updated = $this->vaccinationModel->update($data);

    if (!$updated) {
        die('Failed to update vaccination.');
    }

    // Go back to vaccination details
    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=vet/vaccinationDetails/' .
        $vaccinationId
    );

    exit;
}


    /*
    |--------------------------------------------------------------------------
    | DELETE VACCINATION
    |--------------------------------------------------------------------------
    */

   public function deleteVaccination($vaccinationId)
{
    // Make sure the user is logged in as a veterinarian
    if (
        !isset($_SESSION['staff_logged_in']) ||
        $_SESSION['staff_logged_in'] !== true ||
        ($_SESSION['staff_role'] ?? '') !== 'veterinarian'
    ) {
        $this->redirect('staffauth/login');
        return;
    }

    // Delete the vaccination from the database
    $deleted = $this->vaccinationModel->delete($vaccinationId);

    if (!$deleted) {
        die('Failed to delete vaccination.');
    }

    // Go back to the health record
    $this->redirect('vet/healthRecordDetails/1');
}


    /*
    |--------------------------------------------------------------------------
    | Reviews
    |--------------------------------------------------------------------------
    */

    public function reviews()
    {
        $data = [
            'title' => 'Reviews & Ratings'
        ];

        $this->view(
            'vet/reviews',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    public function notifications()
    {
        $data = [
            'title' => 'Notifications'
        ];

        $this->view(
            'vet/notifications',
            $data
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    public function profile()
    {
        $data = [
            'title' => 'Profile'
        ];

        $this->view(
            'vet/profile',
            $data
        );
    }
    public function logout()
{
    // Destroy the current session
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    // Go back to the staff login page
    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=staffAuth/login'
    );

    exit;
}

public function changePassword()
{
    $data = [
        'title' => 'Change Password'
    ];

    $this->view('vet/change-password', $data);
}
public function editProfile()
{
    $data = [
        'title' => 'Edit Profile',

        'profile' => [
    'full_name' => 'Michael Vance',
    'email' => 'vet@happypaws.lk',
    'phone' => '+94 71 987 6543',
    'date_of_birth' => '1985-04-12',
    'gender' => 'Male',

    'license_number' => 'VET-8924-CA',
    'license_expiry' => '2026-12-31',
    'specialization' => 'Small Animal Surgery',
    'experience' => '12',
    'position' => 'Lead Veterinarian',
    'clinic' => 'Happy Paws Main Clinic',

    'degree' => 'Doctor of Veterinary Medicine (DVM)',
    'institution' => 'University of Colombo',

    'bio' => 'Michael Vance is a dedicated veterinarian with over 12 years of experience specializing in small animal surgery. A graduate of the University of Colombo, he provides compassionate care for pets and supports their health and well-being.'
]
    ];

    $this->view('vet/edit-profile', $data);
}

public function updateProfile()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header(
            'Location: ' .
            URLROOT .
            '/index.php?url=vet/editProfile'
        );
        exit;
    }

    /*
     * Get profile information from the form
     */
    $profile = [

        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'date_of_birth' => $_POST['date_of_birth'] ?? '',
        'gender' => $_POST['gender'] ?? '',

        'license_number' => trim($_POST['license_number'] ?? ''),
        'license_expiry' => $_POST['license_expiry'] ?? '',
        'specialization' => trim($_POST['specialization'] ?? ''),
        'experience' => trim($_POST['experience'] ?? ''),
        'position' => trim($_POST['position'] ?? ''),
        'clinic' => trim($_POST['clinic'] ?? ''),

        'degree' => trim($_POST['degree'] ?? ''),
        'institution' => trim($_POST['institution'] ?? ''),

        'bio' => trim($_POST['bio'] ?? '')
    ];


    /*
     * Save profile temporarily in the session.
     * Later this can be replaced with a database UPDATE.
     */
    $_SESSION['vet_profile'] = $profile;


    /*
     * Certificate upload
     */
    if (
        isset($_FILES['certificate']) &&
        $_FILES['certificate']['error'] === UPLOAD_ERR_OK
    ) {

        $uploadDirectory =
            dirname(APPROOT) .
            '/public/uploads/certificates/';


        /*
         * Create upload folder if it doesn't exist
         */
        if (!is_dir($uploadDirectory)) {

            mkdir(
                $uploadDirectory,
                0777,
                true
            );
        }


        $originalName =
            basename(
                $_FILES['certificate']['name']
            );


        $extension =
            strtolower(
                pathinfo(
                    $originalName,
                    PATHINFO_EXTENSION
                )
            );


        /*
         * Allowed certificate file types
         */
        $allowedExtensions = [
            'pdf',
            'jpg',
            'jpeg',
            'png'
        ];


        if (
            in_array(
                $extension,
                $allowedExtensions
            )
        ) {

            $newFileName =
                'certificate_' .
                time() .
                '_' .
                preg_replace(
                    '/[^A-Za-z0-9._-]/',
                    '_',
                    $originalName
                );


            move_uploaded_file(
                $_FILES['certificate']['tmp_name'],
                $uploadDirectory .
                $newFileName
            );


            /*
             * Store original filename in session
             */
            $_SESSION['certificate_name'] =
                $originalName;
        }
    }


    /*
     * Tell the page that the profile was saved
     */
    $_SESSION['profile_saved'] = true;


    /*
     * Return to Edit Profile page
     */
    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=vet/editProfile'
    );

    exit;
}
}