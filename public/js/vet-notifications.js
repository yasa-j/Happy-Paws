document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Vet Notifications loaded.");


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const notificationList =
        document.getElementById("notification-list");

    const notifications =
        Array.from(
            document.querySelectorAll(".notification-item")
        );

    const filterButtons =
        document.querySelectorAll(
            ".notification-filter"
        );

    const searchInput =
        document.getElementById(
            "notification-search"
        );

    const sortSelect =
        document.getElementById(
            "notification-sort"
        );

    const markAllButton =
        document.getElementById(
            "mark-all-button"
        );

    const unreadCount =
        document.getElementById(
            "unread-count"
        );

    const notificationSummary =
        document.getElementById(
            "notification-summary"
        );

    const emptyMessage =
        document.getElementById(
            "notification-empty"
        );

    const headerDot =
        document.getElementById(
            "header-notification-dot"
        );


    let currentFilter = "all";


    /* =====================================================
       FILTER BUTTONS
       ===================================================== */

    filterButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                filterButtons.forEach(
                    function (item) {

                        item.classList.remove(
                            "active"
                        );

                    }
                );


                this.classList.add("active");


                currentFilter =
                    this.dataset.filter;


                applyFilters();

            }
        );

    });


    /* =====================================================
       SEARCH
       ===================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            function () {

                applyFilters();

            }
        );

    }


    /* =====================================================
       APPLY FILTERS
       ===================================================== */

    function applyFilters() {

        const searchText =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : "";


        let visibleCount = 0;


        notifications.forEach(
            function (notification) {

                /*
                 * If it was deleted,
                 * keep it hidden.
                 */

                if (
                    notification.dataset.deleted ===
                    "true"
                ) {

                    notification.style.display =
                        "none";

                    return;

                }


                const type =
                    notification.dataset.type;


                const isUnread =
                    notification.classList.contains(
                        "unread"
                    );


                const text =
                    notification.textContent
                        .toLowerCase();


                let matchesFilter = true;


                /* -----------------------------
                   FILTER
                   ----------------------------- */

                if (
                    currentFilter === "unread"
                ) {

                    matchesFilter =
                        isUnread;

                }


                else if (
                    currentFilter !== "all"
                ) {

                    matchesFilter =
                        type === currentFilter;

                }


                /* -----------------------------
                   SEARCH
                   ----------------------------- */

                const matchesSearch =
                    searchText === "" ||
                    text.includes(searchText);


                /* -----------------------------
                   SHOW / HIDE
                   ----------------------------- */

                if (
                    matchesFilter &&
                    matchesSearch
                ) {

                    notification.style.display =
                        "flex";

                    visibleCount++;

                }

                else {

                    notification.style.display =
                        "none";

                }

            }
        );


        /*
         * Empty state
         */

        if (emptyMessage) {

            emptyMessage.hidden =
                visibleCount !== 0;

        }


        /*
         * Update summary
         */

        if (notificationSummary) {

            notificationSummary.textContent =
                "Showing " +
                visibleCount +
                " notification" +
                (
                    visibleCount === 1
                        ? ""
                        : "s"
                );

        }


        updateUnreadCount();

    }


    /* =====================================================
       UPDATE UNREAD COUNT
       ===================================================== */

    function updateUnreadCount() {

        const unreadNotifications =
            notifications.filter(
                function (notification) {

                    return (
                        !notification.dataset.deleted &&
                        notification.classList.contains(
                            "unread"
                        )
                    );

                }
            );


        const count =
            unreadNotifications.length;


        if (unreadCount) {

            unreadCount.textContent =
                count;

        }


        /*
         * Header notification dot
         */

        if (headerDot) {

            headerDot.style.display =
                count > 0
                    ? "block"
                    : "none";

        }


        /*
         * Mark all button
         */

        if (markAllButton) {

            if (count === 0) {

                markAllButton.disabled =
                    true;

                markAllButton.style.opacity =
                    "0.5";

                markAllButton.style.cursor =
                    "default";

            }

            else {

                markAllButton.disabled =
                    false;

                markAllButton.style.opacity =
                    "1";

                markAllButton.style.cursor =
                    "pointer";

            }

        }

    }


    /* =====================================================
       MARK INDIVIDUAL NOTIFICATION AS READ
       ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const button =
                event.target.closest(
                    ".mark-read-button"
                );


            if (!button) {
                return;
            }


            const notification =
                button.closest(
                    ".notification-item"
                );


            if (!notification) {
                return;
            }


            notification.classList.remove(
                "unread"
            );


            /*
             * Change button text
             */

            button.textContent =
                "✓ Read";


            button.disabled =
                true;


            /*
             * Reapply current filter
             */

            applyFilters();

        }
    );


    /* =====================================================
       MARK ALL AS READ
       ===================================================== */

    if (markAllButton) {

        markAllButton.addEventListener(
            "click",
            function () {

                notifications.forEach(
                    function (notification) {

                        if (
                            notification.dataset.deleted ===
                            "true"
                        ) {

                            return;

                        }


                        notification.classList.remove(
                            "unread"
                        );


                        const button =
                            notification.querySelector(
                                ".mark-read-button"
                            );


                        if (button) {

                            button.textContent =
                                "✓ Read";

                            button.disabled =
                                true;

                        }

                    }
                );


                updateUnreadCount();

                applyFilters();

            }
        );

    }


    /* =====================================================
       DELETE NOTIFICATION
       ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const deleteButton =
                event.target.closest(
                    ".delete-notification-button"
                );


            if (!deleteButton) {
                return;
            }


            const notification =
                deleteButton.closest(
                    ".notification-item"
                );


            if (!notification) {
                return;
            }


            /*
             * Animate removal
             */

            notification.classList.add(
                "removing"
            );


            setTimeout(
                function () {

                    notification.dataset.deleted =
                        "true";

                    notification.remove();


                    /*
                     * Update array
                     */

                    const index =
                        notifications.indexOf(
                            notification
                        );


                    if (index !== -1) {

                        notifications.splice(
                            index,
                            1
                        );

                    }


                    applyFilters();

                },
                220
            );

        }
    );


    /* =====================================================
       NOTIFICATION ACTIONS
       ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const actionButton =
                event.target.closest(
                    ".notification-action"
                );


            if (!actionButton) {
                return;
            }


            const action =
                actionButton.dataset.action;


            /*
             * Mark as read automatically
             */

            const notification =
                actionButton.closest(
                    ".notification-item"
                );


            if (notification) {

                notification.classList.remove(
                    "unread"
                );

            }


            /*
             * Appointment
             */

            if (
                action === "schedule"
            ) {

                window.location.href =
                    "index.php?url=vet/schedule";

                return;

            }


            /*
             * Medical Record
             */

            if (
                action === "medical"
            ) {

                window.location.href =
                    "index.php?url=vet/healthRecords";

                return;

            }


            /*
             * Vaccination
             */

            if (
                action === "vaccination"
            ) {

                window.location.href =
                    "index.php?url=vet/healthRecords";

                return;

            }


            /*
             * Patient
             */

            if (
                action === "patient"
            ) {

                window.location.href =
                    "index.php?url=vet/healthRecords";

                return;

            }

        }
    );


    /* =====================================================
       SORT
       ===================================================== */

    if (sortSelect) {

        sortSelect.addEventListener(
            "change",
            function () {

                const sortType =
                    this.value;


                const items =
                    Array.from(
                        document.querySelectorAll(
                            ".notification-item"
                        )
                    );


                items.sort(
                    function (a, b) {

                        const dateA =
                            new Date(
                                a.dataset.date
                            );

                        const dateB =
                            new Date(
                                b.dataset.date
                            );


                        if (
                            sortType ===
                            "oldest"
                        ) {

                            return dateA - dateB;

                        }


                        return dateB - dateA;

                    }
                );


                items.forEach(
                    function (item) {

                        notificationList.appendChild(
                            item
                        );

                    }
                );


                applyFilters();

            }
        );

    }


    /* =====================================================
       HEADER NOTIFICATION BUTTON
       ===================================================== */

    const headerNotificationButton =
        document.getElementById(
            "header-notification-button"
        );


    if (headerNotificationButton) {

        headerNotificationButton.addEventListener(
            "click",
            function () {

                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });

            }
        );

    }


    /* =====================================================
       SETTINGS BUTTON
       ===================================================== */

    const settingsButton =
        document.getElementById(
            "settings-button"
        );


    if (settingsButton) {

        settingsButton.addEventListener(
            "click",
            function () {

                window.location.href =
                    "index.php?url=vet/profile";

            }
        );

    }


    /* =====================================================
       INITIALIZE
       ===================================================== */

    applyFilters();

});