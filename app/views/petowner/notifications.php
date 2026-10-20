
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifications | HappyPaws</title>

    <!-- Shared Pet Owner CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/public/css/petowner.css">

    <!-- Shared Topbar CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/public/css/topbar.css">

    <!-- Notifications Page CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/public/css/notifications.css">
</head>

<?php
// Escape output before displaying database values.
$e = function ($value) {
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        'UTF-8'
    );
};

$tab = $tab ?? 'inbox';
$type = $type ?? '';
$notifications = $notifications ?? [];
$unreadCount = $unreadCount ?? 0;
$historyCount = $historyCount ?? 0;
$categoryCounts = $categoryCounts ?? [];

$categories = [
    'appointment' => 'Appointments',
    'vaccination' => 'Vaccinations',
    'reserved_product' => 'Reserved products',
    'clinic_notice' => 'Clinic notices'
];

$icons = [
    'appointment' => '▦',
    'vaccination' => '✳',
    'reserved_product' => '♙',
    'clinic_notice' => '⚑'
];

$colors = [
    'appointment' => 'green',
    'vaccination' => 'purple',
    'reserved_product' => 'orange',
    'clinic_notice' => 'gray'
];
?>

<body>

    <?php
    // Load the existing shared Pet Owner sidebar.
    require_once APPROOT . '/views/layouts/petowner-sidebar.php';
    ?>

    <main class="petowner-main hp-notifications-main">

        <?php
        // Load the existing shared Pet Owner topbar.
        require_once APPROOT . '/views/layouts/petowner-topbar.php';
        ?>

        <div class="hp-notifications">

            <!-- Page heading -->
            <header class="notifications-header">

                <div>
                    <p class="notifications-eyebrow">
                        PET OWNER PORTAL /
                        <span>NOTIFICATIONS</span>
                    </p>

                    <h1>Notifications</h1>

                    <p class="notifications-subtitle">
                        Stay updated on your pet's care.
                    </p>
                </div>

                <div class="notifications-header-actions">

                    <?php if ($tab === 'inbox' && $unreadCount > 0): ?>

                        <form
                            method="POST"
                            action="<?php echo URLROOT; ?>/petowner/markAllNotificationsRead"
                        >
                            <button
                                class="notification-button"
                                type="submit"
                            >
                                ✓ Mark all as read
                            </button>
                        </form>

                    <?php endif; ?>

                    <a
                        class="notification-settings"
                        href="<?php echo URLROOT; ?>/petowner/notificationSettings"
                        aria-label="Notification settings"
                        title="Notification settings"
                    >
                        ⚙
                    </a>

                </div>
            </header>

            <!-- Inbox and history tabs -->
            <nav class="notification-tabs">

                <a
                    href="<?php echo URLROOT; ?>/petowner/notifications?tab=inbox"
                    class="notification-tab <?php echo $tab === 'inbox' ? 'active' : ''; ?>"
                >
                    <span>▣</span>
                    Inbox

                    <span class="notification-tab-count">
                        <?php echo (int) $unreadCount; ?>
                    </span>
                </a>

                <a
                    href="<?php echo URLROOT; ?>/petowner/notifications?tab=history"
                    class="notification-tab <?php echo $tab === 'history' ? 'active' : ''; ?>"
                >
                    <span>◷</span>
                    History

                    <span class="notification-tab-count">
                        <?php echo (int) $historyCount; ?>
                    </span>
                </a>

            </nav>

            <!-- Notification category summary -->
            <section class="notification-summary">

                <p class="notification-section-label">
                    Filter by type
                </p>

                <div class="notification-category-grid">

                    <?php foreach ($categories as $key => $label): ?>

                        <a
                            class="notification-category <?php echo $type === $key ? 'selected' : ''; ?>"
                            href="<?php echo URLROOT; ?>/petowner/notifications?tab=<?php echo $e($tab); ?>&type=<?php echo $e($key); ?>"
                        >

                            <div class="notification-category-top">

                                <span class="notification-category-icon <?php echo $e($colors[$key]); ?>">
                                    <?php echo $e($icons[$key]); ?>
                                </span>

                                <strong>
                                    <?php echo (int) ($categoryCounts[$key] ?? 0); ?>
                                </strong>

                            </div>

                            <span class="notification-category-name">
                                <?php echo $e($label); ?>
                            </span>

                            <span class="notification-category-caption">
                                <?php echo (int) ($categoryCounts[$key] ?? 0); ?>
                                unread
                            </span>

                        </a>

                    <?php endforeach; ?>

                </div>

                <?php if ($type !== ''): ?>

                    <a
                        class="notification-clear-filter"
                        href="<?php echo URLROOT; ?>/petowner/notifications?tab=<?php echo $e($tab); ?>"
                    >
                        Clear category filter ×
                    </a>

                <?php endif; ?>

            </section>

            <!-- Notification list -->
            <section class="notification-content">

                <div class="notification-list-column">

                    <div class="notification-list-heading">

                        <h2>
                            <?php
                            echo $tab === 'history'
                                ? 'Notification history'
                                : 'Your inbox';
                            ?>
                        </h2>

                        <span>
                            <?php echo count($notifications); ?>
                            notifications
                        </span>

                    </div>

                    <?php if (empty($notifications)): ?>

                        <!-- Empty notification state -->
                        <div class="notification-empty">

                            <div class="notification-empty-icon">
                                ♧
                            </div>

                            <h3>
                                <?php
                                echo $tab === 'history'
                                    ? 'No notification history yet'
                                    : 'You are all caught up!';
                                ?>
                            </h3>

                            <p>
                                <?php
                                echo $type !== ''
                                    ? 'There are no notifications in this category.'
                                    : 'When there are updates about your pets, appointments or vaccinations, they will appear here.';
                                ?>
                            </p>

                            <?php if ($type !== ''): ?>

                                <a
                                    class="notification-button primary"
                                    href="<?php echo URLROOT; ?>/petowner/notifications?tab=<?php echo $e($tab); ?>"
                                >
                                    View all notifications
                                </a>

                            <?php endif; ?>

                        </div>

                    <?php else: ?>

                        <div class="notification-timeline">

                            <?php foreach ($notifications as $notification): ?>

                                <?php
                                $notificationType =
                                    $notification->notification_type
                                    ?? 'clinic_notice';

                                $color =
                                    $colors[$notificationType] ?? 'gray';

                                $icon =
                                    $icons[$notificationType] ?? '•';

                                $createdAt = !empty($notification->created_at)
                                    ? strtotime($notification->created_at)
                                    : false;

                                $timeAgo = 'Recently';

                                if ($createdAt !== false) {

                                    $secondsAgo = max(
                                        0,
                                        time() - $createdAt
                                    );

                                    if ($secondsAgo < 60) {
                                        $timeAgo = 'Just now';

                                    } elseif ($secondsAgo < 3600) {
                                        $timeAgo =
                                            floor($secondsAgo / 60)
                                            . ' min ago';

                                    } elseif ($secondsAgo < 86400) {
                                        $timeAgo =
                                            floor($secondsAgo / 3600)
                                            . ' hours ago';

                                    } else {
                                        $timeAgo =
                                            floor($secondsAgo / 86400)
                                            . ' days ago';
                                    }
                                }
                                ?>

                                <article
                                    class="notification-card <?php echo empty($notification->is_read) ? 'unread' : ''; ?>"
                                >

                                    <div class="notification-card-icon <?php echo $e($color); ?>">
                                        <?php echo $e($icon); ?>
                                    </div>

                                    <div class="notification-card-body">

                                        <div class="notification-card-meta">

                                            <span class="notification-type-label">
                                                <?php
                                                echo $e(
                                                    $categories[$notificationType]
                                                    ?? 'Notification'
                                                );
                                                ?>
                                            </span>

                                            <?php if (empty($notification->is_read)): ?>

                                                <span class="notification-unread-dot"></span>

                                            <?php endif; ?>

                                            <span class="notification-time">
                                                <?php echo $e($timeAgo); ?>
                                            </span>

                                        </div>

                                        <h3>
                                            <?php echo $e($notification->title); ?>
                                        </h3>

                                        <p class="notification-message">
                                            <?php
                                            echo nl2br(
                                                $e($notification->message)
                                            );
                                            ?>
                                        </p>

                                        <?php if (!empty($notification->expires_at)): ?>

                                            <p class="notification-expiry">
                                                Expires:

                                                <?php
                                                $expiryTimestamp = strtotime(
                                                    $notification->expires_at
                                                );

                                                echo $expiryTimestamp !== false
                                                    ? $e(
                                                        date(
                                                            'd M Y, g:i A',
                                                            $expiryTimestamp
                                                        )
                                                    )
                                                    : '';
                                                ?>
                                            </p>

                                        <?php endif; ?>

                                        <div class="notification-card-actions">

                                            <!-- Optional action link -->
                                            <?php
                                            $actionUrl =
                                                $notification->action_url ?? '';

                                            $isLocalAction =
                                                $actionUrl !== ''
                                                && strpos($actionUrl, '/') === 0
                                                && strpos($actionUrl, '//') !== 0
                                                && strpos($actionUrl, '\\') === false;
                                            ?>

                                            <?php if (
                                                !empty($notification->action_label)
                                                && $isLocalAction
                                            ): ?>

                                                <a
                                                    class="notification-button primary"
                                                    href="<?php echo URLROOT . $e($actionUrl); ?>"
                                                >
                                                    <?php
                                                    echo $e(
                                                        $notification->action_label
                                                    );
                                                    ?>
                                                    →
                                                </a>

                                            <?php endif; ?>

                                            <!-- Inbox actions -->
                                            <?php if ($tab === 'inbox'): ?>

                                                <?php if (empty($notification->is_read)): ?>

                                                    <form
                                                        method="POST"
                                                        action="<?php echo URLROOT; ?>/petowner/markNotificationRead"
                                                    >

                                                        <input
                                                            type="hidden"
                                                            name="notification_id"
                                                            value="<?php echo (int) $notification->notification_id; ?>"
                                                        >

                                                        <button
                                                            class="notification-button"
                                                            type="submit"
                                                        >
                                                            Mark read
                                                        </button>

                                                    </form>

                                                <?php endif; ?>

                                                <form
                                                    method="POST"
                                                    action="<?php echo URLROOT; ?>/petowner/archiveNotification"
                                                >

                                                    <input
                                                        type="hidden"
                                                        name="notification_id"
                                                        value="<?php echo (int) $notification->notification_id; ?>"
                                                    >

                                                    <button
                                                        class="notification-button"
                                                        type="submit"
                                                    >
                                                        Archive
                                                    </button>

                                                </form>

                                            <?php endif; ?>

                                        </div>

                                    </div>

                                </article>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>

                <!-- Right-hand information column -->
                <aside class="notification-right-column">

                    <section class="notification-side-card">

                        <div class="notification-side-heading">
                            <h2>Notification overview</h2>
                        </div>

                        <div class="notification-overview-row">
                            <span>Unread in inbox</span>

                            <strong>
                                <?php echo (int) $unreadCount; ?>
                            </strong>
                        </div>

                        <div class="notification-overview-row">
                            <span>Archived notifications</span>

                            <strong>
                                <?php echo (int) $historyCount; ?>
                            </strong>
                        </div>

                        <div class="notification-overview-row">
                            <span>Total categories</span>

                            <strong>
                                <?php echo count($categories); ?>
                            </strong>
                        </div>

                    </section>

                    <section class="notification-side-card notification-help-card">

                        <h2>Need assistance?</h2>

                        <p>
                            Contact the clinic if you have questions about
                            your pet's appointments or vaccination reminders.
                        </p>

                        <a
                            class="notification-button full-width"
                            href="<?php echo URLROOT; ?>/petowner/profile"
                        >
                            View your profile
                        </a>

                    </section>

                </aside>

            </section>

        </div>

    </main>

    <!-- Notifications JavaScript -->
    <script src="<?php echo URLROOT; ?>/public/js/notifications.js"></script>
    <script src="<?php echo URLROOT; ?>/js/petowner.js"></script>

</body>
</html>
