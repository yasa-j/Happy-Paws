<?php
/**
 * =======================================================================
 * Happy Paws - User Dashboard View
 * =======================================================================
 * 
 * Displays authenticated user account details, registered pets, and
 * appointment history with responsive styling.
 * =======================================================================
 */
require_once APPROOT . '/views/layouts/header.php'; 
?>

<div class="dashboard-wrapper" style="max-width: 1100px; margin: 0 auto; padding: 20px 0;">

    <?php if (!empty($data['flash_success'])): ?>
        <div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 14px 18px; border-radius: 8px; margin-bottom: 24px; color: #065f46; font-weight: 500;">
            ✓ <?php echo htmlspecialchars($data['flash_success']); ?>
        </div>
    <?php endif; ?>

    <!-- User Profile Header Card -->
    <div style="background: #ffffff; border-radius: 12px; padding: 28px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 8px;">
                <h1 style="font-size: 1.8rem; margin: 0; color: #1e293b;">
                    Hello, <?php echo htmlspecialchars($data['user']->first_name . ' ' . $data['user']->last_name); ?>! 👋
                </h1>
                <span style="background: #e0f2fe; color: #0369a1; padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: capitalize;">
                    <?php echo htmlspecialchars(str_replace('_', ' ', $data['user']->role)); ?>
                </span>
            </div>
            <p style="color: #64748b; margin: 0; font-size: 0.95rem;">
                📧 <?php echo htmlspecialchars($data['user']->email); ?> &nbsp;|&nbsp; 
                📞 <?php echo htmlspecialchars($data['user']->phone_number ?? 'No phone provided'); ?>
            </p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="<?php echo URLROOT; ?>" style="background: #f1f5f9; color: #334155; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                Back to Home
            </a>
            <a href="<?php echo URLROOT; ?>/auth/logout" style="background: #fee2e2; color: #b91c1c; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                Logout
            </a>
        </div>
    </div>

    <!-- Overview Statistics Counter -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 35px;">
        <div style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); border-top: 4px solid #2b7fff;">
            <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Registered Pets</span>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-top: 6px;">
                <?php echo count($data['pets']); ?>
            </div>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); border-top: 4px solid #10b981;">
            <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Appointments</span>
            <div style="font-size: 2rem; font-weight: 700; color: #1e293b; margin-top: 6px;">
                <?php echo count($data['appointments']); ?>
            </div>
        </div>
        <div style="background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.04); border-top: 4px solid #8b5cf6;">
            <span style="font-size: 0.85rem; color: #64748b; text-transform: uppercase; font-weight: 600;">Account Status</span>
            <div style="font-size: 1.5rem; font-weight: 700; color: #10b981; margin-top: 8px;">
                <?php echo htmlspecialchars($data['user']->status); ?>
            </div>
        </div>
    </div>

    <!-- Section 1: Registered Pets -->
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 1.4rem; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            🐾 My Pets
        </h2>
        
        <?php if (!empty($data['pets'])): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                <?php foreach ($data['pets'] as $pet): ?>
                    <div style="background: #ffffff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                            <div>
                                <h3 style="margin: 0; font-size: 1.25rem; color: #1e293b;">
                                    <?php echo htmlspecialchars($pet->name); ?>
                                </h3>
                                <span style="font-size: 0.85rem; color: #64748b;">
                                    <?php echo htmlspecialchars($pet->breed ?? 'Unknown Breed'); ?> (<?php echo htmlspecialchars($pet->species); ?>)
                                </span>
                            </div>
                            <span style="font-size: 1.8rem;">
                                <?php echo ($pet->species === 'Dog') ? '🐶' : (($pet->species === 'Cat') ? '🐱' : '🐾'); ?>
                            </span>
                        </div>
                        
                        <div style="font-size: 0.88rem; color: #475569; display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 14px; padding-top: 12px; border-top: 1px dashed #e2e8f0;">
                            <div><strong>Gender:</strong> <?php echo htmlspecialchars($pet->gender); ?></div>
                            <div><strong>Weight:</strong> <?php echo $pet->weight_kg ? htmlspecialchars($pet->weight_kg) . ' kg' : 'N/A'; ?></div>
                            <div><strong>DOB:</strong> <?php echo htmlspecialchars($pet->date_of_birth ?? 'Unknown'); ?></div>
                            <div><strong>Microchip:</strong> <?php echo htmlspecialchars($pet->microchip_number ?? 'None'); ?></div>
                        </div>

                        <?php if (!empty($pet->allergies) && $pet->allergies !== 'None known'): ?>
                            <div style="margin-top: 12px; padding: 8px 12px; background: #fff1f2; border-radius: 6px; font-size: 0.8rem; color: #be123c;">
                                <strong>Allergies:</strong> <?php echo htmlspecialchars($pet->allergies); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="background: #fff; padding: 30px; border-radius: 10px; text-align: center; color: #64748b;">
                <p>No pets registered yet.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section 2: Appointments List -->
    <div>
        <h2 style="font-size: 1.4rem; color: #1e293b; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            🗓 Appointments
        </h2>

        <?php if (!empty($data['appointments'])): ?>
            <div style="background: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                            <th style="padding: 14px 18px;">Date & Time</th>
                            <th style="padding: 14px 18px;">Pet</th>
                            <th style="padding: 14px 18px;">Service</th>
                            <th style="padding: 14px 18px;">Attending Vet</th>
                            <th style="padding: 14px 18px;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['appointments'] as $appt): ?>
                            <tr style="border-bottom: 1px solid #f1f5f9;">
                                <td style="padding: 14px 18px; font-weight: 500;">
                                    <?php echo htmlspecialchars($appt->appointment_date); ?><br>
                                    <small style="color: #64748b;"><?php echo date('h:i A', strtotime($appt->appointment_time)); ?></small>
                                </td>
                                <td style="padding: 14px 18px; font-weight: 600; color: #1e293b;">
                                    <?php echo htmlspecialchars($appt->pet_name); ?>
                                </td>
                                <td style="padding: 14px 18px;">
                                    <?php echo htmlspecialchars($appt->service_name ?? 'General Consultation'); ?>
                                </td>
                                <td style="padding: 14px 18px; color: #475569;">
                                    <?php echo $appt->vet_name ? 'Dr. ' . htmlspecialchars($appt->vet_name) : 'Pending Assignment'; ?>
                                </td>
                                <td style="padding: 14px 18px;">
                                    <?php
                                    $badgeColor = match ($appt->status) {
                                        'Confirmed' => ['bg' => '#dcfce7', 'text' => '#15803d'],
                                        'Completed' => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                        'Cancelled' => ['bg' => '#fee2e2', 'text' => '#b91c1c'],
                                        default     => ['bg' => '#fef3c7', 'text' => '#b45309'],
                                    };
                                    ?>
                                    <span style="background: <?php echo $badgeColor['bg']; ?>; color: <?php echo $badgeColor['text']; ?>; padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; font-weight: 600;">
                                        <?php echo htmlspecialchars($appt->status); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="background: #fff; padding: 30px; border-radius: 10px; text-align: center; color: #64748b;">
                <p>No appointments booked yet.</p>
            </div>
        <?php endif; ?>
    </div>

</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?>
