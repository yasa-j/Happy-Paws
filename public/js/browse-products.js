
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');
    const filterForm = document.getElementById('productFilterForm');

    if (categorySelect && filterForm) {
        categorySelect.addEventListener('change', function () {
            filterForm.requestSubmit();
        });
    }

    if (sortSelect && filterForm) {
        sortSelect.addEventListener('change', function () {
            filterForm.requestSubmit();
        });
    }
});
