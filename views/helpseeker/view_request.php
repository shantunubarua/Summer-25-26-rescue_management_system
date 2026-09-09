<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

?>

<div class="content">

    <h1>Emergency Request Details</h1>

    <div class="card">

        <h3>
            <?php echo htmlspecialchars(
                ucfirst($request['emergency_type'])
            ); ?>
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
            <?php echo htmlspecialchars(
                ucfirst($request['priority'])
            ); ?>
        </p>

        <p>
            <strong>Victim Type:</strong>
            <?php echo htmlspecialchars(
                ucfirst($request['victim_type'])
            ); ?>
        </p>

        <?php if (!empty($request['victim_information'])): ?>

            <p>
                <strong>Victim Information:</strong>
                <?php echo htmlspecialchars(
                    $request['victim_information']
                ); ?>
            </p>

        <?php endif; ?>

        <p>
            <strong>Victim Count:</strong>
            <?php echo (int)$request['victim_count']; ?>
        </p>

        <p>
            <strong>Contact Information:</strong>
            <?php echo htmlspecialchars(
                $request['contact_information']
            ); ?>
        </p>

        <p>
            <strong>Status:</strong>
            <?php echo htmlspecialchars(
                ucfirst($request['status'] ?? 'pending')
            ); ?>
        </p>

        <?php if (!empty($request['accepted_at'])): ?>

            <p>
                <strong>Accepted At:</strong>
                <?php echo htmlspecialchars(
                    $request['accepted_at']
                ); ?>
            </p>

        <?php endif; ?>

        <?php if (!empty($request['created_at'])): ?>

            <p>
                <strong>Created At:</strong>
                <?php echo htmlspecialchars(
                    $request['created_at']
                ); ?>
            </p>

        <?php endif; ?>

    </div>

    <p>
        <a href="index.php?page=helpseeker-requests">
            Back to My Requests
        </a>
    </p>

</div>

<?php require_once "views/partials/footer.php"; ?>
