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

    <title>Edit Emergency Request</title>

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

        .back-link {
            display: inline-block;
            margin-left: 15px;
            color: #344256;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
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

        <h1>Edit Emergency Request</h1>

        <p>
            Update your pending emergency request information.
        </p>


        <div class="form-box">

            <?php if (!empty($error)): ?>

                <div class="error">
                    <?php
                    echo htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>
                </div>

            <?php endif; ?>


            <form
                method="POST"
                action="index.php?page=helpseeker-request-edit&id=<?php
                    echo (int)$request_id;
                ?>"
                id="helpSeekerEditRequestForm"
            >

                <?php echo csrfField(); ?>


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

                        <option
                            value="accident"
                            <?php
                            echo (
                                ($request['emergency_type'] ?? '') ===
                                'accident'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Accident
                        </option>

                        <option
                            value="fire"
                            <?php
                            echo (
                                ($request['emergency_type'] ?? '') ===
                                'fire'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Fire
                        </option>

                        <option
                            value="flood"
                            <?php
                            echo (
                                ($request['emergency_type'] ?? '') ===
                                'flood'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Flood
                        </option>

                        <option
                            value="medical"
                            <?php
                            echo (
                                ($request['emergency_type'] ?? '') ===
                                'medical'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Medical Emergency
                        </option>

                        <option
                            value="other"
                            <?php
                            echo (
                                ($request['emergency_type'] ?? '') ===
                                'other'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
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
                        value="<?php
                            echo htmlspecialchars(
                                $request['location'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
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
                    ><?php
                        echo htmlspecialchars(
                            $request['description'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?></textarea>

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

                        <option
                            value="low"
                            <?php
                            echo (
                                ($request['priority'] ?? '') ===
                                'low'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Low
                        </option>

                        <option
                            value="medium"
                            <?php
                            echo (
                                ($request['priority'] ?? '') ===
                                'medium'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            Medium
                        </option>

                        <option
                            value="high"
                            <?php
                            echo (
                                ($request['priority'] ?? '') ===
                                'high'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            High
                        </option>

                        <option
                            value="critical"
                            <?php
                            echo (
                                ($request['priority'] ?? '') ===
                                'critical'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
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

                        <option
                            value="self"
                            <?php
                            echo (
                                ($request['victim_type'] ?? '') ===
                                'self'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
                            I am the victim
                        </option>

                        <option
                            value="other"
                            <?php
                            echo (
                                ($request['victim_type'] ?? '') ===
                                'other'
                            )
                                ? 'selected'
                                : '';
                            ?>
                        >
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
                    ><?php
                        echo htmlspecialchars(
                            $request['victim_information'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?></textarea>

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
                        value="<?php
                            echo (int)(
                                $request['victim_count']
                                ?? 1
                            );
                        ?>"
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
                        value="<?php
                            echo htmlspecialchars(
                                $request['contact_information'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                        required
                    >

                </div>


                <button type="submit">
                    Update Emergency Request
                </button>

                <a
                    class="back-link"
                    href="index.php?page=helpseeker-request-view&id=<?php
                        echo (int)$request_id;
                    ?>"
                >
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>