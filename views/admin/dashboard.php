<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

?>

<div class="content">

    <h1>
        Admin Dashboard
    </h1>


    <p>

        Welcome,

        <?= htmlspecialchars(
            $_SESSION['user']['name']
            ?? 'Admin'
        ); ?>

    </p>


    <div class="dashboard-cards">


        <!-- USER OVERVIEW -->

        <div class="card">

            <h3>
                Registered Volunteers
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['volunteers']
                    ?? 0
                ); ?>

            </p>

            <p>
                Volunteer accounts registered in the system.
            </p>

        </div>


        <div class="card">

            <h3>
                Registered Witnesses
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['witnesses']
                    ?? 0
                ); ?>

            </p>

            <p>
                Witness accounts registered in the system.
            </p>

        </div>


        <div class="card">

            <h3>
                Registered Help Seekers
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['help_seekers']
                    ?? 0
                ); ?>

            </p>

            <p>
                Help Seeker accounts registered in the system.
            </p>

        </div>


        <!-- DONATION OVERVIEW -->

        <div class="card">

            <h3>
                Total Donations
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['donations']
                    ?? 0
                ); ?>

            </p>

            <a href="index.php?page=admin-donations">
                View Donations
            </a>

        </div>


        <div class="card">

            <h3>
                Witness Donors
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['donors']
                    ?? 0
                ); ?>

            </p>

            <p>
                Witnesses who have submitted donations.
            </p>

        </div>


        <div class="card">

            <h3>
               Total Donated Amount
            </h3>

            <p class="dashboard-count">

                <?= htmlspecialchars(
                    number_format(
                        (float)(
                            $dashboardCounts['money_donated']
                            ?? 0
                        ),
                        2
                    )
                ); ?>

            </p>

            <p>
                Total amount of all completed donations.
            </p>

        </div>


        <!-- SYSTEM OVERVIEW -->

        <div class="card">

            <h3>
                Notifications
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['notifications']
                    ?? 0
                ); ?>

            </p>

            <a href="index.php?page=notifications">
                View Notifications
            </a>

        </div>


        <div class="card">

            <h3>
                Feedback
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['feedback']
                    ?? 0
                ); ?>

            </p>

            <a href="index.php?page=feedback">
                View Feedback
            </a>

        </div>


        <div class="card">

            <h3>
                Rescue Reports
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['rescue_reports']
                    ?? 0
                ); ?>

            </p>

            <a href="index.php?page=rescue-reports">
                View Rescue Reports
            </a>

        </div>


        <div class="card">

            <h3>
                Emergency Requests
            </h3>

            <p class="dashboard-count">

                <?= (int)(
                    $dashboardCounts['emergency_requests']
                    ?? 0
                ); ?>

            </p>

        </div>

    </div>

</div>

<?php

require_once
    "views/partials/footer.php";

?>