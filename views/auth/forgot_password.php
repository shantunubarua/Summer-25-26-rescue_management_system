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

    <link
        rel="stylesheet"
        href="assets/css/style.css?v=16"
    >

</head>


<body class="auth-page">

<div class="auth-shell forgot-auth-shell">


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
                Recover access to your account securely
                by verifying the information connected
                with your registration.
            </p>


            <div class="auth-brand-note">
                Secure Verification • Protected Access • Account Recovery
            </div>

        </div>

    </div>


    <!-- =========================================
         RECOVERY PANEL
         ========================================= -->

    <div class="auth-form-panel">

        <div class="auth-card forgot-auth-card">


            <?php if (!empty($resetToken)): ?>


                <!-- =================================
                     VERIFIED STATE
                     ================================= -->

                <div class="forgot-success-icon">
                    ✓
                </div>


                <div class="auth-card-header forgot-success-header">

                    <p class="eyebrow">
                        ACCOUNT VERIFIED
                    </p>

                    <h2>
                        Verification Successful
                    </h2>

                    <p>
                        Your account information has been verified.
                        You can now continue and create a new password.
                    </p>

                </div>


                <div class="forgot-token-notice">

                    <span>
                        Reset Link
                    </span>

                    <p>
                        This password reset link is valid for
                        10 minutes and can only be used once.
                    </p>

                </div>


                <a
                    href="index.php?page=reset-password&token=<?php
                        echo urlencode($resetToken);
                    ?>"
                    class="forgot-continue-button"
                >
                    Continue to Reset Password
                </a>


                <div class="auth-footer">

                    <span>
                        Remember your password?
                    </span>

                    <a href="index.php?page=login">
                        Back to Login
                    </a>

                </div>


            <?php else: ?>


                <!-- =================================
                     VERIFICATION FORM
                     ================================= -->

                <div class="auth-card-header">

                    <p class="eyebrow">
                        ACCOUNT RECOVERY
                    </p>

                    <h2>
                        Forgot Password?
                    </h2>

                    <p>
                        Verify your account using your username
                        or email and registered phone number.
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


                <!-- FORM -->

                <form
                    method="POST"
                    action="index.php?page=forgot-password"
                    class="auth-form forgot-password-form"
                >

                    <?php echo csrfField(); ?>


                    <!-- USERNAME / EMAIL -->

                    <div class="form-group">

                        <label for="login">

                            Username or Email

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="login"
                            id="login"
                            maxlength="150"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['login']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Enter username or email"
                            autocomplete="username"
                            required
                        >

                        <small>
                            Enter the username or email used
                            for your account.
                        </small>

                    </div>


                    <!-- PHONE -->

                    <div class="form-group">

                        <label for="phone">

                            Registered Phone Number

                            <span class="auth-required">
                                *
                            </span>

                        </label>


                        <input
                            type="text"
                            name="phone"
                            id="phone"
                            maxlength="20"
                            value="<?php

                                echo htmlspecialchars(
                                    $_POST['phone']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                );

                            ?>"
                            placeholder="Enter registered phone number"
                            autocomplete="tel"
                            required
                        >

                        <small>
                            This must match the phone number
                            registered with your account.
                        </small>

                    </div>


                    <button
                        type="submit"
                        class="btn-primary auth-submit"
                    >
                        Verify Account
                    </button>

                </form>


                <!-- FOOTER -->

                <div class="auth-footer">

                    <span>
                        Remember your password?
                    </span>

                    <a href="index.php?page=login">
                        Back to Login
                    </a>

                </div>


            <?php endif; ?>

        </div>

    </div>

</div>

</body>

</html>