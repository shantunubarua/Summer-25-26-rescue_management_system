<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

require_once "models/VolunteerModel.php";

$volunteer_id = $_SESSION['user']['id'];

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $availability_status =
        $_POST['availability_status'] ?? '';

    $updated = updateVolunteerAvailability(
        $conn,
        $volunteer_id,
        $availability_status
    );

    if ($updated) {
        $message = "Availability updated successfully.";
    } else {
        $error = "Failed to update availability.";
    }
}

$profile = getVolunteerAvailability(
    $conn,
    $volunteer_id
);

$current_status =
    $profile['availability_status'] ?? 'available';

?>

<div class="content">

    <h1>My Availability</h1>

    <p>
        Update your current volunteer availability status.
    </p>

    <?php if ($message !== ''): ?>

        <p>
            <?php echo htmlspecialchars($message); ?>
        </p>

    <?php endif; ?>

    <?php if ($error !== ''): ?>

        <p>
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <div class="card">

        <h3>
            Current Status:
            <span id="availabilityText">
                <?php
                echo htmlspecialchars(
                    ucwords(
                        str_replace(
                            '_',
                            ' ',
                            $current_status
                        )
                    )
                );
                ?>
            </span>
        </h3>

        <form method="POST">

            <div>

                <label for="availability_status">
                    Availability Status
                </label>

                <select
                    name="availability_status"
                    id="availability_status"
                    required
                >

                    <option
                        value="available"
                        <?php
                        echo $current_status === 'available'
                            ? 'selected'
                            : '';
                        ?>
                    >
                        Available
                    </option>

                    <option
                        value="unavailable"
                        <?php
                        echo $current_status === 'unavailable'
                            ? 'selected'
                            : '';
                        ?>
                    >
                        Unavailable
                    </option>

                    <option
                        value="currently_rescuing"
                        <?php
                        echo $current_status === 'currently_rescuing'
                            ? 'selected'
                            : '';
                        ?>
                    >
                        Currently Rescuing
                    </option>

                </select>

            </div>

            <button type="submit">
                Update Availability
            </button>

        </form>

    </div>

</div>

<script>
const availabilitySelect =
    document.getElementById('availability_status');

const availabilityText =
    document.getElementById('availabilityText');

availabilitySelect.addEventListener(
    'change',
    function () {

        let text =
            availabilitySelect
                .options[
                    availabilitySelect.selectedIndex
                ]
                .text;

        availabilityText.textContent = text;
    }
);
</script>

<?php require_once "views/partials/footer.php"; ?>