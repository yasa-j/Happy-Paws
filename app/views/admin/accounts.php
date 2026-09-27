<div class="subpage-card">
    <div class="subpage-header">
        <h1 class="subpage-title">
            Staff Accounts & Security Credentials
        </h1>

        <a href="<?php echo URLROOT; ?>/admin/addStaff">
            <button
            class="panel-action-btn"
            style="border:none; cursor:pointer; font-size:0.9rem; padding:8px 16px;">
            Create Account
            </button>
        </a>
        
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Account Username</th>
                <th>Staff Name</th>
                <th>Access Level</th>
                <th>Email</th>
                <th>Account Status</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($data['accounts'] as $account): ?>
            <tr>
                <td>
                    <strong>
                        <?php echo htmlspecialchars($account->email); ?>
                    </strong>
                </td>

                <td>
                    <?php
                    echo htmlspecialchars($account->first_name . ' ' . $account->last_name);
                    ?>
                </td>

                <td>
                    <span class="role-badge">
                        <?php
                        echo $account->role === 'veterinarian'
                            ? 'Veterinarian'
                            : 'Staff';
                        ?>
                    </span>
                </td>

                <td>
                    <?php echo htmlspecialchars($account->email); ?>
                </td>

                <td>
                    <span class="status-badge active">
                        <?php echo htmlspecialchars($account->status); ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>