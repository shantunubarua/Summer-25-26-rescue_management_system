<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";
?>

<div class="content">

    <div class="page-header">
        <div>
            <h1>Review Witness Incident Report</h1>

            <p>
                Review the complete incident report and update its status.
            </p>
        </div>

        <div>
            <a
                class="btn"
                href="index.php?page=admin-witness-reports"
            >
                Back to Reports
            </a>
        </div>
    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <div class="card">

        <h2>Report Information</h2>

        <p>
            <strong>Report ID:</strong>
            #<?= (int)$report['id']; ?>
        </p>

        <p>
            <strong>Title:</strong>
            <?= htmlspecialchars(
                $report['title'] ?? 'N/A'
            ); ?>
        </p>

        <p>
            <strong>Incident Type:</strong>
            <?= htmlspecialchars(
                ucfirst(
                    $report['incident_type']
                    ?? 'N/A'
                )
            ); ?>
        </p>

        <p>
            <strong>Damage Level:</strong>
            <?= htmlspecialchars(
                ucfirst(
                    $report['damage_level']
                    ?? 'N/A'
                )
            ); ?>
        </p>

        <p>
            <strong>Location:</strong>
            <?= htmlspecialchars(
                $report['location'] ?? 'N/A'
            ); ?>
        </p>

        <p>
            <strong>Incident Date:</strong>
            <?= htmlspecialchars(
                $report['incident_date']
                ?? 'N/A'
            ); ?>
        </p>

        <p>
            <strong>Submitted At:</strong>

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
        </p>

    </div>


    <div class="card">

        <h2>Witness Information</h2>

        <p>
            <strong>Name:</strong>
            <?= htmlspecialchars(
                $report['witness_name']
                ?? 'N/A'
            ); ?>
        </p>

        <p>
            <strong>Email:</strong>
            <?= htmlspecialchars(
                $report['witness_email']
                ?? 'N/A'
            ); ?>
        </p>

        <p>
            <strong>Phone:</strong>
            <?= htmlspecialchars(
                $report['witness_phone']
                ?? 'N/A'
            ); ?>
        </p>

    </div>


    <div class="card">

        <h2>Incident Description</h2>

        <p>
            <?= nl2br(
                htmlspecialchars(
                    $report['description']
                    ?? 'No description provided.'
                )
            ); ?>
        </p>

    </div>


    <div class="card">

        <h2>Evidence</h2>

        <?php if (!empty($report['evidence_file'])): ?>

            <p>
                Evidence File:

                <strong>
                    <?= htmlspecialchars(
                        basename(
                            $report['evidence_file']
                        )
                    ); ?>
                </strong>
            </p>

            <a
                class="btn"
                href="<?= htmlspecialchars(
                    $report['evidence_file']
                ); ?>"
                target="_blank"
                rel="noopener"
            >
                View Evidence
            </a>

        <?php else: ?>

            <p>
                No evidence file was submitted.
            </p>

        <?php endif; ?>

    </div>


    <div class="card">

        <h2>Admin Review</h2>

        <p>
            <strong>Current Status:</strong>

            <span class="status-badge">
                <?= htmlspecialchars(
                    ucfirst(
                        $report['status']
                        ?? 'pending'
                    )
                ); ?>
            </span>
        </p>


        <?php

        $currentStatus =
            $report['status']
            ?? 'pending';

        ?>


        <form
            method="POST"
            action="index.php?page=admin-witness-report-view&id=<?= (int)$report['id']; ?>"
        >

            <?php echo csrfField(); ?>

            <div class="form-group">

                <label for="status">
                    Update Report Status
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
                        value="reviewed"
                        <?= $currentStatus === 'reviewed'
                            ? 'selected'
                            : ''; ?>
                    >
                        Reviewed
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