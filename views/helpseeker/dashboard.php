<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="helpseeker-dashboard-page">


        <!-- ================================
             PAGE HEADER
        ================================= -->

        <div class="page-header">

            <div>

                <p class="eyebrow">
                    HELP SEEKER OVERVIEW
                </p>

                <h1>
                    Help Seeker Dashboard
                </h1>

                <p class="page-subtitle">
                    Welcome back,
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['user']['name']
                            ?? 'Help Seeker',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>.
                    Request emergency assistance, track your rescue
                    requests and find available volunteers.
                </p>

            </div>


            <div class="helpseeker-header-actions">

                <a
                    href="index.php?page=helpseeker-profile"
                    class="secondary-action"
                >
                    My Profile
                </a>

                <a
                    href="index.php?page=helpseeker-request-create"
                    class="primary-action"
                >
                    + Request Rescue
                </a>

            </div>

        </div>


        <!-- ================================
             EMERGENCY ACTION
        ================================= -->

        <div class="helpseeker-emergency-card">

            <div class="helpseeker-emergency-icon">
                SOS
            </div>

            <div class="helpseeker-emergency-content">

                <span>
                    NEED RESCUE ASSISTANCE?
                </span>

                <h2>
                    Create an Emergency Request
                </h2>

                <p>
                    Submit your location, emergency type,
                    priority, victim information and contact
                    details so volunteers can respond.
                </p>

            </div>

            <a
                href="index.php?page=helpseeker-request-create"
                class="helpseeker-emergency-button"
            >
                Request Rescue
            </a>

        </div>


        <!-- ================================
             QUICK ACCESS
        ================================= -->

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="eyebrow">
                        QUICK ACCESS
                    </p>

                    <h2>
                        Help Seeker Actions
                    </h2>

                </div>

            </div>


            <div class="quick-action-grid">


                <!-- REQUEST RESCUE -->

                <a
                    class="quick-action-card"
                    href="index.php?page=helpseeker-request-create"
                >

                    <span class="quick-action-tag">
                        Emergency
                    </span>

                    <h3>
                        Request Rescue
                    </h3>

                    <p>
                        Submit a new emergency rescue request
                        with victim and priority information.
                    </p>

                    <span class="quick-action-link">
                        Create Request →
                    </span>

                </a>


                <!-- MY REQUESTS -->

                <a
                    class="quick-action-card"
                    href="index.php?page=helpseeker-requests"
                >

                    <span class="quick-action-tag">
                        Tracking
                    </span>

                    <h3>
                        My Requests
                    </h3>

                    <p>
                        Search and track your submitted rescue
                        requests and their current status.
                    </p>

                    <span class="quick-action-link">
                        View Requests →
                    </span>

                </a>


                <!-- NEARBY VOLUNTEERS -->

                <a
                    class="quick-action-card"
                    href="index.php?page=helpseeker-nearby-volunteers"
                >

                    <span class="quick-action-tag">
                        Volunteers
                    </span>

                    <h3>
                        Nearby Volunteers
                    </h3>

                    <p>
                        Find available volunteers using the
                        project's local area-based matching.
                    </p>

                    <span class="quick-action-link">
                        Find Volunteers →
                    </span>

                </a>


                <!-- PROFILE -->

                <a
                    class="quick-action-card"
                    href="index.php?page=helpseeker-profile"
                >

                    <span class="quick-action-tag">
                        Account
                    </span>

                    <h3>
                        My Profile
                    </h3>

                    <p>
                        Review and update your personal
                        contact and account information.
                    </p>

                    <span class="quick-action-link">
                        View Profile →
                    </span>

                </a>

            </div>

        </section>


        <!-- ================================
             ADMIN NOTIFICATIONS
        ================================= -->

        <section class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="eyebrow">
                        ADMIN ALERTS
                    </p>

                    <h2>
                        Notifications & Alerts
                    </h2>

                </div>

            </div>


            <?php if (empty($dashboardNotifications)): ?>

                <div class="helpseeker-empty-notification">

                    <div class="helpseeker-empty-icon">
                        N
                    </div>

                    <div>

                        <strong>
                            No Active Notifications
                        </strong>

                        <p>
                            Important rescue notices and admin
                            alerts will appear here.
                        </p>

                    </div>

                </div>

            <?php else: ?>

                <div class="notification-list">

                    <?php foreach (
                        $dashboardNotifications
                        as $notification
                    ): ?>

                        <?php
                        $alertType =
                            strtolower(
                                $notification['alert_type']
                                ?? 'normal'
                            );
                        ?>

                        <div class="notification-item">

                            <div>

                                <div class="notification-title-row">

                                    <strong>
                                        <?= htmlspecialchars(
                                            $notification['title']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </strong>


                                    <span
                                        class="helpseeker-alert-badge helpseeker-alert-<?=
                                            htmlspecialchars(
                                                $alertType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            );
                                        ?>"
                                    >
                                        <?= htmlspecialchars(
                                            ucfirst($alertType),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </span>

                                </div>


                                <p>
                                    <?= nl2br(
                                        htmlspecialchars(
                                            $notification['message']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        )
                                    ); ?>
                                </p>

                            </div>


                            <?php if (
                                !empty(
                                    $notification['created_at']
                                )
                            ): ?>

                                <small>
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
                                </small>

                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>

                </div>

            <?php endif; ?>

        </section>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>