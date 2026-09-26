document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Staff Notifications loaded.");


    // --------------------------------------------------
    // Notification tabs
    // --------------------------------------------------

    const tabs =
        document.querySelectorAll(
            ".notification-tab, .notification-tabs button"
        );


    tabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            tabs.forEach(function (item) {

                item.classList.remove("active");

            });


            this.classList.add("active");

        });

    });


    // --------------------------------------------------
    // Search notifications
    // --------------------------------------------------

    const searchInput =
        document.querySelector(
            ".notification-search input"
        );


    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchText =
                this.value.toLowerCase().trim();


            const notifications =
                document.querySelectorAll(
                    ".notification-card, .notification-item"
                );


            notifications.forEach(function (notification) {

                const text =
                    notification.textContent.toLowerCase();


                notification.style.display =
                    text.includes(searchText)
                        ? ""
                        : "none";

            });

        });

    }


    // --------------------------------------------------
    // Mark all as read
    // --------------------------------------------------

    const markAllButton =
        document.querySelector(
            ".mark-all-read"
        );


    if (markAllButton) {

        markAllButton.addEventListener("click", function () {

            const unreadItems =
                document.querySelectorAll(
                    ".unread"
                );


            unreadItems.forEach(function (item) {

                item.classList.remove("unread");

            });


            const notificationCount =
                document.querySelector(
                    ".notification-count"
                );


            if (notificationCount) {

                notificationCount.textContent = "0";

            }

        });

    }

});