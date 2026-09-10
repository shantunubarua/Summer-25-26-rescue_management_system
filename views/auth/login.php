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


    <?php

    /*
    |--------------------------------------------------------------------------
    | LOGIN FIELD VALUE
    |--------------------------------------------------------------------------
    |
    | Priority:
    | 1. Submitted login value
    | 2. Remembered email cookie
    |
    */

    $loginValue =
        $_POST['login']
        ?? $_POST['email']
        ?? $_COOKIE['remember_email']
        ?? '';

    ?>


    <form
        method="POST"
        action="index.php?page=login"
    >

        <?php echo csrfField(); ?>


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
                        $loginValue
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


        <!-- REMEMBER EMAIL -->

        <div>

            <label>

                <input
                    type="checkbox"
                    name="remember_email"
                    value="1"
                    <?php
                    echo (
                        isset($_POST['remember_email']) ||
                        (
                            $_SERVER['REQUEST_METHOD'] !== 'POST' &&
                            !empty($_COOKIE['remember_email'])
                        )
                    )
                        ? 'checked'
                        : '';
                    ?>
                >

                Remember Email

            </label>

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