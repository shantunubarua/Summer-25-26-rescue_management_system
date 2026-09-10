<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/VolunteerModel.php";

$volunteer_id = (int)$_SESSION['user']['id'];

$activities = getVolunteerActivities(
    $conn,
    $volunteer_id
);

?>

<div class="content">

    <h1>My Rescue Activities</h1>

    <p>
        View and manage the emergency requests assigned to you.
    </p>

    <?php if (empty($activities)): ?>

        <div class="card">

            <h3>No Rescue Activities</h3>

            <p>
                You have not accepted any emergency requests yet.
            </p>

            <p>
                <a href="index.php?page=volunteer-emergency-requests">
                    View Emergency Requests
                </a>
            </p>

        </div>

    <?php else: ?>

        <?php foreach ($activities as $activity): ?>

            <div class="card">

                <h3>
                    <?php
                    echo htmlspecialchars(
                        $activity['emergency_type']
                    );
                    ?>
                </h3>

                <p>
                    <strong>Location:</strong>
                    <?php
                    echo htmlspecialchars(
                        $activity['location']
                    );
                    ?>
                </p>

                <p>
                    <strong>Description:</strong>
                    <?php
                    echo htmlspecialchars(
                        $activity['description']
                    );
                    ?>
                </p>

                <p>
                    <strong>Priority:</strong>
                    <?php
                    echo htmlspecialchars(
                        $activity['priority']
                    );
                    ?>
                </p>

                <p>
                    <strong>Victim Count:</strong>
                    <?php
                    echo (int)$activity['victim_count'];
                    ?>
                </p>

                <p>
                    <strong>Contact:</strong>
                    <?php
                    echo htmlspecialchars(
                        $activity['contact_information']
                    );
                    ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php
                    echo htmlspecialchars(
                        ucfirst($activity['status'])
                    );
                    ?>
                </p>

                <?php if (!empty($activity['accepted_at'])): ?>

                    <p>
                        <strong>Accepted At:</strong>
                        <?php
                        echo htmlspecialchars(
                            $activity['accepted_at']
                        );
                        ?>
                    </p>

                <?php endif; ?>


                <?php if ($activity['status'] === 'assigned'): ?>

                    <form
                        method="POST"
                        action="index.php?page=volunteer-update-status"
                    >

                        <input
                            type="hidden"
                            name="request_id"
                            value="<?php
                            echo (int)$activity['id'];
                            ?>"
                        >

                        <input
                            type="hidden"
                            name="status"
                            value="ongoing"
                        >

                        <button type="submit">
                            Start Rescue
                        </button>

                    </form>


                <?php elseif ($activity['status'] === 'ongoing'): ?>

                    <form
                        method="POST"
                        action="index.php?page=volunteer-update-status"
                    >

                        <input
                            type="hidden"
                            name="request_id"
                            value="<?php
                            echo (int)$activity['id'];
                            ?>"
                        >

                        <input
                            type="hidden"
                            name="status"
                            value="completed"
                        >

                        <button type="submit">
                            Complete Rescue
                        </button>

                    </form>


                <?php elseif ($activity['status'] === 'completed'): ?>

                    <p>
                        <strong>
                            Rescue Completed
                        </strong>
                    </p>

                <?php endif; ?>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>