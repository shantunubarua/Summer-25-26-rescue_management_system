<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";

$initialCount =
    is_array($requests)
    ? count($requests)
    : 0;

?>

<div class="content">

    <div class="helpseeker-requests-page">


        <!-- PAGE HEADER -->

        <div class="helpseeker-requests-header">

            <div>

                <p class="eyebrow">
                    REQUEST MANAGEMENT
                </p>

                <h1>
                    My Emergency Requests
                </h1>

                <p class="page-subtitle">
                    Search and review the rescue requests you have submitted
                    and check their current progress.
                </p>

            </div>


            <div class="helpseeker-requests-header-actions">

                <a
                    href="index.php?page=helpseeker-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

                <a
                    href="index.php?page=helpseeker-request-create"
                    class="primary-action"
                >
                    + New Request
                </a>

            </div>

        </div>


        <!-- SEARCH AREA -->

        <div class="helpseeker-request-search-card">

            <div class="helpseeker-request-search-area">

                <label for="helpSeekerRequestSearch">
                    Search Requests
                </label>

                <input
                    type="search"
                    id="helpSeekerRequestSearch"
                    placeholder="Search by emergency type, location, priority or status..."
                    autocomplete="off"
                >

            </div>


            <div
                class="helpseeker-request-count"
                id="helpSeekerSearchMessage"
            >

                <span>
                    Showing
                </span>

                <strong id="helpSeekerRequestCount">
                    <?= (int)$initialCount; ?>
                </strong>

                <span>
                    request(s)
                </span>

            </div>

        </div>


        <!-- REQUEST HISTORY -->

        <div class="helpseeker-request-history-header">

            <div>

                <p class="helpseeker-request-history-label">
                    REQUEST HISTORY
                </p>

                <h2>
                    Submitted Requests
                </h2>

            </div>


            <span class="helpseeker-request-total">
                <?= (int)$initialCount; ?> total
            </span>

        </div>


        <!-- REQUEST LIST -->

        <div
            id="helpSeekerRequestList"
            class="helpseeker-request-list"
        >

            <?php if (empty($requests)): ?>


                <div class="card">

                    <h3>
                        No Emergency Requests Yet
                    </h3>

                    <p>
                        You have not submitted any rescue requests yet.
                    </p>

                    <p>
                        <a href="index.php?page=helpseeker-request-create">
                            Create Emergency Request
                        </a>
                    </p>

                </div>


            <?php else: ?>


                <?php foreach ($requests as $request): ?>


                    <?php

                    $status =
                        strtolower(
                            $request['status']
                            ?? 'pending'
                        );

                    $statusText =
                        ucfirst($status);

                    $statusClass =
                        'status-pending';


                    if ($status === 'assigned') {

                        $statusClass =
                            'status-assigned';

                    } elseif ($status === 'ongoing') {

                        $statusClass =
                            'status-ongoing';

                    } elseif ($status === 'completed') {

                        $statusClass =
                            'status-completed';

                    } elseif ($status === 'cancelled') {

                        $statusClass =
                            'status-cancelled';
                    }

                    ?>


                    <div class="card">


                        <!-- EMERGENCY TYPE -->

                        <h3>

                            <?= htmlspecialchars(
                                ucfirst(
                                    $request['emergency_type']
                                    ?? ''
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </h3>


                        <!-- REQUEST ID -->

                        <p>

                            <strong>
                                Request ID:
                            </strong>

                            #<?= (int)$request['id']; ?>

                        </p>


                        <!-- LOCATION -->

                        <p>

                            <strong>
                                Location:
                            </strong>

                            <?= htmlspecialchars(
                                $request['location']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- DESCRIPTION -->

                        <p>

                            <strong>
                                Description:
                            </strong>

                            <?= htmlspecialchars(
                                $request['description']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- PRIORITY -->

                        <p>

                            <strong>
                                Priority:
                            </strong>

                            <?= htmlspecialchars(
                                ucfirst(
                                    $request['priority']
                                    ?? ''
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- VICTIM TYPE -->

                        <p>

                            <strong>
                                Victim Type:
                            </strong>

                            <?= htmlspecialchars(
                                ucfirst(
                                    $request['victim_type']
                                    ?? ''
                                ),
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- VICTIM INFORMATION -->

                        <?php if (
                            !empty(
                                $request['victim_information']
                            )
                        ): ?>

                            <p>

                                <strong>
                                    Victim Information:
                                </strong>

                                <?= htmlspecialchars(
                                    $request[
                                        'victim_information'
                                    ],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </p>

                        <?php endif; ?>


                        <!-- VICTIM COUNT -->

                        <p>

                            <strong>
                                Victim Count:
                            </strong>

                            <?= (int)(
                                $request['victim_count']
                                ?? 0
                            ); ?>

                        </p>


                        <!-- CONTACT -->

                        <p>

                            <strong>
                                Contact Information:
                            </strong>

                            <?= htmlspecialchars(
                                $request[
                                    'contact_information'
                                ]
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- STATUS -->

                        <p>

                            <strong>
                                Status:
                            </strong>

                            <span class="<?= $statusClass; ?>">

                                <?= htmlspecialchars(
                                    $statusText,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </span>

                        </p>


                        <!-- ACCEPTED DATE -->

                        <?php if (
                            !empty(
                                $request['accepted_at']
                            )
                        ): ?>

                            <p>

                                <strong>
                                    Accepted At:
                                </strong>

                                <?= htmlspecialchars(
                                    $request['accepted_at'],
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </p>

                        <?php endif; ?>


                        <!-- CREATED DATE -->

                        <p>

                            <strong>
                                Created At:
                            </strong>

                            <?= htmlspecialchars(
                                $request['created_at']
                                ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>

                        </p>


                        <!-- VIEW -->

                        <p>

                            <a
                                href="index.php?page=helpseeker-request-view&id=<?= (int)$request['id']; ?>"
                            >
                                View Details
                            </a>

                        </p>


                        <!-- FEEDBACK -->

                        <?php if ($status === 'completed'): ?>

                            <p>

                                <a
                                    href="index.php?page=helpseeker-feedback&id=<?= (int)$request['id']; ?>"
                                >
                                    Give Feedback
                                </a>

                            </p>

                        <?php endif; ?>


                    </div>


                <?php endforeach; ?>


            <?php endif; ?>

        </div>

    </div>

</div>


<script src="assets/js/helpseeker.js?v=1"></script>


<?php
require_once "views/partials/footer.php";
?>