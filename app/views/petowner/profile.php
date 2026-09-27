<?php
/*
|--------------------------------------------------------------------------
| Happy Paws - Pet Owner Profile
|--------------------------------------------------------------------------
| Displays information belonging to the currently logged-in pet owner.
|--------------------------------------------------------------------------
*/

// Safe defaults
$user = $user ?? null;
$pets = $pets ?? [];

if (!$user) {
    header('Location: ' . URLROOT . '/petowner/dashboard');
    exit;
}


/*
|--------------------------------------------------------------------------
| User information
|--------------------------------------------------------------------------
| These values come from the database through User::getUserById().
|--------------------------------------------------------------------------
*/

$firstName = $user->first_name ?? '';
$lastName = $user->last_name ?? '';

$fullName = trim($firstName . ' ' . $lastName);

$email = $user->email ?? '';
$phone = $user->phone_number ?? '';
$status = $user->status ?? '';

$address = $user->address ?? '';
$emergencyNo = $user->emergency_no ?? '';


/*
|--------------------------------------------------------------------------
| Profile initials
|--------------------------------------------------------------------------
*/

$initials = '';

if (!empty($firstName)) {
    $initials .= strtoupper(substr($firstName, 0, 1));
}

if (!empty($lastName)) {
    $initials .= strtoupper(substr($lastName, 0, 1));
}

if ($initials == '') {
    $initials = 'PO';
}


/*
|--------------------------------------------------------------------------
| Registered pets
|--------------------------------------------------------------------------
*/

$petCount = count($pets);

$petNames = [];

foreach ($pets as $pet) {

    if (isset($pet->name) && !empty($pet->name)) {
        $petNames[] = $pet->name;
    }
}


/*
|--------------------------------------------------------------------------
| Pet names display
|--------------------------------------------------------------------------
*/

$petNamesText = '';

if (!empty($petNames)) {

    $petNamesText = implode(', ', $petNames);

}


/*
|--------------------------------------------------------------------------
| Account status
|--------------------------------------------------------------------------
*/

$accountStatus = !empty($status) ? $status : 'Active';

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
        <?php echo isset($title) ? htmlspecialchars($title) : 'My Profile'; ?>
        | Happy Paws
    </title>


    <!-- Main Pet Owner CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/public/css/petowner.css"
    >


    <!-- Shared Topbar CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/topbar.css"
    >


    <!-- Profile CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/public/css/petowner-profile.css"
    >

</head>


<body>


<div class="petowner-layout">


    <!-- =====================================================
         SHARED SIDEBAR
         ===================================================== -->

    <?php

    $activePage = 'profile';

    require_once APPROOT . '/views/layouts/petowner-sidebar.php';

    ?>


    <!-- =====================================================
         MAIN CONTENT
         ===================================================== -->

    <main class="petowner-main">


        <!-- =================================================
             SHARED TOPBAR
             ================================================= -->

        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <!-- =================================================
             PROFILE CONTENT
             ================================================= -->

        <section class="profile-page">


            <!-- =================================================
                 BREADCRUMB
                 ================================================= -->

            <div class="profile-breadcrumb">

                <span>
                    PET OWNER PORTAL
                </span>

                <span class="breadcrumb-arrow">
                    ›
                </span>

                <strong>
                    PROFILE
                </strong>

            </div>


            <!-- =================================================
                 PAGE HEADER
                 ================================================= -->

            <div class="profile-page-header">

                <div>

                    <h1>
                        My Profile
                    </h1>

                    <p>
                        Manage your personal information, contact details,
                        and Happy Paws account security settings.
                    </p>

                </div>


                <div class="profile-status-badge">

                    <span class="status-dot"></span>

                    Profile <?php echo htmlspecialchars($accountStatus); ?>

                </div>

            </div>


            <!-- =================================================
                 PROFILE SUMMARY CARD
                 ================================================= -->

            <div class="profile-summary-card">


                <!-- Avatar -->

                <div class="profile-summary-avatar">

                    <?php echo htmlspecialchars($initials); ?>


                    <button
                        type="button"
                        class="avatar-camera"
                        title="Profile photo"
                    >
                        📷
                    </button>

                </div>


                <!-- User information -->

                <div class="profile-summary-information">

                    <div class="profile-name-row">

                        <h2>
                            <?php
                            echo htmlspecialchars(
                                !empty($fullName)
                                    ? $fullName
                                    : 'Pet Owner'
                            );
                            ?>
                        </h2>


                        <span class="owner-badge">
                            Pet Owner
                        </span>

                    </div>


                    <div class="profile-meta-row">


                        <?php if (!empty($email)): ?>

                            <span class="profile-meta-item">

                                <span class="meta-icon">
                                    ✉
                                </span>

                                <?php echo htmlspecialchars($email); ?>

                            </span>

                        <?php endif; ?>


                        <?php if (!empty($phone)): ?>

                            <span class="profile-meta-item">

                                <span class="meta-icon">
                                    ☎
                                </span>

                                <?php echo htmlspecialchars($phone); ?>

                            </span>

                        <?php endif; ?>


                    </div>

                </div>


                <!-- Edit button -->

                <button
                    type="button"
                    class="edit-profile-button"
                    onclick="showProfileMessage()"
                >

                    <span>
                        ✎
                    </span>

                    Edit Profile

                </button>

            </div>


            <!-- =================================================
                 MAIN PROFILE GRID
                 ================================================= -->

            <div class="profile-grid">


                <!-- =================================================
                     LEFT COLUMN
                     ================================================= -->

                <div class="profile-left-column">


                    <!-- =================================================
                         PERSONAL INFORMATION
                         ================================================= -->

                    <div class="profile-card">


                        <div class="profile-card-header">

                            <div class="profile-card-title">

                                <div class="section-icon">
                                    ♙
                                </div>

                                <h2>
                                    Personal Information
                                </h2>

                            </div>


                            <span class="section-note">
                                Basic details
                            </span>

                        </div>


                        <div class="profile-divider"></div>


                        <div class="information-grid">


                            <!-- Full Name -->

                            <div class="information-field">

                                <label>
                                    Full Name
                                </label>

                                <div class="information-value">

                                    <?php
                                    echo htmlspecialchars(
                                        !empty($fullName)
                                            ? $fullName
                                            : 'Not provided'
                                    );
                                    ?>

                                </div>

                            </div>


                            <!-- Account Role -->

                            <div class="information-field">

                                <label>
                                    Account Type
                                </label>

                                <div class="information-value">

                                    Pet Owner

                                </div>

                            </div>


                            <!-- Email -->

                            <div class="information-field">

                                <label>
                                    Email Address
                                </label>

                                <div class="information-value">

                                    <?php
                                    echo htmlspecialchars(
                                        !empty($email)
                                            ? $email
                                            : 'Not provided'
                                    );
                                    ?>

                                </div>

                            </div>


                            <!-- Registered Pets -->

                            <div class="information-field">

                                <label>
                                    Registered Pets
                                </label>

                                <div class="information-value pet-count-value">

                                    <span class="paw-small">
                                        🐾
                                    </span>


                                    <span>

                                        <?php echo $petCount; ?>

                                        <?php
                                        echo ($petCount == 1)
                                            ? ' Pet'
                                            : ' Pets';
                                        ?>

                                        <?php if (!empty($petNamesText)): ?>

                                            <small>
                                                (<?php
                                                echo htmlspecialchars(
                                                    $petNamesText
                                                );
                                                ?>)
                                            </small>

                                        <?php endif; ?>

                                    </span>

                                </div>

                            </div>

                        </div>


                        <!-- =================================================
                             CONTACT INFORMATION
                             ================================================= -->

                        <div class="profile-subsection">


                            <div class="profile-subsection-header">

                                <div class="profile-card-title">

                                    <div class="section-icon">
                                        ☎
                                    </div>

                                    <h2>
                                        Contact Information
                                    </h2>

                                </div>

                            </div>


                            <div class="profile-divider"></div>


                            <div class="information-grid">


                                <!-- Phone -->

                                <div class="information-field">

                                    <label>
                                        Mobile Number
                                    </label>

                                    <div class="information-value">

                                        <?php
                                        echo htmlspecialchars(
                                            !empty($phone)
                                                ? $phone
                                                : 'Not provided'
                                        );
                                        ?>

                                    </div>

                                </div>


                                <!-- Email -->

                                <div class="information-field">

                                    <label>
                                        Primary Email Address
                                    </label>

                                    <div class="information-value">

                                        <?php
                                        echo htmlspecialchars(
                                            !empty($email)
                                                ? $email
                                                : 'Not provided'
                                        );
                                        ?>

                                    </div>

                                </div>


                                <!-- Emergency Contact -->

                                <div class="information-field full-width">

                                    <label>
                                        Emergency Alternative Contact
                                    </label>

                                    <div class="information-value">

                                        <?php
                                        echo htmlspecialchars(
                                            !empty($emergencyNo)
                                                ? $emergencyNo
                                                : 'Not provided'
                                        );
                                        ?>

                                    </div>

                                </div>


                                <!-- Address -->

                                <div class="information-field full-width">

                                    <label>
                                        Residential Address
                                    </label>

                                    <div class="information-value address-value">

                                        <?php
                                        echo htmlspecialchars(
                                            !empty($address)
                                                ? $address
                                                : 'Not provided'
                                        );
                                        ?>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- =================================================
                     RIGHT COLUMN
                     ================================================= -->

                <div class="profile-right-column">


                    <!-- =================================================
                         PASSWORD & SECURITY
                         ================================================= -->

                    <div class="profile-card security-card">


                        <div class="profile-card-header">

                            <div class="profile-card-title">

                                <div class="section-icon">
                                    🔒
                                </div>

                                <h2>
                                    Password & Security
                                </h2>

                            </div>


                            <span class="security-shield">
                                ♢
                            </span>

                        </div>


                        <div class="profile-divider"></div>


                        <div class="password-row">

                            <div class="password-information">

                                <div class="password-dots">
                                    • • • • • • • • • • • •
                                </div>

                                <span class="password-note">
                                    Password is securely stored
                                </span>

                            </div>


                            <button
                                type="button"
                                class="change-password-button"
                                onclick="showPasswordMessage()"
                            >
                                Change Password
                            </button>

                        </div>


                        <div class="security-description">

                            <span class="information-icon">
                                ⓘ
                            </span>

                            <p>
                                Keep your account credentials secure to
                                protect your pet health records.
                            </p>

                        </div>

                    </div>


                    <!-- =================================================
                         ACCOUNT INFORMATION
                         ================================================= -->

                    <div class="profile-card account-card">


                        <div class="profile-card-header">

                            <div class="profile-card-title">

                                <div class="section-icon">
                                    ▣
                                </div>

                                <h2>
                                    Account Information
                                </h2>

                            </div>

                        </div>


                        <div class="profile-divider"></div>


                        <div class="account-information-list">


                            <!-- Account Type -->

                            <div class="account-row">

                                <span>
                                    Account Type
                                </span>

                                <strong>
                                    Pet Owner
                                </strong>

                            </div>


                            <!-- Account ID -->

                            <div class="account-row">

                                <span>
                                    Account ID
                                </span>

                                <strong>
                                    #HP-<?php echo htmlspecialchars($user->user_id ?? ''); ?>
                                </strong>

                            </div>


                            <!-- Status -->

                            <div class="account-row">

                                <span>
                                    Status
                                </span>

                                <strong class="active-account-status">

                                    <span></span>

                                    <?php echo htmlspecialchars($accountStatus); ?>

                                </strong>

                            </div>


                        </div>


                        <!-- Privacy message -->

                        <div class="privacy-message">

                            <span class="privacy-icon">
                                ♢
                            </span>

                            <p>
                                Your personal information and pet records
                                are protected within the Happy Paws system.
                            </p>

                        </div>

                    </div>


                </div>


            </div>


        </section>


    </main>


</div>


<!-- =====================================================
     SMALL PAGE MESSAGES
     ===================================================== -->
<script src="<?php echo URLROOT; ?>/js/petowner.js"></script>

<script>

function showProfileMessage()
{
    alert(
        "Profile editing will be available here."
    );
}


function showPasswordMessage()
{
    alert(
        "Password change will be available here."
    );
}

</script>


</body>

</html>