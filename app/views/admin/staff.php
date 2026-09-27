<div class="subpage-card">

    <div class="subpage-header">
        <h1 class="subpage-title">
            Staff Management
        </h1>

        <a href="<?php echo URLROOT; ?>/admin/addStaff" style="text-decoration: none;">
            <button
            class="panel-action-btn"
            style="border:none; cursor:pointer; font-size:0.9rem; padding:8px 16px;">
            + Add New Staff Member
            </button>
        </a>
        
    </div>

    <div class="metrics-row" style="margin-bottom:24px;">
        <div class="metric-card">
            <span class="metric-card-label">
                Total Staff
            </span>

            <span class="metric-card-value">
                <?php echo $data['totalStaff']; ?>
            </span>
        </div>

        <div class="metric-card">
            <span class="metric-card-label">
                Veterinarians
            </span>

            <span class="metric-card-value">
                <?php echo $data['veterinarianCount']; ?>
            </span>
        </div>

        <div class="metric-card">
            <span class="metric-card-label">
                Staff
            </span>

            <span class="metric-card-value">
                <?php echo $data['staffCount']; ?>
            </span>
        </div>

        <div class="metric-card">
            <span class="metric-card-label">
                Active Staff
            </span>

            <span class="metric-card-value">
                <?php echo $data['activeStaffCount']; ?>
            </span>
        </div>
    </div>


    <table class="report-table">
        <thead>
            <tr>
                <th>Staff ID</th>
                <th>Staff Member</th>
                <th>Role</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>


        <tbody>
        <?php foreach ($data['staffList'] as $staff): ?>
            <tr>
                <td>
                    <strong>
                        STF-<?php echo str_pad($staff->user_id, 3, '0', STR_PAD_LEFT); ?>
                    </strong>
                </td>

                <td>
                    <div class="staff-profile-cell">
                            <div class="staff-name">
                                <?php 
                                echo htmlspecialchars($staff->first_name . ' ' . $staff->last_name);
                                ?>
                            </div>
                    </div>
                </td>

                <td>
                    <span class="role-badge">
                        <?php
                        echo $staff->role === 'veterinarian'
                            ? 'Veterinarian'
                            : 'Staff';
                        ?>
                    </span>
                </td>

                <td>
                    <?php echo htmlspecialchars($staff->phone_number ?? 'N/A'); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($staff->email); ?>
                </td>

                <td>
                    <span class="status-badge
                        <?php echo $staff->status === 'Active'
                            ? 'active'
                            : 'on-leave'; ?>">
                        <?php echo htmlspecialchars($staff->status); ?>
                    </span>
                </td>

                <td>
                    <a
                        href="<?php echo URLROOT; ?>/admin/editStaff/<?php echo $staff->user_id; ?>"
                        style="color:#006f6a; font-weight:600; text-decoration:none; margin-right:12px;">
                        Edit
                    </a>

                    <a
                        href="<?php echo URLROOT; ?>/admin/removeStaff/<?php echo $staff->user_id; ?>"
                        onclick="return confirm('Are you sure you want to remove this staff member?');"
                        style="color:#ef4444; font-weight:600; text-decoration:none;">
                        Remove
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
</div>