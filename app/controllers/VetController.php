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
private $petModel;
private $medicalRecordModel;


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
    $this->petModel = $this->model('Pet');
    $this->medicalRecordModel = $this->model('MedicalRecord');
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
        // The vet who is logged in (set in StaffAuth login)
        $vetId = (int)($_SESSION['staff_user_id'] ?? 0);

        // Only this vet's appointments come back from the database
        $rows = $this->appointmentModel
                     ->getAppointmentsForVetSchedule($vetId);

        // Group by date: ['2026-10-28' => [appointment, appointment], ...]
        $appointmentsByDate = [];

        foreach ($rows as $row) {

            $appointmentsByDate[$row->appointment_date][] = [
                'id'       => (int)$row->appointment_id,
                'time'     => substr($row->appointment_time, 0, 5),
                'duration' => ($row->duration_minutes ?? 30) . ' min',
                'pet'      => $row->pet_name,
                'owner'    => trim(
                    $row->owner_first_name . ' ' . $row->owner_last_name
                ),
                'purpose'  => !empty($row->service_name)
                    ? $row->service_name
                    : $row->reason,
                'status'   => $row->status
            ];
        }

        $data = [
            'title' => 'Schedule',
            'appointmentsByDate' => $appointmentsByDate
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
    $this->appointmentModel->getUpcomingAppointmentsForVet($vetId);

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
        $pet = $this->petModel->getPetByIdForVet($petId);

if (!$pet) {
    die('Pet not found.');
}
// Retrieve saved medical records for this pet
$medicalRecords = $this->medicalRecordModel->getByPetId($petId);

// Retrieve medicines saved for this pet
$medicines = $this->medicalRecordModel->getMedicinesByPetId($petId);

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

    'id' => $pet->pet_id,

    'name' => $pet->name,

    'type' => $pet->species,

    'breed' => $pet->breed,

    'gender' => $pet->gender,

    'age' => $pet->date_of_birth,

    'weight' => $pet->weight_kg . ' kg',

    'owner' => trim(
        $pet->owner_first_name . ' ' . $pet->owner_last_name
    ),

    'image' => strtolower($pet->species)

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
'medicines' => $medicines,


            /*
            |--------------------------------------------------------------------------
            | Treatments
            |--------------------------------------------------------------------------
            */

            'medicalRecords' => $medicalRecords,
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
public function addMedicalRecord($petId = null)
{
    if (
        empty($_SESSION['staff_logged_in']) ||
        empty($_SESSION['staff_user_id']) ||
        ($_SESSION['staff_role'] ?? '') !== 'veterinarian'
    ) {
        $this->redirect('staffauth/login');
        return;
    }

    $petId = (int)$petId;

    if ($petId <= 0) {
        die('Invalid pet ID.');
    }

    $petModel = $this->model('Pet');

    $pet = $petModel->getPetByIdForVet($petId);

    if (!$pet) {
        die('Pet not found.');
    }

    $data = [
        'title' => 'Add Medical Record',

        'pet' => [
            'id' => $pet->pet_id,
            'name' => $pet->name,
            'type' => $pet->species ?? '',
            'breed' => $pet->breed ?? '',
            'owner' => $pet->owner_name ?? ''
        ],

        'appointments' => [],
        'error' => ''
    ];

    $this->view('vet/add-medical-record', $data);
}
public function saveMedicalRecord()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $this->redirect('vet/healthRecords');
        return;
    }

    if (
        empty($_SESSION['staff_logged_in']) ||
        empty($_SESSION['staff_user_id']) ||
        ($_SESSION['staff_role'] ?? '') !== 'veterinarian'
    ) {
        $this->redirect('staffauth/login');
        return;
    }
    

   $petId = (int)($_POST['pet_id'] ?? 0);
$vetId = (int)$_SESSION['staff_user_id'];

// No appointment is selected manually
$appointmentId = null;

$visitDate = trim($_POST['visit_date'] ?? '');
$diagnosis = trim($_POST['diagnosis'] ?? '');
$treatment = trim($_POST['treatment'] ?? '');
$prescription = trim($_POST['prescription'] ?? '');
$followUpDate = trim($_POST['follow_up_date'] ?? '');
$notes = trim($_POST['notes'] ?? '');
$status = trim($_POST['status'] ?? 'Completed');

    if (
        $petId <= 0 ||
        $vetId <= 0 ||
        $visitDate === '' ||
        $diagnosis === '' ||
        $treatment === ''
    ) {
        die('Please fill in all required fields.');
    }

    $visitDateObject = DateTime::createFromFormat(
        '!Y-m-d',
        $visitDate
    );

    if (
        !$visitDateObject ||
        $visitDateObject->format('Y-m-d') !== $visitDate
    ) {
        die('Invalid visit date.');
    }

    if ($visitDate > date('Y-m-d')) {
        die('The visit date cannot be in the future.');
    }

    if ($followUpDate !== '') {
        $followUpObject = DateTime::createFromFormat(
            '!Y-m-d',
            $followUpDate
        );

        if (
            !$followUpObject ||
            $followUpObject->format('Y-m-d') !== $followUpDate
        ) {
            die('Invalid follow-up date.');
        }

        if ($followUpDate < $visitDate) {
            die('The follow-up date cannot be earlier than the visit date.');
        }
    }

    $petModel = $this->model('Pet');

    $pet = $petModel->getPetByIdForVet($petId);

    if (!$pet) {
        die('The selected pet was not found.');
    }

    $recordData = [
    'pet_id' => $petId,
    'vet_id' => $vetId,

    'appointment_id' => $appointmentId,
    'visit_date' => $visitDate,
    'diagnosis' => $diagnosis,
    'treatment' => $treatment,

    'prescription' => $prescription !== ''
        ? $prescription
        : null,

    'follow_up_date' => $followUpDate !== ''
        ? $followUpDate
        : null,

    'notes' => $notes !== ''
        ? $notes
        : null,

    'medicine_name' => trim($_POST['medicine_name'] ?? ''),

    'medicine_dose' => trim($_POST['medicine_dose'] ?? ''),

    'medicine_frequency' => trim($_POST['medicine_frequency'] ?? ''),

    'medicine_duration' => trim($_POST['medicine_duration'] ?? ''),
    'status' => $status
];

    $saved = $this->medicalRecordModel->create($recordData);

    if (!$saved) {
        die('The medical record could not be saved.');
    }

    header(
        'Location: ' .
        URLROOT .
        '/index.php?url=vet/healthRecordDetails/' .
        $petId
    );

    exit;
}
public function treatmentDetails($recordId)
{
    $recordId = (int)$recordId;

    if ($recordId <= 0) {
        die('Invalid medical record ID.');
    }

    $record = $this->medicalRecordModel->getById($recordId);

    if (!$record) {
        die('Medical record not found.');
    }

    $petObject = $this->petModel->getPetByIdForVet($record->pet_id);

    if (!$petObject) {
        die('Pet not found.');
    }

    $pet = [
        'id' => $petObject->pet_id,
        'name' => $petObject->name,
        'breed' => $petObject->breed,
        'owner' => trim(
            ($petObject->owner_first_name ?? '') . ' ' .
            ($petObject->owner_last_name ?? '')
        )
    ];

    $data = [
        'title' => 'Medical Record Details',
        'record' => $record,
        'pet' => $pet
    ];

    $this->view('vet/treatment-details', $data);
}
public function editMedicalRecord($recordId = null)
{
    $recordId = (int)$recordId;

    if ($recordId <= 0) {
        die('Invalid medical record ID.');
    }

    $record = $this->medicalRecordModel->getById($recordId);

    if (!$record) {
        die('Medical record not found.');
    }

    $petObject = $this->petModel->getPetByIdForVet($record->pet_id);

    if (!$petObject) {
        die('Pet not found.');
    }

    $pet = [
        'id' => $petObject->pet_id,
        'name' => $petObject->name,
        'breed' => $petObject->breed,
        'owner' => trim(
            ($petObject->owner_first_name ?? '') . ' ' .
            ($petObject->owner_last_name ?? '')
        )
    ];

    $this->view('vet/edit-medical-record', [
        'title' => 'Edit Medical Record',
        'record' => $record,
        'pet' => $pet,
        'error' => ''
    ]);
}

public function updateMedicalRecord($recordId = null)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die('Invalid request method.');
    }

    $recordId = (int)$recordId;
    $postedRecordId = (int)($_POST['record_id'] ?? 0);
    $petId = (int)($_POST['pet_id'] ?? 0);

    if ($recordId <= 0 || $postedRecordId !== $recordId || $petId <= 0) {
        die('Invalid medical record information.');
    }

    $existingRecord = $this->medicalRecordModel->getById($recordId);

    if (!$existingRecord || (int)$existingRecord->pet_id !== $petId) {
        die('Medical record not found.');
    }

    $status = $_POST['status'] ?? '';

    if (!in_array($status, ['Ongoing', 'Completed'], true)) {
        die('Invalid treatment status.');
    }

    $visitDate = $_POST['visit_date'] ?? '';
    $followUpDate = $_POST['follow_up_date'] ?? '';

    if ($visitDate === '' ||
        strtotime($visitDate) === false ||
        ($followUpDate !== '' && strtotime($followUpDate) === false)) {
        die('Please enter valid dates.');
    }

    if ($followUpDate !== '' && $followUpDate < $visitDate) {
        die('The follow-up date cannot be earlier than the visit date.');
    }

    $data = [
        'record_id' => $recordId,
        'pet_id' => $petId,
        'visit_date' => $visitDate,
        'diagnosis' => trim($_POST['diagnosis'] ?? ''),
        'treatment' => trim($_POST['treatment'] ?? ''),
        'prescription' => trim($_POST['prescription'] ?? ''),
        'follow_up_date' => $followUpDate,
        'notes' => trim($_POST['notes'] ?? ''),
        'medicine_name' => trim($_POST['medicine_name'] ?? ''),
        'medicine_dose' => trim($_POST['medicine_dose'] ?? ''),
        'medicine_frequency' => trim($_POST['medicine_frequency'] ?? ''),
        'medicine_duration' => trim($_POST['medicine_duration'] ?? ''),
        'status' => $status
    ];

    if ($data['diagnosis'] === '' || $data['treatment'] === '') {
        die('Diagnosis and treatment are required.');
    }

    if ($this->medicalRecordModel->update($data)) {
        header(
            'Location: ' . URLROOT .
            '/index.php?url=vet/treatmentDetails/' . $recordId
        );
        exit;
    }

    die('The medical record could not be updated. Please try again.');
}
public function deleteMedicalRecord($recordId = null)
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die('Invalid request method.');
    }

    $recordId = (int)$recordId;
    $postedRecordId = (int)($_POST['record_id'] ?? 0);
    $petId = (int)($_POST['pet_id'] ?? 0);

    if ($recordId <= 0 || $postedRecordId !== $recordId || $petId <= 0) {
        die('Invalid medical record information.');
    }

    $record = $this->medicalRecordModel->getById($recordId);

    if (!$record || (int)$record->pet_id !== $petId) {
        die('Medical record not found.');
    }

    if ($this->medicalRecordModel->delete($recordId, $petId)) {
        header(
            'Location: ' . URLROOT .
            '/index.php?url=vet/healthRecordDetails/' . $petId
        );
        exit;
    }

    die('Could not delete the medical record. Please try again.');
}
}