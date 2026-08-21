<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<section class="hero-section">
    <div class="hero-card">
        <h1>Your Trusted Partner in <br>Pet Health Care</h1>
        <h3>Manage appointments, access your pet's medical records, <br>
            receive vaccination reminders, and stay connected with trusted veterinary care
        <br>All in one secure platform</h3>
        
        <a href="<?php echo URLROOT; ?>/auth/register">Register Now</a>
        
        <div class="care-tools">
            <span>COMPREHENSIVE CARE TOOLS</span>
            <div class="care-tags">
                <span>Book Appointments</span>
                <span>Medical Records</span>
                <span>Vaccination Reminders</span>
                <span>Pet Profiles</span>
            </div>
        </div>
    </div>

    <div class="hero-card-login">
        <h1>Pet Owner Login</h1>
        <p>Access your pet's healthcare portal</p>
        <div class="hero-buttons">
            <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-primary">Pet Owner Login</a>
            <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-secondary">Clinic Staff Portal</a>
        </div>
    </div>
</section>

<section class="about-section">
    <div class="about-card">
        <h1>Contact Us</h1>
        <h3>We are Here to Help You and Your Pets</h3>
        <p>Have questions about our services or need to book an appointment? <br>
            Reach out to our friendly team today</p>
        <div class="about-buttons">
            <div class="btn btn-">
                <h3>Call Us</h3>
                <p>077 555 8888</p>
            </div>
            <div class="btn whatsapp">
                <h3>WhatsApp Us</h3>
                <p>077 555 8888</p>
            </div>
            <div class="btn email">
                <h3>Email Us</h3>
                <p>077 555 8888</p>
            </div>
        </div>
    </div>
</section>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
