<?php
require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$selectedRequestId =
    (int)($_POST['emergency_request_id'] ?? 0);

$selectedStatus =
    $_POST['rescue_status'] ?? 'pending';

$description =
    $_POST['description'] ?? '';
?>

<div class="content">

    <div class="page-header">
        <div>
            <h1>Create Rescue Report</h1>
            <p>
                Create an official rescue report for a valid emergency request.
            </p>
        </div>
    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>


    <div class="card">

        <?php if (empty($emergencyRequests)): ?>

            <p>
                No emergency requests are currently available.
            </p>

            <a
                href="index.php?page=rescue-reports"
                class="btn"
            >
                Back to Rescue Reports
            </a>

        <?php else: ?>

            <form
                method="POST"
                action="index.php?page=rescue-report-create"
            >
            <?php echo csrfField(); ?>

                <!-- EMERGENCY REQUEST -->

                <div class="form-group">

                    <label for="emergency_request_id">
                        Emergency Request
                    </label>

                    <select
                        name="emergency_request_id"
                        id="emergency_request_id"
                        required
                    >

                        <option value="">
                            Select an Emergency Request
                        </option>

                        <?php foreach ($emergencyRequests as $request): ?>

                            <option
                                value="<?= (int)$request['id']; ?>"
                                <?= $selectedRequestId === (int)$request['id']
                                    ? 'selected'
                                    : ''; ?>
                            >
                                #<?= (int)$request['id']; ?>
                                -
                                <?= htmlspecialchars(
                                    ucfirst(
                                        $request['emergency_type']
                                        ?? 'Emergency'
                                    )
                                ); ?>

                                |
                                <?= htmlspecialchars(
                                    $request['location']
                                    ?? 'Unknown Location'
                                ); ?>

                                |
                                Priority:
                                <?= htmlspecialchars(
                                    ucfirst(
                                        $request['priority']
                                        ?? 'N/A'
                                    )
                                ); ?>

                                |
                                Status:
                                <?= htmlspecialchars(
                                    ucfirst(
                                        $request['status']
                                        ?? 'N/A'
                                    )
                                ); ?>

                                |
                                Help Seeker:
                                <?= htmlspecialchars(
                                    $request['help_seeker_name']
                                    ?? 'N/A'
                                ); ?>
                            </option>

                        <?php endforeach; ?>

                    </select>

                    <small>
                        Only emergency requests stored in the system can be selected.
                    </small>

                </div>


                <!-- RESCUE STATUS -->

                <div class="form-group">

                    <label for="rescue_status">
                        Rescue Status
                    </label>

                    <select
                        name="rescue_status"
                        id="rescue_status"
                        required
                    >

                        <option
                            value="pending"
                            <?= $selectedStatus === 'pending'
                                ? 'selected'
                                : ''; ?>
                        >
                            Pending
                        </option>

                        <option
                            value="ongoing"
                            <?= $selectedStatus === 'ongoing'
                                ? 'selected'
                                : ''; ?>
                        >
                            Ongoing
                        </option>

                        <option
                            value="completed"
                            <?= $selectedStatus === 'completed'
                                ? 'selected'
                                : ''; ?>
                        >
                            Completed
                        </option>

                        <option
                            value="cancelled"
                            <?= $selectedStatus === 'cancelled'
                                ? 'selected'
                                : ''; ?>
                        >
                            Cancelled
                        </option>

                    </select>

                </div>


                <!-- DESCRIPTION -->

                <div class="form-group">

                    <label for="description">
                        Rescue Report Description
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="6"
                        required
                        placeholder="Describe the rescue operation, actions taken and important observations..."
                    ><?= htmlspecialchars($description); ?></textarea>

                </div>


                <div class="form-actions">

                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Create Rescue Report
                    </button>

                    <a
                        href="index.php?page=rescue-reports"
                        class="btn"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        <?php endif; ?>

    </div>

</div>

<?php
require_once "views/partials/footer.php";
?>