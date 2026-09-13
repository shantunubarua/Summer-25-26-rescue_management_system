<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$totalReports = is_array($reports)
    ? count($reports)
    : 0;

$pendingReports = 0;
$ongoingReports = 0;
$completedReports = 0;
$cancelledReports = 0;


if (!empty($reports)) {

    foreach ($reports as $item) {

        $status = strtolower(
            trim(
                (string)(
                    $item['rescue_status']
                    ?? 'pending'
                )
            )
        );


        if ($status === 'pending') {
            $pendingReports++;
        }

        if ($status === 'ongoing') {
            $ongoingReports++;
        }

        if ($status === 'completed') {
            $completedReports++;
        }

        if ($status === 'cancelled') {
            $cancelledReports++;
        }
    }
}

?>

<div class="content">

    <div class="admin-rescue-reports-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-rescue-reports-header">

            <div>

                <p class="eyebrow">
                    RESCUE OPERATION MANAGEMENT
                </p>

                <h1>
                    Rescue Reports
                </h1>

                <p class="page-subtitle">
                    Review rescue operation reports, update their
                    current progress and manage completed records.
                </p>

            </div>


            <a
                href="index.php?page=rescue-report-create"
                class="primary-action"
            >
                + Create Rescue Report
            </a>

        </div>


        <!-- =========================================
             ERROR MESSAGE
             ========================================= -->

        <?php if (!empty($error)): ?>

            <div class="admin-rescue-report-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             SUMMARY
             ========================================= -->

        <div class="admin-rescue-report-stats">


            <article class="admin-rescue-report-stat">

                <span>
                    Total Reports
                </span>

                <strong>
                    <?= (int)$totalReports; ?>
                </strong>

                <p>
                    All rescue report records.
                </p>

            </article>


            <article class="admin-rescue-report-stat">

                <span>
                    Pending
                </span>

                <strong>
                    <?= (int)$pendingReports; ?>
                </strong>

                <p>
                    Rescue operations waiting to begin.
                </p>

            </article>


            <article class="admin-rescue-report-stat">

                <span>
                    Ongoing
                </span>

                <strong>
                    <?= (int)$ongoingReports; ?>
                </strong>

                <p>
                    Rescue operations currently in progress.
                </p>

            </article>


            <article class="admin-rescue-report-stat">

                <span>
                    Completed
                </span>

                <strong>
                    <?= (int)$completedReports; ?>
                </strong>

                <p>
                    Successfully completed rescue operations.
                </p>

            </article>


            <article class="admin-rescue-report-stat">

                <span>
                    Cancelled
                </span>

                <strong>
                    <?= (int)$cancelledReports; ?>
                </strong>

                <p>
                    Rescue reports marked as cancelled.
                </p>

            </article>

        </div>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="admin-rescue-report-list-heading">

            <div>

                <p>
                    REPORT DIRECTORY
                </p>

                <h2>
                    Rescue Operation Records
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

            <div class="admin-rescue-report-empty">

                <div class="admin-rescue-report-empty-icon">
                    RR
                </div>

                <h3>
                    No Rescue Reports Found
                </h3>

                <p>
                    Rescue reports created by administrators
                    will appear here.
                </p>

                <a
                    href="index.php?page=rescue-report-create"
                    class="primary-action"
                >
                    Create Rescue Report
                </a>

            </div>


        <?php else: ?>


            <!-- =====================================
                 REPORT TABLE
                 ===================================== -->

            <div class="admin-rescue-report-table-card">

                <div class="admin-rescue-report-table-wrap">

                    <table class="admin-rescue-report-table">

                        <thead>

                            <tr>

                                <th>
                                    Report ID
                                </th>

                                <th>
                                    Emergency Request
                                </th>

                                <th>
                                    Admin ID
                                </th>

                                <th>
                                    Rescue Status
                                </th>

                                <th>
                                    Description
                                </th>

                                <th>
                                    Created At
                                </th>

                                <th>
                                    Updated At
                                </th>

                                <th>
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($reports as $report): ?>


                                <?php

                                $status = strtolower(
                                    trim(
                                        (string)(
                                            $report['rescue_status']
                                            ?? 'pending'
                                        )
                                    )
                                );

                                ?>


                                <tr>


                                    <!-- REPORT ID -->

                                    <td>

                                        <span class="admin-rescue-report-id">

                                            #<?= (int)$report['id']; ?>

                                        </span>

                                    </td>


                                    <!-- EMERGENCY REQUEST -->

                                    <td>

                                        <span class="admin-rescue-request-id">

                                            #<?= (int)$report[
                                                'emergency_request_id'
                                            ]; ?>

                                        </span>

                                    </td>


                                    <!-- ADMIN -->

                                    <td>

                                        <span class="admin-rescue-admin-id">

                                            Admin #<?= (int)$report[
                                                'admin_id'
                                            ]; ?>

                                        </span>

                                    </td>


                                    <!-- STATUS UPDATE -->

                                    <td>

                                        <form
                                            method="POST"
                                            action="index.php?page=rescue-reports"
                                            class="status-form admin-rescue-status-form"
                                        >

                                            <?php echo csrfField(); ?>


                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int)$report['id']; ?>"
                                            >


                                            <select
                                                name="rescue_status"
                                                class="admin-rescue-status-select admin-rescue-status-<?= htmlspecialchars(
                                                    $status,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                                required
                                            >

                                                <option
                                                    value="pending"
                                                    <?= $status === 'pending'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Pending
                                                </option>


                                                <option
                                                    value="ongoing"
                                                    <?= $status === 'ongoing'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Ongoing
                                                </option>


                                                <option
                                                    value="completed"
                                                    <?= $status === 'completed'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Completed
                                                </option>


                                                <option
                                                    value="cancelled"
                                                    <?= $status === 'cancelled'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Cancelled
                                                </option>

                                            </select>


                                            <button
                                                type="submit"
                                                class="admin-rescue-update-button"
                                            >
                                                Update
                                            </button>

                                        </form>

                                    </td>


                                    <!-- DESCRIPTION -->

                                    <td>

                                        <div class="admin-rescue-description">

                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $report['description']
                                                    ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            ); ?>

                                        </div>

                                    </td>


                                    <!-- CREATED -->

                                    <td>

                                        <span class="admin-rescue-date">

                                            <?= htmlspecialchars(
                                                $report['created_at']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- UPDATED -->

                                    <td>

                                        <span class="admin-rescue-date">

                                            <?= htmlspecialchars(
                                                $report['updated_at']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- ACTIONS -->

                                    <td>

                                        <div class="admin-rescue-report-actions">


                                            <a
                                                href="index.php?page=rescue-report-view&id=<?= (int)$report['id']; ?>"
                                                class="admin-rescue-view-button"
                                            >
                                                View
                                            </a>


                                            <a
                                                href="index.php?page=rescue-report-edit&id=<?= (int)$report['id']; ?>"
                                                class="admin-rescue-edit-button"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="index.php?page=rescue-report-delete"
                                                class="admin-rescue-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this rescue report?');"
                                            >

                                                <?php echo csrfField(); ?>


                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int)$report['id']; ?>"
                                                >


                                                <button
                                                    type="submit"
                                                    class="admin-rescue-delete-button"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

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