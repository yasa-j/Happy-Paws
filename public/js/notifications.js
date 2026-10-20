
document.addEventListener('DOMContentLoaded', function () {

    // Confirm before marking all notifications as read.
    const markAllForm = document.querySelector(
        'form[action$="/markAllNotificationsRead"]'
    );

    if (markAllForm) {
        markAllForm.addEventListener('submit', function (event) {
            const confirmed = window.confirm(
                'Are you sure you want to mark all notifications as read?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    }

    // Confirm before archiving a notification.
    const archiveForms = document.querySelectorAll(
        'form[action$="/archiveNotification"]'
    );

    archiveForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            const confirmed = window.confirm(
                'Do you want to move this notification to history?'
            );

            if (!confirmed) {
                event.preventDefault();
            }
        });
    });

});
