<?php
$currentUrl = $_GET['url'] ?? 'vet/reviews';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?php echo $data['title'] ?? 'Reviews & Ratings'; ?>
    </title>


    <!-- Existing Vet Sidebar CSS -->
    <link
        rel="stylesheet"
      href="<?php echo URLROOT; ?>/css/vet-sidebar.css?v=3">
    


    <!-- Reviews CSS -->
    <link
        rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/vet-reviews.css?v=2"
    >

</head>


<body>


<div class="vet-page">


    <!-- =====================================================
         SIDEBAR
         ===================================================== -->

    <?php require APPROOT . '/views/layouts/vet_sidebar.php'; ?>


    <!-- =====================================================
         MAIN AREA
         ===================================================== -->

    <main class="vet-main">


        <!-- =================================================
             TOP HEADER
             ================================================= -->

        <header class="vet-top-header">


            <div class="vet-search">

                <span class="search-icon">⌕</span>

                <input
                    type="text"
                    id="review-search"
                    placeholder="Search reviews..."
                >

            </div>


            <div class="vet-header-right">


                <button
                    type="button"
                    class="header-icon-button"
                    id="notification-button"
                    title="Notifications"
                >
                    ♧

                    <span class="notification-dot"></span>

                </button>


                <button
                    type="button"
                    class="header-icon-button"
                    id="settings-button"
                    title="Settings"
                >
                    ⚙
                </button>


                <div class="header-divider"></div>
               

                   <div class="vet-user">

    <div class="vet-user-avatar">
        <img
            src="<?php echo URLROOT; ?>/images/sidebar-icons/profile.png"
            alt="Profile">
    </div>

    <div class="vet-user-info">

                        <strong>
    <?php echo htmlspecialchars($_SESSION['staff_name'] ?? 'Veterinarian'); ?>
</strong>

                        <span>
                            Lead Veterinarian
                        </span>

                    </div>

                </div>

            </div>

        </header>



        <!-- =================================================
             CONTENT
             ================================================= -->

        <section class="reviews-content">


            <!-- =================================================
                 PAGE TITLE
                 ================================================= -->

            <div class="reviews-heading">


                


                <h1>
                    Reviews &amp; Ratings
                </h1>

            </div>



            <!-- =================================================
                 MAIN GRID
                 ================================================= -->

            <div class="reviews-grid">


                <!-- =============================================
                     LEFT SIDE
                     ============================================= -->

                <div class="reviews-left">


                    <!-- =========================================
                         FILTER TABS
                         ========================================= -->

                    <div class="review-filters">


                        <button
                            type="button"
                            class="review-filter active"
                            data-filter="all"
                        >
                            All Reviews
                        </button>


                        <button
                            type="button"
                            class="review-filter"
                            data-filter="5"
                        >
                            5 Stars ★
                        </button>


                        <button
                            type="button"
                            class="review-filter"
                            data-filter="4"
                        >
                            4 Stars ★
                        </button>


                        <button
                            type="button"
                            class="review-filter"
                            data-filter="3"
                        >
                            3 Stars ★
                        </button>


                        <button
                            type="button"
                            class="review-filter"
                            data-filter="comments"
                        >
                            With Comments
                        </button>


                    </div>



                    <!-- =========================================
                         RECENT FEEDBACK CARD
                         ========================================= -->

                    <section class="recent-feedback-card">


                        <div class="feedback-header">


                            <h2>
                                Recent Feedback
                            </h2>


                            <div class="sort-container">


                                <span>
                                    Sort by:
                                </span>


                                <select id="review-sort">

                                    <option value="newest">
                                        Newest
                                    </option>

                                    <option value="oldest">
                                        Oldest
                                    </option>

                                    <option value="highest">
                                        Highest Rating
                                    </option>

                                    <option value="lowest">
                                        Lowest Rating
                                    </option>

                                </select>


                            </div>

                        </div>



                        <!-- =====================================
                             REVIEW
                             ===================================== -->

                        <article
                            class="review-item"
                            data-rating="5"
                            data-comment="true"
                            data-date="2023-10-24"
                        >


                            <!-- Reviewer -->

                            <div class="reviewer-section">


                                <div class="reviewer-avatar">
                                    👩🏼
                                </div>


                                <h3>
                                    Emily Davis
                                </h3>


                                <p class="review-pet">
                                    ♣ Pet: Luna (Dog)
                                </p>


                            </div>



                            <!-- Review Content -->

                            <div class="review-main">


                                <div class="review-top-row">


                                    <div class="stars">
                                        ★★★★★
                                    </div>


                                    <span class="review-date">
                                        Oct 24, 2023
                                    </span>


                                </div>


                                <p class="review-text">

                                    "Dr. Sarah was very kind and
                                    thorough during Luna's annual
                                    checkup. She took the time to
                                    answer all my questions about
                                    her new diet. The clinic is
                                    incredibly clean and serene,
                                    which really helped calm Luna
                                    down. Highly recommend
                                    HappyPaws!"

                                </p>



                                <!-- Reply Area -->

                                <div
                                    class="reply-area"
                                    hidden
                                >

                                    <textarea
                                        class="reply-input"
                                        placeholder="Write your reply..."
                                        maxlength="500"
                                    ></textarea>


                                    <div class="reply-actions">

                                        <button
                                            type="button"
                                            class="cancel-reply-button"
                                        >
                                            Cancel
                                        </button>


                                        <button
                                            type="button"
                                            class="send-reply-button"
                                        >
                                            Send Reply
                                        </button>

                                    </div>

                                </div>



                                <!-- Buttons -->

                                <div class="review-actions">


                                    <button
                                        type="button"
                                        class="reply-button"
                                    >
                                        ↩
                                        Reply
                                    </button>


                                    <button
                                        type="button"
                                        class="appointment-button"
                                        data-appointment="Luna"
                                    >
                                        □
                                        View Appointment
                                    </button>


                                </div>


                            </div>

                        </article>



                        <!-- =====================================
                             NO RESULTS
                             ===================================== -->

                        <div
                            id="no-reviews-message"
                            class="no-reviews-message"
                            hidden
                        >

                            <div class="no-review-icon">
                                ★
                            </div>

                            <h3>
                                No reviews found
                            </h3>

                            <p>
                                Try changing your search or filter.
                            </p>

                        </div>


                    </section>


                </div>



                <!-- =============================================
                     RIGHT SIDE - PERFORMANCE
                     ============================================= -->

                <aside class="performance-card">


                    <h2>
                        Performance Summary
                    </h2>


                    <div class="performance-line"></div>



                    <!-- Average -->

                    <div class="performance-item">

                        <div>

                            <span class="performance-label">
                                AVERAGE RATING
                            </span>

                            <strong>
                                4.9
                                <small>/ 5.0</small>
                            </strong>

                        </div>


                        <div class="performance-icon star">
                            ★
                        </div>

                    </div>



                    <!-- Total Reviews -->

                    <div class="performance-item">

                        <div>

                            <span class="performance-label">
                                TOTAL REVIEWS
                            </span>

                            <strong>
                                186
                            </strong>

                        </div>


                        <div class="performance-icon notes">
                            ☷
                        </div>

                    </div>



                    <!-- Positive Reviews -->

                    <div class="performance-item">

                        <div>

                            <span class="performance-label">
                                POSITIVE REVIEWS
                            </span>

                            <strong>
                                172
                                <small class="positive">
                                    ↑ 12%
                                </small>
                            </strong>

                        </div>


                        <div class="performance-icon positive-icon">
                            ☻
                        </div>

                    </div>



                    <!-- Satisfaction -->

                    <div class="performance-item satisfaction-item">

                        <div class="satisfaction-top">

                            <span class="performance-label">
                                SATISFACTION RATE
                            </span>

                            <strong>
                                97%
                            </strong>

                        </div>


                        <div class="progress-bar">

                            <div
                                class="progress-fill"
                                style="width:97%;"
                            ></div>

                        </div>

                    </div>


                </aside>


            </div>


        </section>


    </main>


</div>



<!-- =========================================================
     REVIEWS JAVASCRIPT
     ========================================================= -->

<script
    src="<?php echo URLROOT; ?>/js/vet-reviews.js"
></script>


</body>

</html>