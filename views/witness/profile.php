<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="page-header">

        <div>
            <h1>Witness Profile</h1>

            <p>
                View and update your account information.
            </p>
        </div>

        <div>
            <a
                href="index.php?page=witness-dashboard"
                class="secondary-action"
            >
                Back to Dashboard
            </a>
        </div>

    </div>


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


    <?php if (!empty($success)): ?>

        <div class="alert alert-success">
            <?php
            echo htmlspecialchars(
                $success,
                ENT_QUOTES,
                'UTF-8'
            );
            ?>
        </div>

    <?php endif; ?>


    <div class="form-card">

        <form
            id="witnessProfileForm"
            method="POST"
            action="index.php?page=witness-profile"
            novalidate
        >

<?php echo csrfField(); ?>

            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    maxlength="100"
                    value="<?php
                    echo htmlspecialchars(
                        $profile['name'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                >

            </div>


            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    maxlength="150"
                    value="<?php
                    echo htmlspecialchars(
                        $profile['email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                >

            </div>


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
                        $profile['phone'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    );
                    ?>"
                >

            </div>


            <div class="form-group">

                <label>
                    Role
                </label>

                <input
                    type="text"
                    value="Witness"
                    disabled
                >

            </div>


            <div
                id="witnessProfileValidationMessage"
                role="alert"
            ></div>


            <div class="form-actions">

                <button
                    type="submit"
                    class="primary-action"
                >
                    Update Profile
                </button>

            </div>

        </form>

    </div>


    <div class="data-card">

        <h2>Account Information</h2>

        <p>
            <strong>Account Created:</strong>

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
        </p>

        <p>
            <strong>Last Updated:</strong>

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
        </p>

    </div>

</div>

<script src="assets/js/witness.js?v=4"></script>

<?php require_once "views/partials/footer.php"; ?>
