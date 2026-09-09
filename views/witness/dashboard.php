<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="witness-dashboard">


        <!-- Dashboard Header -->

        <div class="dashboard-header">

            <div>

                <span class="dashboard-label">
                    WITNESS OVERVIEW
                </span>

                <h1>
                    Witness Dashboard
                </h1>

                <p>
                    Welcome,
                    <strong>
                        <?php
                        echo htmlspecialchars(
                            $_SESSION['user']['name']
                            ?? 'Witness'
                        );
                        ?>
                    </strong>
                </p>

            </div>


            <div class="header-actions">

    <a
        href="index.php?page=witness-profile"
        class="secondary-action"
    >
        My Profile
    </a>

    <a
        href="index.php?page=witness-report-create"
        class="secondary-action"
    >
        + Report Incident
    </a>

    <a
        href="index.php?page=donation-create"
        class="primary-action"
    >
        + Make Donation
    </a>

</div>

        </div>



        <!-- Admin Notifications -->

        <div class="dashboard-panel notification-panel">

            <div class="panel-header">

                <div>
                    <span class="section-small">ADMIN ALERTS</span>
                    <h2>Notifications</h2>
                </div>

            </div>

            <?php if (empty($dashboardNotifications)): ?>

                <div class="empty-data">
                    <p>No active notifications available.</p>
                </div>

            <?php else: ?>

                <div class="notification-list">

                    <?php foreach ($dashboardNotifications as $notification): ?>

                        <?php

                        $alertType = strtolower(
                            $notification['alert_type']
                            ?? 'normal'
                        );

                        ?>

                        <div class="notification-row notification-<?php echo htmlspecialchars($alertType); ?>">

                            <div class="notification-main">

                                <div class="notification-title">
                                    <?php
                                    echo htmlspecialchars(
                                        $notification['title']
                                        ?? ''
                                    );
                                    ?>
                                </div>

                                <div class="notification-message">
                                    <?php
                                    echo nl2br(
                                        htmlspecialchars(
                                            $notification['message']
                                            ?? ''
                                        )
                                    );
                                    ?>
                                </div>

                                <div class="notification-meta">

                                    Audience:
                                    <?php
                                    echo htmlspecialchars(
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $notification['target_audience']
                                                ?? 'all'
                                            )
                                        )
                                    );
                                    ?>

                                    <?php if (!empty($notification['created_at'])): ?>
                                        <span>•</span>
                                        <?php
                                        echo htmlspecialchars(
                                            date(
                                                'd M Y, h:i A',
                                                strtotime(
                                                    $notification['created_at']
                                                )
                                            )
                                        );
                                        ?>
                                    <?php endif; ?>

                                </div>

                            </div>

                            <span class="alert-badge alert-<?php echo htmlspecialchars($alertType); ?>">
                                <?php echo htmlspecialchars(ucfirst($alertType)); ?>
                            </span>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </div>



        <!-- Overview Cards -->

        <div class="stats-grid">


            <!-- Total Reports -->

            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        INCIDENT REPORTS
                    </span>

                    <span class="stat-icon">
                        R
                    </span>

                </div>

                <div class="stat-number">

                    <?php
                    echo (int)(
                        $dashboardCounts[
                            'total_reports'
                        ] ?? 0
                    );
                    ?>

                </div>

                <div class="stat-footer">

                    <a href="index.php?page=witness-reports">
                        View all reports →
                    </a>

                </div>

            </div>



            <!-- Critical Reports -->

            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        CRITICAL REPORTS
                    </span>

                    <span class="stat-icon">
                        !
                    </span>

                </div>

                <div class="stat-number">

                    <?php
                    echo (int)(
                        $dashboardCounts[
                            'critical_reports'
                        ] ?? 0
                    );
                    ?>

                </div>

                <div class="stat-description">
                    Reports marked as critical
                </div>

            </div>



            <!-- Total Donations -->

            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        DONATIONS
                    </span>

                    <span class="stat-icon">
                        D
                    </span>

                </div>

                <div class="stat-number">

                    <?php
                    echo (int)(
                        $dashboardCounts[
                            'total_donations'
                        ] ?? 0
                    );
                    ?>

                </div>

                <div class="stat-footer">

                    <a href="index.php?page=donations">
                        View donation history →
                    </a>

                </div>

            </div>



            <!-- Donation Amount -->

            <div class="stat-card">

                <div class="stat-top">

                    <span class="stat-label">
                        TOTAL DONATED
                    </span>

                    <span class="stat-icon">
                        ৳
                    </span>

                </div>

                <div class="stat-number amount-number">

                    ৳<?php
                    echo number_format(
                        (float)(
                            $dashboardCounts[
                                'total_donated_amount'
                            ] ?? 0
                        ),
                        2
                    );
                    ?>

                </div>

                <div class="stat-description">
                    Total contribution amount
                </div>

            </div>


        </div>



        <!-- Dashboard Details -->

        <div class="dashboard-sections">


            <!-- Recent Reports -->

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>

                        <span class="section-small">
                            INCIDENT ACTIVITY
                        </span>

                        <h2>
                            Recent Reports
                        </h2>

                    </div>


                    <a href="index.php?page=witness-reports">
                        View All
                    </a>

                </div>


                <?php if (empty($recentReports)): ?>

                    <div class="empty-data">

                        <p>
                            No incident reports yet.
                        </p>

                        <a href="index.php?page=witness-report-create">
                            Report an Incident
                        </a>

                    </div>

                <?php else: ?>


                    <div class="activity-list">

                        <?php foreach ($recentReports as $report): ?>

                            <?php

                            $damage =
                                strtolower(
                                    $report['damage_level']
                                    ?? 'low'
                                );

                            ?>


                            <div class="activity-item">

                                <div class="activity-main">

                                    <div class="activity-title">

                                        <a
                                            href="index.php?page=witness-report-view&id=<?php echo (int)$report['id']; ?>"
                                        >
                                            <?php
                                            echo htmlspecialchars(
                                                $report['title']
                                            );
                                            ?>
                                        </a>

                                    </div>


                                    <div class="activity-meta">

                                        <?php
                                        echo htmlspecialchars(
                                            ucfirst(
                                                $report[
                                                    'incident_type'
                                                ]
                                                ?? ''
                                            )
                                        );
                                        ?>

                                        <?php if (!empty($report['location'])): ?>

                                            <span>•</span>

                                            <?php
                                            echo htmlspecialchars(
                                                $report['location']
                                            );
                                            ?>

                                        <?php endif; ?>

                                    </div>

                                </div>


                                <div class="activity-side">

                                    <span
                                        class="damage-badge damage-<?php echo htmlspecialchars($damage); ?>"
                                    >
                                        <?php
                                        echo htmlspecialchars(
                                            ucfirst($damage)
                                        );
                                        ?>
                                    </span>


                                    <small>

                                        <?php

                                        if (!empty(
                                            $report['incident_date']
                                        )) {

                                            echo htmlspecialchars(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $report[
                                                            'incident_date'
                                                        ]
                                                    )
                                                )
                                            );

                                        }

                                        ?>

                                    </small>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>



            <!-- Recent Donations -->

            <div class="dashboard-panel">

                <div class="panel-header">

                    <div>

                        <span class="section-small">
                            CONTRIBUTIONS
                        </span>

                        <h2>
                            Recent Donations
                        </h2>

                    </div>


                    <a href="index.php?page=donations">
                        View All
                    </a>

                </div>


                <?php if (empty($recentDonations)): ?>

                    <div class="empty-data">

                        <p>
                            No donations yet.
                        </p>

                        <a href="index.php?page=donation-create">
                            Make a Donation
                        </a>

                    </div>

                <?php else: ?>


                    <div class="activity-list">

                        <?php foreach ($recentDonations as $donation): ?>

                            <?php

                            $paymentNames = [
                                'card' => 'Credit Card',
                                'bkash' => 'bKash',
                                'nagad' => 'Nagad',
                                'bank' => 'Bank Transfer',
                                'cash' => 'Cash'
                            ];

                            $paymentMethod =
                                $paymentNames[
                                    $donation[
                                        'payment_method'
                                    ]
                                ]
                                ?? ucfirst(
                                    $donation[
                                        'payment_method'
                                    ]
                                    ?? ''
                                );


                            $status =
                                strtolower(
                                    $donation['status']
                                    ?? 'pending'
                                );

                            ?>


                            <div class="activity-item">

                                <div class="activity-main">

                                    <div class="donation-dashboard-amount">

                                        ৳<?php
                                        echo number_format(
                                            (float)$donation[
                                                'amount'
                                            ],
                                            2
                                        );
                                        ?>

                                    </div>


                                    <div class="activity-meta">

                                        <?php
                                        echo htmlspecialchars(
                                            $paymentMethod
                                        );
                                        ?>

                                        <span>•</span>

                                        <?php
                                        echo htmlspecialchars(
                                            ucfirst(
                                                $donation[
                                                    'donation_type'
                                                ]
                                            )
                                        );
                                        ?>

                                    </div>


                                    <div class="transaction-small">

                                        <?php
                                        echo htmlspecialchars(
                                            $donation[
                                                'transaction_id'
                                            ]
                                            ?? ''
                                        );
                                        ?>

                                    </div>

                                </div>


                                <div class="activity-side">

                                    <span
                                        class="donation-status status-<?php echo htmlspecialchars($status); ?>"
                                    >

                                        <?php
                                        echo htmlspecialchars(
                                            ucfirst($status)
                                        );
                                        ?>

                                    </span>


                                    <small>

                                        <?php

                                        if (!empty(
                                            $donation['created_at']
                                        )) {

                                            echo htmlspecialchars(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $donation[
                                                            'created_at'
                                                        ]
                                                    )
                                                )
                                            );

                                        }

                                        ?>

                                    </small>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>


        </div>

    </div>

</div>



<style>

/* ========================================
   Dashboard
======================================== */

.witness-dashboard {
    max-width: 1200px;
    margin: 0 auto;
    padding: 8px 5px 45px;
}


/* ========================================
   Header
======================================== */

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
    margin-bottom: 28px;
}

.dashboard-label,
.section-small {
    display: block;
    margin-bottom: 5px;
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 1.2px;
}

.dashboard-header h1 {
    margin: 0 0 8px;
    color: #172033;
    font-size: 31px;
}

.dashboard-header p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}

.header-actions {
    display: flex;
    gap: 10px;
}

.primary-action,
.secondary-action {
    padding: 11px 16px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
}

.primary-action {
    background: #26384d !important;
    color: white !important;
}

.primary-action:hover {
    background: #172536 !important;
}

.secondary-action {
    border: 1px solid #cbd5e1;
    background: white;
    color: #334155 !important;
}


/* ========================================
   Admin Notifications
======================================== */

.notification-panel {
    margin-bottom: 26px;
}

.notification-list {
    display: flex;
    flex-direction: column;
}

.notification-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 18px;
    padding: 18px 21px;
    border-bottom: 1px solid #eef2f6;
}

.notification-row:last-child {
    border-bottom: none;
}

.notification-main {
    min-width: 0;
}

.notification-title {
    color: #1e293b;
    font-size: 14px;
    font-weight: 800;
}

.notification-message {
    margin-top: 6px;
    color: #475569;
    font-size: 13px;
    line-height: 1.6;
}

.notification-meta {
    margin-top: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    color: #94a3b8;
    font-size: 11px;
}

.alert-badge {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    white-space: nowrap;
    font-size: 10px;
    font-weight: 800;
}

.alert-normal {
    background: #f1f5f9;
    color: #475569;
}

.alert-important {
    background: #fff7e6;
    color: #9a6700;
}

.alert-emergency {
    background: #fff1f1;
    color: #b42318;
}


/* ========================================
   Statistics
======================================== */

.stats-grid {
    display: grid;
    grid-template-columns:
        repeat(4, minmax(0, 1fr));
    gap: 17px;
    margin-bottom: 26px;
}

.stat-card {
    min-height: 150px;
    padding: 20px;
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow:
        0 3px 12px rgba(0, 0, 0, 0.04);
}

.stat-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-label {
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .7px;
}

.stat-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f1f5f9;
    color: #334155;
    font-size: 13px;
    font-weight: 900;
}

.stat-number {
    margin: 20px 0 12px;
    color: #172033;
    font-size: 31px;
    line-height: 1;
    font-weight: 800;
}

.amount-number {
    font-size: 27px;
}

.stat-description {
    color: #94a3b8;
    font-size: 12px;
}

.stat-footer a {
    color: #475569 !important;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}


/* ========================================
   Main Panels
======================================== */

.dashboard-sections {
    display: grid;
    grid-template-columns:
        repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.dashboard-panel {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow:
        0 3px 12px rgba(0, 0, 0, 0.04);
}

.panel-header {
    padding: 20px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e5e7eb;
}

.panel-header h2 {
    margin: 0;
    color: #1e293b;
    font-size: 19px;
}

.panel-header > a {
    color: #475569 !important;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
}


/* ========================================
   Activities
======================================== */

.activity-item {
    padding: 17px 21px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    border-bottom: 1px solid #eef2f6;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background: #fafbfd;
}

.activity-main {
    min-width: 0;
}

.activity-title a {
    color: #1e293b !important;
    font-size: 14px;
    font-weight: 750;
    text-decoration: none;
}

.activity-title a:hover {
    text-decoration: underline;
}

.activity-meta {
    margin-top: 5px;
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    color: #64748b;
    font-size: 12px;
}

.activity-side {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 7px;
}

.activity-side small {
    color: #94a3b8;
    white-space: nowrap;
    font-size: 11px;
}


/* ========================================
   Damage Levels
======================================== */

.damage-badge,
.donation-status {
    display: inline-block;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 800;
}

.damage-low {
    background: #ecfdf3;
    color: #18794e;
}

.damage-medium {
    background: #fff8e6;
    color: #946200;
}

.damage-high {
    background: #fff0e5;
    color: #b54708;
}

.damage-critical {
    background: #fff1f1;
    color: #b42318;
}


/* ========================================
   Donations
======================================== */

.donation-dashboard-amount {
    color: #172033;
    font-size: 16px;
    font-weight: 800;
}

.transaction-small {
    margin-top: 7px;
    color: #64748b;
    font-family: Consolas, monospace;
    font-size: 11px;
}

.status-pending {
    background: #fff7e6;
    color: #9a6700;
}

.status-approved,
.status-completed,
.status-success {
    background: #ecfdf3;
    color: #18794e;
}

.status-rejected,
.status-failed,
.status-cancelled {
    background: #fff1f1;
    color: #b42318;
}


/* ========================================
   Empty State
======================================== */

.empty-data {
    padding: 40px 20px;
    text-align: center;
}

.empty-data p {
    margin: 0 0 10px;
    color: #64748b;
}

.empty-data a {
    color: #334155 !important;
    font-size: 13px;
    font-weight: 700;
}


/* ========================================
   Responsive
======================================== */

@media (max-width: 1050px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 750px) {

    .dashboard-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .dashboard-sections {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 520px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .header-actions {
        width: 100%;
        flex-direction: column;
    }

    .primary-action,
    .secondary-action {
        text-align: center;
    }

}

</style>

<?php require_once "views/partials/footer.php"; ?>