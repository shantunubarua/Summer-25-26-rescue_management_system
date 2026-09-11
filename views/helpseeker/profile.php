<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                My Profile
            </h1>

            <p>
                View and update your account information.
            </p>

        </div>

    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars(
                $error
            ); ?>

        </div>

    <?php endif; ?>


    <?php if (!empty($success)): ?>

        <div class="alert alert-success">

            <?= htmlspecialchars(
                $success
            ); ?>

        </div>

    <?php endif; ?>


    <div class="card">

        <form
            method="POST"
            action="index.php?page=helpseeker-profile"
        >

            <?php echo csrfField(); ?>


            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    value="<?= htmlspecialchars(
                        $profile['username']
                        ?? ''
                    ); ?>"
                    readonly
                >

                <small>
                    Username cannot be changed.
                </small>

            </div>


            <div class="form-group">

                <label for="name">
                    Full Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    minlength="2"
                    maxlength="100"
                    value="<?= htmlspecialchars(
                        $profile['name']
                        ?? ''
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    maxlength="150"
                    value="<?= htmlspecialchars(
                        $profile['email']
                        ?? ''
                    ); ?>"
                    required
                >

            </div>


            <div class="form-group">

                <label for="phone">
                    Phone
                </label>

                <input
                    type="text"
                    id="phone"
                    name="phone"
                    maxlength="20"
                    value="<?= htmlspecialchars(
                        $profile['phone']
                        ?? ''
                    ); ?>"
                >

            </div>


            <div class="form-group">

                <label>
                    Account Role
                </label>

                <input
                    type="text"
                    value="Help Seeker"
                    readonly
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Profile
            </button>

        </form>

    </div>


    <div class="card">

        <h3>
            Password Security
        </h3>

        <p>
            You can update your password separately.
        </p>

        <a
            href="index.php?page=change-password"
            class="btn"
        >
            Change Password
        </a>

    </div>

</div>

<?php
require_once
    "views/partials/footer.php";
?>