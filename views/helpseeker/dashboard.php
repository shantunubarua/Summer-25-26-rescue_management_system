<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";


$user =
    $_SESSION['user']
    ?? [];

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Help Seeker Dashboard
            </h1>

            <p>
                Welcome,
                <?= htmlspecialchars(
                    $user['name']
                    ?? 'Help Seeker'
                ); ?>.
            </p>

        </div>

    </div>


    <div class="card">

        <h2>
            Request Rescue
        </h2>

        <p>
            Create a new emergency request when rescue assistance is needed.
        </p>

        <a
            href="index.php?page=helpseeker-request-create"
            class="btn btn-primary"
        >
            Request Rescue
        </a>

    </div>


    <div class="card">

        <h2>
            My Emergency Requests
        </h2>

        <p>
            View, search and manage your submitted emergency requests.
        </p>

        <a
            href="index.php?page=helpseeker-requests"
            class="btn"
        >
            View My Requests
        </a>

    </div>


    <div class="card">

        <h2>
            Nearby Volunteers
        </h2>

        <p>
            Find currently available volunteers by area.
        </p>

        <a
            href="index.php?page=helpseeker-nearby-volunteers"
            class="btn"
        >
            Find Volunteers
        </a>

    </div>


    <div class="card">

        <h2>
            My Profile
        </h2>

        <p>
            View and update your account information.
        </p>

        <a
            href="index.php?page=helpseeker-profile"
            class="btn"
        >
            View Profile
        </a>

    </div>


    <div class="card">

        <h2>
            Notifications & Alerts
        </h2>


        <?php if (empty($dashboardNotifications)): ?>

            <p>
                No active notifications at this time.
            </p>

        <?php else: ?>

            <?php foreach ($dashboardNotifications as $notification): ?>

                <div class="notification-item">

                    <h3>
                        <?= htmlspecialchars(
                            $notification['title']
                            ?? 'Notification'
                        ); ?>
                    </h3>


                    <p>
                        <?= nl2br(
                            htmlspecialchars(
                                $notification['message']
                                ?? ''
                            )
                        ); ?>
                    </p>


                    <p>

                        <strong>
                            Alert:
                        </strong>

                        <?= htmlspecialchars(
                            ucfirst(
                                $notification['alert_type']
                                ?? 'normal'
                            )
                        ); ?>

                    </p>


                    <?php if (!empty($notification['created_at'])): ?>

                        <p>
                            <small>
                                <?= htmlspecialchars(
                                    date(
                                        'd M Y, h:i A',
                                        strtotime(
                                            $notification['created_at']
                                        )
                                    )
                                ); ?>
                            </small>
                        </p>

                    <?php endif; ?>

                </div>

                <hr>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

</div>

<?php
require_once
    "views/partials/footer.php";
?>