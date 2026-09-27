<?php
$vet = [
    'full_name' => 'Michael Vance',
    'email' => 'vet@happypaws.lk',
    'phone' => '+94 71 987 6543',
    'license' => 'VET-8924-CA'
];
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Happy Paws - My Profile</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <!-- Sidebar -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    >

    <!-- Profile -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-profile.css?v=2"
    >

</head>


<body>

<div class="vet-page">

    <!-- SIDEBAR -->

    <?php require_once APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- MAIN -->

    <main class="vet-main">


        <!-- HEADER -->

        <header class="vet-topbar">

            <div class="vet-search">

                <span class="search-icon">
                    ⌕
                </span>

                <input
                    type="text"
                    placeholder="Search appointments, patients..."
                >

            </div>


            <div class="vet-header-right">

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
                    class="header-action"
                    title="Notifications"
                >
                    ♧
                    <span class="notification-dot"></span>
                </a>


                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                    class="header-action"
                    title="Settings"
                >
                    ⚙
                </a>


                <div class="header-divider"></div>


                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                    class="vet-profile"
                >

                    
                    

                    <div class="vet-profile-info">

                        <strong>
    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
</strong>

                        <span>
                            Lead Veterinarian
                        </span>

                    </div>

                </a>

            </div>

        </header>


        <!-- ================= PROFILE ================= -->

        <section class="profile-page">


            <!-- TITLE -->

            <div class="profile-heading">

                <h1>
                    My Profile
                </h1>

            </div>


            <!-- GRID -->

            <div class="profile-grid">


                <!-- LEFT SIDE -->

                <div class="profile-left">


                    <!-- PERSONAL INFORMATION -->

                    <section class="profile-card">

                        <h2>
                            Personal Information
                        </h2>

                        <div class="card-line"></div>


                        <div class="information-grid">

                            <div class="information-item">

                                <label>
                                    FULL NAME
                                </label>

                                <p>
                                    <?php echo $vet['full_name']; ?>
                                </p>

                            </div>


                            <div class="information-item">

                                <label>
                                    EMAIL ADDRESS
                                </label>

                                <p>
                                    <?php echo $vet['email']; ?>
                                </p>

                            </div>


                            <div class="information-item">

                                <label>
                                    PHONE NUMBER
                                </label>

                                <p>
                                    <?php echo $vet['phone']; ?>
                                </p>

                            </div>


                            <div class="information-item">

                                <label>
                                    LICENSE NUMBER
                                </label>

                                <p>
                                    <span class="license-badge">
                                        <?php echo $vet['license']; ?>
                                    </span>
                                </p>

                            </div>

                        </div>

                    </section>


                    <!-- WORKING SCHEDULE -->

                    <section class="profile-card">

                        <h2>
                            Working Schedule
                        </h2>

                        <div class="card-line"></div>


                        <div class="schedule-row">

                            <span>
                                Monday - Friday
                            </span>

                            <strong>
                                09:00 AM - 05:00 PM
                            </strong>

                        </div>


                        <div class="schedule-row">

                            <span>
                                Saturday
                            </span>

                            <strong>
                                09:00 AM - 01:00 PM
                            </strong>

                        </div>


                        <div class="schedule-row">

                            <span>
                                Sunday
                            </span>

                            <strong class="off">
                                Off
                            </strong>

                        </div>

                    </section>


                    <!-- CERTIFICATIONS -->

                    <section class="profile-card">

                        <h2>
                            Certifications
                        </h2>

                        <div class="card-line"></div>


                        <div class="certification">

                            <span class="certification-icon">
                                ◉
                            </span>

                            <div>

                                <strong>
                                    Board Certified Surgeon
                                </strong>

                                <p>
                                    ACVS, 2015
                                </p>

                            </div>

                        </div>


                        <div class="certification">

                            <span class="certification-icon">
                                ◉
                            </span>

                            <div>

                                <strong>
                                    Soft Tissue Surgery
                                </strong>

                                <p>
                                    Global Vet Academy, 2018
                                </p>

                            </div>

                        </div>

                    </section>

                </div>


                <!-- RIGHT SIDE -->

                <div class="profile-right">


                    <!-- DOCTOR -->

                    <section class="doctor-card">

                        <div class="doctor-image">

                          <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">


                        </div>


                       <h2>
    <?php echo htmlspecialchars($vet['full_name']); ?>
</h2>

                        <p class="doctor-role">
                            Lead Veterinarian
                        </p>


                        <div class="doctor-divider"></div>


                        <a
                            href="<?php echo URLROOT; ?>/index.php?url=vet/editProfile"
                            class="profile-action primary"
                        >
                            ✎ Edit Profile
                        </a>


                        <a
                            href="<?php echo URLROOT; ?>/index.php?url=vet/changePassword"
                            class="profile-action secondary"
                        >
                            ◉ Change Password
                        </a>

                    </section>


                    <!-- PERFORMANCE -->

                    <section class="performance-card">

                        <h2>
                            Performance
                        </h2>

                        <div class="card-line"></div>


                        <div class="performance-item">

                            <div>

                                <span>
                                    RATING
                                </span>

                                <strong>
                                    4.9
                                </strong>

                            </div>

                            <div class="performance-icon">
                                ★
                            </div>

                        </div>


                        <div class="performance-item">

                            <div>

                                <span>
                                    EXPERIENCE
                                </span>

                                <strong>
                                    12 Yrs
                                </strong>

                            </div>

                            <div class="performance-icon">
                                ◉
                            </div>

                        </div>

                    </section>

                </div>

            </div>

        </section>

    </main>

</div>

</body>

</html>