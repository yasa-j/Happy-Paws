<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/auth.css">

<div class="auth-page">

    <div class="auth-card">

        <!-- Logo / Branding -->
        <div class="auth-brand">

            <div class="auth-logo">
                🐾
            </div>

            <div>
                <h1>Happy Paws</h1>
                <span>Pet Healthcare</span>
            </div>

        </div>


        <!-- Heading -->
        <div class="auth-heading">

            <h2>Welcome Back!</h2>

            <p>
                Sign in to access your pet's healthcare portal.
            </p>

        </div>


        <!-- Login Form -->
        <form
            action="<?php echo URLROOT; ?>/auth/login"
            method="POST"
            id="loginForm"
        >

            <!-- Email / Phone Number -->
            <div class="auth-form-group">

                <label for="login">
                    Email Address or Mobile Number
                </label>

                <div class="auth-input-wrapper">

                    <span class="auth-input-icon">
                        ✉
                    </span>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        placeholder="owner@example.com or +94771234567"
                        value="<?php echo htmlspecialchars($data['login'] ?? ''); ?>"
                        class="<?php echo (!empty($data['login_err'])) ? 'auth-input-error' : ''; ?>"
                        required
                    >

                </div>

                <?php if (!empty($data['login_err'])): ?>

                    <small class="auth-field-error">
                        <?php echo htmlspecialchars($data['login_err']); ?>
                    </small>

                <?php endif; ?>

            </div>


            <!-- Password -->
            <div class="auth-form-group">

                <div class="auth-label-row">

                    <label for="password">
                        Password
                    </label>

                    <a href="#" class="forgot-password">
                        Forgot Password?
                    </a>

                </div>

                <div class="auth-input-wrapper">

                    <span class="auth-input-icon">
                        🔒
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        class="<?php echo (!empty($data['password_err'])) ? 'auth-input-error' : ''; ?>"
                        required
                    >

                    <button
                        type="button"
                        class="auth-password-toggle"
                        onclick="togglePassword('password', this)"
                        aria-label="Show password"
                    >
                        ◉
                    </button>

                </div>

                <?php if (!empty($data['password_err'])): ?>

                    <small class="auth-field-error">
                        <?php echo htmlspecialchars($data['password_err']); ?>
                    </small>

                <?php endif; ?>

            </div>


            <!-- Remember Me -->
            <div class="auth-options">

                <label class="auth-remember">

                    <input
                        type="checkbox"
                        name="remember"
                    >

                    <span>
                        Remember me
                    </span>

                </label>

            </div>


            <!-- Login Button -->
            <button
                type="submit"
                class="auth-submit-btn"
            >
                Login
            </button>


            <!-- Divider -->
            <div class="auth-divider">

                <span></span>

                <small>OR</small>

                <span></span>

            </div>


            <!-- Register -->
            <div class="auth-register-link">

                <span>
                    New to Happy Paws?
                </span>

                <a href="<?php echo URLROOT; ?>/auth/register">
                    Register Now
                </a>

            </div>

        </form>


        <!-- Back to Home -->
        <a
            href="<?php echo URLROOT; ?>/"
            class="back-home"
        >
            ← Back to Home
        </a>

    </div>

</div>


<script src="<?php echo URLROOT; ?>/public/js/auth.js"></script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>