<?php
$activePage = 'pets';
?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/topbar.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner-pets.css">


<div class="petowner-layout">

    <?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>


    <main class="petowner-main">

        <!-- Top bar -->
        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <section class="pets-page">

            <!-- Page Header -->
            <div class="pets-header">

                <div>
                    <h1 class="pets-title">
                        <?php echo htmlspecialchars($pet->name); ?>
                    </h1>

                    <p class="pets-subtitle">
                        View your pet's information.
                    </p>
                </div>

                <a
                    href="<?php echo URLROOT; ?>/petowner/pets"
                    class="register-pet-button"
                >
                    ← &nbsp; Back to My Pets
                </a>

            </div>


            <!-- Pet Profile -->
            <div class="pet-profile-card">

                <!-- Pet Image -->
                <div class="pet-profile-image">

                    <div class="pet-image-placeholder"></div>

                </div>


                <!-- Pet Information -->
                <div class="pet-profile-info">

                    <h2>
                        <?php echo htmlspecialchars($pet->name); ?>
                    </h2>

                    <p class="pet-profile-species">
                        <?php echo htmlspecialchars($pet->species); ?>
                    </p>


                    <div class="pet-profile-details">

                        <div class="profile-detail">
                            <strong>Breed</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->breed); ?>
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Gender</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->gender); ?>
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Date of Birth</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->date_of_birth); ?>
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Weight</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->weight_kg); ?>
                                kg
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Color</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->color ?: 'Not provided'); ?>
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Microchip Number</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->microchip_number ?: 'Not provided'); ?>
                            </span>
                        </div>


                        <div class="profile-detail">
                            <strong>Allergies</strong>
                            <span>
                                <?php echo htmlspecialchars($pet->allergies ?: 'None recorded'); ?>
                            </span>
                        </div>

                    </div>


                    <!-- Action Buttons -->
                    <div class="pet-profile-actions">

                        <!-- Edit -->
                        <a
                            href="<?php echo URLROOT; ?>/petowner/editPet/<?php echo $pet->pet_id; ?>"
                            class="pet-button pet-button-primary"
                        >
                            Edit Pet
                        </a>


                        <!-- Delete -->
                        <form
                            action="<?php echo URLROOT; ?>/petowner/deletePet/<?php echo $pet->pet_id; ?>"
                            method="POST"
                            onsubmit="return confirmDelete();"
                        >

                            <button
                                type="submit"
                                class="pet-button pet-button-danger"
                            >
                                Delete Pet
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </section>

    </main>

</div>


<script>

function confirmDelete()
{
    return confirm(
        "Are you sure you want to delete <?php echo htmlspecialchars($pet->name, ENT_QUOTES); ?>? This action cannot be undone."
    );
}

</script>