document.addEventListener('DOMContentLoaded', () => {

    /* TAB SWITCHING */

    const tabs = [
        ...document.querySelectorAll('.records-tab')
    ];

    const panels = [
        ...document.querySelectorAll('.records-tab-content')
    ];

    function activateTab(name) {

        tabs.forEach(tab => {

            const active = tab.dataset.tab === name;

            tab.classList.toggle('active', active);

            tab.setAttribute(
                'aria-selected',
                active ? 'true' : 'false'
            );

            tab.tabIndex = active ? 0 : -1;

        });

        panels.forEach(panel => {

            const active = panel.dataset.tabContent === name;

            panel.classList.toggle('active', active);

            panel.hidden = !active;

        });

    }

    tabs.forEach((tab, index) => {

        tab.addEventListener('click', () => {

            activateTab(tab.dataset.tab);

        });

        tab.addEventListener('keydown', event => {

            if (
                !['ArrowLeft', 'ArrowRight'].includes(event.key)
            ) {
                return;
            }

            event.preventDefault();

            const next = (
                index +
                (event.key === 'ArrowRight' ? 1 : tabs.length - 1)
            ) % tabs.length;

            tabs[next].focus();

            activateTab(tabs[next].dataset.tab);

        });

    });


    /* VIEW TREATMENT DETAILS */

    document.querySelectorAll('.treatment-view-button')
        .forEach(button => {

            button.addEventListener('click', () => {

                const row = button.closest('.treatment-item');

                const details = row?.querySelector('.treatment-extra');

                if (!details) {
                    return;
                }

                const opening = details.hidden;

                details.hidden = !opening;

                row.classList.toggle('is-expanded', opening);

                button.textContent = opening ? 'Hide' : 'View';

            });

        });


    /* QUICK-ADD DIALOG */

    const dialog = document.getElementById('quick-dialog');

    const dialogTitle = document.getElementById('dialog-title');

    const dialogDescription =
        document.getElementById('dialog-description');

    const dialogLabel = document.getElementById('dialog-label');

    const input = document.getElementById('dialog-value');

    const form = document.getElementById('quick-dialog-form');

    let activeAction = '';


    function openQuickDialog(
        action,
        title,
        description,
        label
    ) {

        activeAction = action;

        dialogTitle.textContent = title;

        dialogDescription.textContent = description;

        dialogLabel.textContent = label;

        input.value = '';

        if (typeof dialog.showModal === 'function') {

            dialog.showModal();

        } else {

            window.alert(description);

        }

        setTimeout(() => input.focus(), 0);

    }


    /* PET INFORMATION BUTTON */

    document.getElementById('edit-pet-button')
        ?.addEventListener('click', () => {

            openQuickDialog(
                'pet',
                'Pet information',
                'Pet details are managed by the pet record in the system.',
                'Pet name (view only)'
            );

            input.value =
                document.querySelector('.pet-name-line h1')
                    ?.textContent.trim() || '';

        });


    /* ADD TREATMENT */

    document.getElementById('add-treatment-button')
        ?.addEventListener('click', () => {

            openQuickDialog(
                'treatment',
                'Add treatment note',
                'Enter a short treatment note. This preview is added to the page only.',
                'Treatment / clinical note'
            );

        });


    /* ADD ALLERGY */

    document.getElementById('add-allergy-button')
        ?.addEventListener('click', () => {

            openQuickDialog(
                'allergy',
                'Add allergy',
                'Enter the allergy name. This preview is added to the page only.',
                'Allergy'
            );

        });


    /* ADD MEDICATION */

    document.getElementById('add-medication-button')
        ?.addEventListener('click', () => {

            openQuickDialog(
                'medication',
                'Add medication',
                'Enter the medication name. This preview is added to the page only.',
                'Medication name'
            );

        });


    /* CANCEL DIALOG */

    document.getElementById('dialog-cancel')
        ?.addEventListener('click', () => {

            dialog.close('cancel');

        });


    /* HANDLE QUICK-ADD SUBMISSION */

    form?.addEventListener('submit', event => {

        event.preventDefault();

        const value = input.value.trim();

        if (!value) {

            input.focus();

            return;

        }


        /* ADD ALLERGY PREVIEW */

        if (activeAction === 'allergy') {

            const list = document.getElementById('allergy-list');

            list.querySelector('.muted-note')?.remove();

            const tag = document.createElement('span');

            tag.className = 'allergy-tag';

            tag.textContent = value;

            list.appendChild(tag);

        }


        /* ADD MEDICATION PREVIEW */

        else if (activeAction === 'medication') {

            const list = document.getElementById('medication-list');

            list.querySelector('.muted-note')?.remove();

            const card = document.createElement('article');

            card.className = 'medication-item';

            const title = document.createElement('div');

            title.className = 'medication-item-title';

            const name = document.createElement('strong');

            name.textContent = value;

            const status = document.createElement('span');

            status.className = 'medication-status';

            status.textContent = 'ONGOING';

            title.append(name, status);

            card.appendChild(title);

            list.prepend(card);

        }


        /* ADD TREATMENT PREVIEW */

        else if (activeAction === 'treatment') {

            const tbody =
                document.querySelector('#panel-treatments tbody');

            tbody.querySelector('.empty-state')
                ?.closest('tr')
                ?.remove();

            const row = document.createElement('tr');

            row.className = 'treatment-item';

            const date = document.createElement('td');

            date.textContent = new Date().toLocaleDateString(
                undefined,
                {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric'
                }
            );

            const details = document.createElement('td');

            const strong = document.createElement('strong');

            strong.textContent = value;

            details.appendChild(strong);

            const vet = document.createElement('td');

            vet.textContent = 'Current veterinarian';

            const statusCell = document.createElement('td');

            const status = document.createElement('span');

            status.className = 'status-pill';

            status.textContent = '✓ Added (preview)';

            statusCell.appendChild(status);

            const actions = document.createElement('td');

            actions.textContent = '—';

            row.append(
                date,
                details,
                vet,
                statusCell,
                actions
            );

            tbody.prepend(row);

        }


        /* PET INFORMATION IS VIEW-ONLY HERE */

        else if (activeAction === 'pet') {

            dialog.close('ok');

            return;

        }


        dialog.close('ok');

    });


    /* SEARCH */

    const search = document.querySelector(
        '.vet-search input, .staff-search input, .header-search input'
    );

    search?.addEventListener('input', () => {

        const query = search.value.trim().toLowerCase();

        document.querySelectorAll(
            '.treatment-item, #panel-vaccinations tbody tr, .allergy-tag, .medication-item'
        ).forEach(item => {

            item.hidden =
                query !== '' &&
                !item.textContent.toLowerCase().includes(query);

        });

    });

});