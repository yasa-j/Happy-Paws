
<?php

class Notification
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Get notifications belonging to one user.
    // $archived = false retrieves the inbox.
    // $archived = true retrieves notification history.
    public function getNotificationsByUser($userId, $archived = false, $type = null)
    {
        $sql = "SELECT *
                FROM notifications
                WHERE user_id = :user_id
                AND is_archived = :is_archived";

        if (!empty($type)) {
            $sql .= " AND notification_type = :notification_type";
        }

        $sql .= " ORDER BY created_at DESC";

        $this->db->query($sql);

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':is_archived', $archived ? 1 : 0);

        if (!empty($type)) {
            $this->db->bind(':notification_type', $type);
        }

        return $this->db->resultSet();
    }

    // Count unread notifications for the inbox.
    public function getUnreadCount($userId)
    {
        $this->db->query(
            "SELECT COUNT(*) AS total
             FROM notifications
             WHERE user_id = :user_id
             AND is_archived = 0
             AND is_read = 0"
        );

        $this->db->bind(':user_id', $userId);

        $result = $this->db->single();

        return $result ? (int) $result->total : 0;
    }

    // Count notifications in the archived history.
    public function getHistoryCount($userId)
    {
        $this->db->query(
            "SELECT COUNT(*) AS total
             FROM notifications
             WHERE user_id = :user_id
             AND is_archived = 1"
        );

        $this->db->bind(':user_id', $userId);

        $result = $this->db->single();

        return $result ? (int) $result->total : 0;
    }

    // Count unread notifications for a specific type.
    public function getUnreadCountByType($userId, $type)
    {
        $this->db->query(
            "SELECT COUNT(*) AS total
             FROM notifications
             WHERE user_id = :user_id
             AND notification_type = :type
             AND is_archived = 0
             AND is_read = 0"
        );

        $this->db->bind(':user_id', $userId);
        $this->db->bind(':type', $type);

        $result = $this->db->single();

        return $result ? (int) $result->total : 0;
    }

    // Mark one notification as read.
    // The user_id condition prevents access to another owner's record.
    public function markAsRead($notificationId, $userId)
    {
        $this->db->query(
            "UPDATE notifications
             SET is_read = 1,
                 read_at = CURRENT_TIMESTAMP
             WHERE notification_id = :notification_id
             AND user_id = :user_id"
        );

        $this->db->bind(':notification_id', $notificationId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    // Mark every notification in the inbox as read.
    public function markAllAsRead($userId)
    {
        $this->db->query(
            "UPDATE notifications
             SET is_read = 1,
                 read_at = CURRENT_TIMESTAMP
             WHERE user_id = :user_id
             AND is_archived = 0
             AND is_read = 0"
        );

        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }

    // Archive one notification.
    public function archiveNotification($notificationId, $userId)
    {
        $this->db->query(
            "UPDATE notifications
             SET is_archived = 1
             WHERE notification_id = :notification_id
             AND user_id = :user_id"
        );

        $this->db->bind(':notification_id', $notificationId);
        $this->db->bind(':user_id', $userId);

        return $this->db->execute();
    }
}
