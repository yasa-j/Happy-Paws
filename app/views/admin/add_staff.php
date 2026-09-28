<?php if (!empty($data['error'])): ?>

    <div class="form-error">
        <?php echo htmlspecialchars($data['error']); ?>
    </div>

<?php endif; ?>

<div class="subpage-card">

    <div class="subpage-header">
        <h1 class="subpage-title">
            Add New Staff Member
        </h1>

        <a href="<?php echo URLROOT; ?>/admin/staff" style="text-decoration: none;">
            <button class="back-button">
                Back
            </button>
        </a>
    </div>

    <form method="POST" action="<?php echo URLROOT; ?>/admin/createStaff">

        <div>
            <label>First Name</label>
            <input type="text" name="first_name" required>
        </div>

        <div>
            <label>Last Name</label>
            <input type="text" name="last_name" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" required>
        </div>

        <div>
            <label>Phone Number</label>
            <div>
                <span>+94</span>
                <input type="text" 
                    name="phone_number"
                    maxlength="9"
                    minlength="9"
                    pattern="[0-9]{9}"
                    inputmode="numeric"
                    placeholder="771234567"
                    required >
            </div>
        </div>

        <div>
            <label>Role</label>
            <select name="role" required>
                <option value="veterinarian">Veterinarian</option>
                <option value="staff">Staff</option>
            </select>
        </div>

        <div>
            <label>Status</label>
            <select name="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select>
        </div>

        <div>
            <label>Address</label>
            <input type="text" name="address">
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-buttons">
            <button type="reset" class="reset-button">
                Reset
            </button>
            
            <button type="submit" class="submit-button">
                Create Staff Profile
            </button>
        </div>
        

    </form>

</div>