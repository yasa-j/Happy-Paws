<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Billing History</title>


    <!-- Same Google Font as other staff pages -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">


    <!-- SAME COMMON STAFF CSS -->
    <link rel="stylesheet"
         href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">


    <!-- BILLING CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-billing.css">

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
     SIDEBAR + CONTENT
========================================= -->

<div class="staff-layout">


    <!-- SAME SIDEBAR -->

    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>



    <!-- =====================================
         BILLING CONTENT
    ====================================== -->

    <main class="billing-content">


        <!-- PAGE TITLE -->

        <div class="billing-heading">

            <h1>
                Billing History
            </h1>


           <button type="button"
        class="create-invoice-button"
        onclick="window.location.href='<?php echo URLROOT; ?>/index.php?url=staff/billingDetails'">
    <span>＋</span>
    Create Invoice
</button>

        </div>



        <!-- =================================
             BILLING CARD
        ================================== -->

        <section class="billing-card">


            <!-- =================================
                 FILTER AREA
            ================================== -->

            <div class="billing-controls">


                <!-- SEARCH -->

                <div class="billing-search">

                    <span>⌕</span>

                    <input
                        type="text"
                        placeholder="Search by Client or ID...">

                </div>



                <!-- STATUS TABS -->

                <div class="billing-tabs">

                    <button class="billing-tab active">
                        All
                    </button>

                    <button class="billing-tab">
                        Paid
                    </button>

                    <button class="billing-tab">
                        Pending
                    </button>

                    <button class="billing-tab">
                        Refunded
                    </button>

                </div>



                <!-- RESULT COUNT -->

                <div class="result-count">

                    Showing 1-10 of 450<br>
                    results

                </div>


            </div>



            <!-- DATE FILTER -->

            <div class="billing-date-filter">

                <button class="date-filter-button">

                    <span>▣</span>

                    Last 30 Days

                </button>

            </div>



            <!-- =================================
                 BILLING TABLE
            ================================== -->

            <div class="billing-table">


                <!-- TABLE HEADER -->

                <div class="billing-table-header">

                    <div>
                        DATE
                    </div>

                    <div>
                        INVOICE<br>
                        ID
                    </div>

                    <div>
                        CLIENT & PET
                    </div>

                    <div>
                        AMOUNT
                    </div>

                    <div>
                        METHOD
                    </div>

                    <div>
                        STATUS
                    </div>

                </div>



                <!-- =================================
                     BILL 1
                ================================== -->

                <div class="billing-row">


                    <div class="billing-date">

                        <strong>
                            Oct 24,
                        </strong>

                        <span>
                            2023
                        </span>

                    </div>



                    <div class="invoice-id">

                        #INV-9402

                    </div>



                    <div class="client-pet">

                        <div class="client-avatar blue">

                            SM

                        </div>

                        <div>

                            <strong>
                                Sarah Miller
                            </strong>

                            <span>
                                Luna (Husky)
                            </span>

                        </div>

                    </div>



                    <div class="billing-amount">

                        Rs. 245.00

                    </div>



                    <div class="payment-method">

                        <span class="method-icon">
                            ▭
                        </span>

                        Visa (****42)

                    </div>



                    <div>

                        <span class="payment-status paid">
                            PAID
                        </span>

                    </div>


                </div>



                <!-- =================================
                     BILL 2
                ================================== -->

                <div class="billing-row">


                    <div class="billing-date">

                        <strong>
                            Oct 23,
                        </strong>

                        <span>
                            2023
                        </span>

                    </div>



                    <div class="invoice-id">

                        #INV-9401

                    </div>



                    <div class="client-pet">

                        <div class="client-avatar light-blue">

                            JW

                        </div>

                        <div>

                            <strong>
                                James Wilson
                            </strong>

                            <span>
                                Oliver (Tabby)
                            </span>

                        </div>

                    </div>



                    <div class="billing-amount">

                        Rs.<br>
                        1,280.50

                    </div>



                    <div class="payment-method">

                        <span class="method-icon">
                            ♜
                        </span>

                        Transfer

                    </div>



                    <div>

                        <span class="payment-status pending">
                            PENDING
                        </span>

                    </div>


                </div>



                <!-- =================================
                     BILL 3
                ================================== -->

                <div class="billing-row">


                    <div class="billing-date">

                        <strong>
                            Oct 21,
                        </strong>

                        <span>
                            2023
                        </span>

                    </div>



                    <div class="invoice-id">

                        #INV-9388

                    </div>



                    <div class="client-pet">

                        <div class="client-avatar light-blue">

                            EB

                        </div>

                        <div>

                            <strong>
                                Elian Brooks
                            </strong>

                            <span>
                                Charlie (Beagle)
                            </span>

                        </div>

                    </div>



                    <div class="billing-amount">

                        Rs. 65.00

                    </div>



                    <div class="payment-method">

                        <span class="method-icon">
                            ▣
                        </span>

                        Cash

                    </div>



                    <div>

                        <span class="payment-status refunded">
                            REFUNDED
                        </span>

                    </div>


                </div>



                <!-- =================================
                     BILL 4
                ================================== -->

                <div class="billing-row">


                    <div class="billing-date">

                        <strong>
                            Oct 20,
                        </strong>

                        <span>
                            2023
                        </span>

                    </div>



                    <div class="invoice-id">

                        #INV-9380

                    </div>



                    <div class="client-pet">

                        <div class="client-avatar dark-blue">

                            RD

                        </div>

                        <div>

                            <strong>
                                Robert Davis
                            </strong>

                            <span>
                                Max (Golden Retriever)
                            </span>

                        </div>

                    </div>



                    <div class="billing-amount">

                        Rs. 412.20

                    </div>



                    <div class="payment-method">

                        <span class="method-icon">
                            ▭
                        </span>

                        Mastercard<br>
                        (****11)

                    </div>



                    <div>

                        <span class="payment-status paid">
                            PAID
                        </span>

                    </div>


                </div>


            </div>


        </section>


    </main>


</div>

<script src="<?php echo URLROOT; ?>/js/staff-billing.js"></script>
</body>

</html>