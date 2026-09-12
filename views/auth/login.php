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

    <link
        rel="stylesheet"
        href="assets/css/style.css?v=15"
    >

</head>

<body class="auth-page">

<div class="auth-shell">

    <div class="auth-brand-panel">

        <div class="auth-brand-content">

            <div class="auth-brand-badge">
                RMS
            </div>

            <h1>
                Rescue Management System
            </h1>

            <p>
                Coordinate emergency response, rescue activities,
                resources and community support from one secure platform.
            </p>

            <div class="auth-brand-note">
                Emergency Response • Volunteer Coordination • Rescue Management
            </div>

        </div>

    </div>


    <div class="auth-form-panel">

        <div class="auth-card">

            <div class="auth-card-header">

                <p class="eyebrow">
                    Secure Access
                </p>

                <h2>
                    Welcome Back
                </h2>

                <p>
                    Sign in to continue to your dashboard.
                </p>

            </div>


            <?php if (!empty($error)): ?>

                <div class="alert alert-error">

                    <?=
                        htmlspecialchars(
                            $error,
                            ENT_QUOTES,
                            'UTF-8'
                        );
                    ?>

                </div>

            <?php endif; ?>


            <?php
            if (
                isset($_GET['registered']) &&
                $_GET['registered'] === '1'
            ):
            ?>

                <div class="alert alert-success">
                    Registration successful. You can now log in.
                </div>

            <?php endif; ?>


            <?php
            if (
                isset($_GET['reset']) &&
                $_GET['reset'] === '1'
            ):
            ?>

                <div class="alert alert-success">
                    Password reset successful. You can now log in.
                </div>

            <?php endif; ?>


            <?php
            if (
                isset($_GET['expired']) &&
                $_GET['expired'] === '1'
            ):
            ?>

                <div class="alert alert-error">
                    Your session expired due to inactivity.
                    Please log in again.
                </div>

            <?php endif; ?>


            <?php

            $loginValue =
                $_POST['login']
                ?? $_POST['email']
                ?? $_COOKIE['remember_email']
                ?? '';

            ?>


            <form
                method="POST"
                action="index.php?page=login"
                class="auth-form"
            >

                <?= csrfField(); ?>


                <div class="form-group">

                    <label for="login">
                        Username or Email
                    </label>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        value="<?=
                            htmlspecialchars(
                                $loginValue,
                                ENT_QUOTES,
                                'UTF-8'
                            );
                        ?>"
                        placeholder="Enter username or email"
                        autocomplete="username"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >

                </div>


                <div class="auth-options">

                    <label class="checkbox-label">

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

                        <span>
                            Remember Email
                        </span>

                    </label>


                    <a href="index.php?page=forgot-password">
                        Forgot Password?
                    </a>

                </div>


                <button
                    type="submit"
                    class="btn-primary auth-submit"
                >
                    Sign In
                </button>

            </form>


            <div class="auth-footer">

                <span>
                    Don't have an account?
                </span>

                <a href="index.php?page=register">
                    Create Account
                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>