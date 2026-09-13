<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$totalRequests =
    is_array($requests)
    ? count($requests)
    : 0;


$pendingRequests = 0;
$approvedRequests = 0;
$rejectedRequests = 0;
$completedRequests = 0;


if (!empty($requests)) {

    foreach ($requests as $request) {

        $requestStatus =
            strtolower(
                trim(
                    (string)(
                        $request['status']
                        ?? 'pending'
                    )
                )
            );


        if ($requestStatus === 'pending') {
            $pendingRequests++;
        }

        if ($requestStatus === 'approved') {
            $approvedRequests++;
        }

        if ($requestStatus === 'rejected') {
            $rejectedRequests++;
        }

        if ($requestStatus === 'completed') {
            $completedRequests++;
        }
    }
}

?>

<div class="content">

    <div class="admin-resource-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-resource-header">

            <div>

                <p class="eyebrow">
                    RESOURCE MANAGEMENT
                </p>

                <h1>
                    Volunteer Resource Requests
                </h1>

                <p class="page-subtitle">
                    Review resource requests submitted by volunteers
                    and monitor their current request status.
                </p>

            </div>

        </div>


        <!-- =========================================
             SUMMARY
             ========================================= -->

        <div class="admin-resource-stats">


            <article class="admin-resource-stat">

                <span>
                    Total Requests
                </span>

                <strong>
                    <?= (int)$totalRequests; ?>
                </strong>

                <p>
                    All volunteer resource requests.
                </p>

            </article>


            <article class="admin-resource-stat">

                <span>
                    Pending
                </span>

                <strong>
                    <?= (int)$pendingRequests; ?>
                </strong>

                <p>
                    Requests waiting for review.
                </p>

            </article>


            <article class="admin-resource-stat">

                <span>
                    Approved
                </span>

                <strong>
                    <?= (int)$approvedRequests; ?>
                </strong>

                <p>
                    Resource requests approved by admin.
                </p>

            </article>


            <article class="admin-resource-stat">

                <span>
                    Rejected
                </span>

                <strong>
                    <?= (int)$rejectedRequests; ?>
                </strong>

                <p>
                    Requests rejected after review.
                </p>

            </article>


            <article class="admin-resource-stat">

                <span>
                    Completed
                </span>

                <strong>
                    <?= (int)$completedRequests; ?>
                </strong>

                <p>
                    Resource requests already completed.
                </p>

            </article>

        </div>


        <!-- =========================================
             SEARCH
             ========================================= -->

        <section class="admin-resource-search-card">


            <div class="admin-resource-search-header">

                <div>

                    <p>
                        RESOURCE DIRECTORY
                    </p>

                    <h2>
                        Search Requests
                    </h2>

                </div>


                <div
                    id="resourceSearchMessage"
                    class="admin-resource-search-message"
                >
                    <?= (int)$totalRequests; ?>
                    request(s) found
                </div>

            </div>


            <div class="admin-resource-search-field">

                <label for="resourceRequestSearch">
                    Search Resource Requests
                </label>


                <input
                    type="text"
                    id="resourceRequestSearch"
                    placeholder="Search volunteer, resource, status or description..."
                    autocomplete="off"
                >

            </div>

        </section>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="admin-resource-list-heading">

            <div>

                <p>
                    REQUEST RECORDS
                </p>

                <h2>
                    Resource Requests
                </h2>

            </div>


            <span>
                <?= (int)$totalRequests; ?>
                request<?= $totalRequests === 1 ? '' : 's'; ?>
            </span>

        </div>


        <!-- =========================================
             TABLE
             ========================================= -->

        <div class="admin-resource-table-card">

            <div class="admin-resource-table-wrap">

                <table class="admin-resource-table">

                    <thead>

                        <tr>

                            <th>
                                ID
                            </th>

                            <th>
                                Volunteer
                            </th>

                            <th>
                                Resource
                            </th>

                            <th>
                                Quantity
                            </th>

                            <th>
                                Availability
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Requested At
                            </th>

                            <th>
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="resourceRequestTableBody">


                        <?php if (empty($requests)): ?>

                            <tr>

                                <td
                                    colspan="8"
                                    class="admin-resource-empty-cell"
                                >

                                    <div class="admin-resource-empty">

                                        <div class="admin-resource-empty-icon">
                                            RQ
                                        </div>

                                        <strong>
                                            No Resource Requests Found
                                        </strong>

                                        <p>
                                            Resource requests submitted
                                            by volunteers will appear here.
                                        </p>

                                    </div>

                                </td>

                            </tr>


                        <?php else: ?>


                            <?php foreach ($requests as $request): ?>


                                <?php

                                $status =
                                    strtolower(
                                        trim(
                                            (string)(
                                                $request['status']
                                                ?? 'pending'
                                            )
                                        )
                                    );


                                $availability =
                                    strtolower(
                                        trim(
                                            (string)(
                                                $request[
                                                    'availability_status'
                                                ]
                                                ?? 'unavailable'
                                            )
                                        )
                                    );


                                $createdAt =
                                    $request['created_at']
                                    ?? '';

                                ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <span class="admin-resource-id">

                                            #<?= (int)$request['id']; ?>

                                        </span>

                                    </td>


                                    <!-- VOLUNTEER -->

                                    <td>

                                        <div class="admin-resource-volunteer">

                                            <div class="admin-resource-avatar">

                                                <?= htmlspecialchars(
                                                    strtoupper(
                                                        substr(
                                                            trim(
                                                                $request[
                                                                    'volunteer_name'
                                                                ]
                                                                ?? 'V'
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
                                                    $request[
                                                        'volunteer_name'
                                                    ]
                                                    ?? 'N/A',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </strong>

                                        </div>

                                    </td>


                                    <!-- RESOURCE -->

                                    <td>

                                        <strong class="admin-resource-type">

                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $request[
                                                            'resource_type'
                                                        ]
                                                        ?? 'N/A'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </strong>

                                    </td>


                                    <!-- QUANTITY -->

                                    <td>

                                        <span class="admin-resource-quantity">

                                            <?= (int)(
                                                $request['quantity']
                                                ?? 0
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- AVAILABILITY -->

                                    <td>

                                        <span
                                            class="admin-resource-availability admin-resource-availability-<?= htmlspecialchars(
                                                $availability,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $request[
                                                            'availability_status'
                                                        ]
                                                        ?? 'N/A'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="status-badge admin-resource-status admin-resource-status-<?= htmlspecialchars(
                                                $status,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $request['status']
                                                    ?? 'pending'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- DATE -->

                                    <td>

                                        <span class="admin-resource-date">

                                            <?php

                                            echo $createdAt
                                                ? htmlspecialchars(
                                                    date(
                                                        'd M Y, h:i A',
                                                        strtotime(
                                                            $createdAt
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                )
                                                : 'N/A';

                                            ?>

                                        </span>

                                    </td>


                                    <!-- REVIEW -->

                                    <td>

                                        <a
                                            class="btn btn-primary admin-resource-review"
                                            href="index.php?page=admin-resource-request-view&id=<?= (int)$request['id']; ?>"
                                        >
                                            Review
                                        </a>

                                    </td>

                                </tr>


                            <?php endforeach; ?>


                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


<?php
require_once "views/partials/footer.php";
?>