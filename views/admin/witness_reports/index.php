<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$totalReports = is_array($reports)
    ? count($reports)
    : 0;

$pendingReports = 0;
$reviewedReports = 0;
$approvedReports = 0;
$rejectedReports = 0;


if (!empty($reports)) {

    foreach ($reports as $item) {

        $reportStatus = strtolower(
            trim(
                (string)(
                    $item['status']
                    ?? 'pending'
                )
            )
        );


        if ($reportStatus === 'pending') {
            $pendingReports++;
        }

        if ($reportStatus === 'reviewed') {
            $reviewedReports++;
        }

        if ($reportStatus === 'approved') {
            $approvedReports++;
        }

        if ($reportStatus === 'rejected') {
            $rejectedReports++;
        }
    }
}

?>

<div class="content">

    <div class="admin-witness-reports-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-witness-reports-header">

            <div>

                <p class="eyebrow">
                    INCIDENT REVIEW
                </p>

                <h1>
                    Witness Incident Reports
                </h1>

                <p class="page-subtitle">
                    Review incident reports submitted by
                    registered witnesses and track their
                    current review status.
                </p>

            </div>

        </div>


        <!-- =========================================
             REPORT SUMMARY
             ========================================= -->

        <div class="admin-witness-report-stats">


            <!-- TOTAL -->

            <article class="admin-witness-report-stat">

                <span>
                    Total Reports
                </span>

                <strong>
                    <?= (int)$totalReports; ?>
                </strong>

                <p>
                    All witness incident reports.
                </p>

            </article>


            <!-- PENDING -->

            <article class="admin-witness-report-stat">

                <span>
                    Pending
                </span>

                <strong>
                    <?= (int)$pendingReports; ?>
                </strong>

                <p>
                    Reports waiting for review.
                </p>

            </article>


            <!-- REVIEWED -->

            <article class="admin-witness-report-stat">

                <span>
                    Reviewed
                </span>

                <strong>
                    <?= (int)$reviewedReports; ?>
                </strong>

                <p>
                    Reports already reviewed.
                </p>

            </article>


            <!-- APPROVED -->

            <article class="admin-witness-report-stat">

                <span>
                    Approved
                </span>

                <strong>
                    <?= (int)$approvedReports; ?>
                </strong>

                <p>
                    Reports approved by admin.
                </p>

            </article>


            <!-- REJECTED -->

            <article class="admin-witness-report-stat">

                <span>
                    Rejected
                </span>

                <strong>
                    <?= (int)$rejectedReports; ?>
                </strong>

                <p>
                    Reports rejected after review.
                </p>

            </article>

        </div>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="admin-witness-report-list-heading">

            <div>

                <p>
                    REPORT DIRECTORY
                </p>

                <h2>
                    Submitted Reports
                </h2>

            </div>


            <span>
                <?= (int)$totalReports; ?>
                report<?= $totalReports === 1 ? '' : 's'; ?>
            </span>

        </div>


        <!-- =========================================
             EMPTY STATE
             ========================================= -->

        <?php if (empty($reports)): ?>

            <div class="admin-witness-report-empty">

                <div class="admin-witness-report-empty-icon">
                    WR
                </div>

                <h3>
                    No Witness Reports Found
                </h3>

                <p>
                    Incident reports submitted by witnesses
                    will appear here for administrative review.
                </p>

            </div>


        <?php else: ?>


            <!-- =====================================
                 REPORT TABLE
                 ===================================== -->

            <div class="admin-witness-report-table-card">

                <div class="admin-witness-report-table-wrap">

                    <table class="admin-witness-report-table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Witness
                                </th>

                                <th>
                                    Report
                                </th>

                                <th>
                                    Incident Type
                                </th>

                                <th>
                                    Damage
                                </th>

                                <th>
                                    Location
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Submitted
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($reports as $report): ?>


                                <?php

                                $status = strtolower(
                                    trim(
                                        (string)(
                                            $report['status']
                                            ?? 'pending'
                                        )
                                    )
                                );


                                $damageLevel = strtolower(
                                    trim(
                                        (string)(
                                            $report['damage_level']
                                            ?? 'unknown'
                                        )
                                    )
                                );


                                $createdAt =
                                    $report['created_at']
                                    ?? '';

                                ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <span class="admin-witness-report-id">

                                            #<?= (int)$report['id']; ?>

                                        </span>

                                    </td>


                                    <!-- WITNESS -->

                                    <td>

                                        <div class="admin-witness-report-user">


                                            <div class="admin-witness-report-avatar">

                                                <?= htmlspecialchars(
                                                    strtoupper(
                                                        substr(
                                                            trim(
                                                                $report[
                                                                    'witness_name'
                                                                ]
                                                                ?? 'W'
                                                            ),
                                                            0,
                                                            1
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </div>


                                            <strong>

                                                <?= htmlspecialchars(
                                                    $report[
                                                        'witness_name'
                                                    ]
                                                    ?? 'N/A',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </strong>

                                        </div>

                                    </td>


                                    <!-- TITLE -->

                                    <td>

                                        <strong class="admin-witness-report-title">

                                            <?= htmlspecialchars(
                                                $report['title']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </strong>

                                    </td>


                                    <!-- INCIDENT TYPE -->

                                    <td>

                                        <span class="admin-witness-incident-type">

                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $report[
                                                            'incident_type'
                                                        ]
                                                        ?? 'N/A'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- DAMAGE LEVEL -->

                                    <td>

                                        <span
                                            class="admin-witness-damage admin-witness-damage-<?= htmlspecialchars(
                                                $damageLevel,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $report[
                                                        'damage_level'
                                                    ]
                                                    ?? 'N/A'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- LOCATION -->

                                    <td>

                                        <div class="admin-witness-report-location">

                                            <?= htmlspecialchars(
                                                $report['location']
                                                ?? 'N/A',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </div>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="admin-witness-report-status admin-witness-report-status-<?= htmlspecialchars(
                                                $status,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst($status),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- SUBMITTED -->

                                    <td>

                                        <span class="admin-witness-report-date">

                                            <?php

                                            echo $createdAt
                                                ? htmlspecialchars(
                                                    date(
                                                        'd M Y, h:i A',
                                                        strtotime(
                                                            $createdAt
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                : 'N/A';

                                            ?>

                                        </span>

                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <a
                                            href="index.php?page=admin-witness-report-view&id=<?= (int)$report['id']; ?>"
                                            class="admin-witness-report-review"
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

</div>


<?php
require_once "views/partials/footer.php";
?>