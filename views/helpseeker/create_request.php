<?php

$user = $_SESSION['user'] ?? [];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Create Emergency Request</title>

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

        .main {
            flex: 1;
            background: white;
            padding: 45px;
        }

        .main h1 {
            margin-top: 0;
            font-size: 34px;
        }

        .form-box {
            max-width: 700px;
            border: 1px solid #ddd;
            padding: 30px;
            margin-top: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 7px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        button {
            padding: 12px 20px;
            background: #344256;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #263446;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="layout">

    <div class="sidebar">

        <h1>Help Seeker Panel</h1>

        <a href="index.php?page=helpseeker-dashboard">
            Dashboard
        </a>

        <a href="index.php?page=helpseeker-request-create">
            Request Rescue
        </a>

        <a href="index.php?page=helpseeker-requests">
            My Requests
        </a>

        <a href="#">
            Profile
        </a>

        <a href="index.php?page=logout">
            Logout
        </a>

    </div>


    <div class="main">

        <h1>Create Emergency Request</h1>

        <p>
            Submit the information below to request rescue assistance.
        </p>


        <div class="form-box">

            <?php if (!empty($error)): ?>

                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>

            <?php endif; ?>


            <form
                method="POST"
                action="index.php?page=helpseeker-request-create"
            >

                <div class="form-group">

                    <label for="emergency_type">
                        Emergency Type
                    </label>

                    <select
                        id="emergency_type"
                        name="emergency_type"
                        required
                    >

                        <option value="">
                            Select Emergency Type
                        </option>

                        <option value="accident">
                            Accident
                        </option>

                        <option value="fire">
                            Fire
                        </option>

                        <option value="flood">
                            Flood
                        </option>

                        <option value="medical">
                            Medical Emergency
                        </option>

                        <option value="other">
                            Other
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="location">
                        Location
                    </label>

                    <input
                        type="text"
                        id="location"
                        name="location"
                        maxlength="255"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="5"
                        required
                    ></textarea>

                </div>


                <div class="form-group">

                    <label for="priority">
                        Priority
                    </label>

                    <select
                        id="priority"
                        name="priority"
                        required
                    >

                        <option value="low">
                            Low
                        </option>

                        <option value="medium" selected>
                            Medium
                        </option>

                        <option value="high">
                            High
                        </option>

                        <option value="critical">
                            Critical
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="victim_type">
                        Who Needs Help?
                    </label>

                    <select
                        id="victim_type"
                        name="victim_type"
                        required
                    >

                        <option value="self">
                            I am the victim
                        </option>

                        <option value="other">
                            Another person is the victim
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <label for="victim_information">
                        Victim Information
                    </label>

                    <textarea
                        id="victim_information"
                        name="victim_information"
                        rows="3"
                        placeholder="Required when requesting help for another person"
                    ></textarea>

                </div>


                <div class="form-group">

                    <label for="victim_count">
                        Number of Victims
                    </label>

                    <input
                        type="number"
                        id="victim_count"
                        name="victim_count"
                        min="1"
                        value="1"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="contact_information">
                        Contact Information
                    </label>

                    <input
                        type="text"
                        id="contact_information"
                        name="contact_information"
                        maxlength="150"
                        required
                    >

                </div>


                <button type="submit">
                    Submit Emergency Request
                </button>

            </form>

        </div>

    </div>

</div>

</body>

</html>