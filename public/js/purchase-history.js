
/*
 * Purchase History page JavaScript
 */

// Show or hide purchase details.
function showPurchaseDetails(orderId) {
    const details = document.getElementById(
        'purchase-details-' + orderId
    );

    if (!details) {
        return;
    }

    details.hidden = !details.hidden;

    if (!details.hidden) {
        details.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }
}


// Automatically submit the form when the sorting option changes.
document.addEventListener('DOMContentLoaded', function () {
    const sortSelect = document.querySelector(
        '.purchase-filter-options select[name="sort"]'
    );

    const filterForm = document.querySelector(
        '.purchase-filter-bar'
    );

    if (sortSelect && filterForm) {
        sortSelect.addEventListener('change', function () {
            filterForm.submit();
        });
    }
});
