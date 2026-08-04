<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<section class="hero-section">
    <div class="hero-card">
        <h1>Welcome to Happy Paws</h1>
        <p>Making Pet Care Simple - Comprehensive Veterinary & Appointment Management System.</p>
        <div class="hero-buttons">
            <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-primary">Pet Owner Login</a>
            <a href="<?php echo URLROOT; ?>/auth/login" class="btn btn-secondary">Clinic Staff Portal</a>
        </div>
    </div>
</section>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
