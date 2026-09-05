<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Edit Rescue Report</h1>

    <p>
        Update rescue report status and description.
    </p>

    <?php if ($error !== ''): ?>

        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <form
        method="POST"
        action="index.php?page=rescue-report-edit&id=<?php echo (int)$report['id']; ?>"
    >

        <div>
            <label>Emergency Request ID</label>

            <input
                type="text"
                value="<?php echo (int)$report['emergency_request_id']; ?>"
                readonly
            >
        </div>

        <div>
            <label>Rescue Status</label>

            <select
                name="rescue_status"
                required
            >

                <option
                    value="pending"
                    <?php
                    echo $report['rescue_status'] === 'pending'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Pending
                </option>

                <option
                    value="ongoing"
                    <?php
                    echo $report['rescue_status'] === 'ongoing'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Ongoing
                </option>

                <option
                    value="completed"
                    <?php
                    echo $report['rescue_status'] === 'completed'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Completed
                </option>

                <option
                    value="cancelled"
                    <?php
                    echo $report['rescue_status'] === 'cancelled'
                        ? 'selected'
                        : '';
                    ?>
                >
                    Cancelled
                </option>

            </select>
        </div>

        <div>
            <label>Description</label>

            <textarea
                name="description"
                required
            ><?php
                echo htmlspecialchars(
                    $report['description']
                );
            ?></textarea>
        </div>

        <button type="submit">
            Save Changes
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>