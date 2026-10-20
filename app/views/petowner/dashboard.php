
<?php
/*
 * HappyPaws Pet Owner Dashboard
 *
 * All pet, appointment, vaccination and medical-history
 * information is retrieved from the database.
 */

$pets = $pets ?? [];
$selectedPet = $selectedPet ?? null;
$petHealthSummary = $petHealthSummary ?? null;
$vaccinations = $vaccinations ?? [];
$medicalHistory = $medicalHistory ?? [];
$nextAppointment = $nextAppointment ?? null;
$allUpcomingAppointments = $allUpcomingAppointments ?? [];

$petCount = (int) ($petCount ?? 0);
$upcomingAppointments = (int) ($upcomingAppointments ?? 0);
$vaccinationsDue = (int) ($vaccinationsDue ?? 0);

$e = static function ($value) {
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$formatDate = static function ($date, $format = 'M j, Y') {
    if (empty($date)) {
        return 'Not recorded';
    }

    try {
        return (new DateTime($date))->format($format);
    } catch (Exception $exception) {
        return 'Not recorded';
    }
};

$getVaccineStatus = static function ($dueDate) {
    if (empty($dueDate)) {
        return [
            'label' => 'No due date',
            'class' => 'hp-status-neutral'
        ];
    }

    try {
        $today = new DateTime('today');
        $due = new DateTime($dueDate);
        $days = (int) $today->diff($due)->format('%r%a');

        if ($days < 0) {
            return [
                'label' => 'Overdue',
                'class' => 'hp-status-overdue'
            ];
        }

        if ($days === 0) {
            return [
                'label' => 'Due today',
                'class' => 'hp-status-due'
            ];
        }

        if ($days <= 30) {
            return [
                'label' => 'Due in ' . $days . ' day' . ($days === 1 ? '' : 's'),
                'class' => 'hp-status-due'
            ];
        }

        return [
            'label' => 'Up to date',
            'class' => 'hp-status-good'
        ];
    } catch (Exception $exception) {
        return [
            'label' => 'Status unavailable',
            'class' => 'hp-status-neutral'
        ];
    }
};

// Calculate the selected pet's age only when its date of birth exists.
$petAge = null;

if ($selectedPet && !empty($selectedPet->date_of_birth)) {
    try {
        $birthDate = new DateTime($selectedPet->date_of_birth);
        $today = new DateTime('today');
        $petAge = $birthDate->diff($today);
    } catch (Exception $exception) {
        $petAge = null;
    }
}

// Build a timeline from actual medical and vaccination records.
$careTimeline = [];

foreach ($medicalHistory as $record) {
    if (!empty($record->visit_date)) {
        $careTimeline[] = [
            'date' => $record->visit_date,
            'type' => 'medical',
            'title' => !empty($record->service_name)
                ? $record->service_name
                : 'Medical visit',
            'description' => !empty($record->diagnosis)
                ? $record->diagnosis
                : (!empty($record->notes)
                    ? $record->notes
                    : 'Medical record available'),
            'vet' => $record->vet_name ?? ''
        ];
    }
}

foreach ($vaccinations as $vaccination) {
    if (!empty($vaccination->administered_date)) {
        $careTimeline[] = [
            'date' => $vaccination->administered_date,
            'type' => 'vaccination',
            'title' => $vaccination->vaccine_name ?? 'Vaccination',
            'description' => 'Vaccination record',
            'vet' => $vaccination->vet_name ?? ''
        ];
    }
}

usort($careTimeline, static function ($a, $b) {
    return strtotime($b['date']) <=> strtotime($a['date']);
});

$careTimeline = array_slice($careTimeline, 0, 5);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - HappyPaws</title>

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/petowner.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/topbar.css">

    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/dashboard.css">
</head>

<body>

    <?php
    require_once APPROOT . '/views/layouts/petowner-sidebar.php';
    ?>

    <main class="petowner-main hp-dashboard-main">

        <?php
        require_once APPROOT . '/views/layouts/petowner-topbar.php';
        ?>

        <div class="hp-dashboard">

            <!-- Welcome header -->
            <section class="hp-welcome">
                <div class="hp-welcome-copy">
                    <p class="hp-eyebrow">YOUR PET CARE SPACE</p>

                    <h1>
                        <?php echo $e($greeting ?? 'Welcome,'); ?>
                        <?php echo $e($userName ?? 'Pet Owner'); ?>
                    </h1>

                    <p>
                        Keep track of your pets' health, appointments
                        and vaccination records in one place.
                    </p>
                </div>

                <?php if (!empty($pets)): ?>
                    <form class="hp-pet-picker"
                          method="GET"
                          action="<?php echo URLROOT; ?>/petowner/dashboard">

                        <label for="dashboardPet">Viewing pet</label>

                        <div class="pet-select-wrapper">
                            <select name="pet_id"
                                    id="dashboardPet"
                                    onchange="this.form.submit()">

                                <?php foreach ($pets as $pet): ?>
                                    <option
                                        value="<?php echo (int) $pet->pet_id; ?>"
                                        <?php echo (
                                            $selectedPet &&
                                            (int) $selectedPet->pet_id === (int) $pet->pet_id
                                        ) ? 'selected' : ''; ?>>

                                        <?php echo $e($pet->name); ?>
                                        <?php if (!empty($pet->species)): ?>
                                            — <?php echo $e($pet->species); ?>
                                        <?php endif; ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>

                            <img
                                class="pet-select-arrow"
                                src="<?php echo URLROOT; ?>/Assets/down-arrow.png"
                                alt=""
                                aria-hidden="true">
                        </div>
                    </form>
                <?php endif; ?>
            </section>

            <!-- Summary statistics -->
            <section class="hp-stat-grid" aria-label="Dashboard statistics">

                <article class="hp-stat-card">
                    <div class="hp-stat-icon hp-icon-teal">
                        <img src="<?php echo URLROOT; ?>/Assets/myPets.png" alt="Pet health">
                    </div>
                    <div>
                        <p>Registered pets</p>
                        <strong><?php echo $petCount; ?></strong>
                        <span>Your registered companions</span>
                    </div>
                </article>

                <article class="hp-stat-card">
                    <div class="hp-stat-icon hp-icon-blue">
                        <img src="<?php echo URLROOT; ?>/Assets/upcoming.png" alt="Upcoming Appointments">
                    </div>
                    <div>
                        <p>Upcoming appointments</p>
                        <strong><?php echo $upcomingAppointments; ?></strong>
                        <span>Scheduled visits</span>
                    </div>
                </article>

                <article class="hp-stat-card">
                    <div class="hp-stat-icon hp-icon-amber">
                        <img src="<?php echo URLROOT; ?>/Assets/vaccine1.png" alt="Vaccinations">
                    </div>
                    <div>
                        <p>Vaccination Attention</p>
                        <strong><?php echo $vaccinationsDue; ?></strong>
                        <span>Overdue or due within 30 days</span>
                    </div>
                </article>

                <article class="hp-stat-card">
                    <div class="hp-stat-icon hp-icon-purple">
                        <img src="<?php echo URLROOT; ?>/Assets/notification.png" alt="Upcoming Appointments">
                    </div>
                    <div>
                        <p>Notifications</p>
                        <strong>—</strong>
                        <span>Notification feature coming soon</span>
                    </div>
                </article>

            </section>

            <?php if (empty($pets)): ?>

                <!-- Empty state when the owner has no registered pets -->
                <section class="hp-empty-state">
                    <div class="hp-empty-icon">♡</div>
                    <h2>Let's meet your first pet!</h2>
                    <p>
                        You haven't registered a pet yet. Add your dog
                        or cat to start managing their appointments and health records.
                    </p>
                    <a class="hp-primary-button"
                       href="<?php echo URLROOT; ?>/petowner/registerPet">
                        + Register your first pet
                    </a>
                </section>

            <?php else: ?>

                <!-- Selected pet health overview -->
                <section class="hp-panel hp-pet-overview">

                    <div class="hp-panel-heading">
                        <div>
                            <p class="hp-eyebrow">PET HEALTH PROFILE</p>
                            <h2>Meet <?php echo $e($selectedPet->name); ?></h2>
                        </div>

                        <a class="hp-text-link"
                           href="<?php echo URLROOT; ?>/petowner/healthRecords?pet_id=<?php echo (int) $selectedPet->pet_id; ?>">
                            View health records →
                        </a>
                    </div>

                    <div class="hp-pet-profile">

                        <div class="hp-pet-avatar" aria-hidden="true">
                            <?php
                            $species = strtolower((string) ($selectedPet->species ?? ''));

                            if (strpos($species, 'cat') !== false) {
                                $petImage = URLROOT . '/Assets/cat.png';
                                $petAlt = 'Cat';
                            } else {
                                $petImage = URLROOT . '/Assets/dog.png';
                                $petAlt = 'Dog';
                            }
                            ?>

                            <img src="<?php echo htmlspecialchars($petImage); ?>"
                                alt="<?php echo $petAlt; ?>">
                        </div>

                        <div class="hp-pet-main-details">
                            <h3><?php echo $e($selectedPet->name); ?></h3>

                            <p>
                                <?php echo $e($selectedPet->species ?: 'Species not recorded'); ?>
                                <?php if (!empty($selectedPet->breed)): ?>
                                    · <?php echo $e($selectedPet->breed); ?>
                                <?php endif; ?>
                            </p>

                            <div class="hp-pet-tags">
                                <?php if (!empty($selectedPet->gender)): ?>
                                    <span><?php echo $e($selectedPet->gender); ?></span>
                                <?php endif; ?>

                                <?php if ($petAge): ?>
                                    <span>
                                        <?php echo $petAge->y > 0
                                            ? $petAge->y . ' yr' . ($petAge->y === 1 ? '' : 's')
                                            : $petAge->m . ' mo'; ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($selectedPet->weight_kg)): ?>
                                    <span><?php echo $e($selectedPet->weight_kg); ?> kg</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="hp-pet-facts">
                            <div>
                                <span>Microchip number</span>
                                <strong>
                                    <?php echo !empty($selectedPet->microchip_number)
                                        ? $e($selectedPet->microchip_number)
                                        : 'Not recorded'; ?>
                                </strong>
                            </div>

                            <div>
                                <span>Allergies</span>
                                <strong>
                                    <?php echo !empty($selectedPet->allergies)
                                        ? $e($selectedPet->allergies)
                                        : 'None recorded'; ?>
                                </strong>
                            </div>

                            <div>
                                <span>Last recorded visit</span>
                                <strong>
                                    <?php
                                    echo !empty($medicalHistory[0]->visit_date)
                                        ? $e($formatDate($medicalHistory[0]->visit_date))
                                        : 'No visit recorded';
                                    ?>
                                </strong>
                            </div>
                        </div>

                    </div>
                </section>

                <!-- Next appointment and vaccinations -->
                <section class="hp-main-grid">

                    <article class="hp-panel hp-next-visit">

                        <div class="hp-panel-heading">
                            <div>
                                <p class="hp-eyebrow">COMING UP</p>
                                <h2>Next appointment</h2>
                            </div>
                            <span class="hp-heading-symbol">
                                <img src="<?php echo URLROOT; ?>/Assets/clock.png" alt="Appointments">
                            </span>
                        </div>

                        <?php if ($nextAppointment): ?>

                            <div class="hp-visit-date">
                                <strong>
                                    <?php echo $e($formatDate(
                                        $nextAppointment->appointment_date,
                                        'd'
                                    )); ?>
                                </strong>
                                <span>
                                    <?php echo $e($formatDate(
                                        $nextAppointment->appointment_date,
                                        'M Y'
                                    )); ?>
                                </span>
                            </div>

                            <div class="hp-visit-details">
                                <h3>
                                    <?php echo $e(
                                        $nextAppointment->service_name
                                        ?: 'Appointment'
                                    ); ?>
                                </h3>

                                <p>
                                    <?php echo $e($selectedPet->name); ?>
                                </p>

                                <p>
                                    <span>Time</span>
                                    <?php echo $e($formatDate(
                                        $nextAppointment->appointment_time,
                                        'g:i A'
                                    )); ?>
                                </p>

                                <p>
                                    <span>Veterinarian</span>
                                    <?php echo $e(
                                        trim((string) ($nextAppointment->vet_name ?? ''))
                                        ?: 'Not assigned'
                                    ); ?>
                                </p>

                                <span class="hp-status-badge hp-status-neutral">
                                    <?php echo $e($nextAppointment->status ?? 'Scheduled'); ?>
                                </span>
                            </div>

                            <a class="hp-secondary-button"
                               href="<?php echo URLROOT; ?>/petowner/upcomingAppointments">
                                View appointments
                            </a>

                        <?php else: ?>

                            <div class="hp-inline-empty">
                                <div class="hp-inline-empty-icon">
                                    <img src="<?php echo URLROOT; ?>/Assets/upcoming.png" alt="Upcoming Appointments">
                                </div>
                                <h3>No upcoming appointment</h3>
                                <p>
                                    There are no upcoming appointments recorded
                                    for <?php echo $e($selectedPet->name); ?>.
                                </p>
                                <a class="hp-primary-button"
                                   href="<?php echo URLROOT; ?>/petowner/bookAppointment">
                                    Book an appointment
                                </a>
                            </div>

                        <?php endif; ?>

                    </article>

                    <article class="hp-panel hp-vaccinations">

                        <div class="hp-panel-heading">
                            <div>
                                <p class="hp-eyebrow">HEALTH PROTECTION</p>
                                <h2>Vaccination passport</h2>
                            </div>
                            <span class="hp-heading-symbol">
                                <img src="<?php echo URLROOT; ?>/Assets/cross.png" alt="Vaccinations">
                            </span>
                        </div>

                        <?php if (!empty($vaccinations)): ?>

                            <div class="hp-vaccine-list">

                                <?php foreach (array_slice($vaccinations, 0, 4) as $vaccination): ?>
                                    <?php $vaccineStatus = $getVaccineStatus(
                                        $vaccination->next_due_date ?? null
                                    ); ?>

                                    <div class="hp-vaccine-item">

                                        <div class="hp-vaccine-info">
                                            <h3>
                                                <?php echo $e(
                                                    $vaccination->vaccine_name
                                                    ?? 'Vaccination'
                                                ); ?>
                                            </h3>

                                            <p>
                                                Last administered:
                                                <?php echo $e($formatDate(
                                                    $vaccination->administered_date ?? null
                                                )); ?>
                                            </p>

                                            <p>
                                                Next due:
                                                <?php echo $e($formatDate(
                                                    $vaccination->next_due_date ?? null
                                                )); ?>
                                            </p>
                                        </div>

                                        <span class="hp-status-badge <?php echo $e($vaccineStatus['class']); ?>">
                                            <?php echo $e($vaccineStatus['label']); ?>
                                        </span>

                                    </div>
                                <?php endforeach; ?>

                            </div>

                            <a class="hp-text-link"
                               href="<?php echo URLROOT; ?>/petowner/healthRecords?pet_id=<?php echo (int) $selectedPet->pet_id; ?>">
                                View all health records →
                            </a>

                        <?php else: ?>

                            <div class="hp-inline-empty">
                                <div class="hp-inline-empty-icon">
                                    <img src="<?php echo URLROOT; ?>/Assets/vaccine1.png" alt="Vaccinations">
                                </div>
                                <h3>No vaccination records</h3>
                                <p>
                                    No vaccination records have been added
                                    for <?php echo $e($selectedPet->name); ?> yet.
                                </p>
                                <p class="hp-muted-note">
                                    This doesn't confirm whether vaccinations
                                    are current or overdue.
                                </p>
                            </div>

                        <?php endif; ?>

                    </article>

                </section>

                <!-- Recent care timeline -->
                <section class="hp-panel hp-timeline-panel">

                    <div class="hp-panel-heading">
                        <div>
                            <p class="hp-eyebrow">RECORD OF CARE</p>
                            <h2>Recent health activity</h2>
                        </div>

                        <a class="hp-text-link"
                           href="<?php echo URLROOT; ?>/petowner/healthRecords?pet_id=<?php echo (int) $selectedPet->pet_id; ?>">
                            All health records →
                        </a>
                    </div>

                    <?php if (!empty($careTimeline)): ?>

                        <div class="hp-timeline">

                            <?php foreach ($careTimeline as $item): ?>
                                <article class="hp-timeline-item">

                                    <div class="hp-timeline-marker <?php echo $item['type'] === 'vaccination' ? 'hp-marker-vaccine' : 'hp-marker-medical'; ?>">
                                        <?php echo $item['type'] === 'vaccination' ? '✚' : '＋'; ?>
                                    </div>

                                    <div class="hp-timeline-content">
                                        <div class="hp-timeline-title-row">
                                            <h3><?php echo $e($item['title']); ?></h3>
                                            <time>
                                                <?php echo $e($formatDate($item['date'])); ?>
                                            </time>
                                        </div>

                                        <p><?php echo $e($item['description']); ?></p>

                                        <?php if (!empty($item['vet'])): ?>
                                            <span>Veterinarian: <?php echo $e($item['vet']); ?></span>
                                        <?php endif; ?>
                                    </div>

                                </article>
                            <?php endforeach; ?>

                        </div>

                    <?php else: ?>

                        <div class="hp-timeline-empty">
                            <h3>No health activity recorded yet</h3>
                            <p>
                                Medical visits and vaccinations will appear
                                here once records have been added.
                            </p>
                        </div>

                    <?php endif; ?>

                </section>

            <?php endif; ?>

            <!-- Quick actions -->
            <section class="hp-quick-actions">

                <div class="hp-panel-heading">
                    <div>
                        <p class="hp-eyebrow">SHORTCUTS</p>
                        <h2>Quick actions</h2>
                    </div>
                </div>

                <div class="hp-action-grid">

                    <a href="<?php echo URLROOT; ?>/petowner/bookAppointment"
                       class="hp-action-card">
                        <span class="hp-action-icon hp-icon-teal">▦</span>
                        <span>
                            <strong>Book appointment</strong>
                            <small>Schedule a visit for your pet</small>
                        </span>
                        <span class="hp-action-arrow">→</span>
                    </a>

                    <a href="<?php echo URLROOT; ?>/petowner/registerPet"
                       class="hp-action-card">
                        <span class="hp-action-icon hp-icon-blue">＋</span>
                        <span>
                            <strong>Register a pet</strong>
                            <small>Add a dog or cat to your account</small>
                        </span>
                        <span class="hp-action-arrow">→</span>
                    </a>

                    <a href="<?php echo URLROOT; ?>/petowner/healthRecords"
                       class="hp-action-card">
                        <span class="hp-action-icon hp-icon-amber">♡</span>
                        <span>
                            <strong>Health records</strong>
                            <small>Review medical history and vaccinations</small>
                        </span>
                        <span class="hp-action-arrow">→</span>
                    </a>

                    <a href="<?php echo URLROOT; ?>/petowner/store"
                       class="hp-action-card">
                        <span class="hp-action-icon hp-icon-purple">⌑</span>
                        <span>
                            <strong>Product store</strong>
                            <small>Browse available pet products</small>
                        </span>
                        <span class="hp-action-arrow">→</span>
                    </a>

                </div>
            </section>

        </div>
    </main>

    <script src="<?php echo URLROOT; ?>/js/petowner.js"></script>

</body>
</html>
