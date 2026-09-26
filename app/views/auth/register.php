<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/css/auth.css">

<div class="register-page">

    <div class="register-card">

        <!-- Page Heading -->
        <div class="register-heading">

            <h1>Create Your Happy Paws Account</h1>

            <p>
                Join Happy Paws and make managing your pet's healthcare simple.
            </p>

        </div>


        <!-- Registration Form -->
        <form
            action="<?php echo URLROOT; ?>/auth/register"
            method="POST"
            id="registerForm"
        >


            <!-- Personal Information -->
            <div class="form-section">

                <h2>Personal Information</h2>

                <div class="section-line"></div>


                <!-- First Name and Last Name -->
                <div class="form-row">

                    <!-- First Name -->
                    <div class="form-group">

                        <label for="first_name">
                            First Name
                        </label>

                        <div class="input-wrapper">

                            <span class="input-icon">♙</span>

                            <input
                                type="text"
                                id="first_name"
                                name="first_name"
                                placeholder="John"
                                value="<?php echo htmlspecialchars($data['first_name']); ?>"
                                class="<?php echo (!empty($data['first_name_err'])) ? 'input-error' : ''; ?>"
                                required
                            >

                        </div>

                        <?php if (!empty($data['first_name_err'])): ?>

                            <small class="field-error">
                                <?php echo $data['first_name_err']; ?>
                            </small>

                        <?php endif; ?>

                    </div>


                    <!-- Last Name -->
                    <div class="form-group">

                        <label for="last_name">
                            Last Name
                        </label>

                        <div class="input-wrapper">

                            <span class="input-icon">♙</span>

                            <input
                                type="text"
                                id="last_name"
                                name="last_name"
                                placeholder="Doe"
                                value="<?php echo htmlspecialchars($data['last_name']); ?>"
                                class="<?php echo (!empty($data['last_name_err'])) ? 'input-error' : ''; ?>"
                                required
                            >

                        </div>

                        <?php if (!empty($data['last_name_err'])): ?>

                            <small class="field-error">
                                <?php echo $data['last_name_err']; ?>
                            </small>

                        <?php endif; ?>

                    </div>

                </div>


                <!-- Email -->
                <div class="form-group">

                    <label for="email">
                        Email Address
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">✉</span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="john.doe@example.com"
                            value="<?php echo htmlspecialchars($data['email']); ?>"
                            class="<?php echo (!empty($data['email_err'])) ? 'input-error' : ''; ?>"
                            required
                        >

                    </div>


                    <?php if (!empty($data['email_err'])): ?>

                        <small class="field-error">
                            <?php echo $data['email_err']; ?>
                        </small>

                    <?php else: ?>

                        <small>
                            We'll never share your email with anyone else.
                        </small>

                    <?php endif; ?>

                </div>


                <!-- Mobile Number -->
                <div class="form-group">

                    <label for="phone">
                        Mobile Number
                    </label>

                    <div class="phone-wrapper">

                        <div class="country-code">

                            <span>⌕</span>

                            <span>+94</span>

                        </div>

                        <input
                            type="tel"
                            id="phone_number"
                            name="phone_number"
                            placeholder="77 123 4567"
                            value="<?php echo htmlspecialchars($data['phone_number']); ?>"
                            maxlength="9"
                            required
                        >

                    </div>


                    <?php if (!empty($data['phone_err'])): ?>

                        <small class="field-error">
                            <?php echo $data['phone_err']; ?>
                        </small>

                    <?php endif; ?>

                </div>
                <!-- Address -->
                <div class="form-group">

                    <label for="address">
                        Address
                    </label>

                    <div class="address-wrapper">
                        <textarea
                            id="address"
                            name="address"
                            rows="4"
                            placeholder="Enter your residential address"
                        ><?php echo htmlspecialchars($data['address'] ?? ''); ?></textarea>
                    </div>

                    <?php if (!empty($data['address_err'])): ?>

                        <small class="field-error">
                            <?php echo $data['address_err']; ?>
                        </small>

                    <?php endif; ?>

                </div>
            </div>



            <!-- Account Security -->
            <div class="form-section security-section">

                <h2>Account Security</h2>

                <div class="section-line"></div>


                <!-- Password -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">🔒</span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            class="<?php echo (!empty($data['password_err'])) ? 'input-error' : ''; ?>"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('password', this)"
                        >
                            ◉
                        </button>

                    </div>


                    <?php if (!empty($data['password_err'])): ?>

                        <small class="field-error">
                            <?php echo $data['password_err']; ?>
                        </small>

                    <?php else: ?>

                        <small>
                            Use at least 8 characters, including a number
                            and a special character.
                        </small>

                    <?php endif; ?>

                </div>


                <!-- Confirm Password -->
                <div class="form-group">

                    <label for="confirm_password">
                        Confirm Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">🔒</span>

                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            placeholder="••••••••"
                            class="<?php echo (!empty($data['confirm_password_err'])) ? 'input-error' : ''; ?>"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword('confirm_password', this)"
                        >
                            ◉
                        </button>

                    </div>


                    <?php if (!empty($data['confirm_password_err'])): ?>

                        <small class="field-error">
                            <?php echo $data['confirm_password_err']; ?>
                        </small>

                    <?php endif; ?>

                </div>

            </div>



            <!-- Terms and Conditions -->
            <div class="terms-section">

                <label class="terms-label">

                    <input
                        type="checkbox"
                        name="terms"
                        value="1"
                        <?php echo !empty($data['terms']) ? 'checked' : ''; ?>
                    >

                    <span>

                        I agree to the Happy Paws

                        <a href="#">
                            Terms of Service
                        </a>

                        and

                        <a href="#">
                            Privacy Policy
                        </a>

                    </span>

                </label>


                <?php if (!empty($data['terms_err'])): ?>

                    <small class="field-error terms-error">
                        <?php echo $data['terms_err']; ?>
                    </small>

                <?php endif; ?>

            </div>



            <!-- General Registration Error -->
            <?php if (!empty($data['register_error'])): ?>

                <div class="form-error">

                    <?php echo $data['register_error']; ?>

                </div>

            <?php endif; ?>



            <!-- Create Account Button -->
            <button
                type="submit"
                class="create-account-btn"
            >
                Create Account
            </button>



            <!-- Login Link -->
            <div class="login-link">

                Already have an account?

                <a href="<?php echo URLROOT; ?>/auth/login">
                    Login
                </a>

            </div>

        </form>

    </div>

</div>



<!-- =========================================================
     Registration Success Popup
     ========================================================= -->

<?php if (!empty($data['register_success'])): ?>

    <div class="success-overlay" id="successPopup">

        <div class="success-popup">

            <!-- Success Icon -->
            <div class="success-icon">
                ✓
            </div>


            <!-- Heading -->
            <h2>
                Account Created!
            </h2>


            <!-- Message -->
            <p>
                Your Happy Paws account has been created successfully.
                You can now log in and start managing your pet's healthcare.
            </p>


            <!-- Login Button -->
            <button
                type="button"
                class="popup-login-btn"
                onclick="window.location.href='<?php echo URLROOT; ?>/'"
            >
                Go to Login
            </button>

        </div>

    </div>

<?php endif; ?>



<!-- Registration JavaScript -->
<script src="<?php echo URLROOT; ?>/js/auth.js"></script>


<?php require_once APPROOT . '/views/layouts/footer.php'; ?>