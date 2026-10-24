
document.addEventListener('DOMContentLoaded', function () {

    // Handle reservation cancellation forms.
    const cancelForms = document.querySelectorAll(
        '.cancel-reservation-form'
    );

    cancelForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {

            // Prevent the form from submitting more than once.
            const button = form.querySelector('.cancel-button');

            if (form.dataset.submitting === 'true') {
                event.preventDefault();
                return;
            }

            // Ask for confirmation before cancelling.
            const confirmed = confirm(
                'Are you sure you want to cancel this reservation? ' +
                'The reserved stock will become available again.'
            );

            if (!confirmed) {
                event.preventDefault();
                return;
            }

            form.dataset.submitting = 'true';

            if (button) {
                button.disabled = true;
                button.textContent = 'Cancelling...';
            }
        });
    });

    // Update countdowns for active reservations.
    const countdowns = document.querySelectorAll(
        '[data-expiry]'
    );

    function updateCountdowns() {
        const now = new Date().getTime();

        countdowns.forEach(function (element) {
            const expiryTime = new Date(
                element.dataset.expiry.replace(' ', 'T')
            ).getTime();

            if (Number.isNaN(expiryTime)) {
                element.textContent = 'Expiry time unavailable';
                return;
            }

            const remaining = expiryTime - now;

            if (remaining <= 0) {
                element.textContent = 'Expiry time reached';
                element.classList.add('countdown-expired');
                return;
            }

            const totalSeconds = Math.floor(remaining / 1000);
            const days = Math.floor(totalSeconds / 86400);
            const hours = Math.floor((totalSeconds % 86400) / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;

            let text = '';

            if (days > 0) {
                text += days + 'd ';
            }

            text += hours + 'h ' +
                    minutes + 'm ' +
                    seconds + 's remaining';

            element.textContent = text;
        });
    }

    if (countdowns.length > 0) {
        updateCountdowns();
        setInterval(updateCountdowns, 1000);
    }

});
