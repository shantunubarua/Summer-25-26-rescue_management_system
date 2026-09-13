<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<?php
$initialCount = is_array($reports)
    ? count($reports)
    : 0;
?>

<div class="content">

    <div class="witness-reports-page">


        <!-- ================================
             PAGE HEADER
        ================================= -->

        <div class="witness-page-header">

            <div>

                <p class="eyebrow">
                    INCIDENT MANAGEMENT
                </p>

                <h1>
                    My Incident Reports
                </h1>

                <p class="page-subtitle">
                    Search, review and manage the incident reports
                    you have submitted.
                </p>

            </div>


            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=witness-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

                <a
                    href="index.php?page=witness-report-create"
                    class="primary-action"
                >
                    + Report New Incident
                </a>

            </div>

        </div>


        <!-- ================================
             SEARCH
        ================================= -->

        <div class="witness-report-search-card">

            <div class="witness-report-search-main">

                <label for="witnessReportSearch">
                    Search Incident Reports
                </label>

                <div class="witness-search-input-wrap">

                    <span class="witness-search-icon">
                        S
                    </span>

                    <input
                        type="text"
                        id="witnessReportSearch"
                        placeholder="Search by title, type, location, damage level or status..."
                        autocomplete="off"
                    >

                </div>

            </div>


            <div
                class="witness-search-count-box"
                id="witnessSearchStatus"
            >

                <span>
                    Showing
                </span>

                <strong id="witnessSearchCount">
                    <?= (int)$initialCount; ?>
                </strong>

                <span>
                    report(s)
                </span>

            </div>

        </div>


        <!-- CSRF TOKEN FOR AJAX DELETE -->

        <input
            type="hidden"
            id="witnessCsrfToken"
            value="<?= htmlspecialchars(
                getCsrfToken(),
                ENT_QUOTES,
                'UTF-8'
            ); ?>"
        >


        <!-- ================================
             TABLE
        ================================= -->

        <div class="witness-table-card">

            <div class="witness-table-card-header">

                <div>

                    <span>
                        REPORT HISTORY
                    </span>

                    <h2>
                        Submitted Reports
                    </h2>

                </div>

                <small>
                    <?= (int)$initialCount; ?>
                    total report(s)
                </small>

            </div>


            <div class="witness-table-responsive">

                <table id="witnessReportTable">

                    <thead>

                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Incident Type</th>
                            <th>Damage Level</th>
                            <th>Location</th>
                            <th>Incident Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                    </thead>


                    <tbody id="witnessReportTableBody">

                        <?php if (empty($reports)): ?>

                            <tr id="witnessNoReportsRow">

                                <td
                                    colspan="8"
                                    class="witness-table-empty-cell"
                                >

                                    <div class="witness-table-empty">

                                        <div class="witness-table-empty-icon">
                                            R
                                        </div>

                                        <strong>
                                            No Incident Reports Yet
                                        </strong>

                                        <span>
                                            Submit your first incident report
                                            to see it here.
                                        </span>

                                        <a
                                            href="index.php?page=witness-report-create"
                                            class="secondary-action"
                                        >
                                            Report an Incident
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php else: ?>


                            <?php foreach ($reports as $report): ?>

                                <?php

                                $damageLevel =
                                    strtolower(
                                        $report['damage_level']
                                        ?? 'low'
                                    );

                                $reportStatus =
                                    strtolower(
                                        $report['status']
                                        ?? 'pending'
                                    );

                                ?>

                                <tr>


                                    <!-- ID -->

                                    <td class="witness-report-id">

                                        #<?= (int)$report['id']; ?>

                                    </td>


                                    <!-- TITLE -->

                                    <td>

                                        <a
                                            class="witness-report-title-link"
                                            href="index.php?page=witness-report-view&id=<?= (int)$report['id']; ?>"
                                        >
                                            <?= htmlspecialchars(
                                                $report['title']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </a>

                                    </td>


                                    <!-- TYPE -->

                                    <td>

                                        <?= htmlspecialchars(
                                            ucfirst(
                                                $report['incident_type']
                                                ?? ''
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </td>


                                    <!-- DAMAGE -->

                                    <td>

                                        <span
                                            class="witness-table-badge witness-damage-<?=
                                                htmlspecialchars(
                                                    $damageLevel,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                );
                                            ?>"
                                        >
                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $report['damage_level']
                                                    ?? 'Not specified'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </span>

                                    </td>


                                    <!-- LOCATION -->

                                    <td class="witness-location-cell">

                                        <?= htmlspecialchars(
                                            $report['location']
                                            ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </td>


                                    <!-- DATE -->

                                    <td class="witness-date-cell">

                                        <?php if (
                                            !empty(
                                                $report['incident_date']
                                            )
                                        ): ?>

                                            <?= htmlspecialchars(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $report[
                                                            'incident_date'
                                                        ]
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        <?php else: ?>

                                            —

                                        <?php endif; ?>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="witness-table-badge witness-report-status-<?=
                                                htmlspecialchars(
                                                    $reportStatus,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                );
                                            ?>"
                                        >
                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $reportStatus
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </span>

                                    </td>


                                    <!-- ACTION -->

                                    <td>

                                        <div class="witness-table-actions">

                                            <a
                                                href="index.php?page=witness-report-view&id=<?= (int)$report['id']; ?>"
                                                class="witness-action-link witness-view-link"
                                            >
                                                View
                                            </a>


                                            <a
                                                href="index.php?page=witness-report-edit&id=<?= (int)$report['id']; ?>"
                                                class="witness-action-link witness-edit-link"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="index.php?page=witness-report-delete"
                                                class="witness-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this report?');"
                                            >

                                                <?= csrfField(); ?>

                                                <input
                                                    type="hidden"
                                                    name="id"
                                                    value="<?= (int)$report['id']; ?>"
                                                >

                                                <button
                                                    type="submit"
                                                    class="witness-delete-button"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        <!-- AJAX SEARCH MESSAGE -->

        <div
            id="witnessSearchMessage"
            class="witness-search-message"
            aria-live="polite"
        ></div>

    </div>

</div>

<script src="assets/js/witness.js?v=6"></script>

<?php require_once "views/partials/footer.php"; ?>