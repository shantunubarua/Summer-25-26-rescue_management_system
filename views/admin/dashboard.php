<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Admin Dashboard</h1>

    <p>
        Welcome,
        <?php
        echo htmlspecialchars(
            $_SESSION['user']['name']
        );
        ?>
    </p>

    <div class="dashboard-cards">

        <div class="card">
            <h3>Notifications</h3>

            <p class="dashboard-count">
                <?php echo $dashboardCounts['notifications']; ?>
            </p>

            <a href="index.php?page=notifications">
                View Notifications
            </a>
        </div>

        <div class="card">
            <h3>Feedback</h3>

            <p class="dashboard-count">
                <?php echo $dashboardCounts['feedback']; ?>
            </p>

            <a href="index.php?page=feedback">
                View Feedback
            </a>
        </div>

        <div class="card">
            <h3>Rescue Reports</h3>

            <p class="dashboard-count">
                <?php echo $dashboardCounts['rescue_reports']; ?>
            </p>

            <a href="index.php?page=rescue-reports">
                View Rescue Reports
            </a>
        </div>

        <div class="card">
            <h3>Emergency Requests</h3>

            <p class="dashboard-count">
                <?php echo $dashboardCounts['emergency_requests']; ?>
            </p>
        </div>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>