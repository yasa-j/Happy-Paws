document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Staff Notifications loaded.");

    // --------------------------------------------------
    // Notification tabs
    // --------------------------------------------------

    const tabs = document.querySelectorAll(".notification-tab");
    const notifications = document.querySelectorAll(".notification-card");

    tabs.forEach(function (tab) {

        tab.addEventListener("click", function () {

            tabs.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const selectedTab = this.textContent.trim().toLowerCase();

            notifications.forEach(function (notification) {

                const text = notification.textContent.toLowerCase();

                if (selectedTab === "all") {
                    notification.style.display = "flex";
                }
                else if (selectedTab === "unread") {
                    notification.style.display =
                        notification.classList.contains("unread") ? "flex" : "none";
                }
                else if (selectedTab === "appointments") {
                    notification.style.display =
                        text.includes("appointment") ? "flex" : "none";
                }
                else if (selectedTab === "payments") {
                    notification.style.display =
                        text.includes("payment") ? "flex" : "none";
                }

            });

        });

    });


    // --------------------------------------------------
    // Search notifications
    // --------------------------------------------------

    const searchInput = document.querySelector(".notification-search input");

    if (searchInput) {

        searchInput.addEventListener("input", function () {

            const searchText = this.value.toLowerCase().trim();

            notifications.forEach(function (notification) {

                const matchesSearch =
                    notification.textContent.toLowerCase().includes(searchText);

                notification.style.display = matchesSearch ? "flex" : "none";

            });

        });

    }


    // --------------------------------------------------
    // Mark all as read
    // --------------------------------------------------

    const markAllButton = document.querySelector(".mark-read-button");

    if (markAllButton) {

        markAllButton.addEventListener("click", function () {

            document.querySelectorAll(".notification-card.unread").forEach(function (item) {
                item.classList.remove("unread");
            });

            document.querySelectorAll(".notification-count").forEach(function (count) {
                count.textContent = "0";
            });

            alert("All notifications have been marked as read.");

        });

    }


    // --------------------------------------------------
    // Filter button
    // --------------------------------------------------

    const filterButton = document.querySelector(".notification-actions .filter-button");

    if (filterButton) {

        filterButton.addEventListener("click", function () {
            alert("The notification filter feature has not been implemented yet.");
        });

    }

});

