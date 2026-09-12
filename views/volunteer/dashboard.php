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
    'status-muted';


if ($current_status === 'available') {

    $availabilityClass =
        'status-success';

} elseif (
    $current_status === 'currently_rescuing'
) {

    $availabilityClass =
        'status-warning';
}

?>

<div class="content">

    <div class="page-header">

        <div>

            <p class="eyebrow">
                Volunteer Operations
            </p>

            <h1>
                Volunteer Dashboard
            </h1>

            <p class="page-subtitle">
                Welcome back,
                <strong>
                    <?=
                        htmlspecialchars(
                            $_SESSION['user']['name']
                            ?? 'Volunteer',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>
                </strong>.
                Manage rescue activities, availability and resources.
            </p>

        </div>

    </div>


    <div class="dashboard-grid">

        <div class="stat-card">

            <span class="stat-label">
                Availability
            </span>

            <div class="stat-value stat-value-small">

                <span class="status-pill <?= $availabilityClass; ?>">

                    <?=
                        htmlspecialchars(
                            ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    $current_status
                                )
                            ),
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>

                </span>

            </div>

            <a href="index.php?page=volunteer-availability">
                Update Status
            </a>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Total Activities
            </span>

            <strong class="stat-value">
                <?= (int)$total_activities; ?>
            </strong>

            <span class="stat-help">
                All assigned rescue operations
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Assigned
            </span>

            <strong class="stat-value">
                <?= (int)$assigned_count; ?>
            </strong>

            <span class="stat-help">
                Waiting to be started
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Ongoing
            </span>

            <strong class="stat-value">
                <?= (int)$ongoing_count; ?>
            </strong>

            <span class="stat-help">
                Rescue operations in progress
            </span>

        </div>


        <div class="stat-card">

            <span class="stat-label">
                Completed
            </span>

            <strong class="stat-value">
                <?= (int)$completed_count; ?>
            </strong>

            <span class="stat-help">
                Successfully completed rescues
            </span>

        </div>

    </div>


    <div class="dashboard-section">

        <div class="section-heading">

            <div>

                <p class="eyebrow">
                    Quick Access
                </p>

                <h2>
                    Volunteer Actions
                </h2>

            </div>

        </div>


        <div class="quick-action-grid">

            <a
                class="quick-action-card"
                href="index.php?page=volunteer-emergency-requests"
            >

                <span class="quick-action-tag">
                    Rescue
                </span>

                <h3>
                    Emergency Requests
                </h3>

                <p>
                    View pending emergency requests requiring volunteer support.
                </p>

                <span class="quick-action-link">
                    View Requests →
                </span>

            </a>


            <a
                class="quick-action-card"
                href="index.php?page=volunteer-activities"
            >

                <span class="quick-action-tag">
                    Activity
                </span>

                <h3>
                    My Rescue Activities
                </h3>

                <p>
                    Track assigned, ongoing and completed rescue operations.
                </p>

                <span class="quick-action-link">
                    View Activities →
                </span>

            </a>


            <a
                class="quick-action-card"
                href="index.php?page=volunteer-resource-request"
            >

                <span class="quick-action-tag">
                    Resources
                </span>

                <h3>
                    Request Resource
                </h3>

                <p>
                    Submit resource requirements for rescue activities.
                </p>

                <span class="quick-action-link">
                    New Request →
                </span>

            </a>


            <a
                class="quick-action-card"
                href="index.php?page=volunteer-resource-requests"
            >

                <span class="quick-action-tag">
                    Tracking
                </span>

                <h3>
                    My Resource Requests
                </h3>

                <p>
                    Search and monitor previously submitted resource requests.
                </p>

                <span class="quick-action-link">
                    View Requests →
                </span>

            </a>


            <a
                class="quick-action-card"
                href="index.php?page=volunteer-profile"
            >

                <span class="quick-action-tag">
                    Account
                </span>

                <h3>
                    My Profile
                </h3>

                <p>
                    Review and update volunteer profile information.
                </p>

                <span class="quick-action-link">
                    View Profile →
                </span>

            </a>

        </div>

    </div>


    <?php if (!empty($dashboardNotifications)): ?>

        <div class="dashboard-section">

            <div class="section-heading">

                <div>

                    <p class="eyebrow">
                        Updates
                    </p>

                    <h2>
                        Notifications & Alerts
                    </h2>

                </div>

            </div>


            <div class="notification-list">

                <?php
                foreach (
                    $dashboardNotifications
                    as $notification
                ):
                ?>

                    <div class="notification-item">

                        <div>

                            <div class="notification-title-row">

                                <strong>

                                    <?=
                                        htmlspecialchars(
                                            $notification['title']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>

                                </strong>


                                <span class="status-pill status-info">

                                    <?=
                                        htmlspecialchars(
                                            ucfirst(
                                                $notification['alert_type']
                                                ?? 'normal'
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        );
                                    ?>

                                </span>

                            </div>


                            <p>

                                <?=
                                    htmlspecialchars(
                                        $notification['message']
                                        ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?>

                            </p>

                        </div>


                        <?php
                        if (
                            !empty(
                                $notification['created_at']
                            )
                        ):
                        ?>

                            <small>

                                <?=
                                    htmlspecialchars(
                                        $notification['created_at'],
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );
                                ?>

                            </small>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        </div>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>