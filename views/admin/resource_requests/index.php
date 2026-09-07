<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <div class="page-header">
        <div>
            <h1>Volunteer Resource Requests</h1>
            <p>
                Review resource and rescue support requests submitted by volunteers.
            </p>
        </div>
    </div>


    <?php if (empty($requests)): ?>

        <div class="card">
            <p>No resource requests found.</p>
        </div>

    <?php else: ?>

        <div class="card">

            <div class="table-responsive">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Volunteer</th>
                            <th>Resource</th>
                            <th>Quantity</th>
                            <th>Availability</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($requests as $request): ?>

                            <tr>

                                <td>
                                    #<?= (int)$request['id']; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $request['volunteer_name']
                                        ?? 'N/A'
                                    ); ?>
                                </td>

                                <td>
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
                                </td>

                                <td>
                                    <?= (int)(
                                        $request['quantity']
                                        ?? 0
                                    ); ?>
                                </td>

                                <td>
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
                                </td>

                                <td>
                                    <span class="status-badge">
                                        <?= htmlspecialchars(
                                            ucfirst(
                                                $request['status']
                                                ?? 'pending'
                                            )
                                        ); ?>
                                    </span>
                                </td>

                                <td>
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
                                </td>

                                <td>

                                    <a
                                        class="btn btn-primary"
                                        href="index.php?page=admin-resource-request-view&id=<?= (int)$request['id']; ?>"
                                    >
                                        Review
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    <?php endif; ?>

</div>

<?php
require_once "views/partials/footer.php";
?>