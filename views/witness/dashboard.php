<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Witness Dashboard</h1>

    <p>
        Welcome,
        <?php echo htmlspecialchars($_SESSION['user']['name']); ?>
    </p>


    <!-- My Incident Reports -->
    <div class="card">

        <h3>My Incident Reports</h3>

        <p>
            View your submitted incident reports.
        </p>

        <p>
            <a href="index.php?page=witness-reports">
                View Reports
            </a>
        </p>

    </div>


    <!-- Report New Incident -->
    <div class="card">

        <h3>Report New Incident</h3>

        <p>
            Submit a new witness incident report.
        </p>

        <p>
            <a href="index.php?page=witness-report-create">
                Create Report
            </a>
        </p>

    </div>


    <!-- Donation -->
    <div class="card">

        <h3>Make a Donation</h3>

        <p>
            Support rescue and relief activities by making a donation.
        </p>

        <p>
            <a href="index.php?page=donation-create">
                Make Donation
            </a>
        </p>

    </div>


    <!-- My Donations -->
    <div class="card">

        <h3>My Donations</h3>

        <p>
            View your previous donation records and their status.
        </p>

        <p>
            <a href="index.php?page=donations">
                View Donations
            </a>
        </p>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>