<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/VolunteerModel.php";

$volunteer_id = (int)$_SESSION['user']['id'];

/*
|--------------------------------------------------------------------------
| Volunteer Dashboard Data
|--------------------------------------------------------------------------
*/

$activities = getVolunteerActivities(
    $conn,
    $volunteer_id
);

$availability = getVolunteerAvailability(
    $conn,
    $volunteer_id
);

$current_status =
    $availability['availability_status']
    ?? 'available';


/*
|--------------------------------------------------------------------------
| Activity Counts
|--------------------------------------------------------------------------
*/

$total_activities = count($activities);

$assigned_count = 0;
$ongoing_count = 0;
$completed_count = 0;

foreach ($activities as $activity) {

    if ($activity['status'] === 'assigned') {
        $assigned_count++;
    }

    if ($activity['status'] === 'ongoing') {
        $ongoing_count++;
    }

    if ($activity['status'] === 'completed') {
        $completed_count++;
    }
}

?>

<div class="content">

    <h1>Volunteer Dashboard</h1>

    <p>
        Welcome,
        <?php
        echo htmlspecialchars(
            $_SESSION['user']['name']
        );
        ?>
    </p>


    <!-- Availability -->

    <div class="card">

        <h3>My Availability</h3>

        <p>

            <strong>Current Status:</strong>

            <?php

            echo htmlspecialchars(
                ucwords(
                    str_replace(
                        '_',
                        ' ',
                        $current_status
                    )
                )
            );

            ?>

        </p>

        <a href="index.php?page=volunteer-availability">
            Update Availability
        </a>

    </div>


    <!-- Rescue Statistics -->

    <div class="card">

        <h3>My Rescue Activities</h3>

        <p>
            <strong>Total:</strong>
            <?php echo $total_activities; ?>
        </p>

        <p>
            <strong>Assigned:</strong>
            <?php echo $assigned_count; ?>
        </p>

        <p>
            <strong>Ongoing:</strong>
            <?php echo $ongoing_count; ?>
        </p>

        <p>
            <strong>Completed:</strong>
            <?php echo $completed_count; ?>
        </p>

        <a href="index.php?page=volunteer-activities">
            View My Activities
        </a>

    </div>


    <!-- Emergency Requests -->

    <div class="card">

        <h3>Emergency Requests</h3>

        <p>
            View emergency requests that need
            volunteer assistance.
        </p>

        <a href="index.php?page=volunteer-emergency-requests">
            View Emergency Requests
        </a>

    </div>


    <!-- Resource Request -->

    <div class="card">

        <h3>Resource Request</h3>

        <p>
            Request resources needed for rescue activities.
        </p>

        <a href="index.php?page=volunteer-resource-request">
            Request Resource
        </a>

    </div>


    <!-- My Resource Requests -->

    <div class="card">

        <h3>My Resource Requests</h3>

        <p>
            View the resources you have already requested.
        </p>

        <a href="index.php?page=volunteer-resource-requests">
            View My Resource Requests
        </a>

    </div>


    <!-- Profile -->

    <div class="card">

        <h3>My Profile</h3>

        <p>
            View and update your volunteer information.
        </p>

        <a href="index.php?page=volunteer-profile">
            View My Profile
        </a>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>