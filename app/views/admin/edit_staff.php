<div class="subpage-card">

    <div class="subpage-header">
        <h1 class="subpage-title">
            Edit Staff Member
        </h1>
    </div>

    <form method="POST"
          action="<?php echo URLROOT; ?>/admin/updateStaff/<?php echo $data['staff']->user_id; ?>">

        <div>
            <label>First Name</label>
            <input
                type="text"
                name="first_name"
                value="<?php echo htmlspecialchars($data['staff']->first_name); ?>"
                required>
        </div>

        <div>
            <label>Last Name</label>
            <input
                type="text"
                name="last_name"
                value="<?php echo htmlspecialchars($data['staff']->last_name); ?>"
                required>
        </div>

        <div>
            <label>Email</label>
            <input
                type="email"
                name="email"
                value="<?php echo htmlspecialchars($data['staff']->email); ?>"
                required>
        </div>

        <div>
            <label>Phone Number</label>
            <input
                type="text"
                name="phone_number"
                value="<?php echo htmlspecialchars($data['staff']->phone_number ?? ''); ?>">
        </div>

        <div>
            <label>Role</label>

            <select name="role" required>
                <option value="staff"
                    <?php echo $data['staff']->role === 'staff' ? 'selected' : ''; ?>>
                    Staff
                </option>

                <option value="veterinarian"
                    <?php echo $data['staff']->role === 'veterinarian' ? 'selected' : ''; ?>>
                    Veterinarian
                </option>
            </select>
        </div>

        <div>
            <label>Status</label>

            <select name="status" required>
                <option value="Active"
                    <?php echo $data['staff']->status === 'Active' ? 'selected' : ''; ?>>
                    Active
                </option>

                <option value="Inactive"
                    <?php echo $data['staff']->status === 'Inactive' ? 'selected' : ''; ?>>
                    Inactive
                </option>

                <option value="Suspended"
                    <?php echo $data['staff']->status === 'Suspended' ? 'selected' : ''; ?>>
                    Suspended
                </option>
            </select>
        </div>

        <div style="margin-top:20px;" class="form-buttons">

            <button type="submit" class="panel-action-btn" style="background-color: #a39011;">
                Save Changes
            </button>

            <a href="<?php echo URLROOT; ?>/admin/staff" style="text-decoration: none;">
                <button class="panel-action-btn" style="background-color:  #a39011;">
                    Cancel
                </button>
            </a>
        </div>
    </form>
</div>