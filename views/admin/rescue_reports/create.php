<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Create Rescue Report</h1>

    <p>
        Create a rescue report for an emergency request.
    </p>

    <?php if (!empty($error)): ?>

        <p class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>

    <form
        method="POST"
        action="index.php?page=rescue-report-create"
    >

        <div>

            <label>
                Emergency Request ID
            </label>

            <input
                type="number"
                name="emergency_request_id"
                min="1"
                required
            >

        </div>

        <div>

            <label>
                Rescue Status
            </label>

            <select
                name="rescue_status"
                required
            >

                <option value="">
                    Select Status
                </option>

                <option value="pending">
                    Pending
                </option>

                <option value="ongoing">
                    Ongoing
                </option>

                <option value="completed">
                    Completed
                </option>

                <option value="cancelled">
                    Cancelled
                </option>

            </select>

        </div>

        <div>

            <label>
                Description
            </label>

            <textarea
                name="description"
                required
            ></textarea>

        </div>

        <button type="submit">
            Create Report
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>