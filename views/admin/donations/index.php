<?php

require_once "views/partials/header.php";
require_once "views/partials/sidebar.php";


$search =
    $search
    ?? '';


$totalDonations =
    is_array($donations)
    ? count($donations)
    : 0;


$totalAmount = 0;
$completedDonations = 0;
$uniqueWitnesses = [];


if (!empty($donations)) {

    foreach ($donations as $donation) {

        $totalAmount +=
            (float)(
                $donation['amount']
                ?? 0
            );


        if (
            strtolower(
                $donation['status']
                ?? ''
            ) === 'completed'
        ) {
            $completedDonations++;
        }


        if (!empty($donation['witness_id'])) {

            $uniqueWitnesses[
                (int)$donation['witness_id']
            ] = true;
        }
    }
}


$totalWitnesses =
    count($uniqueWitnesses);

?>

<div class="content">

    <div class="admin-donations-page">


        <!-- =========================================
             PAGE HEADER
             ========================================= -->

        <div class="admin-donations-header">

            <div>

                <p class="eyebrow">
                    DONATION MONITORING
                </p>

                <h1>
                    Donations
                </h1>

                <p class="page-subtitle">
                    Monitor donations submitted by witnesses,
                    review transaction information and search
                    donation records.
                </p>

            </div>

        </div>


        <!-- =========================================
             ERROR
             ========================================= -->

        <?php if (!empty($error)): ?>

            <div class="admin-donations-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- =========================================
             SUMMARY
             ========================================= -->

        <div class="admin-donation-stats">


            <!-- RECORDS -->

            <article class="admin-donation-stat">

                <span>
                    Displayed Records
                </span>

                <strong>
                    <?= (int)$totalDonations; ?>
                </strong>

                <p>
                    Donation records in the current result.
                </p>

            </article>


            <!-- WITNESSES -->

            <article class="admin-donation-stat">

                <span>
                    Witness Donors
                </span>

                <strong>
                    <?= (int)$totalWitnesses; ?>
                </strong>

                <p>
                    Unique witnesses in the current result.
                </p>

            </article>


            <!-- COMPLETED -->

            <article class="admin-donation-stat">

                <span>
                    Completed
                </span>

                <strong>
                    <?= (int)$completedDonations; ?>
                </strong>

                <p>
                    Completed donation transactions.
                </p>

            </article>


            <!-- AMOUNT -->

            <article class="admin-donation-stat">

                <span>
                    Recorded Amount
                </span>

                <strong class="admin-donation-stat-amount">

                    <?= htmlspecialchars(
                        number_format(
                            $totalAmount,
                            2
                        ),
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>

                </strong>

                <p>
                    Combined amount in displayed records.
                </p>

            </article>

        </div>


        <!-- =========================================
             SEARCH
             ========================================= -->

        <section class="admin-donation-search-card">


            <div class="admin-donation-search-header">

                <div>

                    <p>
                        DONATION DIRECTORY
                    </p>

                    <h2>
                        Search Donations
                    </h2>

                </div>


                <span class="admin-donation-result-count">

                    <?= (int)$totalDonations; ?>

                    result<?= $totalDonations === 1 ? '' : 's'; ?>

                </span>

            </div>


            <form
                method="GET"
                action="index.php"
                class="admin-donation-search-form"
            >

                <input
                    type="hidden"
                    name="page"
                    value="admin-donations"
                >


                <div class="admin-donation-search-field">

                    <label for="search">
                        Search Donation Records
                    </label>


                    <div class="admin-donation-search-row">

                        <input
                            type="text"
                            id="search"
                            name="search"
                            maxlength="100"
                            value="<?= htmlspecialchars(
                                $search,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                            placeholder="Search witness, email, transaction ID, type, payment method or status"
                        >


                        <button
                            type="submit"
                            class="admin-donation-search-button"
                        >
                            Search
                        </button>


                        <?php if ($search !== ''): ?>

                            <a
                                href="index.php?page=admin-donations"
                                class="admin-donation-clear-button"
                            >
                                Clear
                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </form>


            <?php if ($search !== ''): ?>

                <div class="admin-donation-active-search">

                    <span>
                        Search results for:
                    </span>

                    <strong>
                        <?= htmlspecialchars(
                            $search,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?>
                    </strong>

                </div>

            <?php endif; ?>

        </section>


        <!-- =========================================
             LIST HEADING
             ========================================= -->

        <div class="admin-donation-list-heading">

            <div>

                <p>
                    DONATION RECORDS
                </p>

                <h2>
                    Witness Donations
                </h2>

            </div>


            <span>

                <?= (int)$totalDonations; ?>

                donation<?= $totalDonations === 1 ? '' : 's'; ?>

            </span>

        </div>


        <!-- =========================================
             EMPTY
             ========================================= -->

        <?php if (empty($donations)): ?>

            <div class="admin-donation-empty">

                <div class="admin-donation-empty-icon">
                    DN
                </div>


                <h3>
                    No Donation Records Found
                </h3>


                <?php if ($search !== ''): ?>

                    <p>
                        No donations matched your current search.
                        Try using another keyword.
                    </p>

                    <a
                        href="index.php?page=admin-donations"
                        class="secondary-action"
                    >
                        Clear Search
                    </a>

                <?php else: ?>

                    <p>
                        Donations submitted by witnesses
                        will appear here.
                    </p>

                <?php endif; ?>

            </div>


        <?php else: ?>


            <!-- =====================================
                 TABLE
                 ===================================== -->

            <div class="admin-donation-table-card">

                <div class="admin-donation-table-wrap">

                    <table class="admin-donation-table">

                        <thead>

                            <tr>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Witness
                                </th>

                                <th>
                                    Donation Type
                                </th>

                                <th>
                                    Amount
                                </th>

                                <th>
                                    Payment Method
                                </th>

                                <th>
                                    Transaction ID
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Date
                                </th>

                                <th>
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                            <?php foreach ($donations as $donation): ?>


                                <?php

                                $status =
                                    strtolower(
                                        trim(
                                            (string)(
                                                $donation['status']
                                                ?? 'completed'
                                            )
                                        )
                                    );


                                $donationType =
                                    strtolower(
                                        trim(
                                            (string)(
                                                $donation['donation_type']
                                                ?? 'other'
                                            )
                                        )
                                    );


                                $createdAt =
                                    $donation['created_at']
                                    ?? '';


                                $witnessName =
                                    $donation['witness_name']
                                    ?? 'N/A';

                                ?>


                                <tr>


                                    <!-- ID -->

                                    <td>

                                        <span class="admin-donation-id">

                                            #<?= (int)$donation['id']; ?>

                                        </span>

                                    </td>


                                    <!-- WITNESS -->

                                    <td>

                                        <div class="admin-donation-witness">


                                            <div class="admin-donation-avatar">

                                                <?= htmlspecialchars(
                                                    strtoupper(
                                                        substr(
                                                            trim(
                                                                $witnessName
                                                            ),
                                                            0,
                                                            1
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </div>


                                            <div class="admin-donation-witness-info">

                                                <strong>

                                                    <?= htmlspecialchars(
                                                        $witnessName,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>

                                                </strong>


                                                <span>

                                                    <?= htmlspecialchars(
                                                        $donation[
                                                            'witness_email'
                                                        ]
                                                        ?? '',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>

                                                </span>

                                            </div>

                                        </div>

                                    </td>


                                    <!-- TYPE -->

                                    <td>

                                        <span
                                            class="admin-donation-type admin-donation-type-<?= htmlspecialchars(
                                                $donationType,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $donation[
                                                        'donation_type'
                                                    ]
                                                    ?? 'N/A'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- AMOUNT -->

                                    <td>

                                        <strong class="admin-donation-amount">

                                            <?= htmlspecialchars(
                                                number_format(
                                                    (float)(
                                                        $donation['amount']
                                                        ?? 0
                                                    ),
                                                    2
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </strong>

                                    </td>


                                    <!-- PAYMENT -->

                                    <td>

                                        <span class="admin-donation-payment">

                                            <?= htmlspecialchars(
                                                ucwords(
                                                    str_replace(
                                                        '_',
                                                        ' ',
                                                        $donation[
                                                            'payment_method'
                                                        ]
                                                        ?? 'N/A'
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- TRANSACTION -->

                                    <td>

                                        <span class="admin-donation-transaction">

                                            <?= htmlspecialchars(
                                                $donation[
                                                    'transaction_id'
                                                ]
                                                ?? 'N/A',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="admin-donation-status admin-donation-status-<?= htmlspecialchars(
                                                $status,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $donation['status']
                                                    ?? 'N/A'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- DATE -->

                                    <td>

                                        <span class="admin-donation-date">

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


                                    <!-- VIEW -->

                                    <td>

                                        <a
                                            href="index.php?page=admin-donation-view&id=<?= (int)$donation['id']; ?>"
                                            class="admin-donation-view-button"
                                        >
                                            View
                                        </a>

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