<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Forgot Password - Rescue Management System
    </title>

</head>

<body>

    <h1>
        Rescue Management System
    </h1>

    <h2>
        Forgot Password
    </h2>

    <p>
        Enter your username/email and registered phone number
        to verify your account.
    </p>


    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <?php if (!empty($resetToken)): ?>

        <p>
            Account verified successfully.
        </p>

        <p>
            This reset link is valid for 10 minutes
            and can only be used once.
        </p>

        <p>

            <a
                href="index.php?page=reset-password&token=<?php
                    echo urlencode($resetToken);
                ?>"
            >
                Continue to Reset Password
            </a>

        </p>

    <?php else: ?>


        <form
            method="POST"
            action="index.php?page=forgot-password"
        >

            <?php echo csrfField(); ?>


            <div>

                <label for="login">
                    Username or Email
                </label>

                <input
                    type="text"
                    name="login"
                    id="login"
                    value="<?php
                        echo htmlspecialchars(
                            $_POST['login'] ?? ''
                        );
                    ?>"
                    required
                    autocomplete="username"
                >

            </div>


            <br>


            <div>

                <label for="phone">
                    Registered Phone Number
                </label>

                <input
                    type="text"
                    name="phone"
                    id="phone"
                    value="<?php
                        echo htmlspecialchars(
                            $_POST['phone'] ?? ''
                        );
                    ?>"
                    required
                    autocomplete="tel"
                >

            </div>


            <br>


            <button type="submit">
                Verify Account
            </button>

        </form>

    <?php endif; ?>


    <p>
        <a href="index.php?page=login">
            Back to Login
        </a>
    </p>

</body>

</html>