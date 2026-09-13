<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/VolunteerModel.php";


$volunteer_id =
    (int)(
        $_SESSION['user']['id']
        ?? 0
    );


$activities =
    getVolunteerActivities(
        $conn,
        $volunteer_id
    );


$availability =
    getVolunteerAvailability(
        $conn,
        $volunteer_id
    );


$current_status =
    $availability['availability_status']
    ?? 'available';


$total_activities =
    count($activities);


$assigned_count = 0;
$ongoing_count = 0;
$completed_count = 0;


foreach ($activities as $activity) {

    if (
        ($activity['status'] ?? '')
        === 'assigned'
    ) {
        $assigned_count++;
    }


    if (
        ($activity['status'] ?? '')
        === 'ongoing'
    ) {
        $ongoing_count++;
    }


    if (
        ($activity['status'] ?? '')
        === 'completed'
    ) {
        $completed_count++;
    }
}


$availabilityClass =
    'volunteer-availability-unavailable';


if ($current_status === 'available') {

    $availabilityClass =
        'volunteer-availability-available';

} elseif (
    $current_status === 'currently_rescuing'
) {

    $availabilityClass =
        'volunteer-availability-rescuing';
}

?>

<div class="content">

    <div class="volunteer-dashboard-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="volunteer-dashboard-header">

            <div>

                <p class="eyebrow">
                    VOLUNTEER OPERATIONS
                </p>

                <h1>
                    Volunteer Dashboard
                </h1>

                <p class="page-subtitle">
                    Welcome back,
                    <strong>
                        <?= htmlspecialchars(
                            $_SESSION['user']['name']
                            ?? 'Volunteer',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>.
                    Manage rescue activities, availability
                    and resource requests.
                </p>

            </div>


            <a
                href="index.php?page=volunteer-profile"
                class="secondary-action"
            >
                My Profile
            </a>

        </div>


        <!-- =========================================
             AVAILABILITY + ACTIVITY SUMMARY
             ========================================= -->

        <div class="volunteer-dashboard-overview">


            <!-- AVAILABILITY -->

            <section class="volunteer-availability-overview">

                <p class="volunteer-overview-label">
                    CURRENT AVAILABILITY
                </p>

                <div class="volunteer-availability-row">

                    <div>

                        <h2>
                            Rescue Availability
                        </h2>

                        <p>
                            Your availability determines whether
                            you can respond to new rescue requests.
                        </p>

                    </div>


                    <span
                        class="volunteer-availability-badge <?= $availabilityClass; ?>"
                    >

                        <?= htmlspecialchars(
                            ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $current_status
                                )
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </span>

                </div>


                <a
                    href="index.php?page=volunteer-availability"
                    class="volunteer-availability-action"
                >
                    Update Availability
                </a>

            </section>


            <!-- ACTIVITY TOTAL -->

            <section class="volunteer-total-activity">

                <span>
                    TOTAL RESCUE ACTIVITIES
                </span>

                <strong>
                    <?= (int)$total_activities; ?>
                </strong>

                <p>
                    All emergency requests accepted
                    by your volunteer account.
                </p>

                <a href="index.php?page=volunteer-activities">
                    View Activities →
                </a>

            </section>

        </div>


        <!-- =========================================
             RESCUE PROGRESS
             ========================================= -->

        <section class="volunteer-dashboard-section">

            <div class="volunteer-dashboard-section-heading">

                <div>

                    <p>
                        RESCUE PROGRESS
                    </p>

                    <h2>
                        My Activity Overview
                    </h2>

                </div>

            </div>


            <div class="volunteer-progress-grid">


                <!-- ASSIGNED -->

                <article class="volunteer-progress-card">

                    <div class="volunteer-progress-card-top">

                        <span class="volunteer-progress-code">
                            ASN
                        </span>

                        <span class="volunteer-progress-label">
                            Assigned
                        </span>

                    </div>


                    <strong>
                        <?= (int)$assigned_count; ?>
                    </strong>


                    <p>
                        Rescue requests assigned and
                        waiting to be started.
                    </p>

                </article>


                <!-- ONGOING -->

                <article class="volunteer-progress-card">

                    <div class="volunteer-progress-card-top">

                        <span class="volunteer-progress-code">
                            ONG
                        </span>

                        <span class="volunteer-progress-label">
                            Ongoing
                        </span>

                    </div>


                    <strong>
                        <?= (int)$ongoing_count; ?>
                    </strong>


                    <p>
                        Rescue operations currently
                        in progress.
                    </p>

                </article>


                <!-- COMPLETED -->

                <article class="volunteer-progress-card">

                    <div class="volunteer-progress-card-top">

                        <span class="volunteer-progress-code">
                            CMP
                        </span>

                        <span class="volunteer-progress-label">
                            Completed
                        </span>

                    </div>


                    <strong>
                        <?= (int)$completed_count; ?>
                    </strong>


                    <p>
                        Rescue operations successfully
                        completed.
                    </p>

                </article>

            </div>

        </section>


        <!-- =========================================
             QUICK ACCESS
             ========================================= -->

        <section class="volunteer-dashboard-section">

            <div class="volunteer-dashboard-section-heading">

                <div>

                    <p>
                        QUICK ACCESS
                    </p>

                    <h2>
                        Volunteer Actions
                    </h2>

                </div>

            </div>


            <div class="volunteer-action-grid">


                <!-- EMERGENCY REQUESTS -->

                <a
                    href="index.php?page=volunteer-emergency-requests"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Rescue
                    </span>

                    <h3>
                        Emergency Requests
                    </h3>

                    <p>
                        View pending emergencies currently
                        requiring volunteer assistance.
                    </p>

                    <span class="volunteer-action-link">
                        View Requests →
                    </span>

                </a>


                <!-- ACTIVITIES -->

                <a
                    href="index.php?page=volunteer-activities"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Activity
                    </span>

                    <h3>
                        My Rescue Activities
                    </h3>

                    <p>
                        Track assigned, ongoing and
                        completed rescue operations.
                    </p>

                    <span class="volunteer-action-link">
                        View Activities →
                    </span>

                </a>


                <!-- AVAILABILITY -->

                <a
                    href="index.php?page=volunteer-availability"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Availability
                    </span>

                    <h3>
                        Availability Status
                    </h3>

                    <p>
                        Control whether you are available
                        to respond to rescue operations.
                    </p>

                    <span class="volunteer-action-link">
                        Update Status →
                    </span>

                </a>


                <!-- REQUEST RESOURCE -->

                <a
                    href="index.php?page=volunteer-resource-request"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Resources
                    </span>

                    <h3>
                        Request Resource
                    </h3>

                    <p>
                        Submit resources needed during
                        rescue operations.
                    </p>

                    <span class="volunteer-action-link">
                        New Request →
                    </span>

                </a>


                <!-- MY RESOURCE REQUESTS -->

                <a
                    href="index.php?page=volunteer-resource-requests"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Tracking
                    </span>

                    <h3>
                        My Resource Requests
                    </h3>

                    <p>
                        Search and monitor your previously
                        submitted resource requests.
                    </p>

                    <span class="volunteer-action-link">
                        View Requests →
                    </span>

                </a>


                <!-- PROFILE -->

                <a
                    href="index.php?page=volunteer-profile"
                    class="volunteer-action-card"
                >

                    <span class="volunteer-action-tag">
                        Account
                    </span>

                    <h3>
                        My Profile
                    </h3>

                    <p>
                        Review and update your volunteer
                        information and rescue details.
                    </p>

                    <span class="volunteer-action-link">
                        View Profile →
                    </span>

                </a>

            </div>

        </section>


        <!-- =========================================
             NOTIFICATIONS
             ========================================= -->

        <section class="volunteer-dashboard-section">

            <div class="volunteer-dashboard-section-heading">

                <div>

                    <p>
                        SYSTEM UPDATES
                    </p>

                    <h2>
                        Notifications & Alerts
                    </h2>

                </div>

            </div>


            <div class="volunteer-notification-panel">


                <?php if (empty($dashboardNotifications)): ?>

                    <div class="volunteer-notification-empty">

                        <div class="volunteer-notification-empty-icon">
                            N
                        </div>

                        <h3>
                            No Active Notifications
                        </h3>

                        <p>
                            Important volunteer announcements
                            and alerts will appear here.
                        </p>

                    </div>


                <?php else: ?>


                    <div class="volunteer-notification-list">


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


                            <article class="volunteer-notification-item">


                                <div class="volunteer-notification-content">

                                    <strong>

                                        <?= htmlspecialchars(
                                            $notification['title']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </strong>


                                    <p>

                                        <?= htmlspecialchars(
                                            $notification['message']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </p>


                                    <?php if (
                                        !empty(
                                            $notification['created_at']
                                        )
                                    ): ?>

                                        <small>

                                            <?= htmlspecialchars(
                                                $notification['created_at'],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </small>

                                    <?php endif; ?>

                                </div>


                                <span
                                    class="volunteer-notification-type volunteer-notification-type-<?= htmlspecialchars(
                                        $alertType,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>"
                                >

                                    <?= htmlspecialchars(
                                        ucfirst($alertType),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </span>

                            </article>


                        <?php endforeach; ?>


                    </div>


                <?php endif; ?>

            </div>

        </section>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>