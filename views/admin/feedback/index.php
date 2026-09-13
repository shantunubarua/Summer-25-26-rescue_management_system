<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$totalFeedback = is_array($feedback)
    ? count($feedback)
    : 0;

$pendingFeedback = 0;
$reviewedFeedback = 0;
$resolvedFeedback = 0;


if (!empty($feedback)) {

    foreach ($feedback as $item) {

        $itemStatus =
            strtolower(
                trim(
                    (string)(
                        $item['status']
                        ?? ''
                    )
                )
            );


        if ($itemStatus === 'pending') {
            $pendingFeedback++;
        }

        if ($itemStatus === 'reviewed') {
            $reviewedFeedback++;
        }

        if ($itemStatus === 'resolved') {
            $resolvedFeedback++;
        }
    }
}

?>

<div class="content">

    <div class="admin-feedback-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-feedback-header">

            <div>

                <p class="eyebrow">
                    USER RESPONSE MANAGEMENT
                </p>

                <h1>
                    Feedback Management
                </h1>

                <p class="page-subtitle">
                    Review feedback submitted by help seekers
                    after rescue activities and update its status.
                </p>

            </div>

        </div>


        <!-- =========================================
             ERROR
             ========================================= -->

        <?php if (!empty($error)): ?>

            <div class="admin-feedback-message admin-feedback-message-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             FEEDBACK SUMMARY
             ========================================= -->

        <div class="admin-feedback-stats">


            <!-- TOTAL -->

            <article class="admin-feedback-stat">

                <span class="admin-feedback-stat-label">
                    Total Feedback
                </span>

                <strong>
                    <?= (int)$totalFeedback; ?>
                </strong>

                <p>
                    All feedback submitted by help seekers.
                </p>

            </article>


            <!-- PENDING -->

            <article class="admin-feedback-stat">

                <span class="admin-feedback-stat-label">
                    Pending Review
                </span>

                <strong>
                    <?= (int)$pendingFeedback; ?>
                </strong>

                <p>
                    Feedback waiting for admin review.
                </p>

            </article>


            <!-- REVIEWED -->

            <article class="admin-feedback-stat">

                <span class="admin-feedback-stat-label">
                    Reviewed
                </span>

                <strong>
                    <?= (int)$reviewedFeedback; ?>
                </strong>

                <p>
                    Feedback already reviewed by admin.
                </p>

            </article>


            <!-- RESOLVED -->

            <article class="admin-feedback-stat">

                <span class="admin-feedback-stat-label">
                    Resolved
                </span>

                <strong>
                    <?= (int)$resolvedFeedback; ?>
                </strong>

                <p>
                    Feedback marked as fully resolved.
                </p>

            </article>

        </div>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="admin-feedback-list-heading">

            <div>

                <p>
                    FEEDBACK RECORDS
                </p>

                <h2>
                    Submitted Feedback
                </h2>

            </div>


            <span>
                <?= (int)$totalFeedback; ?>
                record<?= $totalFeedback === 1 ? '' : 's'; ?>
            </span>

        </div>


        <!-- =========================================
             EMPTY STATE
             ========================================= -->

        <?php if (empty($feedback)): ?>

            <div class="admin-feedback-empty">

                <div class="admin-feedback-empty-icon">
                    FB
                </div>

                <h3>
                    No Feedback Submitted
                </h3>

                <p>
                    Help seeker feedback will appear here
                    after it is submitted.
                </p>

            </div>


        <?php else: ?>


            <!-- =====================================
                 TABLE
                 ===================================== -->

            <div class="admin-feedback-table-card">

                <div class="admin-feedback-table-wrap">

                    <table class="admin-feedback-table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Help Seeker
                                </th>

                                <th>
                                    Rescue Request
                                </th>

                                <th>
                                    Feedback Message
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Submitted At
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($feedback as $item): ?>


                                <?php

                                $status =
                                    strtolower(
                                        trim(
                                            (string)(
                                                $item['status']
                                                ?? 'pending'
                                            )
                                        )
                                    );

                                ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <span class="admin-feedback-id">

                                            #<?= (int)$item['id']; ?>

                                        </span>

                                    </td>


                                    <!-- HELP SEEKER -->

                                    <td>

                                        <div class="admin-feedback-user">

                                            <div class="admin-feedback-user-avatar">

                                                <?= htmlspecialchars(
                                                    strtoupper(
                                                        substr(
                                                            trim(
                                                                $item[
                                                                    'help_seeker_name'
                                                                ]
                                                                ?? 'H'
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
                                                    $item['help_seeker_name']
                                                    ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </strong>

                                        </div>

                                    </td>


                                    <!-- REQUEST ID -->

                                    <td>

                                        <?php if (
                                            $item['rescue_request_id']
                                            !== null
                                        ): ?>

                                            <span class="admin-feedback-request-id">

                                                #<?= (int)$item[
                                                    'rescue_request_id'
                                                ]; ?>

                                            </span>

                                        <?php else: ?>

                                            <span class="admin-feedback-na">
                                                N/A
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- MESSAGE -->

                                    <td>

                                        <div class="admin-feedback-text">

                                            <?= nl2br(
                                                htmlspecialchars(
                                                    $item['message']
                                                    ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                            ); ?>

                                        </div>

                                    </td>


                                    <!-- STATUS UPDATE -->

                                    <td>

                                        <form
                                            method="POST"
                                            action="index.php?page=feedback"
                                            class="admin-feedback-status-form"
                                        >

                                            <?php echo csrfField(); ?>


                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int)$item['id']; ?>"
                                            >


                                            <select
                                                name="status"
                                                class="admin-feedback-status-select admin-feedback-status-select-<?= htmlspecialchars(
                                                    $status,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
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
                                                    value="reviewed"
                                                    <?= $status === 'reviewed'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Reviewed
                                                </option>


                                                <option
                                                    value="resolved"
                                                    <?= $status === 'resolved'
                                                        ? 'selected'
                                                        : ''; ?>
                                                >
                                                    Resolved
                                                </option>

                                            </select>


                                            <button
                                                type="submit"
                                                class="admin-feedback-update-button"
                                            >
                                                Update
                                            </button>

                                        </form>

                                    </td>


                                    <!-- CREATED -->

                                    <td>

                                        <span class="admin-feedback-date">

                                            <?= htmlspecialchars(
                                                $item['created_at']
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- DELETE -->

                                    <td>

                                        <form
                                            method="POST"
                                            action="index.php?page=feedback-delete"
                                            class="admin-feedback-delete-form"
                                            onsubmit="return confirm('Are you sure you want to delete this feedback?');"
                                        >

                                            <?php echo csrfField(); ?>


                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int)$item['id']; ?>"
                                            >


                                            <button
                                                type="submit"
                                                class="admin-feedback-delete-button"
                                            >
                                                Delete
                                            </button>

                                        </form>

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