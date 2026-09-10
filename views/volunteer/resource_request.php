<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
require_once "models/ResourceRequestModel.php";

$volunteer_id = (int)($_SESSION['user']['id'] ?? 0);

$isMyRequests =
    isset($_GET['page']) &&
    $_GET['page'] === 'volunteer-resource-requests';

?>

<div class="content">

<?php if ($isMyRequests): ?>

    <!-- ============================= -->
    <!-- MY RESOURCE REQUESTS -->
    <!-- ============================= -->

    <h1>My Resource Requests</h1>

    <p>
        View all resource requests you have submitted.
    </p>

    <p>
        <a href="index.php?page=volunteer-resource-request">
            Request New Resource
        </a>
    </p>

    <?php

    $requests = getVolunteerResourceRequests(
        $conn,
        $volunteer_id
    );

    ?>

    <?php if (empty($requests)): ?>

        <div class="card">

            <h3>No Resource Requests</h3>

            <p>
                You have not submitted any resource requests yet.
            </p>

        </div>

    <?php else: ?>

        <?php foreach ($requests as $request): ?>

            <div class="card">

                <h3>
                    <?php
                    echo htmlspecialchars(
                        $request['resource_type'] ?? ''
                    );
                    ?>
                </h3>

                <p>
                    <strong>Request ID:</strong>
                    <?php
                    echo (int)($request['id'] ?? 0);
                    ?>
                </p>

                <p>
                    <strong>Volunteer ID:</strong>
                    <?php
                    echo (int)($request['volunteer_id'] ?? 0);
                    ?>
                </p>

                <p>
                    <strong>Resource Type:</strong>
                    <?php
                    echo htmlspecialchars(
                        $request['resource_type'] ?? ''
                    );
                    ?>
                </p>

                <p>
                    <strong>Quantity:</strong>
                    <?php
                    echo (int)($request['quantity'] ?? 0);
                    ?>
                </p>

                <p>
                    <strong>Description:</strong>
                    <?php
                    echo htmlspecialchars(
                        $request['description'] ?? ''
                    );
                    ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php
                    echo htmlspecialchars(
                        ucfirst(
                            $request['status'] ?? 'pending'
                        )
                    );
                    ?>
                </p>

                <p>
                    <strong>Requested At:</strong>
                    <?php
                    echo htmlspecialchars(
                        $request['created_at'] ?? ''
                    );
                    ?>
                </p>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>


<?php else: ?>

    <!-- ============================= -->
    <!-- NEW RESOURCE REQUEST FORM -->
    <!-- ============================= -->

    <h1>Request Resource</h1>

    <p>
        Submit a request for resources needed during rescue
        activities.
    </p>

    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?php
            echo htmlspecialchars($error);
            ?>
        </p>

    <?php endif; ?>

    <div class="card">

        <form
            method="POST"
            action="index.php?page=volunteer-resource-request"
        >

            <div>

                <label>
                    Resource Type *
                </label>

                <input
                    type="text"
                    name="resource_type"
                    placeholder="Example: First Aid Kit"
                    required
                >

            </div>


            <div>

                <label>
                    Quantity *
                </label>

                <input
                    type="number"
                    name="quantity"
                    min="1"
                    required
                >

            </div>


            <div>

                <label>
                    Description
                </label>

                <textarea
                    name="description"
                    placeholder="Describe the resource you need..."
                ></textarea>

            </div>


            <button type="submit">
                Submit Resource Request
            </button>

        </form>

    </div>

<?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>