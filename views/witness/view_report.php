<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Incident Report Details</h1>

    <?php if (!$report): ?>

        <p>
            Incident report not found.
        </p>

        <p>
            <a href="index.php?page=witness-reports">
                Back to My Reports
            </a>
        </p>

    <?php else: ?>

        <div class="card">

            <p>
                <strong>Report ID:</strong>
                <?php echo (int)$report['id']; ?>
            </p>

            <p>
                <strong>Title:</strong>
                <?php echo htmlspecialchars($report['title']); ?>
            </p>

            <p>
                <strong>Incident Type:</strong>
                <?php echo htmlspecialchars($report['incident_type']); ?>
            </p>

            <p>
    <strong>Damage Level:</strong>

    <?php
    echo htmlspecialchars(
        ucfirst($report['damage_level'] ?? 'Not specified')
    );
    ?>
</p>

            <p>
                <strong>Location:</strong>
                <?php echo htmlspecialchars($report['location']); ?>
            </p>

            <p>
                <strong>Incident Date:</strong>
                <?php echo htmlspecialchars($report['incident_date']); ?>
            </p>

            <p>
                <strong>Description:</strong>
                <?php
                echo nl2br(
                    htmlspecialchars($report['description'])
                );
                ?>
            </p>

            <p>
                <strong>Status:</strong>
                <?php echo htmlspecialchars($report['status']); ?>
            </p>

            <?php if (!empty($report['created_at'])): ?>

                <p>
                    <strong>Submitted At:</strong>
                    <?php
                    echo htmlspecialchars(
                        $report['created_at']
                    );
                    ?>
                </p>

            <?php endif; ?>

           <?php if (!empty($report['evidence_file'])): ?>

    <p>
        <strong>Evidence:</strong>

        <a
            href="<?php echo htmlspecialchars($report['evidence_file']); ?>"
            target="_blank"
        >
            View Evidence
        </a>
    </p>

<?php else: ?>

    <p>
        <strong>Evidence:</strong>
        No evidence file uploaded.
    </p>

<?php endif; ?>

        </div>

        <p>
            <a href="index.php?page=witness-reports">
                Back to My Reports
            </a>
        </p>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>