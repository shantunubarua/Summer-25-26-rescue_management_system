<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

require_once "models/VolunteerModel.php";

$requests = getVolunteerEmergencyRequests($conn);

?>

<div class="content">

    <h1>Emergency Requests</h1>

    <p>
        View pending emergency requests that need volunteer assistance.
    </p>

    <?php if (empty($requests)): ?>

        <div class="card">

            <h3>No Emergency Requests</h3>

            <p>
                There are currently no pending emergency requests.
            </p>

        </div>

    <?php else: ?>

        <?php foreach ($requests as $request): ?>

            <div class="card">

                <h3>
                    <?php echo htmlspecialchars($request['emergency_type']); ?>
                </h3>

                <p>
                    <strong>Location:</strong>
                    <?php echo htmlspecialchars($request['location']); ?>
                </p>

                <p>
                    <strong>Description:</strong>
                    <?php echo htmlspecialchars($request['description']); ?>
                </p>

                <p>
                    <strong>Priority:</strong>
                    <?php echo htmlspecialchars($request['priority']); ?>
                </p>

                <p>
                    <strong>Victim Count:</strong>
                    <?php echo htmlspecialchars($request['victim_count']); ?>
                </p>

                <p>
                    <strong>Contact:</strong>
                    <?php echo htmlspecialchars($request['contact_information']); ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php echo htmlspecialchars($request['status']); ?>
                </p>
                
                <?php if ($request['status'] === 'pending'): ?>

    <form method="POST" action="index.php?page=volunteer-accept-request">

        <input
            type="hidden"
            name="request_id"
            value="<?php echo $request['id']; ?>"
        >

        <button type="submit">
            Accept Request
        </button>

    </form>

<?php endif; ?>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>