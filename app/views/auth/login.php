<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Sign In to Happy Paws</h2>
        <form action="<?php echo URLROOT; ?>/auth/login" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" required>
                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
