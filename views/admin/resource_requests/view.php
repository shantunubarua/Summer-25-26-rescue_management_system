<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <div class="page-header">

        <div>
            <h1>Review Resource Request</h1>

            <p>
                Review the volunteer's resource request
                and update its current status.
            </p>
        </div>

        <div>

            <a
                href="index.php?page=admin-resource-requests"
                class="btn"
            >
                Back to Requests
            </a>

        </div>

    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <!-- REQUEST INFORMATION -->

    <div class="card">

        <h2>Request Information</h2>

        <p>
            <strong>Request ID:</strong>

            #<?= (int)$request['id']; ?>
        </p>


        <p>
            <strong>Resource Type:</strong>

            <?= htmlspecialchars(
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $request['resource_type']
                        ?? 'N/A'
                    )
                )
            ); ?>
        </p>


        <p>
            <strong>Quantity:</strong>

            <?= (int)(
                $request['quantity']
                ?? 0
            ); ?>
        </p>


        <p>
            <strong>Current Status:</strong>

            <span class="status-badge">

                <?= htmlspecialchars(
                    ucfirst(
                        $request['status']
                        ?? 'pending'
                    )
                ); ?>

            </span>
        </p>


        <p>
            <strong>Requested At:</strong>

            <?php

            $createdAt =
                $request['created_at']
                ?? '';

            echo $createdAt
                ? htmlspecialchars(
                    date(
                        'd M Y, h:i A',
                        strtotime($createdAt)
                    )
                )
                : 'N/A';

            ?>
        </p>


        <p>
            <strong>Last Updated:</strong>

            <?php

            $updatedAt =
                $request['updated_at']
                ?? '';

            echo $updatedAt
                ? htmlspecialchars(
                    date(
                        'd M Y, h:i A',
                        strtotime($updatedAt)
                    )
                )
                : 'N/A';

            ?>
        </p>

    </div>


    <!-- REQUEST DESCRIPTION -->

    <div class="card">

        <h2>Request Description</h2>

        <p>
            <?= nl2br(
                htmlspecialchars(
                    $request['description']
                    ?? 'No description provided.'
                )
            ); ?>
        </p>

    </div>


    <!-- VOLUNTEER INFORMATION -->

    <div class="card">

        <h2>Volunteer Information</h2>

        <p>
            <strong>Name:</strong>

            <?= htmlspecialchars(
                $request['volunteer_name']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Email:</strong>

            <?= htmlspecialchars(
                $request['volunteer_email']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Phone:</strong>

            <?= htmlspecialchars(
                $request['volunteer_phone']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Address:</strong>

            <?= htmlspecialchars(
                $request['volunteer_address']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Blood Group:</strong>

            <?= htmlspecialchars(
                $request['blood_group']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Experience:</strong>

            <?= htmlspecialchars(
                $request['experience']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Skills:</strong>

            <?= htmlspecialchars(
                $request['skills']
                ?? 'N/A'
            ); ?>
        </p>


        <p>
            <strong>Availability:</strong>

            <?= htmlspecialchars(
                ucfirst(
                    str_replace(
                        '_',
                        ' ',
                        $request['availability_status']
                        ?? 'N/A'
                    )
                )
            ); ?>
        </p>


        <p>
            <strong>Emergency Contact:</strong>

            <?= htmlspecialchars(
                $request['emergency_contact']
                ?? 'N/A'
            ); ?>
        </p>

    </div>


    <!-- ADMIN REVIEW -->

    <div class="card">

        <h2>Admin Decision</h2>

        <?php

        $currentStatus =
            $request['status']
            ?? 'pending';

        ?>

        <form method="POST">

            <div class="form-group">

                <label for="status">
                    Request Status
                </label>

                <select
                    name="status"
                    id="status"
                    required
                >

                    <option
                        value="pending"
                        <?= $currentStatus === 'pending'
                            ? 'selected'
                            : ''; ?>
                    >
                        Pending
                    </option>

                    <option
                        value="approved"
                        <?= $currentStatus === 'approved'
                            ? 'selected'
                            : ''; ?>
                    >
                        Approved
                    </option>

                    <option
                        value="rejected"
                        <?= $currentStatus === 'rejected'
                            ? 'selected'
                            : ''; ?>
                    >
                        Rejected
                    </option>

                    <option
                        value="completed"
                        <?= $currentStatus === 'completed'
                            ? 'selected'
                            : ''; ?>
                    >
                        Completed
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Update Status
            </button>

        </form>

    </div>

</div>

<?php
require_once "views/partials/footer.php";
?>