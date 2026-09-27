<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Staff Login | Happy Paws</title>

    <!-- ONLY staff-login CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-login.css">
</head>

<body>

    <!-- TOP NAVBAR -->
    <header class="staff-navbar">

        <div class="staff-brand">
            <img
                src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                alt="Happy Paws Logo"
            >

            <span>HappyPaws</span>
        </div>

        <div class="staff-nav-icons">
            <span>?</span>
            <span>⚙</span>
        </div>

    </header>


    <!-- MAIN LOGIN AREA -->
    <main class="staff-login-page">

        <!-- LEFT SIDE -->
        <section class="staff-intro">

            <h1>
                Happy Paws
                <span>Staff Portal</span>
            </h1>

            <p>
                Secure access for veterinarians, receptionists,
                and clinic administrators.
            </p>

        </section>


        <!-- RIGHT SIDE LOGIN BOX -->
        <section class="staff-login-card">

            <div class="login-icon">
                ♙
            </div>

            <h2>Staff Login</h2>

            <p class="login-description">
                Enter your clinic credentials provided by the clinic owner.
            </p>
            <?php if (!empty($data['error'])): ?>
    <div class="login-error">
        <?php echo htmlspecialchars($data['error']); ?>
    </div>
<?php endif; ?>


            <form action="<?php echo URLROOT; ?>/index.php?url=staffauth/login" method="POST">

                <!-- USERNAME -->
                <div class="form-group">

                    <label for="username">
    Email Address
</label>

                    <div class="input-box">

                        <span class="input-icon">♙</span>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            placeholder="staff@happypaws.lk"
                            required
                        >

                    </div>

                </div>


                <!-- PASSWORD -->
                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <div class="input-box">

                        <span class="input-icon">🔒</span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        >

                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword()"
                        >
                            ◉
                        </button>

                    </div>

                </div>


                <!-- OPTIONS -->
                <div class="login-options">

                    <label class="remember">
                        <input type="checkbox" name="remember">
                        <span>Remember me</span>
                    </label>

                    <a href="#">
                        Forgot Password?
                    </a>

                </div>


                <!-- LOGIN BUTTON -->
                <button type="submit" class="login-button">
                    Login →
                </button>

            </form>


            <!-- INFORMATION BOX -->
            <div class="staff-info">

                <div class="info-icon">
                    ⓘ
                </div>

                <p>
                    Only authorized clinic staff can access this portal.
                    Staff accounts are created by the clinic owner or
                    system administrator. Pet owners should use the
                    Customer Portal instead.
                </p>

            </div>


            <!-- HELP -->
            <div class="login-help">

                Need help accessing your account?

                <a href="#">
                    Contact your clinic administrator.
                </a>

            </div>

        </section>

    </main>


    <!-- FOOTER -->
    <footer class="staff-footer">

        <div class="footer-brand">

            <img
                src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                alt="Happy Paws Logo"
            >

            <strong>Happy Paws</strong>

        </div>

        <p>
            © <?php echo date('Y'); ?> Happy Paws. All Rights Reserved.
        </p>

        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
        </div>

    </footer>


    <script src="<?php echo URLROOT; ?>/js/staff-login.js"></script>

</body>
</html>