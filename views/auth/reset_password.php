<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Reset Password - Rescue Management System
    </title>

</head>

<body>

    <h1>
        Rescue Management System
    </h1>

    <h2>
        Reset Password
    </h2>


    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <?php if (!empty($showResetForm)): ?>

        <form
            method="POST"
            action="index.php?page=reset-password"
        >

            <?php echo csrfField(); ?>


            <input
                type="hidden"
                name="reset_token"
                value="<?php
                    echo htmlspecialchars($token);
                ?>"
            >


            <div>

                <label for="password">
                    New Password
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <br>


            <div>

                <label for="confirm_password">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    name="confirm_password"
                    id="confirm_password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <br>


            <button type="submit">
                Reset Password
            </button>

        </form>

    <?php else: ?>

        <p>
            Please request a new password reset link.
        </p>

    <?php endif; ?>


    <p>
        <a href="index.php?page=forgot-password">
            Forgot Password
        </a>
    </p>

    <p>
        <a href="index.php?page=login">
            Back to Login
        </a>
    </p>

</body>

</html>