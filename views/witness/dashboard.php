<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="witness-dashboard-page">

        <!-- ================================
             PAGE HEADER
        ================================= -->

        <div class="witness-dashboard-header">

            <div>

                <p class="eyebrow">
                    WITNESS OVERVIEW
                </p>

                <h1>
                    Witness Dashboard
                </h1>

                <p class="page-subtitle">
                    Welcome back,
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['user']['name']
                            ?? 'Witness',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>.
                    Track incidents, donations and admin alerts
                    from one place.
                </p>

            </div>


            <div class="witness-dashboard-actions">

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


        <!-- ================================
             STATISTICS
        ================================= -->

        <div class="witness-stats-grid">


            <!-- TOTAL REPORTS -->

            <div class="witness-stat-card">

                <div class="witness-stat-top">

                    <span class="witness-stat-label">
                        Incident Reports
                    </span>

                    <span class="witness-stat-icon">
                        IR
                    </span>

                </div>

                <strong class="witness-stat-value">

                    <?= (int)(
                        $dashboardCounts['total_reports']
                        ?? 0
                    ); ?>

                </strong>

                <div class="witness-stat-footer">

                    <span>
                        Total submitted reports
                    </span>

                    <a href="index.php?page=witness-reports">
                        View Reports
                    </a>

                </div>

            </div>


            <!-- CRITICAL REPORTS -->

            <div class="witness-stat-card">

                <div class="witness-stat-top">

                    <span class="witness-stat-label">
                        Critical Reports
                    </span>

                    <span class="witness-stat-icon witness-stat-danger">
                        !
                    </span>

                </div>

                <strong class="witness-stat-value">

                    <?= (int)(
                        $dashboardCounts['critical_reports']
                        ?? 0
                    ); ?>

                </strong>

                <div class="witness-stat-footer">

                    <span>
                        Reports marked critical
                    </span>

                </div>

            </div>


            <!-- TOTAL DONATIONS -->

            <div class="witness-stat-card">

                <div class="witness-stat-top">

                    <span class="witness-stat-label">
                        Donations
                    </span>

                    <span class="witness-stat-icon">
                        DN
                    </span>

                </div>

                <strong class="witness-stat-value">

                    <?= (int)(
                        $dashboardCounts['total_donations']
                        ?? 0
                    ); ?>

                </strong>

                <div class="witness-stat-footer">

                    <span>
                        Completed donations
                    </span>

                    <a href="index.php?page=donations">
                        View History
                    </a>

                </div>

            </div>


            <!-- TOTAL DONATED -->

            <div class="witness-stat-card">

                <div class="witness-stat-top">

                    <span class="witness-stat-label">
                        Total Donated
                    </span>

                    <span class="witness-stat-icon">
                        ৳
                    </span>

                </div>

                <strong class="witness-stat-value witness-money">

                    ৳<?= number_format(
                        (float)(
                            $dashboardCounts[
                                'total_donated_amount'
                            ]
                            ?? 0
                        ),
                        2
                    ); ?>

                </strong>

                <div class="witness-stat-footer">

                    <span>
                        Total contribution amount
                    </span>

                </div>

            </div>

        </div>


        <!-- ================================
             ADMIN NOTIFICATIONS
        ================================= -->

        <section class="witness-dashboard-section">

            <div class="witness-section-heading">

                <div>

                    <p class="eyebrow">
                        ADMIN ALERTS
                    </p>

                    <h2>
                        Notifications
                    </h2>

                </div>

            </div>


            <div class="witness-panel">

                <?php if (
                    empty($dashboardNotifications)
                ): ?>

                    <div class="witness-empty-state">

                        <div class="witness-empty-icon">
                            N
                        </div>

                        <h3>
                            No Active Notifications
                        </h3>

                        <p>
                            Admin alerts and important notices
                            will appear here.
                        </p>

                    </div>

                <?php else: ?>

                    <div class="witness-notification-list">

                        <?php foreach (
                            $dashboardNotifications
                            as $notification
                        ): ?>

                            <?php
                            $alertType =
                                strtolower(
                                    $notification[
                                        'alert_type'
                                    ]
                                    ?? 'normal'
                                );
                            ?>

                            <div class="witness-notification-item">

                                <div class="witness-notification-content">

                                    <div class="witness-notification-title">

                                        <?= htmlspecialchars(
                                            $notification['title']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </div>


                                    <div class="witness-notification-message">

                                        <?= nl2br(
                                            htmlspecialchars(
                                                $notification['message']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ); ?>

                                    </div>


                                    <div class="witness-notification-meta">

                                        <span>
                                            Audience:
                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $notification[
                                                            'target_audience'
                                                        ]
                                                        ?? 'all'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </span>


                                        <?php if (
                                            !empty(
                                                $notification[
                                                    'created_at'
                                                ]
                                            )
                                        ): ?>

                                            <span>
                                                <?= htmlspecialchars(
                                                    date(
                                                        'd M Y, h:i A',
                                                        strtotime(
                                                            $notification[
                                                                'created_at'
                                                            ]
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </div>


                                <span
                                    class="
                                        witness-alert-badge
                                        witness-alert-<?=
                                            htmlspecialchars(
                                                $alertType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                        ?>
                                    "
                                >
                                    <?= htmlspecialchars(
                                        ucfirst($alertType),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>
                                </span>

                            </div>

                        <?php endforeach; ?>

                    </div>

                <?php endif; ?>

            </div>

        </section>


        <!-- ================================
             RECENT ACTIVITY
        ================================= -->

        <section class="witness-dashboard-section">

            <div class="witness-section-heading">

                <div>

                    <p class="eyebrow">
                        RECENT ACTIVITY
                    </p>

                    <h2>
                        Activity Overview
                    </h2>

                </div>

            </div>


            <div class="witness-dashboard-columns">


                <!-- RECENT REPORTS -->

                <div class="witness-panel">

                    <div class="witness-panel-header">

                        <div>

                            <span>
                                INCIDENT ACTIVITY
                            </span>

                            <h3>
                                Recent Reports
                            </h3>

                        </div>

                        <a href="index.php?page=witness-reports">
                            View All
                        </a>

                    </div>


                    <?php if (
                        empty($recentReports)
                    ): ?>

                        <div class="witness-empty-state">

                            <div class="witness-empty-icon">
                                R
                            </div>

                            <h3>
                                No Reports Yet
                            </h3>

                            <p>
                                Your recently submitted incident
                                reports will appear here.
                            </p>

                            <a
                                href="index.php?page=witness-report-create"
                                class="secondary-action"
                            >
                                Report an Incident
                            </a>

                        </div>

                    <?php else: ?>

                        <div class="witness-activity-list">

                            <?php foreach (
                                $recentReports
                                as $report
                            ): ?>

                                <?php
                                $damage =
                                    strtolower(
                                        $report['damage_level']
                                        ?? 'low'
                                    );
                                ?>

                                <div class="witness-activity-row">

                                    <div class="witness-activity-main">

                                        <a
                                            class="witness-activity-title"
                                            href="index.php?page=witness-report-view&id=<?= (int)$report['id']; ?>"
                                        >
                                            <?= htmlspecialchars(
                                                $report['title']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </a>


                                        <div class="witness-activity-meta">

                                            <span>
                                                <?= htmlspecialchars(
                                                    ucfirst(
                                                        $report[
                                                            'incident_type'
                                                        ]
                                                        ?? ''
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </span>


                                            <?php if (
                                                !empty(
                                                    $report['location']
                                                )
                                            ): ?>

                                                <span>•</span>

                                                <span>
                                                    <?= htmlspecialchars(
                                                        $report[
                                                            'location'
                                                        ],
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                    </div>


                                    <div class="witness-activity-side">

                                        <span
                                            class="
                                                witness-damage-badge
                                                witness-damage-<?=
                                                    htmlspecialchars(
                                                        $damage,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                ?>
                                            "
                                        >
                                            <?= htmlspecialchars(
                                                ucfirst($damage),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </span>


                                        <?php if (
                                            !empty(
                                                $report[
                                                    'incident_date'
                                                ]
                                            )
                                        ): ?>

                                            <small>
                                                <?= htmlspecialchars(
                                                    date(
                                                        'd M Y',
                                                        strtotime(
                                                            $report[
                                                                'incident_date'
                                                            ]
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>


                <!-- RECENT DONATIONS -->

                <div class="witness-panel">

                    <div class="witness-panel-header">

                        <div>

                            <span>
                                CONTRIBUTIONS
                            </span>

                            <h3>
                                Recent Donations
                            </h3>

                        </div>

                        <a href="index.php?page=donations">
                            View All
                        </a>

                    </div>


                    <?php if (
                        empty($recentDonations)
                    ): ?>

                        <div class="witness-empty-state">

                            <div class="witness-empty-icon">
                                D
                            </div>

                            <h3>
                                No Donations Yet
                            </h3>

                            <p>
                                Your recent donation history
                                will appear here.
                            </p>

                            <a
                                href="index.php?page=donation-create"
                                class="secondary-action"
                            >
                                Make a Donation
                            </a>

                        </div>

                    <?php else: ?>

                        <div class="witness-activity-list">

                            <?php foreach (
                                $recentDonations
                                as $donation
                            ): ?>

                                <?php

                                $paymentNames = [
                                    'card' =>
                                        'Credit Card',
                                    'bkash' =>
                                        'bKash',
                                    'nagad' =>
                                        'Nagad',
                                    'bank' =>
                                        'Bank Transfer',
                                    'cash' =>
                                        'Cash'
                                ];

                                $method =
                                    $paymentNames[
                                        $donation[
                                            'payment_method'
                                        ]
                                        ?? ''
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

                                <div class="witness-activity-row">

                                    <div class="witness-activity-main">

                                        <div class="witness-donation-amount">

                                            ৳<?= number_format(
                                                (float)(
                                                    $donation[
                                                        'amount'
                                                    ]
                                                    ?? 0
                                                ),
                                                2
                                            ); ?>

                                        </div>


                                        <div class="witness-activity-meta">

                                            <span>
                                                <?= htmlspecialchars(
                                                    $method,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </span>

                                            <span>•</span>

                                            <span>
                                                <?= htmlspecialchars(
                                                    ucfirst(
                                                        $donation[
                                                            'donation_type'
                                                        ]
                                                        ?? ''
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </span>

                                        </div>


                                        <?php if (
                                            !empty(
                                                $donation[
                                                    'transaction_id'
                                                ]
                                            )
                                        ): ?>

                                            <div class="witness-transaction-id">

                                                <?= htmlspecialchars(
                                                    $donation[
                                                        'transaction_id'
                                                    ],
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </div>

                                        <?php endif; ?>

                                    </div>


                                    <div class="witness-activity-side">

                                        <span
                                            class="
                                                witness-donation-status
                                                witness-donation-<?=
                                                    htmlspecialchars(
                                                        $status,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    );
                                                ?>
                                            "
                                        >
                                            <?= htmlspecialchars(
                                                ucfirst($status),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </span>


                                        <?php if (
                                            !empty(
                                                $donation[
                                                    'created_at'
                                                ]
                                            )
                                        ): ?>

                                            <small>
                                                <?= htmlspecialchars(
                                                    date(
                                                        'd M Y',
                                                        strtotime(
                                                            $donation[
                                                                'created_at'
                                                            ]
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            </small>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </section>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>