<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$witnessName =
    $profile['name']
    ?? 'Witness';


$witnessInitial =
    strtoupper(
        substr(
            trim($witnessName),
            0,
            1
        )
    );

?>

<div class="content">

    <div class="witness-profile-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="witness-profile-page-header">

            <div>

                <p class="eyebrow">
                    ACCOUNT SETTINGS
                </p>

                <h1>
                    My Profile
                </h1>

                <p class="page-subtitle">
                    View and update your witness account
                    and contact information.
                </p>

            </div>


            <div class="witness-profile-header-actions">

                <a
                    href="index.php?page=witness-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <!-- =========================================
             ERROR MESSAGE
             ========================================= -->

        <?php if (!empty($error)): ?>

            <div class="witness-profile-message witness-profile-message-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             SUCCESS MESSAGE
             ========================================= -->

        <?php if (!empty($success)): ?>

            <div class="witness-profile-message witness-profile-message-success">

                <?= htmlspecialchars(
                    $success,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             PROFILE IDENTITY
             ========================================= -->

        <section class="witness-profile-identity-card">

            <div class="witness-profile-identity-main">

                <div class="witness-profile-avatar">

                    <?= htmlspecialchars(
                        $witnessInitial,
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                </div>


                <div class="witness-profile-identity-text">

                    <span class="witness-profile-role-badge">
                        Witness
                    </span>

                    <h2>

                        <?= htmlspecialchars(
                            $witnessName,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </h2>

                    <p>

                        <?= htmlspecialchars(
                            $profile['email']
                            ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>

                    </p>

                </div>

            </div>


            <div class="witness-profile-contact-summary">

                <span>
                    CONTACT NUMBER
                </span>

                <strong>

                    <?= !empty($profile['phone'])
                        ? htmlspecialchars(
                            $profile['phone'],
                            ENT_QUOTES,
                            'UTF-8'
                        )
                        : 'Not provided'; ?>

                </strong>

            </div>

        </section>


        <!-- =========================================
             MAIN PROFILE LAYOUT
             ========================================= -->

        <div class="witness-profile-layout">


            <!-- =====================================
                 EDIT PROFILE
                 ===================================== -->

            <section class="witness-profile-form-card">


                <div class="witness-profile-card-header">

                    <span>
                        PERSONAL INFORMATION
                    </span>

                    <h2>
                        Profile Details
                    </h2>

                    <p>
                        Update the information connected
                        with your witness account.
                    </p>

                </div>


                <form
                    id="witnessProfileForm"
                    method="POST"
                    action="index.php?page=witness-profile"
                    novalidate
                    class="witness-profile-form"
                >

                    <?php echo csrfField(); ?>


                    <div class="witness-profile-form-grid">


                        <!-- FULL NAME -->

                        <div class="witness-profile-field witness-profile-field-full">

                            <label for="name">

                                Full Name

                                <span>*</span>

                            </label>


                            <input
                                type="text"
                                id="name"
                                name="name"
                                maxlength="100"
                                value="<?= htmlspecialchars(
                                    $profile['name']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                                placeholder="Enter your full name"
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="witness-profile-field">

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
                                placeholder="Enter your email address"
                            >

                        </div>


                        <!-- PHONE -->

                        <div class="witness-profile-field">

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
                                placeholder="Enter your phone number"
                            >

                            <small>
                                Phone number is optional.
                            </small>

                        </div>


                        <!-- ROLE -->

                        <div class="witness-profile-field witness-profile-field-full">

                            <label for="witness_role">
                                Account Role
                            </label>


                            <input
                                type="text"
                                id="witness_role"
                                value="Witness"
                                disabled
                            >

                            <small>
                                Account role cannot be changed.
                            </small>

                        </div>

                    </div>


                    <!-- JS VALIDATION MESSAGE -->

                    <div
                        id="witnessProfileValidationMessage"
                        role="alert"
                        class="witness-profile-validation"
                    ></div>


                    <!-- FORM ACTION -->

                    <div class="witness-profile-form-actions">

                        <button
                            type="submit"
                            class="primary-action"
                        >
                            Update Profile
                        </button>

                    </div>

                </form>

            </section>


            <!-- =====================================
                 ACCOUNT INFORMATION
                 ===================================== -->

            <aside class="witness-profile-account-card">

                <p class="witness-profile-account-eyebrow">
                    ACCOUNT INFORMATION
                </p>

                <h2>
                    Account Details
                </h2>

                <p class="witness-profile-account-description">
                    Basic information about your
                    Rescue Management System account.
                </p>


                <div class="witness-profile-account-divider"></div>


                <!-- ROLE -->

                <div class="witness-profile-account-item">

                    <span>
                        Account Type
                    </span>

                    <strong>
                        Witness
                    </strong>

                </div>


                <!-- CREATED -->

                <div class="witness-profile-account-item">

                    <span>
                        Account Created
                    </span>

                    <strong>

                        <?php

                        echo !empty($profile['created_at'])
                            ? htmlspecialchars(
                                date(
                                    'd M Y, h:i A',
                                    strtotime(
                                        $profile['created_at']
                                    )
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            : 'Not available';

                        ?>

                    </strong>

                </div>


                <!-- UPDATED -->

                <div class="witness-profile-account-item">

                    <span>
                        Last Updated
                    </span>

                    <strong>

                        <?php

                        echo !empty($profile['updated_at'])
                            ? htmlspecialchars(
                                date(
                                    'd M Y, h:i A',
                                    strtotime(
                                        $profile['updated_at']
                                    )
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            )
                            : 'Not available';

                        ?>

                    </strong>

                </div>

            </aside>

        </div>

    </div>

</div>


<script src="assets/js/witness.js?v=4"></script>


<?php
require_once "views/partials/footer.php";
?>