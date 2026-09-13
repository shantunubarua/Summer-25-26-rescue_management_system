<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Create Account - Rescue Management System
    </title>

    <link
        rel="stylesheet"
        href="assets/css/style.css?v=16"
    >

</head>


<body class="auth-page">

<div class="auth-shell register-auth-shell">


    <!-- =========================================
         BRAND PANEL
         ========================================= -->

    <div class="auth-brand-panel">

        <div class="auth-brand-content">

            <div class="auth-brand-badge">
                RMS
            </div>


            <h1>
                Rescue Management System
            </h1>


            <p>
                Join the rescue network and access the tools
                designed for volunteers, witnesses and people
                seeking emergency assistance.
            </p>


            <div class="auth-brand-note">
                Community Support • Rescue Coordination • Emergency Response
            </div>

        </div>

    </div>


    <!-- =========================================
         REGISTRATION PANEL
         ========================================= -->

    <div class="auth-form-panel register-form-panel">

        <div class="auth-card register-auth-card">


            <!-- HEADER -->

            <div class="auth-card-header">

                <p class="eyebrow">
                    GET STARTED
                </p>

                <h2>
                    Create Account
                </h2>

                <p>
                    Enter your information and choose how
                    you will use the Rescue Management System.
                </p>

            </div>


            <!-- ERROR -->

            <?php if (!empty($error)): ?>

                <div class="alert alert-error">

                    <?php

                    echo htmlspecialchars(
                        $error,
                        ENT_QUOTES,
                        'UTF-8'
                    );

                    ?>

                </div>

            <?php endif; ?>


            <!-- =========================================
                 FORM
                 ========================================= -->

            <form
                method="POST"
                action="index.php?page=register"
                id="registerForm"
                class="auth-form register-form"
            >

                <?php echo csrfField(); ?>


                <div class="register-form-grid">


                    <!-- FULL NAME -->

                    <div class="form-group register-field-full">

                        <label for="name">

                            Full Name

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="name"
                            name="name"
                            minlength="2"
                            maxlength="100"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['name']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Enter your full name"
                            autocomplete="name"
                            required
                        >

                    </div>


                    <!-- USERNAME -->

                    <div class="form-group">

                        <label for="username">

                            Username

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['username']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Choose a username"
                            minlength="3"
                            maxlength="30"
                            pattern="[A-Za-z0-9_]+"
                            autocomplete="username"
                            required
                        >


                        <small>
                            3-30 characters. Letters, numbers
                            and underscore only.
                        </small>

                    </div>


                    <!-- ROLE -->

                    <div class="form-group">

                        <label for="role">

                            Register As

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <select
                            id="role"
                            name="role"
                            required
                        >

                            <option value="">
                                Select your role
                            </option>


                            <option
                                value="volunteer"
                                <?php

                                echo (
                                    ($_POST['role'] ?? '')
                                    === 'volunteer'
                                )
                                    ? 'selected'
                                    : '';

                                ?>
                            >
                                Volunteer
                            </option>


                            <option
                                value="witness"
                                <?php

                                echo (
                                    ($_POST['role'] ?? '')
                                    === 'witness'
                                )
                                    ? 'selected'
                                    : '';

                                ?>
                            >
                                Witness
                            </option>


                            <option
                                value="help_seeker"
                                <?php

                                echo (
                                    ($_POST['role'] ?? '')
                                    === 'help_seeker'
                                )
                                    ? 'selected'
                                    : '';

                                ?>
                            >
                                Help Seeker
                            </option>

                        </select>

                    </div>


                    <!-- EMAIL -->

                    <div class="form-group">

                        <label for="email">

                            Email Address

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            maxlength="150"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['email']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Enter your email"
                            autocomplete="email"
                            required
                        >

                    </div>


                    <!-- PHONE -->

                    <div class="form-group">

                        <label for="phone">
                            Phone Number
                        </label>


                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            maxlength="20"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['phone']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Enter phone number"
                            autocomplete="tel"
                        >

                        <small>
                            Optional during registration.
                        </small>

                    </div>


                    <!-- PASSWORD -->

                    <div class="form-group">

                        <label for="password">

                            Password

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="password"
                            id="password"
                            name="password"
                            minlength="8"
                            placeholder="Create a password"
                            autocomplete="new-password"
                            required
                        >


                        <small>
                            Minimum 8 characters.
                        </small>

                    </div>


                    <!-- CONFIRM PASSWORD -->

                    <div class="form-group">

                        <label for="confirm_password">

                            Confirm Password

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            minlength="8"
                            placeholder="Re-enter your password"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                </div>


                <!-- SUBMIT -->

                <button
                    type="submit"
                    class="btn-primary auth-submit register-submit"
                >
                    Create Account
                </button>

            </form>


            <!-- FOOTER -->

            <div class="auth-footer">

                <span>
                    Already have an account?
                </span>

                <a href="index.php?page=login">
                    Sign In
                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>