<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login - Rescue Management System
    </title>

</head>


<body>

    <h1>
        Rescue Management System
    </h1>

    <h2>
        Login
    </h2>


    <?php if (!empty($error)): ?>

        <p>
            <?php
            echo htmlspecialchars(
                $error
            );
            ?>
        </p>

    <?php endif; ?>


    <?php
    if (
        isset($_GET['registered']) &&
        $_GET['registered'] === '1'
    ):
    ?>

        <p>
            Registration successful. You can now log in.
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=login"
    >


        <!-- USERNAME OR EMAIL -->

        <div>

            <label for="login">
                Username or Email
            </label>

            <input
                type="text"
                id="login"
                name="login"
                value="<?php
                    echo htmlspecialchars(
                        $_POST['login']
                        ?? $_POST['email']
                        ?? ''
                    );
                ?>"
                placeholder="Enter username or email"
                autocomplete="username"
                required
            >

        </div>


        <br>


        <!-- PASSWORD -->

        <div>

            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                autocomplete="current-password"
                required
            >

        </div>


        <br>


        <button type="submit">
            Login
        </button>


    </form>


    <p>
        Don't have an account?

        <a href="index.php?page=register">
            Register
        </a>
    </p>

</body>

</html>