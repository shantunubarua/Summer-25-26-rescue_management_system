<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$profileName =
    $profile['name']
    ?? 'Help Seeker';

$profileInitial =
    strtoupper(
        substr(
            trim($profileName),
            0,
            1
        )
    );

?>

<div class="content">

    <div class="helpseeker-profile-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="helpseeker-profile-page-header">

            <div>

                <p class="eyebrow">
                    ACCOUNT SETTINGS
                </p>

                <h1>
                    My Profile
                </h1>

                <p class="page-subtitle">
                    Review and update your personal account
                    and contact information.
                </p>

            </div>


            <div class="helpseeker-profile-header-actions">

                <a
                    href="index.php?page=helpseeker-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <!-- =========================================
             MESSAGES
             ========================================= -->

        <?php if (!empty($error)): ?>

            <div class="helpseeker-profile-message helpseeker-profile-message-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <?php if (!empty($success)): ?>

            <div class="helpseeker-profile-message helpseeker-profile-message-success">

                <?= htmlspecialchars(
                    $success,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             PROFILE LAYOUT
             ========================================= -->

        <div class="helpseeker-profile-layout">


            <!-- =====================================
                 ACCOUNT SUMMARY
                 ===================================== -->

            <aside class="helpseeker-profile-summary">

                <div class="helpseeker-profile-avatar">

                    <?= htmlspecialchars(
                        $profileInitial,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                </div>


                <h2>

                    <?= htmlspecialchars(
                        $profileName,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                </h2>


                <p class="helpseeker-profile-role">
                    Help Seeker
                </p>


                <div class="helpseeker-profile-summary-divider"></div>


                <div class="helpseeker-profile-summary-item">

                    <span>
                        Username
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            $profile['username']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </strong>

                </div>


                <div class="helpseeker-profile-summary-item">

                    <span>
                        Email
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            $profile['email']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </strong>

                </div>


                <div class="helpseeker-profile-summary-item">

                    <span>
                        Phone
                    </span>

                    <strong>

                        <?= htmlspecialchars(
                            $profile['phone']
                            ?? 'Not provided',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </strong>

                </div>

            </aside>


            <!-- =====================================
                 PROFILE FORM
                 ===================================== -->

            <section class="helpseeker-profile-form-card">


                <div class="helpseeker-profile-form-header">

                    <div>

                        <span>
                            PERSONAL INFORMATION
                        </span>

                        <h2>
                            Profile Details
                        </h2>

                        <p>
                            Keep your account information accurate
                            and up to date.
                        </p>

                    </div>

                </div>


                <form
                    method="POST"
                    action="index.php?page=helpseeker-profile"
                    class="helpseeker-profile-form"
                >

                    <?php echo csrfField(); ?>


                    <div class="helpseeker-profile-form-grid">


                        <!-- USERNAME -->

                        <div class="helpseeker-profile-field helpseeker-profile-field-full">

                            <label for="username">
                                Username
                            </label>

                            <input
                                type="text"
                                id="username"
                                value="<?= htmlspecialchars(
                                    $profile['username']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                readonly
                            >

                            <small>
                                Username cannot be changed.
                            </small>

                        </div>


                        <!-- FULL NAME -->

                        <div class="helpseeker-profile-field">

                            <label for="name">

                                Full Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                minlength="2"
                                maxlength="100"
                                value="<?= htmlspecialchars(
                                    $profile['name']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="helpseeker-profile-field">

                            <label for="email">

                                Email Address

                                <span>*</span>

                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                maxlength="150"
                                value="<?= htmlspecialchars(
                                    $profile['email']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                required
                            >

                        </div>


                        <!-- PHONE -->

                        <div class="helpseeker-profile-field">

                            <label for="phone">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                maxlength="20"
                                value="<?= htmlspecialchars(
                                    $profile['phone']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                placeholder="Enter phone number"
                            >

                        </div>


                        <!-- ACCOUNT ROLE -->

                        <div class="helpseeker-profile-field">

                            <label for="helpseeker_role">
                                Account Role
                            </label>

                            <input
                                type="text"
                                id="helpseeker_role"
                                value="Help Seeker"
                                readonly
                            >

                        </div>

                    </div>


                    <!-- ACTION -->

                    <div class="helpseeker-profile-form-actions">

                        <button
                            type="submit"
                            class="helpseeker-profile-save-button"
                        >
                            Update Profile
                        </button>

                    </div>

                </form>

            </section>

        </div>


        <!-- =========================================
             PASSWORD SECURITY
             ========================================= -->

        <section class="helpseeker-security-card">


            <div class="helpseeker-security-content">

                <div class="helpseeker-security-icon">
                    PW
                </div>


                <div>

                    <span>
                        ACCOUNT SECURITY
                    </span>

                    <h3>
                        Password Security
                    </h3>

                    <p>
                        Change your password separately whenever
                        you need to update your account credentials.
                    </p>

                </div>

            </div>


            <a
                href="index.php?page=change-password"
                class="secondary-action"
            >
                Change Password
            </a>

        </section>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>