<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Happy Paws') ?></title>

    <link rel="stylesheet" href="css/home.css">
</head>

<body>

<!-- =========================
     NAVIGATION
========================= -->

<header class="navbar" id="home">

    <div class="nav-container">

        <a href="#home" class="logo">
            <div class="logo-icon">🐾</div>
            <span>Happy Paws</span>
        </a>

        <nav class="nav-links">

            <a href="#home" class="nav-link active">
                Home
            </a>

            <a href="#about" class="nav-link">
                About Us
            </a>

            <a href="#services" class="nav-link">
                Services
            </a>

            <a href="#contact" class="nav-link">
                Contact
            </a>

        </nav>

        <a href="#login" class="login-nav-btn">
            Login
        </a>

    </div>

</header>


<main>

    <!-- =========================
         HERO SECTION
    ========================= -->

    <section class="hero-section" id="home-section">

        <div class="hero-background"></div>

        <div class="hero-container">

            <!-- LEFT SIDE -->

            <div class="hero-content">

                <span class="hero-small-title">
                    HAPPY PAWS VETERINARY CARE
                </span>

                <h1>
                    Your Trusted Partner in
                    <span>Pet Healthcare</span>
                </h1>

                <p class="hero-description">
                    Manage appointments, access your pet's medical records,
                    receive vaccination reminders, and stay connected with
                    trusted veterinary care—all in one secure platform.
                </p>

                <a href="#register" class="primary-btn">
                    Register Now
                </a>


                <div class="hero-divider"></div>


                <span class="care-title">
                    COMPREHENSIVE CARE TOOLS
                </span>

                <div class="feature-pills">

                    <span class="feature-pill">
                        🗓 Book Appointments
                    </span>

                    <span class="feature-pill">
                        📋 Medical Records
                    </span>

                    <span class="feature-pill">
                        💉 Vaccination Reminders
                    </span>

                    <span class="feature-pill">
                        🐾 Pet Profiles
                    </span>

                </div>

            </div>


            <!-- LOGIN CARD -->

            <div class="login-card" id="login">

                <h2>Pet Owner Login</h2>

                <p class="login-subtitle">
                    Access your pet's healthcare portal
                </p>

                <form action="#" method="POST">

                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="owner@example.com"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="password">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                        >

                    </div>


                    <div class="login-options">

                        <label class="remember">

                            <input
                                type="checkbox"
                                name="remember"
                            >

                            <span>Remember Me</span>

                        </label>

                        <a href="#">
                            Forgot Password?
                        </a>

                    </div>


                    <button
                        type="submit"
                        class="login-btn"
                    >
                        Login
                    </button>

                </form>


                <div class="or-divider">

                    <span></span>

                    <small>OR</small>

                    <span></span>

                </div>


                <p class="register-text">
                    New to Happy Paws?

                    <a href="#register">
                        Register Now
                    </a>
                </p>

            </div>

        </div>

    </section>



    <!-- =========================
         ABOUT US
    ========================= -->

    <section class="about-section" id="about">

        <div class="section-container about-container">

            <div class="about-image">

                <img
                    src="images/vet-dog.jpg"
                    alt="Veterinarian caring for a dog"
                >

            </div>


            <div class="about-content">

                <span class="section-label">
                    ABOUT US
                </span>

                <h2>
                    Dedicated to Your
                    <span>Pet's Well-being</span>
                </h2>

                <p>
                    At Happy Paws, we blend high-end medical precision
                    with empathetic warmth. Our state-of-the-art facility
                    is designed to reduce stress for both pets and their
                    owners, providing a serene environment for
                    comprehensive veterinary care.
                </p>

                <p>
                    Our team of experienced professionals utilizes the
                    latest technology to ensure accurate diagnoses and
                    effective treatments, all while prioritizing the
                    comfort and happiness of your furry family members.
                </p>

                <a href="#services" class="text-link">
                    Learn more about our team
                    <span>→</span>
                </a>

            </div>

        </div>

    </section>



    <!-- =========================
         SERVICES
    ========================= -->

    <section class="services-section" id="services">

        <div class="section-container">

            <div class="section-heading">

                <span class="section-label">
                    OUR SERVICES
                </span>

                <h2>
                    Provide Complete Care for Every
                    <br>
                    Stage of Your Pet's Life
                </h2>

                <p>
                    From preventive healthcare to professional grooming
                    and quality pet essentials, Happy Paws offers
                    everything your furry companion needs under one roof.
                </p>

                <div class="service-tags">

                    <span>
                        🩺 Trusted Veterinary Care
                    </span>

                    <span>
                        💙 Modern Medical Facilities
                    </span>

                </div>

            </div>


            <div class="services-grid">

                <!-- SERVICE 1 -->

                <article class="service-card">

                    <div class="service-icon">
                        🩺
                    </div>

                    <h3>
                        Health Checkups
                    </h3>

                    <p>
                        Comprehensive examinations to monitor your
                        pet's health, detect illnesses early, and
                        ensure long-term wellness.
                    </p>

                    <a href="#">
                        Learn More →
                    </a>

                </article>


                <!-- SERVICE 2 -->

                <article class="service-card">

                    <div class="service-icon">
                        🛡
                    </div>

                    <h3>
                        Vaccinations
                    </h3>

                    <p>
                        Protect your pets with timely vaccination
                        programs and preventive healthcare tailored
                        to every stage of life.
                    </p>

                    <a href="#">
                        Learn More →
                    </a>

                </article>


                <!-- SERVICE 3 -->

                <article class="service-card">

                    <div class="service-icon">
                        ✂
                    </div>

                    <h3>
                        Grooming
                    </h3>

                    <p>
                        Complete grooming services including bathing,
                        coat care, nail trimming, ear cleaning,
                        and hygiene treatments.
                    </p>

                    <a href="#">
                        Learn More →
                    </a>

                </article>


                <!-- SERVICE 4 -->

                <article class="service-card">

                    <div class="service-icon">
                        🛍
                    </div>

                    <h3>
                        Pet Product Store
                    </h3>

                    <p>
                        Browse premium pet food, toys, accessories,
                        grooming supplies, and healthcare essentials
                        in one convenient place.
                    </p>

                    <a href="#">
                        Learn More →
                    </a>

                </article>

            </div>

        </div>

    </section>



    <!-- =========================
         REGISTER CTA
    ========================= -->

    <section class="register-section" id="register">

        <div class="register-container">

            <span class="section-label">
                JOIN HAPPY PAWS
            </span>

            <h2>
                Give Your Pet the Care They Deserve
            </h2>

            <p>
                Create your account and manage your pet's healthcare
                journey from one convenient platform.
            </p>

            <a href="#" class="primary-btn">
                Create Your Account
            </a>

        </div>

    </section>



    <!-- =========================
         CONTACT
    ========================= -->

    <section class="contact-section" id="contact">

        <div class="section-container">

            <div class="section-heading">

                <span class="section-label">
                    CONTACT US
                </span>

                <h2>
                    We're Here to Help You and Your Pets
                </h2>

                <p>
                    Have questions about our services or need to book
                    an appointment? Reach out to our friendly team today.
                </p>

            </div>


            <div class="contact-cards">

                <!-- PHONE -->

                <div class="contact-card">

                    <div class="contact-icon">
                        ☎
                    </div>

                    <h3>
                        Call Us
                    </h3>

                    <p>
                        +94 XX XXX XXXX
                    </p>

                    <a
                        href="tel:+94XXXXXXXXX"
                        class="contact-btn"
                    >
                        Call Now
                    </a>

                </div>


                <!-- WHATSAPP -->

                <div class="contact-card">

                    <div class="contact-icon">
                        💬
                    </div>

                    <h3>
                        WhatsApp Us
                    </h3>

                    <p>
                        +94 XX XXX XXXX
                    </p>

                    <a
                        href="#"
                        class="contact-btn whatsapp"
                    >
                        Message on WhatsApp
                    </a>

                </div>


                <!-- EMAIL -->

                <div class="contact-card">

                    <div class="contact-icon">
                        ✉
                    </div>

                    <h3>
                        Email Us
                    </h3>

                    <p>
                        support@happypaws.lk
                    </p>

                    <a
                        href="mailto:support@happypaws.lk"
                        class="contact-btn email"
                    >
                        Send an Email
                    </a>

                </div>

            </div>


            <!-- CLINIC INFORMATION -->

            <div class="clinic-info">

                <div class="clinic-detail">

                    <div class="clinic-icon">
                        ◷
                    </div>

                    <div>

                        <span>
                            CLINIC HOURS
                        </span>

                        <strong>
                            Mon - Sat: 8AM - 8PM
                        </strong>

                    </div>

                </div>


                <div class="clinic-detail">

                    <div class="clinic-icon">
                        📍
                    </div>

                    <div>

                        <span>
                            CLINIC LOCATION
                        </span>

                        <strong>
                            123 Pet Lane, Colombo 07
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>



<!-- =========================
     FOOTER
========================= -->

<footer class="footer">

    <div class="footer-container">

        <a href="#home" class="footer-logo">

            <div class="logo-icon">
                🐾
            </div>

            <span>
                Happy Paws
            </span>

        </a>

        <p>
            © 2026 Happy Paws Veterinary Clinic.
            All rights reserved.
        </p>

        <div class="footer-links">

            <a href="#">
                Privacy Policy
            </a>

            <a href="#">
                Terms of Service
            </a>

        </div>

    </div>

</footer>


<script src="js/home.js"></script>

</body>
</html>