/* =========================================
   HAPPY PAWS - HEALTH RECORDS JS
   ========================================= */


/* =========================================
   TAB SWITCHING
   ========================================= */

function switchHealthTab(tabName) {

    // Remove active class from all tabs
    const tabs = document.querySelectorAll('.record-tab');

    tabs.forEach(function(tab) {
        tab.classList.remove('active');
    });


    // Hide all tab contents
    const contents = document.querySelectorAll('.health-tab-content');

    contents.forEach(function(content) {
        content.classList.remove('active');
    });


    // Activate selected button
    const selectedButton = document.querySelector(
        '.record-tab[data-tab="' + tabName + '"]'
    );

    if (selectedButton) {
        selectedButton.classList.add('active');
    }


    // Activate selected content
    const selectedContent = document.getElementById(
        tabName + '-tab'
    );

    if (selectedContent) {
        selectedContent.classList.add('active');
    }


    // Clear search when changing tabs
    const searchInput = document.getElementById('recordSearch');

    if (searchInput) {
        searchInput.value = '';
    }

    filterRecords();
}


/* =========================================
   SEARCH RECORDS
   ========================================= */

function filterRecords() {

    const searchInput = document.getElementById('recordSearch');

    if (!searchInput) {
        return;
    }

    const searchText = searchInput.value.toLowerCase().trim();

    const activeTab = document.querySelector(
        '.health-tab-content.active'
    );

    if (!activeTab) {
        return;
    }


    const cards = activeTab.querySelectorAll(
        '.medical-record-card, .vaccination-card, .prescription-card'
    );


    cards.forEach(function(card) {

        const cardText = card.textContent.toLowerCase();

        if (cardText.includes(searchText)) {

            card.style.display = '';

        } else {

            card.style.display = 'none';

        }

    });
}


document.addEventListener('DOMContentLoaded', function() {

    const searchInput = document.getElementById('recordSearch');

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterRecords
        );

    }


    /* =========================================
       PET SELECTOR
       ========================================= */

    const petSelector = document.getElementById('petSelector');

    if (petSelector) {

        petSelector.addEventListener('click', function() {

            alert(
                'Pet selection will be connected to your registered pets later.'
            );

        });

    }


    /* =========================================
       TIME FILTER
       ========================================= */

    const timeFilter = document.getElementById(
        'recordTimeFilter'
    );

    if (timeFilter) {

        timeFilter.addEventListener('change', function() {

            const selectedYear = this.value;

            const activeTab = document.querySelector(
                '.health-tab-content.active'
            );

            if (!activeTab) {
                return;
            }


            const cards = activeTab.querySelectorAll(
                '.medical-record-card, .vaccination-card, .prescription-card'
            );


            cards.forEach(function(card) {

                if (selectedYear === 'all') {

                    card.style.display = '';

                    return;
                }


                const cardText = card.textContent;

                if (cardText.includes(selectedYear)) {

                    card.style.display = '';

                } else {

                    card.style.display = 'none';

                }

            });

        });

    }

});


/* =========================================
   DOWNLOAD BUTTON
   ========================================= */

function downloadHealthSummary() {

    alert(
        'Health Summary download will be connected to the clinic records system later.'
    );

}