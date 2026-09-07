<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <div class="page-header">
        <div>
            <h1>Witness Incident Reports</h1>
            <p>
                Review incident reports submitted by registered witnesses.
            </p>
        </div>
    </div>


    <?php if (empty($reports)): ?>

        <div class="card">
            <p>No witness reports found.</p>
        </div>

    <?php else: ?>

        <div class="card">

            <div class="table-responsive">

                <table class="data-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Witness</th>
                            <th>Title</th>
                            <th>Incident Type</th>
                            <th>Damage</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($reports as $report): ?>

                            <tr>

                                <td>
                                    #<?= (int)$report['id']; ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $report['witness_name'] ?? 'N/A'
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $report['title'] ?? ''
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        ucfirst(
                                            $report['incident_type']
                                            ?? 'N/A'
                                        )
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        ucfirst(
                                            $report['damage_level']
                                            ?? 'N/A'
                                        )
                                    ); ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $report['location'] ?? 'N/A'
                                    ); ?>
                                </td>

                                <td>
                                    <span class="status-badge">
                                        <?= htmlspecialchars(
                                            ucfirst(
                                                $report['status']
                                                ?? 'pending'
                                            )
                                        ); ?>
                                    </span>
                                </td>

                                <td>
                                    <?php

                                    $createdAt =
                                        $report['created_at']
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
                                        href="index.php?page=admin-witness-report-view&id=<?= (int)$report['id']; ?>"
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