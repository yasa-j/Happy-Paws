<?php
$activePage = 'pets';
?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/petowner.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/topbar.css">
<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/edit-pet.css">


<div class="petowner-layout">

    <?php require_once APPROOT . '/views/layouts/petowner-sidebar.php'; ?>

    <main class="petowner-main">

        <!-- Top bar -->
        <?php require_once APPROOT . '/views/layouts/petowner-topbar.php'; ?>


        <section class="edit-pet-page">

            <!-- Header -->
            <div class="edit-pet-header">

                <h1 class="edit-pet-title">
                    Edit Pet
                </h1>

                <p class="edit-pet-subtitle">
                    Update the basic information of your pet.
                </p>

            </div>


            <!-- Edit Form -->
            <div class="edit-pet-card">

                <h2 class="form-section-title">
                    Pet Information
                </h2>


                <form
                    method="POST"
                    action="<?php echo URLROOT; ?>/petowner/editPet/<?php echo $pet->pet_id; ?>"
                >

                    <div class="form-grid">


                        <!-- Pet Name -->
                        <div class="form-group">

                            <label for="name">
                                Pet Name
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="petName"
                                value="<?php echo htmlspecialchars($pet->name); ?>"
                                required
                            >

                        </div>


                        <!-- Species -->
                        <div class="form-group">

                            <label for="species">
                                Species
                            </label>

                            <select
                                id="species"
                                name="petType"
                                required
                            >

                                <option value="Dog"
                                    <?php echo ($pet->species === 'Dog') ? 'selected' : ''; ?>>
                                    Dog
                                </option>

                                <option value="Cat"
                                    <?php echo ($pet->species === 'Cat') ? 'selected' : ''; ?>>
                                    Cat
                                </option>

                            </select>

                        </div>


                        <!-- Breed -->
                        <div class="form-group">

                            <label for="breed">
                                Breed
                            </label>

                            <input
                                type="text"
                                id="breed"
                                name="breed"
                                value="<?php echo htmlspecialchars($pet->breed); ?>"
                                required
                            >

                        </div>


                        <!-- Gender -->
                        <div class="form-group">

                            <label for="gender">
                                Gender
                            </label>

                            <select
                                id="gender"
                                name="gender"
                                required
                            >

                                <option value="Male"
                                    <?php echo ($pet->gender === 'Male') ? 'selected' : ''; ?>>
                                    Male
                                </option>

                                <option value="Female"
                                    <?php echo ($pet->gender === 'Female') ? 'selected' : ''; ?>>
                                    Female
                                </option>

                            </select>

                        </div>


                        <!-- Date of Birth -->
                        <div class="form-group">

                            <label for="date_of_birth">
                                Date of Birth
                            </label>

                            <input
                                type="date"
                                id="date_of_birth"
                                name="dateOfBirth"
                                value="<?php echo htmlspecialchars($pet->date_of_birth); ?>"
                                required
                            >

                        </div>


                        <!-- Weight -->
                        <div class="form-group">

                            <label for="weight">
                                Weight (kg)
                            </label>

                            <input
                                type="number"
                                id="weight_kg"
                                name="weight"
                                step="0.1"
                                min="0"
                                value="<?php echo htmlspecialchars($pet->weight_kg ?? ''); ?>"
                            >

                        </div>


                        <!-- Color -->
                        <div class="form-group">

                            <label for="color">
                                Color
                            </label>

                            <input
                                type="text"
                                id="color"
                                name="color"
                                value="<?php echo htmlspecialchars($pet->color); ?>"
                            >

                        </div>


                        <!-- Microchip -->
                        <div class="form-group">

                            <label for="microchip_number">
                                Microchip Number
                            </label>

                            <input
                                type="text"
                                id="microchip_number"
                                name="microchipNumber"
                                value="<?php echo htmlspecialchars($pet->microchip_number); ?>"
                            >

                        </div>


                        <!-- Allergies -->
                        <div class="form-group full-width">

                            <label for="allergies">
                                Allergies
                            </label>

                            <textarea
                                id="allergies"
                                name="allergies"
                                placeholder="Enter any known allergies..."
                            ><?php echo htmlspecialchars($pet->allergies); ?></textarea>

                        </div>

                    </div>


                    <!-- Photo -->
                    <div class="photo-section">

                        <h2 class="form-section-title">
                            Pet Photo
                        </h2>

                        <div class="photo-upload">

                            <p>
                                Upload a new photo of your pet (optional).
                            </p>

                            <input
                                type="file"
                                name="pet_photo"
                                accept="image/*"
                            >

                            <div class="form-note">
                                Photo upload is optional and is not stored in the database.
                            </div>

                        </div>

                    </div>


                    <!-- Buttons -->
                    <div class="form-actions">

                        <a
                            href="<?php echo URLROOT; ?>/petowner/pets"
                            class="cancel-button"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="update-button"
                        >
                            Update Pet
                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

</div>