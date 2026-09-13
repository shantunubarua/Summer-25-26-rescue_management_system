<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$currentAvailability =
    $currentAvailability
    ?? 'available';

?>

<div class="content">

    <div class="page-header">
        <div>
            <h1>My Availability</h1>

            <p>
                Update your current availability for rescue operations.
            </p>
        </div>
    </div>


    <?php if (!empty($_GET['updated'])): ?>

        <div class="alert alert-success">
            Availability updated successfully.
        </div>

    <?php endif; ?>


    <?php if (!empty($error)): ?>

        <div class="alert alert-error">
            <?= htmlspecialchars(
                $error,
                ENT_QUOTES,
                'UTF-8'
            ); ?>
        </div>

    <?php endif; ?>


    <div class="card">

        <h3>Current Availability</h3>

        <p>
            Your current status is:

            <strong>
                <?= htmlspecialchars(
                    ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $currentAvailability
                        )
                    ),
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </strong>
        </p>


        <form
            method="POST"
            action="index.php?page=volunteer-availability"
        >

            <?= csrfField(); ?>


            <div class="form-group">

                <label for="availability_status">
                    Availability Status
                </label>

                <select
                    id="availability_status"
                    name="availability_status"
                    required
                >

                    <option
                        value="available"
                        <?= $currentAvailability === 'available'
                            ? 'selected'
                            : ''; ?>
                    >
                        Available
                    </option>

                    <option
                        value="unavailable"
                        <?= $currentAvailability === 'unavailable'
                            ? 'selected'
                            : ''; ?>
                    >
                        Unavailable
                    </option>

                    <option
                        value="currently_rescuing"
                        <?= $currentAvailability === 'currently_rescuing'
                            ? 'selected'
                            : ''; ?>
                    >
                        Currently Rescuing
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Availability
            </button>

        </form>

    </div>

</div>

<?php
require_once "views/partials/footer.php";
?>