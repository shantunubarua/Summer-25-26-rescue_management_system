<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Change Password
            </h1>

            <p>
                Update your account password securely.
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


    <?php
    if (
        isset($_GET['changed']) &&
        $_GET['changed'] === '1'
    ):
    ?>

        <div class="alert alert-success">

            Password changed successfully.

        </div>

    <?php endif; ?>


    <div class="card">

        <form
            method="POST"
            action="index.php?page=change-password"
        >

            <?php echo csrfField(); ?>


            <div class="form-group">

                <label for="current_password">
                    Current Password
                </label>

                <input
                    type="password"
                    name="current_password"
                    id="current_password"
                    autocomplete="current-password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="new_password">
                    New Password
                </label>

                <input
                    type="password"
                    name="new_password"
                    id="new_password"
                    minlength="8"
                    autocomplete="new-password"
                    required
                >

            </div>


            <div class="form-group">

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


            <button
                type="submit"
                class="btn btn-primary"
            >
                Change Password
            </button>

        </form>

    </div>

</div>

<?php
require_once "views/partials/footer.php";
?>