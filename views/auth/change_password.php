<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

?>

<div class="content">

    <div class="change-password-page">


        <!-- PAGE HEADER -->

        <div class="change-password-page-header">

            <div>

                <p class="eyebrow">
                    ACCOUNT SECURITY
                </p>

                <h1>
                    Change Password
                </h1>

                <p class="page-subtitle">
                    Update your account password to keep your
                    Rescue Management System account secure.
                </p>

            </div>

        </div>


        <!-- ERROR MESSAGE -->

        <?php if (!empty($error)): ?>

            <div class="change-password-message change-password-message-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- SUCCESS MESSAGE -->

        <?php
        if (
            isset($_GET['changed']) &&
            $_GET['changed'] === '1'
        ):
        ?>

            <div class="change-password-message change-password-message-success">

                Password changed successfully.

            </div>

        <?php endif; ?>


        <!-- MAIN SECURITY LAYOUT -->

        <div class="change-password-layout">


            <!-- SECURITY INFORMATION -->

            <aside class="change-password-security-panel">


                <div class="change-password-security-badge">
                    SEC
                </div>


                <p class="change-password-security-label">
                    PASSWORD SECURITY
                </p>


                <h2>
                    Protect Your Account
                </h2>


                <p class="change-password-security-description">
                    Use a secure password that is different
                    from your current password.
                </p>


                <div class="change-password-security-divider"></div>


                <div class="change-password-security-item">

                    <span>
                        01
                    </span>

                    <div>

                        <strong>
                            Current Password
                        </strong>

                        <p>
                            Enter your existing password for verification.
                        </p>

                    </div>

                </div>


                <div class="change-password-security-item">

                    <span>
                        02
                    </span>

                    <div>

                        <strong>
                            Minimum 8 Characters
                        </strong>

                        <p>
                            Your new password must contain at least
                            8 characters.
                        </p>

                    </div>

                </div>


                <div class="change-password-security-item">

                    <span>
                        03
                    </span>

                    <div>

                        <strong>
                            Confirm Password
                        </strong>

                        <p>
                            Re-enter your new password before submitting.
                        </p>

                    </div>

                </div>

            </aside>


            <!-- PASSWORD FORM -->

            <section class="change-password-form-card">


                <div class="change-password-form-header">

                    <span>
                        PASSWORD UPDATE
                    </span>

                    <h2>
                        Update Password
                    </h2>

                    <p>
                        Enter your current password and choose
                        a new password for your account.
                    </p>

                </div>


                <form
                    method="POST"
                    action="index.php?page=change-password"
                    class="change-password-form"
                >

                    <?php echo csrfField(); ?>


                    <!-- CURRENT PASSWORD -->

                    <div class="change-password-field">

                        <label for="current_password">

                            Current Password

                            <span>*</span>

                        </label>


                        <input
                            type="password"
                            name="current_password"
                            id="current_password"
                            autocomplete="current-password"
                            placeholder="Enter your current password"
                            required
                        >

                    </div>


                    <div class="change-password-field-divider"></div>


                    <!-- NEW PASSWORD -->

                    <div class="change-password-field">

                        <label for="new_password">

                            New Password

                            <span>*</span>

                        </label>


                        <input
                            type="password"
                            name="new_password"
                            id="new_password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Enter a new password"
                            required
                        >

                        <small>
                            Password must contain at least 8 characters.
                        </small>

                    </div>


                    <!-- CONFIRM PASSWORD -->

                    <div class="change-password-field">

                        <label for="confirm_password">

                            Confirm New Password

                            <span>*</span>

                        </label>


                        <input
                            type="password"
                            name="confirm_password"
                            id="confirm_password"
                            minlength="8"
                            autocomplete="new-password"
                            placeholder="Re-enter your new password"
                            required
                        >

                    </div>


                    <!-- SUBMIT -->

                    <div class="change-password-form-actions">

                        <button
                            type="submit"
                            class="change-password-submit"
                        >
                            Change Password
                        </button>

                    </div>

                </form>

            </section>

        </div>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>