document.addEventListener("DOMContentLoaded", function () {

    console.log("Happy Paws Reviews & Ratings loaded.");


    /* =====================================================
       ELEMENTS
       ===================================================== */

    const filterButtons =
        document.querySelectorAll(".review-filter");

    const reviewItems =
        document.querySelectorAll(".review-item");

    const searchInput =
        document.getElementById("review-search");

    const sortSelect =
        document.getElementById("review-sort");

    const noReviewsMessage =
        document.getElementById("no-reviews-message");


    /* =====================================================
       FILTER REVIEWS
       ===================================================== */

    filterButtons.forEach(function (button) {

        button.addEventListener("click", function () {

            filterButtons.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            const filter =
                this.dataset.filter;

            applyFilters(filter);

        });

    });


    /* =====================================================
       SEARCH
       ===================================================== */

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            function () {

                const activeFilter =
                    document.querySelector(
                        ".review-filter.active"
                    );

                const filter =
                    activeFilter
                        ? activeFilter.dataset.filter
                        : "all";

                applyFilters(filter);

            }
        );

    }


    /* =====================================================
       FILTER FUNCTION
       ===================================================== */

    function applyFilters(filter) {

        const searchText =
            searchInput
                ? searchInput.value
                    .toLowerCase()
                    .trim()
                : "";

        let visibleCount = 0;


        reviewItems.forEach(function (review) {

            const rating =
                review.dataset.rating;

            const hasComment =
                review.dataset.comment === "true";

            const reviewText =
                review.textContent.toLowerCase();


            let matchesFilter = true;


            /*
             * Rating filters
             */

            if (
                filter === "5" ||
                filter === "4" ||
                filter === "3"
            ) {

                matchesFilter =
                    rating === filter;

            }


            /*
             * Comments filter
             */

            if (filter === "comments") {

                matchesFilter =
                    hasComment;

            }


            /*
             * Search
             */

            const matchesSearch =
                searchText === "" ||
                reviewText.includes(searchText);


            if (
                matchesFilter &&
                matchesSearch
            ) {

                review.style.display = "grid";

                visibleCount++;

            } else {

                review.style.display = "none";

            }

        });


        if (noReviewsMessage) {

            noReviewsMessage.hidden =
                visibleCount !== 0;

        }

    }


    /* =====================================================
       SORT REVIEWS
       ===================================================== */

    if (sortSelect) {

        sortSelect.addEventListener(
            "change",
            function () {

                const reviewsContainer =
                    document.querySelector(
                        ".recent-feedback-card"
                    );

                const reviews =
                    Array.from(
                        document.querySelectorAll(
                            ".review-item"
                        )
                    );


                const sortType =
                    this.value;


                reviews.sort(
                    function (a, b) {

                        if (
                            sortType === "newest"
                        ) {

                            return new Date(
                                b.dataset.date
                            ) -
                            new Date(
                                a.dataset.date
                            );

                        }


                        if (
                            sortType === "oldest"
                        ) {

                            return new Date(
                                a.dataset.date
                            ) -
                            new Date(
                                b.dataset.date
                            );

                        }


                        if (
                            sortType === "highest"
                        ) {

                            return Number(
                                b.dataset.rating
                            ) -
                            Number(
                                a.dataset.rating
                            );

                        }


                        if (
                            sortType === "lowest"
                        ) {

                            return Number(
                                a.dataset.rating
                            ) -
                            Number(
                                b.dataset.rating
                            );

                        }


                        return 0;

                    }
                );


                const noResults =
                    document.getElementById(
                        "no-reviews-message"
                    );


                reviews.forEach(function (review) {

                    reviewsContainer.insertBefore(
                        review,
                        noResults
                    );

                });

            }
        );

    }


    /* =====================================================
       REPLY BUTTON
       ===================================================== */

    const replyButtons =
        document.querySelectorAll(
            ".reply-button"
        );


    replyButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const review =
                    this.closest(
                        ".review-item"
                    );

                if (!review) {
                    return;
                }


                const replyArea =
                    review.querySelector(
                        ".reply-area"
                    );


                if (!replyArea) {
                    return;
                }


                /*
                 * Close other reply areas
                 */

                document
                    .querySelectorAll(
                        ".reply-area"
                    )
                    .forEach(function (area) {

                        if (
                            area !== replyArea
                        ) {

                            area.hidden = true;

                        }

                    });


                /*
                 * Show current reply area
                 */

                replyArea.hidden =
                    !replyArea.hidden;


                if (!replyArea.hidden) {

                    const input =
                        replyArea.querySelector(
                            ".reply-input"
                        );

                    if (input) {
                        input.focus();
                    }

                }

            }
        );

    });


    /* =====================================================
       CANCEL REPLY
       ===================================================== */

    const cancelButtons =
        document.querySelectorAll(
            ".cancel-reply-button"
        );


    cancelButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const replyArea =
                    this.closest(
                        ".reply-area"
                    );

                if (!replyArea) {
                    return;
                }


                const input =
                    replyArea.querySelector(
                        ".reply-input"
                    );


                if (input) {
                    input.value = "";
                }


                replyArea.hidden = true;

            }
        );

    });


    /* =====================================================
       SEND REPLY
       ===================================================== */

    const sendReplyButtons =
        document.querySelectorAll(
            ".send-reply-button"
        );


    sendReplyButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                const replyArea =
                    this.closest(
                        ".reply-area"
                    );


                if (!replyArea) {
                    return;
                }


                const input =
                    replyArea.querySelector(
                        ".reply-input"
                    );


                if (!input) {
                    return;
                }


                const reply =
                    input.value.trim();


                if (reply === "") {

                    alert(
                        "Please enter a reply before sending."
                    );

                    input.focus();

                    return;
                }


                /*
                 * Since database is not connected,
                 * show the reply inside the UI.
                 */

                const existingReply =
                    document.createElement(
                        "div"
                    );


                existingReply.className =
                    "submitted-reply";


                existingReply.innerHTML =
                    "<strong>Your reply:</strong> " +
                    escapeHtml(reply);


                replyArea.parentNode.insertBefore(
                    existingReply,
                    replyArea
                );


                input.value = "";

                replyArea.hidden = true;


                button.textContent =
                    "Reply Sent";


                setTimeout(function () {

                    button.textContent =
                        "Send Reply";

                }, 1500);

            }
        );

    });


    /* =====================================================
       VIEW APPOINTMENT
       ===================================================== */

    const appointmentButtons =
        document.querySelectorAll(
            ".appointment-button"
        );


    appointmentButtons.forEach(function (button) {

        button.addEventListener(
            "click",
            function () {

                /*
                 * Navigate to vet schedule.
                 *
                 * Database is not connected yet,
                 * so the appointment page is the
                 * schedule page.
                 */

                
                window.location.href =
    "index.php?url=vet/schedule";
            }
        );

    });


    /* =====================================================
       NOTIFICATION BUTTON
       ===================================================== */

    const notificationButton =
        document.getElementById(
            "notification-button"
        );


    if (notificationButton) {

        notificationButton.addEventListener(
            "click",
            function () {

               window.location.href =
    "index.php?url=vet/notifications";
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
       HTML ESCAPE
       ===================================================== */

    function escapeHtml(text) {

        const div =
            document.createElement("div");

        div.textContent = text;

        return div.innerHTML;

    }


    /* =====================================================
       INITIAL FILTER
       ===================================================== */

    applyFilters("all");

});