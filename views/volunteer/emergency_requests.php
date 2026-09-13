<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

require_once
    "models/VolunteerModel.php";


$requests =
    getVolunteerEmergencyRequests(
        $conn
    );


$totalRequests =
    is_array($requests)
        ? count($requests)
        : 0;


$highPriority = 0;
$mediumPriority = 0;
$lowPriority = 0;


if (!empty($requests)) {

    foreach ($requests as $item) {

        $priority =
            strtolower(
                trim(
                    (string)(
                        $item['priority']
                        ?? ''
                    )
                )
            );


        if (
            $priority === 'high'
            || $priority === 'critical'
            || $priority === 'urgent'
        ) {
            $highPriority++;
        }


        if ($priority === 'medium') {
            $mediumPriority++;
        }


        if ($priority === 'low') {
            $lowPriority++;
        }
    }
}

?>

<div class="content">

    <div class="volunteer-emergency-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="volunteer-emergency-header">

            <div>

                <p class="eyebrow">
                    RESCUE RESPONSE
                </p>

                <h1>
                    Emergency Requests
                </h1>

                <p class="page-subtitle">
                    View pending emergency requests that
                    currently need volunteer assistance.
                </p>

            </div>


            <a
                href="index.php?page=volunteer-activities"
                class="secondary-action"
            >
                My Rescue Activities
            </a>

        </div>


        <!-- =========================================
             REQUEST SUMMARY
             ========================================= -->

        <div class="volunteer-emergency-stats">


            <article class="volunteer-emergency-stat">

                <span>
                    Available Requests
                </span>

                <strong>
                    <?= (int)$totalRequests; ?>
                </strong>

                <p>
                    Emergencies currently waiting
                    for volunteer assistance.
                </p>

            </article>


            <article class="volunteer-emergency-stat">

                <span>
                    High Priority
                </span>

                <strong>
                    <?= (int)$highPriority; ?>
                </strong>

                <p>
                    Requests requiring urgent attention.
                </p>

            </article>


            <article class="volunteer-emergency-stat">

                <span>
                    Medium Priority
                </span>

                <strong>
                    <?= (int)$mediumPriority; ?>
                </strong>

                <p>
                    Requests marked with medium priority.
                </p>

            </article>


            <article class="volunteer-emergency-stat">

                <span>
                    Low Priority
                </span>

                <strong>
                    <?= (int)$lowPriority; ?>
                </strong>

                <p>
                    Lower priority pending requests.
                </p>

            </article>

        </div>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="volunteer-emergency-list-heading">

            <div>

                <p>
                    ACTIVE EMERGENCIES
                </p>

                <h2>
                    Requests Needing Assistance
                </h2>

            </div>


            <span>

                <?= (int)$totalRequests; ?>

                request<?= $totalRequests === 1 ? '' : 's'; ?>

            </span>

        </div>


        <!-- =========================================
             EMPTY STATE
             ========================================= -->

        <?php if (empty($requests)): ?>

            <div class="volunteer-emergency-empty">

                <div class="volunteer-emergency-empty-mark">
                    ✓
                </div>

                <h3>
                    No Emergency Requests
                </h3>

                <p>
                    There are currently no pending emergency
                    requests requiring volunteer assistance.
                </p>

            </div>


        <?php else: ?>


            <!-- =====================================
                 REQUEST GRID
                 ===================================== -->

            <div class="volunteer-emergency-grid">


                <?php foreach ($requests as $request): ?>


                    <?php

                    $priority =
                        strtolower(
                            trim(
                                (string)(
                                    $request['priority']
                                    ?? 'normal'
                                )
                            )
                        );


                    $status =
                        strtolower(
                            trim(
                                (string)(
                                    $request['status']
                                    ?? 'pending'
                                )
                            )
                        );

                    ?>


                    <article class="volunteer-emergency-card">


                        <!-- =============================
                             CARD HEADER
                             ============================= -->

                        <div class="volunteer-emergency-card-header">

                            <div>

                                <span class="volunteer-emergency-request-id">

                                    Request #<?= (int)$request['id']; ?>

                                </span>


                                <h3>

                                    <?= htmlspecialchars(
                                        ucwords(
                                            str_replace(
                                                '_',
                                                ' ',
                                                $request[
                                                    'emergency_type'
                                                ]
                                                ?? ''
                                            )
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </h3>

                            </div>


                            <span
                                class="volunteer-emergency-priority volunteer-emergency-priority-<?= htmlspecialchars(
                                    $priority,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                            >

                                <?= htmlspecialchars(
                                    ucfirst(
                                        $request['priority']
                                        ?? 'Normal'
                                    ),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                                Priority

                            </span>

                        </div>


                        <!-- =============================
                             LOCATION
                             ============================= -->

                        <div class="volunteer-emergency-location">

                            <span>
                                LOCATION
                            </span>


                            <strong>

                                <?= htmlspecialchars(
                                    $request['location']
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </strong>

                        </div>


                        <!-- =============================
                             DESCRIPTION
                             ============================= -->

                        <div class="volunteer-emergency-description">

                            <span>
                                EMERGENCY DESCRIPTION
                            </span>


                            <p>

                                <?= nl2br(
                                    htmlspecialchars(
                                        $request['description']
                                        ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    )
                                ); ?>

                            </p>

                        </div>


                        <!-- =============================
                             DETAILS
                             ============================= -->

                        <div class="volunteer-emergency-details">


                            <!-- VICTIMS -->

                            <div class="volunteer-emergency-detail">

                                <span>
                                    Victim Count
                                </span>

                                <strong>
                                    <?= (int)(
                                        $request['victim_count']
                                        ?? 0
                                    ); ?>
                                </strong>

                            </div>


                            <!-- STATUS -->

                            <div class="volunteer-emergency-detail">

                                <span>
                                    Request Status
                                </span>

                                <strong
                                    class="volunteer-emergency-status volunteer-emergency-status-<?= htmlspecialchars(
                                        $status,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>"
                                >

                                    <?= htmlspecialchars(
                                        ucfirst(
                                            $request['status']
                                            ?? ''
                                        ),
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>

                                </strong>

                            </div>

                        </div>


                        <!-- =============================
                             CONTACT
                             ============================= -->

                        <div class="volunteer-emergency-contact">

                            <span>
                                CONTACT INFORMATION
                            </span>


                            <strong>

                                <?= htmlspecialchars(
                                    $request[
                                        'contact_information'
                                    ]
                                    ?? '',
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>

                            </strong>

                        </div>


                        <!-- =============================
                             ACTION
                             ============================= -->

                        <?php
                        if (
                            (
                                $request['status']
                                ?? ''
                            ) === 'pending'
                        ):
                        ?>

                            <div class="volunteer-emergency-action">

                                <form
                                    method="POST"
                                    action="index.php?page=volunteer-accept-request"
                                    class="volunteer-emergency-accept-form"
                                >

                                    <?= csrfField(); ?>


                                    <input
                                        type="hidden"
                                        name="request_id"
                                        value="<?= (int)$request['id']; ?>"
                                    >


                                    <button
                                        type="submit"
                                        class="volunteer-emergency-accept-button"
                                    >
                                        Accept Request
                                    </button>

                                </form>

                            </div>

                        <?php endif; ?>


                    </article>


                <?php endforeach; ?>


            </div>


        <?php endif; ?>

    </div>

</div>


<?php

require_once
    "views/partials/footer.php";

?>