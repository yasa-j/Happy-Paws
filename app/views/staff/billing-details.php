<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>HappyPaws - Billing & Payments</title>


    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">


    <!-- Common Staff CSS -->
    <link rel="stylesheet"
        href="<?php echo URLROOT; ?>/css/staff-common.css?v=2">
        
    <!-- Billing Details CSS -->
    <link rel="stylesheet"
          href="<?php echo URLROOT; ?>/css/staff-billing-details.css">

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


    <!-- SAME SIDEBAR USED BY ALL STAFF PAGES -->

    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>



    <!-- =====================================
         BILLING DETAILS CONTENT
    ====================================== -->

    <main class="billing-details-content">


        <!-- =================================
             PAGE HEADER
        ================================== -->

        <div class="billing-page-header">

            <div class="billing-title-area">

                <h1>
                    <span class="title-icon">▤</span>
                    Billing &amp; Payments
                </h1>

                <p>
                    Invoice Generation &amp; Management
                </p>

            </div>


            <div class="billing-header-buttons">

                <button class="preview-button">
                    Preview PDF
                </button>

                <button class="print-button">
                    ▣ &nbsp; Print
                </button>

            </div>

        </div>



        <!-- =================================
             MAIN BILLING GRID
        ================================== -->

        <div class="billing-main-grid">


            <!-- =================================
                 LEFT SIDE
            ================================== -->

            <div class="billing-left">


                <!-- =================================
                     CLIENT + INVOICE INFORMATION
                ================================== -->

                <section class="invoice-information-card">


                    <!-- CLIENT INFORMATION -->

                    <div class="client-information">

                        <h3>
                            CLIENT INFORMATION
                        </h3>


                        <div class="client-box">

                            <div class="client-photo">

                                <span>JD</span>

                            </div>


                            <div class="client-details">

                                <strong>
                                    John Doe
                                </strong>

                                <small>
                                    ID: 0772456986
                                </small>

                                <small>
                                    Luka (Golden Retriever)
                                </small>

                            </div>

                        </div>

                    </div>



                    <!-- DIVIDER -->

                    <div class="information-divider"></div>



                    <!-- INVOICE DETAILS -->

                    <div class="invoice-details">

                        <div class="invoice-heading">

                            <h3>
                                INVOICE DETAILS
                            </h3>

                            <span class="draft-badge">
                                DRAFT
                            </span>

                        </div>


                        <div class="invoice-row">

                            <span>
                                Invoice #
                            </span>

                            <strong>
                                INV-00834
                            </strong>

                        </div>


                        <div class="invoice-row">

                            <span>
                                Issued Date
                            </span>

                            <strong>
                                20 May 2025
                            </strong>

                        </div>


                        <div class="invoice-row">

                            <span>
                                Due Date
                            </span>

                            <strong>
                                27 May 2025
                            </strong>

                        </div>

                    </div>

                </section>



                <!-- =================================
                     SERVICES RENDERED
                ================================== -->

                <section class="services-card">


                    <div class="services-header">

                        <h2>
                            Services Rendered
                        </h2>


                        <button class="add-fee-button">
                            ⊕ &nbsp; Add New fee
                        </button>

                    </div>



                    <!-- TABLE HEADER -->

                    <div class="services-table-header">

                        <div>
                            DESCRIPTION
                        </div>

                        <div>
                            UNIT<br>PRICE
                        </div>

                        <div>
                            QTY
                        </div>

                        <div>
                            TOTAL
                        </div>

                    </div>



                    <!-- SERVICE 1 -->

                    <div class="service-row">

                        <div class="service-description">

                            <strong>
                                Consultation Fee
                            </strong>

                            <small>
                                Standard wellness checkup
                            </small>

                        </div>


                        <div class="service-price">

                            Rs.<br>
                            1600.00

                        </div>


                        <div class="service-qty">
                            1
                        </div>


                        <div class="service-total">

                            Rs.<br>
                            1600.00

                        </div>

                    </div>



                    <!-- SERVICE 2 -->

                    <div class="service-row">

                        <div class="service-description">

                            <strong>
                                Appointment<br>
                                Confirmation Fee
                            </strong>

                            <small>
                                Priority scheduling charge
                            </small>

                        </div>


                        <div class="service-price">

                            Rs.<br>
                            500.00

                        </div>


                        <div class="service-qty">
                            1
                        </div>


                        <div class="service-total">

                            Rs.<br>
                            500.00

                        </div>

                    </div>



                    <!-- TOTALS -->

                    <div class="invoice-totals">

                        <div class="total-row">

                            <span>
                                Subtotal
                            </span>

                            <strong>
                                Rs. 2100.00
                            </strong>

                        </div>


                        <div class="total-row discount">

                            <span>
                                Discount (0%)
                            </span>

                            <strong>
                                -Rs. 0.00
                            </strong>

                        </div>


                        <div class="total-line"></div>


                        <div class="grand-total">

                            <strong>
                                Total Amount
                            </strong>

                            <strong>
                                Rs. 2100.00
                            </strong>

                        </div>

                    </div>

                </section>

            </div>



            <!-- =================================
                 RIGHT SIDE - PAYMENT PROCESS
            ================================== -->

            <aside class="payment-process-card">


                <h2>
                    ▤ &nbsp; Payment Process
                </h2>


                <p class="payment-label">
                    SELECT METHOD
                </p>



                <!-- CASH -->

                <label class="payment-option selected">

                    <input
                        type="radio"
                        name="payment"
                        checked>

                    <span class="radio-circle"></span>

                    <span class="payment-icon">
                        ▣
                    </span>

                    <strong>
                        Cash
                    </strong>

                </label>



                <!-- CARD -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment">

                    <span class="radio-circle"></span>

                    <span class="payment-icon">
                        ▤
                    </span>

                    <span>
                        Card Payment
                    </span>

                </label>



                <!-- BANK -->

                <label class="payment-option">

                    <input
                        type="radio"
                        name="payment">

                    <span class="radio-circle"></span>

                    <span class="payment-icon">
                        ♜
                    </span>

                    <span>
                        Bank Transfer
                    </span>

                </label>



                <div class="payment-divider"></div>



                <!-- TRANSACTION SUMMARY -->

                <p class="payment-label">
                    TRANSACTION SUMMARY
                </p>


                <div class="transaction-summary">

                    <span class="amount-label">
                        AMOUNT RECEIVED
                    </span>


                    <div class="amount-box">

                        Rs. <strong>
                            2100.00
                        </strong>

                    </div>


                    <div class="outstanding-line"></div>


                    <div class="outstanding">

                        <span>
                            Outstanding
                        </span>

                        <strong>
                            Rs. 0.00
                        </strong>

                    </div>

                </div>



                <!-- ACTION BUTTONS -->

                <button class="finalize-button">

                    ◉ &nbsp;
                    Finalize &amp; Save Invoice

                </button>


                <button class="cancel-button">

                    Cancel Transaction

                </button>

            </aside>

        </div>

    </main>

</div>
<script src="<?php echo URLROOT; ?>/js/staff-billing-details.js"></script>

</body>

</html>