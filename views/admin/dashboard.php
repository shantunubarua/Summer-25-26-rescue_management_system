<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$adminName =
    $_SESSION['user']['name']
    ?? 'Admin';

?>

<div class="content">

    <div class="admin-dashboard-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-dashboard-header">

            <div>

                <p class="eyebrow">
                    ADMINISTRATION OVERVIEW
                </p>

                <h1>
                    Admin Dashboard
                </h1>

                <p class="page-subtitle">
                    Welcome back,
                    <strong>
                        <?= htmlspecialchars(
                            $adminName,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>.
                    Review system activity and manage the
                    Rescue Management System from one place.
                </p>

            </div>

        </div>


        <!-- =========================================
             USER OVERVIEW
             ========================================= -->

        <section class="admin-dashboard-section">

            <div class="admin-dashboard-section-heading">

                <div>

                    <p class="admin-dashboard-section-eyebrow">
                        USER OVERVIEW
                    </p>

                    <h2>
                        Registered Users
                    </h2>

                </div>


                <p class="admin-dashboard-section-description">
                    Current registered user accounts by role.
                </p>

            </div>


            <div class="admin-user-stat-grid">


                <!-- VOLUNTEERS -->

                <article class="admin-user-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-code">
                            VOL
                        </span>

                        <span class="admin-stat-category">
                            Volunteer
                        </span>

                    </div>


                    <strong class="admin-stat-number">

                        <?= (int)(
                            $dashboardCounts['volunteers']
                            ?? 0
                        ); ?>

                    </strong>


                    <p>
                        Registered volunteer accounts
                        available in the system.
                    </p>

                </article>


                <!-- WITNESSES -->

                <article class="admin-user-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-code">
                            WIT
                        </span>

                        <span class="admin-stat-category">
                            Witness
                        </span>

                    </div>


                    <strong class="admin-stat-number">

                        <?= (int)(
                            $dashboardCounts['witnesses']
                            ?? 0
                        ); ?>

                    </strong>


                    <p>
                        Registered witness accounts
                        in the system.
                    </p>

                </article>


                <!-- HELP SEEKERS -->

                <article class="admin-user-stat-card">

                    <div class="admin-stat-top">

                        <span class="admin-stat-code">
                            HLP
                        </span>

                        <span class="admin-stat-category">
                            Help Seeker
                        </span>

                    </div>


                    <strong class="admin-stat-number">

                        <?= (int)(
                            $dashboardCounts['help_seekers']
                            ?? 0
                        ); ?>

                    </strong>


                    <p>
                        Registered help seeker accounts
                        using rescue services.
                    </p>

                </article>

            </div>

        </section>


        <!-- =========================================
             SYSTEM ACTIVITY
             ========================================= -->

        <section class="admin-dashboard-section">

            <div class="admin-dashboard-section-heading">

                <div>

                    <p class="admin-dashboard-section-eyebrow">
                        SYSTEM ACTIVITY
                    </p>

                    <h2>
                        Management Overview
                    </h2>

                </div>


                <p class="admin-dashboard-section-description">
                    Key records currently managed by the administration.
                </p>

            </div>


            <div class="admin-management-grid">


                <!-- NOTIFICATIONS -->

                <a
                    href="index.php?page=notifications"
                    class="admin-management-card"
                >

                    <div class="admin-management-card-header">

                        <span class="admin-management-code">
                            NTF
                        </span>

                        <span class="admin-management-arrow">
                            →
                        </span>

                    </div>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['notifications']
                            ?? 0
                        ); ?>

                    </strong>


                    <h3>
                        Notifications
                    </h3>


                    <p>
                        Manage system announcements and
                        important user alerts.
                    </p>


                    <span class="admin-management-link">
                        Manage Notifications
                    </span>

                </a>


                <!-- FEEDBACK -->

                <a
                    href="index.php?page=feedback"
                    class="admin-management-card"
                >

                    <div class="admin-management-card-header">

                        <span class="admin-management-code">
                            FDB
                        </span>

                        <span class="admin-management-arrow">
                            →
                        </span>

                    </div>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['feedback']
                            ?? 0
                        ); ?>

                    </strong>


                    <h3>
                        Feedback
                    </h3>


                    <p>
                        Review feedback submitted after
                        rescue activities.
                    </p>


                    <span class="admin-management-link">
                        Review Feedback
                    </span>

                </a>


                <!-- RESCUE REPORTS -->

                <a
                    href="index.php?page=rescue-reports"
                    class="admin-management-card"
                >

                    <div class="admin-management-card-header">

                        <span class="admin-management-code">
                            RPT
                        </span>

                        <span class="admin-management-arrow">
                            →
                        </span>

                    </div>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['rescue_reports']
                            ?? 0
                        ); ?>

                    </strong>


                    <h3>
                        Rescue Reports
                    </h3>


                    <p>
                        Review and manage official
                        rescue operation reports.
                    </p>


                    <span class="admin-management-link">
                        Manage Reports
                    </span>

                </a>


                <!-- EMERGENCY REQUESTS -->

                <article class="admin-management-card admin-management-card-static">

                    <div class="admin-management-card-header">

                        <span class="admin-management-code">
                            EMR
                        </span>

                    </div>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['emergency_requests']
                            ?? 0
                        ); ?>

                    </strong>


                    <h3>
                        Emergency Requests
                    </h3>


                    <p>
                        Total emergency rescue requests
                        recorded in the system.
                    </p>


                    <span class="admin-management-link admin-management-link-muted">
                        System Record
                    </span>

                </article>

            </div>

        </section>


        <!-- =========================================
             DONATION OVERVIEW
             ========================================= -->

        <section class="admin-dashboard-section">

            <div class="admin-dashboard-section-heading">

                <div>

                    <p class="admin-dashboard-section-eyebrow">
                        DONATION OVERVIEW
                    </p>

                    <h2>
                        Donation Activity
                    </h2>

                </div>


                <a
                    href="index.php?page=admin-donations"
                    class="secondary-action"
                >
                    View Donations
                </a>

            </div>


            <div class="admin-donation-summary">


                <!-- TOTAL DONATIONS -->

                <div class="admin-donation-stat">

                    <span>
                        Total Donations
                    </span>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['donations']
                            ?? 0
                        ); ?>

                    </strong>


                    <p>
                        Donation records submitted
                        through the system.
                    </p>

                </div>


                <!-- DONORS -->

                <div class="admin-donation-stat">

                    <span>
                        Witness Donors
                    </span>


                    <strong>

                        <?= (int)(
                            $dashboardCounts['donors']
                            ?? 0
                        ); ?>

                    </strong>


                    <p>
                        Witnesses who have submitted
                        donations.
                    </p>

                </div>


                <!-- AMOUNT -->

                <div class="admin-donation-stat">

                    <span>
                        Total Donated Amount
                    </span>


                    <strong class="admin-donation-amount">

                        <?= htmlspecialchars(
                            number_format(
                                (float)(
                                    $dashboardCounts['money_donated']
                                    ?? 0
                                ),
                                2
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </strong>


                    <p>
                        Combined amount from completed
                        donations.
                    </p>

                </div>

            </div>

        </section>


        <!-- =========================================
             ADMIN QUICK ACCESS
             ========================================= -->

        <section class="admin-dashboard-section">

            <div class="admin-dashboard-section-heading">

                <div>

                    <p class="admin-dashboard-section-eyebrow">
                        QUICK ACCESS
                    </p>

                    <h2>
                        Administration
                    </h2>

                </div>

            </div>


            <div class="admin-quick-access-grid">


                <a href="index.php?page=notifications">
                    <span>
                        Notifications
                    </span>

                    <strong>
                        Manage Alerts →
                    </strong>
                </a>


                <a href="index.php?page=feedback">
                    <span>
                        Feedback
                    </span>

                    <strong>
                        Review Feedback →
                    </strong>
                </a>


                <a href="index.php?page=admin-witness-reports">
                    <span>
                        Witness Reports
                    </span>

                    <strong>
                        Review Reports →
                    </strong>
                </a>


                <a href="index.php?page=rescue-reports">
                    <span>
                        Rescue Reports
                    </span>

                    <strong>
                        Manage Reports →
                    </strong>
                </a>


                <a href="index.php?page=admin-resource-requests">
                    <span>
                        Resource Requests
                    </span>

                    <strong>
                        Manage Requests →
                    </strong>
                </a>


                <a href="index.php?page=admin-donations">
                    <span>
                        Donations
                    </span>

                    <strong>
                        View Donations →
                    </strong>
                </a>

            </div>

        </section>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>