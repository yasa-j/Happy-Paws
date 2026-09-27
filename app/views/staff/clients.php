<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Clients</title>


    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">


    <!-- Common Staff CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">


    <!-- Clients CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-clients.css">

</head>


<body>


<!-- =========================================
     HEADER
========================================= -->

<header class="staff-header">

    <div class="header-logo">

        <img
            src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
            alt="HappyPaws">

        <span>HappyPaws</span>

    </div>


    <div class="search-box">

        <span>⌕</span>

        <input
            type="text"
            placeholder="Search patients, records...">

    </div>


    <div class="header-right">

        <span class="header-icon">?</span>

        <span class="header-icon">⚙</span>

        <div class="user-profile">

            <span>Jane D.</span>

            <img
                src="<?php echo URLROOT; ?>/images/happy_paws_logo.png"
                alt="User">

        </div>

    </div>

</header>



<!-- =========================================
     SIDEBAR + CLIENT CONTENT
========================================= -->

<div class="staff-layout">


    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>


    <!-- =====================================
         CLIENT CONTENT
    ====================================== -->

    <main class="staff-clients-content">


        <!-- Title -->

        <div class="clients-heading">

            <h1>
                Client Directory
            </h1>

        </div>



        <!-- Filter -->

        <div class="filter-row">

            <button class="all-clients-button">
                All Clients
            </button>


            <div class="filter-button">
                Filter ⇅
            </div>

        </div>



        <!-- =================================
             CLIENT TABLE
        ================================== -->

        <section class="clients-table">


            <!-- Header -->

            <div class="table-header">

                <div>
                    CLIENT NAME
                </div>

                <div>
                    CLIENT ID
                </div>

                <div>
                    CONTACT INFORMATION
                </div>

                <div>
                    TOTAL PETS
                </div>

                <div>
                    JOINED DATE
                </div>

            </div>



            <!-- Client 1 -->

            <div class="client-row">

                <div class="client-info">

                    <div class="client-avatar">
                        JD
                    </div>

                    <div class="client-name">
                        John Doe
                    </div>

                </div>


                <div class="client-id">
                    #HP-4921
                </div>


                <div class="contact">

                    john@gmail.com

                    <br>

                    <span class="phone">
                        0772839742
                    </span>

                </div>


                <div class="pet-count">
                    2
                </div>


                <div class="contact">
                    Oct 2023
                </div>

            </div>



            <!-- Client 2 -->

            <div class="client-row">

                <div class="client-info">

                    <div class="client-avatar blue">
                        JT
                    </div>

                    <div class="client-name">
                        James Thomson
                    </div>

                </div>


                <div class="client-id">
                    #HP-8329
                </div>


                <div class="contact">

                    james@gmail.com

                    <br>

                    <span class="phone">
                        0772834782
                    </span>

                </div>


                <div class="pet-count">
                    3
                </div>


                <div class="contact">
                    Nov 2023
                </div>

            </div>



            <!-- Client 3 -->

            <div class="client-row">

                <div class="client-info">

                    <div class="client-avatar gray">
                        SM
                    </div>

                    <div class="client-name">
                        Sarah Miller
                    </div>

                </div>


                <div class="client-id">
                    #HP-1102
                </div>


                <div class="contact">

                    sarah.m@outlook.com

                    <br>

                    <span class="phone">
                        0771122334
                    </span>

                </div>


                <div class="pet-count">
                    1
                </div>


                <div class="contact">
                    Jan 2023
                </div>

            </div>



            <!-- Footer -->

            <div class="table-footer">

                <div class="showing">

                    SHOWING 1-3 OF 48 CLIENTS

                </div>


                <div class="pagination">

                    <button class="page-button prev-next">
                        PREV
                    </button>

                    <button class="page-button active">
                        1
                    </button>

                    <button class="page-button">
                        2
                    </button>

                    <button class="page-button">
                        3
                    </button>

                    <button class="page-button prev-next">
                        NEXT
                    </button>

                </div>

            </div>


        </section>


    </main>

</div>

<script src="<?php echo URLROOT; ?>/js/staff-clients.js"></script>
</body>

</html>