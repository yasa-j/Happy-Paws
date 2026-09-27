<?php

$profile = $data['profile'] ?? [
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

    <title>
        <?php echo htmlspecialchars($data['title'] ?? 'Edit Profile'); ?>
    </title>


    <!-- SIDEBAR CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    

    <!-- EDIT PROFILE CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-edit-profile.css"
    >

</head>


<body>


<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php
    require APPROOT . '/views/layouts/vet_sidebar.php';
    ?>


    <!-- =====================================================
         MAIN AREA
         ===================================================== -->

    <main class="vet-main">


        <!-- =====================================================
             TOP HEADER
             ===================================================== -->

        <header class="vet-topbar">


            <!-- SEARCH -->

            <div class="vet-search">

                <span class="search-icon">⌕</span>

                <input
                    type="text"
                    placeholder="Search appointments, patients..."
                >

            </div>


            <!-- HEADER RIGHT -->

            <div class="vet-header-right">


                <!-- Notifications -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/notifications"
                    class="header-action"
                    title="Notifications"
                >

                    ♧

                    <span class="notification-dot"></span>

                </a>


                <!-- Settings -->

                <a
                    href="#"
                    class="header-action"
                    title="Settings"
                >
                    ⚙
                </a>


                <div class="header-divider"></div>


                <!-- Profile -->

                <a
                    href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                    class="vet-profile"
                >

                    
                    <img
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="Profile">

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


        <!-- =====================================================
             EDIT PROFILE CONTENT
             ===================================================== -->

        <section class="edit-profile-page">


            <!-- PAGE TITLE -->

            <div class="edit-profile-heading">

                <div class="edit-profile-title-icon">
                    ♙
                </div>

                <div>

                    <h1>
                        Edit Profile
                    </h1>

                </div>

            </div>


            <!-- =================================================
                 EDIT PROFILE FORM
                 ================================================= -->

            <form
                id="edit-profile-form"
                class="edit-profile-layout"
                action="<?php echo URLROOT; ?>/index.php?url=vet/updateProfile"
                method="POST"
                enctype="multipart/form-data"
            >


                <!-- =================================================
                     LEFT COLUMN
                     ================================================= -->

                <div class="edit-profile-main">


                    <!-- =================================================
                         PERSONAL INFORMATION
                         ================================================= -->

                    <section class="edit-card">


                        <div class="edit-card-header">

                            <h2>
                                Personal Information
                            </h2>

                        </div>


                        <div class="edit-card-line"></div>


                        <div class="edit-form-grid">


                            <!-- Full Name -->

                            <div class="edit-form-group">

                                <label>
                                    FULL NAME
                                </label>

                                <input
                                    type="text"
                                    id="full-name"
                                    name="full_name"
                                    value="<?php echo htmlspecialchars($profile['full_name']); ?>"
                                >

                            </div>


                            <!-- Email -->

                            <div class="edit-form-group">

                                <label>
                                    EMAIL ADDRESS
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="<?php echo htmlspecialchars($profile['email']); ?>"
                                >

                            </div>


                            <!-- Phone -->

                            <div class="edit-form-group">

                                <label>
                                    PHONE NUMBER
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    value="<?php echo htmlspecialchars($profile['phone']); ?>"
                                >

                            </div>


                            <!-- Date of Birth -->

                            <div class="edit-form-group">

                                <label>
                                    DATE OF BIRTH
                                </label>

                                <input
                                    type="date"
                                    id="date-of-birth"
                                    name="date_of_birth"
                                    value="<?php echo htmlspecialchars($profile['date_of_birth']); ?>"
                                >

                            </div>


                            <!-- Gender -->

                            <div class="edit-form-group">

                                <label>
                                    GENDER
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                >

                                    <option
                                        value="Female"
                                        <?php echo ($profile['gender'] === 'Female') ? 'selected' : ''; ?>
                                    >
                                        Female
                                    </option>

                                    <option
                                        value="Male"
                                        <?php echo ($profile['gender'] === 'Male') ? 'selected' : ''; ?>
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Other"
                                        <?php echo ($profile['gender'] === 'Other') ? 'selected' : ''; ?>
                                    >
                                        Other
                                    </option>

                                </select>

                            </div>


                        </div>

                    </section>


                    <!-- =================================================
                         PROFESSIONAL INFORMATION
                         ================================================= -->

                    <section class="edit-card">


                        <div class="edit-card-header">

                            <h2>
                                Professional Information
                            </h2>

                        </div>


                        <div class="edit-card-line"></div>


                        <div class="edit-form-grid">


                            <!-- License Number -->

                            <div class="edit-form-group">

                                <label>
                                    VETERINARY LICENSE NUMBER
                                </label>

                                <input
                                    type="text"
                                    id="license-number"
                                    name="license_number"
                                    value="<?php echo htmlspecialchars($profile['license_number']); ?>"
                                >

                            </div>


                            <!-- License Expiry -->

                            <div class="edit-form-group">

                                <label>
                                    LICENSE EXPIRY DATE
                                </label>

                                <input
                                    type="date"
                                    id="license-expiry"
                                    name="license_expiry"
                                    value="<?php echo htmlspecialchars($profile['license_expiry']); ?>"
                                >

                            </div>


                            <!-- Specialization -->

                            <div class="edit-form-group">

                                <label>
                                    SPECIALIZATION
                                </label>

                                <input
                                    type="text"
                                    id="specialization"
                                    name="specialization"
                                    value="<?php echo htmlspecialchars($profile['specialization']); ?>"
                                >

                            </div>


                            <!-- Experience -->

                            <div class="edit-form-group">

                                <label>
                                    YEARS OF EXPERIENCE
                                </label>

                                <input
                                    type="number"
                                    id="experience"
                                    name="experience"
                                    min="0"
                                    value="<?php echo htmlspecialchars($profile['experience']); ?>"
                                >

                            </div>


                            <!-- Position -->

                            <div class="edit-form-group">

                                <label>
                                    CURRENT POSITION
                                </label>

                                <input
                                    type="text"
                                    id="position"
                                    name="position"
                                    value="<?php echo htmlspecialchars($profile['position']); ?>"
                                >

                            </div>


                            <!-- Clinic -->

                            <div class="edit-form-group">

                                <label>
                                    CLINIC / BRANCH
                                </label>

                                <select
                                    id="clinic"
                                    name="clinic"
                                >

                                    <option
                                        value="Downtown Seattle Main Branch"
                                        <?php echo ($profile['clinic'] === 'Downtown Seattle Main Branch') ? 'selected' : ''; ?>
                                    >
                                        Downtown Seattle Main Branch
                                    </option>

                                    <option
                                        value="Happy Paws Main Clinic"
                                        <?php echo ($profile['clinic'] === 'Happy Paws Main Clinic') ? 'selected' : ''; ?>
                                    >
                                        Happy Paws Main Clinic
                                    </option>

                                    <option
                                        value="Downtown Branch"
                                        <?php echo ($profile['clinic'] === 'Downtown Branch') ? 'selected' : ''; ?>
                                    >
                                        Downtown Branch
                                    </option>

                                </select>

                            </div>


                        </div>

                    </section>


                    <!-- =================================================
                         QUALIFICATIONS
                         ================================================= -->

                    <section class="edit-card">


                        <div class="edit-card-header">

                            <h2>
                                Qualifications
                            </h2>

                        </div>


                        <div class="edit-card-line"></div>


                        <div class="edit-form-grid">


                            <!-- Degree -->

                            <div class="edit-form-group">

                                <label>
                                    DEGREE / CERTIFICATION NAME
                                </label>

                                <input
                                    type="text"
                                    id="degree"
                                    name="degree"
                                    value="<?php echo htmlspecialchars($profile['degree']); ?>"
                                >

                            </div>


                            <!-- Institution -->

                            <div class="edit-form-group">

                                <label>
                                    ISSUING INSTITUTION
                                </label>

                                <input
                                    type="text"
                                    id="institution"
                                    name="institution"
                                    value="<?php echo htmlspecialchars($profile['institution']); ?>"
                                >

                            </div>


                        </div>


                        <!-- CERTIFICATE -->

                        <div class="certificate-section">


                            <label>
                                QUALIFICATION CERTIFICATE
                            </label>


                            <div
                                class="certificate-upload"
                                id="certificate-area"
                            >


                                <div class="certificate-file-icon">
                                    ▤
                                </div>


                                <div
                                    class="certificate-file-name"
                                    id="certificate-file-name"
                                >
                                    DVM_Certificate_MichaelVance.pdf
                                </div>


                                <label
                                    for="certificate-upload"
                                    class="certificate-button"
                                >
                                    ↑ Upload Certificate
                                </label>


                                <input
                                    type="file"
                                    id="certificate-upload"
                                    name="certificate"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    hidden
                                >


                            </div>


                            <button
                                type="button"
                                class="add-qualification"
                                id="add-qualification"
                            >
                                ⊕ Add Another Qualification
                            </button>


                        </div>

                    </section>


                    <!-- =================================================
                         PROFESSIONAL BIOGRAPHY
                         ================================================= -->

                    <section class="edit-card">


                        <div class="edit-card-header">

                            <h2>
                                Professional Biography
                            </h2>

                        </div>


                        <div class="edit-card-line"></div>


                        <div class="edit-form-group">


                            <label>
                                SHORT BIO (VISIBLE TO CLIENTS)
                            </label>


                            <textarea
                                id="bio"
                                name="bio"
                                rows="6"
                                maxlength="500"
                            ><?php echo htmlspecialchars($profile['bio']); ?></textarea>


                            <div class="character-count">

                                <span id="bio-count">
                                    <?php echo strlen($profile['bio']); ?>
                                </span>/500

                            </div>


                        </div>

                    </section>


                    <!-- =================================================
                         SAVE / CANCEL
                         ================================================= -->

                    <div class="edit-form-actions">


                        <a
                            href="<?php echo URLROOT; ?>/index.php?url=vet/profile"
                            class="cancel-profile-button"
                        >
                            Cancel
                        </a>


                        <button
                            type="submit"
                            class="save-profile-button"
                        >
                            ✓ Save Changes
                        </button>


                    </div>


                </div>


                <!-- =================================================
                     RIGHT COLUMN
                     ================================================= -->

                <aside class="edit-profile-side">


                    <!-- =================================================
                         PROFILE PHOTO
                         ================================================= -->

                    <section class="photo-card">


                        <div class="doctor-edit-image">


                            <img
    id="profile-image"
    src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
    alt="<?php echo htmlspecialchars($profile['full_name']); ?>"
>


                            <label
                                for="photo-upload"
                                class="photo-edit-icon"
                                title="Change photo"
                            >
                                ✎
                            </label>


                        </div>


                        <input
                            type="file"
                            id="photo-upload"
                            name="profile_photo"
                            accept="image/*"
                            hidden
                        >


                        <label
                            for="photo-upload"
                            class="upload-photo-button"
                        >
                            Upload New Photo
                        </label>


                        <button
                            type="button"
                            id="remove-photo"
                            class="remove-photo-button"
                        >
                            Remove Photo
                        </button>


                    </section>


                    <!-- =================================================
                         ACCOUNT SETTINGS
                         ================================================= -->

                    <section class="account-card">


                        <h3>
                            Account Settings
                        </h3>


                        <div class="account-line"></div>


                        <a
                            href="#"
                            class="account-button"
                            id="change-password"
                        >
                            <span>
                                Change Password
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                        <a
                            href="#"
                            class="account-button"
                            id="change-email"
                        >
                            <span>
                                Change Email
                            </span>

                            <span>
                                ›
                            </span>
                        </a>


                    </section>


                </aside>


            </form>


        </section>


    </main>


</div>


<!-- EDIT PROFILE JAVASCRIPT -->

<script src="<?php echo URLROOT; ?>/js/vet-edit-profile.js"></script>


</body>
</html>