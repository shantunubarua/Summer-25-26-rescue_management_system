<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "helpers/auth.php";

requireHelpSeeker();

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Help Seeker Dashboard</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */

        .sidebar {
            width: 280px;
            background: #344256;
            color: white;
            padding: 22px 25px;
            min-height: 100vh;
        }

        .sidebar h1 {
            margin: 0 0 25px 0;
            font-size: 27px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        /* Main Content */

        .main {
            flex: 1;
            background: white;
            padding: 45px 25px;
        }

        .main h2 {
            margin-top: 0;
            font-size: 36px;
            color: #111;
        }

        .welcome {
            font-size: 18px;
            margin-bottom: 25px;
        }

        /* Cards */

        .card {
            border: 1px solid #ddd;
            padding: 25px 22px;
            margin-bottom: 22px;
            min-height: 135px;
        }

        .card h3 {
            margin: 0 0 18px 0;
            font-size: 21px;
        }

        .card p {
            margin: 0;
            font-size: 17px;
        }

        .card a {
            display: inline-block;
            margin-top: 15px;
            color: #344256;
            text-decoration: none;
            font-weight: bold;
        }

        .card a:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="layout">

    <!-- Sidebar -->

    <div class="sidebar">

        <h1>Help Seeker Panel</h1>

        <a href="index.php?page=helpseeker-dashboard">
            Dashboard
        </a>

        <a href="index.php?page=helpseeker-request-create">
    Request Rescue
</a>
        <a href="#">
            My Requests
        </a>

        <a href="#">
            Profile
        </a>

        <a href="index.php?page=logout">
            Logout
        </a>

    </div>


    <!-- Main Content -->

    <div class="main">

        <h2>Help Seeker Dashboard</h2>

        <div class="welcome">

            Welcome,
            <?php echo htmlspecialchars($user['name']); ?>

        </div>


        <div class="card">

            <h3>Request Rescue</h3>

            <p>
                Create a new rescue request when you need help.
            </p>

            <a href="index.php?page=helpseeker-request-create">
    Request Rescue
</a>

        </div>


        <div class="card">

            <h3>My Requests</h3>

            <p>
                View and manage your submitted rescue requests.
            </p>

            <a href="#">
                View My Requests
            </a>

        </div>


        <div class="card">

            <h3>Request Status</h3>

            <p>
                Check the current status of your rescue requests.
            </p>

            <a href="#">
                Check Status
            </a>

        </div>


        <div class="card">

            <h3>Profile</h3>

            <p>
                View your account information.
            </p>

            <a href="#">
                View Profile
            </a>

        </div>

    </div>

</div>

</body>

</html>