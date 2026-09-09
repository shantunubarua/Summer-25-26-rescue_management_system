<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

?>

<div class="content">

    <h1>My Emergency Requests</h1>

    <p>
        View the emergency requests you have submitted.
    </p>

    <p>
        <a href="index.php?page=helpseeker-request-create">
            Create New Emergency Request
        </a>
    </p>


    <?php if (empty($requests)): ?>

        <div class="card">

            <h3>No Emergency Requests</h3>

            <p>
                You have not submitted any emergency requests yet.
            </p>

            <p>
                <a href="index.php?page=helpseeker-request-create">
                    Create Emergency Request
                </a>
            </p>

        </div>

    <?php else: ?>


        <?php foreach ($requests as $request): ?>

            <div class="card">

                <!-- EMERGENCY TYPE -->

                <h3>
                    <?php
                    echo htmlspecialchars(
                        ucfirst($request['emergency_type'])
                    );
                    ?>
                </h3>


                <!-- REQUEST ID -->

                <p>
                    <strong>Request ID:</strong>

                    <?php
                    echo (int)$request['id'];
                    ?>
                </p>


                <!-- LOCATION -->

                <p>
                    <strong>Location:</strong>

                    <?php
                    echo htmlspecialchars(
                        $request['location']
                    );
                    ?>
                </p>


                <!-- DESCRIPTION -->

                <p>
                    <strong>Description:</strong>

                    <?php
                    echo htmlspecialchars(
                        $request['description']
                    );
                    ?>
                </p>


                <!-- PRIORITY -->

                <p>
                    <strong>Priority:</strong>

                    <?php
                    echo htmlspecialchars(
                        ucfirst($request['priority'])
                    );
                    ?>
                </p>


                <!-- VICTIM TYPE -->

                <p>
                    <strong>Victim Type:</strong>

                    <?php
                    echo htmlspecialchars(
                        ucfirst($request['victim_type'])
                    );
                    ?>
                </p>


                <!-- VICTIM INFORMATION -->

                <?php if (!empty($request['victim_information'])): ?>

                    <p>
                        <strong>Victim Information:</strong>

                        <?php
                        echo htmlspecialchars(
                            $request['victim_information']
                        );
                        ?>
                    </p>

                <?php endif; ?>


                <!-- VICTIM COUNT -->

                <p>
                    <strong>Victim Count:</strong>

                    <?php
                    echo (int)$request['victim_count'];
                    ?>
                </p>


                <!-- CONTACT INFORMATION -->

                <p>
                    <strong>Contact Information:</strong>

                    <?php
                    echo htmlspecialchars(
                        $request['contact_information']
                    );
                    ?>
                </p>


                <!-- STATUS -->

                <p>

                    <strong>Status:</strong>

                    <?php

                    $status = $request['status'] ?? 'pending';

                    $statusText = ucfirst($status);

                    $statusClass = 'status-pending';

                    if ($status === 'assigned') {

                        $statusClass = 'status-assigned';

                    } elseif ($status === 'ongoing') {

                        $statusClass = 'status-ongoing';

                    } elseif ($status === 'completed') {

                        $statusClass = 'status-completed';

                    } elseif ($status === 'cancelled') {

                        $statusClass = 'status-cancelled';

                    }

                    ?>

                    <span class="<?php echo $statusClass; ?>">

                        <?php
                        echo htmlspecialchars($statusText);
                        ?>

                    </span>

                </p>


                <!-- ACCEPTED AT -->

                <?php if (!empty($request['accepted_at'])): ?>

                    <p>

                        <strong>Accepted At:</strong>

                        <?php
                        echo htmlspecialchars(
                            $request['accepted_at']
                        );
                        ?>

                    </p>

                <?php endif; ?>


                <!-- CREATED AT -->

                <p>

                    <strong>Created At:</strong>

                    <?php
                    echo htmlspecialchars(
                        $request['created_at'] ?? ''
                    );
                    ?>

                </p>


                <!-- VIEW DETAILS -->

                <p>

                    <a
                        href="index.php?page=helpseeker-request-view&id=<?php echo (int)$request['id']; ?>"
                    >
                        View Details
                    </a>

                </p>


                <!-- GIVE FEEDBACK -->

                <?php if ($status === 'completed'): ?>

                    <p>

                        <a
                            href="index.php?page=helpseeker-feedback&id=<?php echo (int)$request['id']; ?>"
                        >
                            Give Feedback
                        </a>

                    </p>

                <?php endif; ?>


            </div>

        <?php endforeach; ?>


    <?php endif; ?>

</div>


<style>

.status-pending {
    color: #856404;
    background-color: #fff3cd;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-assigned {
    color: #004085;
    background-color: #cce5ff;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-ongoing {
    color: #155724;
    background-color: #d4edda;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-completed {
    color: #155724;
    background-color: #c3e6cb;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-cancelled {
    color: #721c24;
    background-color: #f8d7da;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

</style>


<?php require_once "views/partials/footer.php"; ?>