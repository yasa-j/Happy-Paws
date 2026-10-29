<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Happy Paws | Receptionist Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/staff-common.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/staff-dashboard.css?v=3">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/shared-staff-header.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/vet-sidebar.css">
</head>
<body>

<div class="staff-layout">

    <!-- Existing sidebar: do not change -->
    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>

    <!-- Main area: existing header + dashboard -->
    <div class="staff-main-area">

        <!-- Existing header: do not change -->
        <?php require_once APPROOT . '/views/layouts/staff-header.php'; ?>

        <main class="staff-dashboard-content">

            <!-- Welcome heading -->
            <div class="dashboard-heading">

                <div>
                    <h1>Welcome Back, Emily!</h1>

                </div>

                <div class="date-box">
                    <span>▣</span>
                    Monday, Oct 25th 2027
                </div>

            </div>

            


            <section class="stats-grid" aria-label="Clinic summary">
                <article class="summary-card">
                    <div class="summary-card-top">
                        <div>
                            <p class="summary-label">TODAY'S APPOINTMENTS</p>
                            <h2>12</h2>
                            <p class="summary-note">Scheduled for today</p>
                        </div>
                        <div class="summary-icon icon-teal">▦</div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/index.php?url=staff/appointments">View schedule <span>→</span></a>
                </article>

                <article class="summary-card">
                    <div class="summary-card-top">
                        <div>
                            <p class="summary-label">WALK-INS</p>
                            <h2 class="green-number">4</h2>
                            <p class="summary-note">Walk-in registrations today</p>
                        </div>
                        <div class="summary-icon icon-green">♙+</div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/index.php?url=staff/walkin">Register walk-in <span>→</span></a>
                </article>

                <article class="summary-card">
                    <div class="summary-card-top">
                        <div>
                            <p class="summary-label">PAYMENTS TODAY</p>
                            <h2 class="orange-number">3</h2>
                            <p class="summary-note">Payments completed</p>
                        </div>
                        <div class="summary-icon icon-orange">▱</div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/index.php?url=staff/billing">View billing <span>→</span></a>
                </article>

                <article class="summary-card">
                    <div class="summary-card-top">
                        <div>
                            <p class="summary-label">NEW CLIENTS</p>
                            <h2 class="blue-number">5</h2>
                            <p class="summary-note">Registered this week</p>
                        </div>
                        <div class="summary-icon icon-blue">♙+</div>
                    </div>
                    <a href="<?php echo URLROOT; ?>/index.php?url=staff/clients">View clients <span>→</span></a>
                </article>
            </section>

            <section class="dashboard-charts">
                <article class="dashboard-panel weekly-panel">
                    <div class="panel-heading">
                        <div>
                            <h2><span class="heading-symbol">▥</span> Weekly Appointments</h2>
                            <p>Appointment activity throughout the week</p>
                        </div>
                        <span class="period-pill">This Week</span>
                    </div>

                    <div class="bar-chart" role="img" aria-label="Weekly appointments: Monday 8, Tuesday 12, Wednesday 9, Thursday 15, Friday 11, Saturday 7, Sunday 4">
                        <div class="chart-y-labels"><span>20</span><span>15</span><span>10</span><span>5</span><span>0</span></div>
                        <div class="chart-plot">
                            <div class="chart-gridline grid-20"></div>
                            <div class="chart-gridline grid-15"></div>
                            <div class="chart-gridline grid-10"></div>
                            <div class="chart-gridline grid-5"></div>
                            <div class="chart-gridline grid-0"></div>
                            <div class="bar-column"><span class="bar-value">8</span><div class="bar bar-light" style="--bar-height:40%"></div><span class="bar-day">Mon</span></div>
                            <div class="bar-column"><span class="bar-value">12</span><div class="bar bar-dark" style="--bar-height:60%"></div><span class="bar-day">Tue</span></div>
                            <div class="bar-column"><span class="bar-value">9</span><div class="bar bar-light" style="--bar-height:45%"></div><span class="bar-day">Wed</span></div>
                            <div class="bar-column"><span class="bar-value">15</span><div class="bar bar-dark" style="--bar-height:75%"></div><span class="bar-day">Thu</span></div>
                            <div class="bar-column"><span class="bar-value">11</span><div class="bar bar-light" style="--bar-height:55%"></div><span class="bar-day">Fri</span></div>
                            <div class="bar-column"><span class="bar-value">7</span><div class="bar bar-pale" style="--bar-height:35%"></div><span class="bar-day">Sat</span></div>
                            <div class="bar-column"><span class="bar-value">4</span><div class="bar bar-paler" style="--bar-height:20%"></div><span class="bar-day">Sun</span></div>
                        </div>
                    </div>
                </article>

                <article class="dashboard-panel status-panel">
                    <div class="panel-heading">
                        <div>
                            <h2><span class="heading-symbol">◷</span> Appointment Status</h2>
                            <p>Overview of appointment progress</p>
                        </div>
                    </div>
                    <div class="status-chart-content">
                        <div class="donut-chart" role="img" aria-label="16 appointments: 8 confirmed, 3 pending, 5 completed">
                            <div class="donut-hole"><strong>16</strong><span>Appointments</span></div>
                        </div>
                        <div class="status-legend">
                            <div><span class="legend-dot confirmed-dot"></span><span>Confirmed</span><strong>8</strong><small>50%</small></div>
                            <div><span class="legend-dot pending-dot"></span><span>Pending</span><strong>3</strong><small>19%</small></div>
                            <div><span class="legend-dot completed-dot"></span><span>Completed</span><strong>5</strong><small>31%</small></div>
                        </div>
                    </div>
                </article>
            </section>

            <section class="dashboard-panel recent-panel">
                <div class="recent-heading">
                    <div>
                        <h2>Recent Appointments</h2>
                        <p>Keep track of today's patient visits</p>
                    </div>
                    <a href="<?php echo URLROOT; ?>/index.php?url=staff/appointments">View All →</a>
                </div>

                <div class="appointments-table-wrap">
                    <table class="appointments-table">
                        <thead>
                            <tr>
                                <th>TIME</th>
                                <th>PATIENT</th>
                                <th>OWNER</th>
                                <th>VISIT TYPE</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>09:00 AM</td>
                                <td><span class="pet-avatar dog-avatar">🐶</span><strong>Cooper</strong></td>
                                <td>Sarah Jenkins</td>
                                <td><span class="visit-tag checkup-tag">Check-up</span></td>
                                <td><span class="status-tag confirmed-tag"><i></i>Confirmed</span></td>
                                
                            </tr>
                            <tr>
                                <td>10:30 AM</td>
                                <td><span class="pet-avatar cat-avatar">🐱</span><strong>Luna</strong></td>
                                <td>Mark Robinson</td>
                                <td><span class="visit-tag vaccination-tag">Vaccination</span></td>
                                <td><span class="status-tag pending-tag"><i></i>Pending</span></td>
                                
                            </tr>
                            <tr>
                                <td>11:30 AM</td>
                                <td><span class="pet-avatar dog-avatar">🐶</span><strong>Milo</strong></td>
                                <td>Sarah Miller</td>
                                <td><span class="visit-tag consultation-tag">Consultation</span></td>
                                <td><span class="status-tag completed-tag"><i></i>Completed</span></td>
                               
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- Reuse your existing sidebar. Do not replace this file. -->
    <?php require_once APPROOT . '/views/layouts/staff_sidebar.php'; ?>
</div>

</body>
</html>
