<?php
$activePage = 'pets';

$showEditSuccess = false;
$editedPetName = '';

if (!empty($_SESSION['pet_edit_success'])) {

    $showEditSuccess = true;

    $editedPetName = $_SESSION['edited_pet_name'] ?? '';

    // Remove the message after reading it
    unset($_SESSION['pet_edit_success']);
    unset($_SESSION['edited_pet_name']);
}

?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner.css">
<link rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/topbar.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner-pets.css">


<div class="petowner-layout">

    <?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>


    <main class="petowner-main">

        <?php if ($showEditSuccess): ?>

            <div class="success-popup-overlay" id="successPopup">

                <div class="success-popup">

                    <div class="success-icon">
                        ✓
                    </div>

                    <h2>Pet Updated Successfully!</h2>

                    <p>
                        <?php echo htmlspecialchars($editedPetName); ?>
                        has been updated successfully.
                    </p>

                    <button
                        type="button"
                        class="success-popup-button"
                        onclick="closeSuccessPopup()"
                    >
                        Continue
                    </button>

                </div>

            </div>

        <?php endif; ?>

        <!-- Top bar -->
        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <!-- My Pets page -->
        <section class="pets-page">


            <!-- Header -->
            <div class="pets-header">

                <div>
                    <h1 class="pets-title">My Pets</h1>

                    <p class="pets-subtitle">
                        Manage all your registered dogs and cats.
                    </p>
                </div>


                <a
                    href="<?php echo URLROOT; ?>/petowner/registerPet"
                    class="register-pet-button"
                >
                    + &nbsp; Register New Pet
                </a>

            </div>


            <!-- Search -->
            <div class="pets-search-wrapper">

                <input
                    type="text"
                    id="petSearch"
                    class="pets-search"
                    placeholder="🔍  Search pets by name or breed..."
                >

            </div>


            <?php if (empty($pets)): ?>

                <!-- No pets -->
                <div class="no-pets">

                    <div class="no-pets-content">

                        <div class="no-pets-icon">
                            🐾
                        </div>

                        <h2 class="no-pets-title">
                            Add your first pet
                        </h2>

                        <p class="no-pets-text">
                            Register your dog or cat to start managing
                            their appointments and health records.
                        </p>

                        <a
                            href="<?php echo URLROOT; ?>/petowner/registerPet"
                            class="register-pet-button"
                        >
                            + &nbsp; Register New Pet
                        </a>

                    </div>

                </div>


            <?php else: ?>

                <!-- Pets -->
                <div class="pets-grid" id="petsGrid">

                    <?php foreach ($pets as $pet): ?>

                        <?php

                        /*
                         * Calculate the pet's age
                         * using the date of birth stored in the database.
                         */

                        $ageText = 'Age not available';

                        if (!empty($pet->date_of_birth)) {

                            $birthDate = new DateTime($pet->date_of_birth);
                            $today = new DateTime();

                            $age = $today->diff($birthDate);


                            if ($age->y > 0) {

                                $ageText = $age->y . ' ' .
                                    ($age->y == 1 ? 'Year' : 'Years');


                                if ($age->m > 0) {

                                    $ageText .= ' ' . $age->m . ' ' .
                                        ($age->m == 1 ? 'Month' : 'Months');
                                }

                            } elseif ($age->m > 0) {

                                $ageText = $age->m . ' ' .
                                    ($age->m == 1 ? 'Month' : 'Months');

                            } else {

                                $ageText = $age->d . ' ' .
                                    ($age->d == 1 ? 'Day' : 'Days');
                            }
                        }


                        /*
                         * Create a display pet ID.
                         *
                         * Example:
                         * Database ID 1 → HP-000001
                         * Database ID 25 → HP-000025
                         */

                        $displayPetId = 'HP-' . str_pad(
                            $pet->pet_id,
                            6,
                            '0',
                            STR_PAD_LEFT
                        );

                        ?>


                        <div
                            class="pet-card"
                            data-name="<?php echo htmlspecialchars(strtolower($pet->name)); ?>"
                            data-breed="<?php echo htmlspecialchars(strtolower($pet->breed)); ?>"
                        >

                            <div class="pet-card-top">


                                <!-- Pet image -->
                                <div class="pet-image">

                                    <!--
                                         Pet photos are not stored in the database.
                                         Therefore, display the placeholder.
                                    -->

                                    <div class="pet-image-placeholder"></div>

                                </div>


                                <!-- Information -->
                                <div class="pet-info">

                                    <div class="pet-name-row">

                                        <h2 class="pet-name">
                                            <?php echo htmlspecialchars($pet->name); ?>
                                        </h2>

                                        <span class="pet-paw">
                                            🐾
                                        </span>

                                    </div>


                                    <p class="pet-breed">

                                        <?php
                                        echo htmlspecialchars(
                                            $pet->breed ?: $pet->species
                                        );
                                        ?>

                                    </p>


                                    <p class="pet-details">

                                        <?php echo htmlspecialchars($pet->gender); ?>

                                        &nbsp; • &nbsp;

                                        <?php echo htmlspecialchars($ageText); ?>

                                        &nbsp; • &nbsp;

                                        <?php echo htmlspecialchars($displayPetId); ?>

                                    </p>

                                </div>


                                <!-- Status -->
                                <div class="pet-status status-healthy">

                                    <span class="status-dot"></span>

                                    Active

                                </div>


                                <!-- Menu -->
                                <button
                                    type="button"
                                    class="pet-menu"
                                >
                                    ⋮
                                </button>

                            </div>


                            <!-- Divider -->
                            <div class="pet-card-divider"></div>


                            <!-- Buttons -->
                            <div class="pet-card-actions">

                                <a
                                    href="<?php echo URLROOT; ?>/petowner/viewPet/<?php echo $pet->pet_id; ?>"
                                    class="pet-button pet-button-primary"
                                >
                                    View Profile
                                </a>

                                <a
                                    href="<?php echo URLROOT; ?>/petowner/editPet/<?php echo $pet->pet_id; ?>"
                                    class="pet-button pet-button-secondary"
                                >
                                    Edit
                                </a>

                            </div>

                        </div>


                    <?php endforeach; ?>

                </div>

            <?php endif; ?>


        </section>

    </main>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('petSearch');

    if (!searchInput) {
        return;
    }


    searchInput.addEventListener('input', function () {

        const searchValue = this.value.toLowerCase().trim();

        const cards = document.querySelectorAll('.pet-card');


        cards.forEach(function (card) {

            const name = card.dataset.name || '';
            const breed = card.dataset.breed || '';


            if (
                name.includes(searchValue) ||
                breed.includes(searchValue)
            ) {

                card.style.display = '';

            } else {

                card.style.display = 'none';

            }

        });

    });

});

function closeSuccessPopup() {

    const popup = document.getElementById('successPopup');

    if (popup) {
        popup.remove();
    }

}

</script>