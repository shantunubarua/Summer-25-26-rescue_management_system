<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<?php

$totalDonations = 0;
$completedDonations = 0;
$totalAmount = 0;

if (!empty($donations) && is_array($donations)) {

    $totalDonations =
        count($donations);

    foreach ($donations as $donation) {

        $status =
            strtolower(
                $donation['status']
                ?? 'pending'
            );

        if ($status === 'completed') {

            $completedDonations++;

            $totalAmount +=
                (float)(
                    $donation['amount']
                    ?? 0
                );
        }
    }
}

$paymentNames = [
    'card' => 'Credit Card',
    'bkash' => 'bKash',
    'nagad' => 'Nagad',
    'bank' => 'Bank Transfer',
    'cash' => 'Cash'
];

?>

<div class="content">

    <div class="witness-donations-page">


        <!-- ================================
             PAGE HEADER
        ================================= -->

        <div class="witness-page-header">

            <div>

                <p class="eyebrow">
                    CONTRIBUTION HISTORY
                </p>

                <h1>
                    My Donations
                </h1>

                <p class="page-subtitle">
                    Review your submitted donations,
                    payment information and transaction history.
                </p>

            </div>


            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=witness-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

                <a
                    href="index.php?page=donation-create"
                    class="primary-action"
                >
                    + Make Donation
                </a>

            </div>

        </div>


        <!-- ================================
             SUMMARY CARDS
        ================================= -->

        <div class="witness-donation-summary-grid">


            <div class="witness-donation-summary-card">

                <span>
                    Total Donations
                </span>

                <strong>
                    <?= (int)$totalDonations; ?>
                </strong>

                <small>
                    All submitted donations
                </small>

            </div>


            <div class="witness-donation-summary-card">

                <span>
                    Completed
                </span>

                <strong>
                    <?= (int)$completedDonations; ?>
                </strong>

                <small>
                    Successfully completed
                </small>

            </div>


            <div class="witness-donation-summary-card">

                <span>
                    Total Donated
                </span>

                <strong class="witness-donation-summary-money">
                    ৳<?= number_format(
                        $totalAmount,
                        2
                    ); ?>
                </strong>

                <small>
                    Completed contribution amount
                </small>

            </div>

        </div>


        <!-- ================================
             DONATION HISTORY
        ================================= -->

        <div class="witness-donation-table-card">

            <div class="witness-table-card-header">

                <div>

                    <span>
                        DONATION HISTORY
                    </span>

                    <h2>
                        Submitted Donations
                    </h2>

                </div>

                <small>
                    <?= (int)$totalDonations; ?>
                    record(s)
                </small>

            </div>


            <?php if (empty($donations)): ?>

                <div class="witness-donation-empty">

                    <div class="witness-donation-empty-icon">
                        D
                    </div>

                    <h3>
                        No Donations Yet
                    </h3>

                    <p>
                        You have not submitted any donations yet.
                        Your donation history will appear here.
                    </p>

                    <a
                        href="index.php?page=donation-create"
                        class="primary-action"
                    >
                        Make Your First Donation
                    </a>

                </div>

            <?php else: ?>


                <div class="witness-donation-table-responsive">

                    <table class="witness-donation-table">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Donation Type</th>
                                <th>Payment Method</th>
                                <th>Transaction ID</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Created At</th>
                            </tr>

                        </thead>


                        <tbody>

                            <?php foreach (
                                $donations
                                as $donation
                            ): ?>

                                <?php

                                $status =
                                    strtolower(
                                        $donation['status']
                                        ?? 'pending'
                                    );

                                $paymentMethod =
                                    strtolower(
                                        $donation[
                                            'payment_method'
                                        ]
                                        ?? ''
                                    );

                                $paymentLabel =
                                    $paymentNames[
                                        $paymentMethod
                                    ]
                                    ?? ucfirst(
                                        $paymentMethod
                                    );

                                ?>

                                <tr>


                                    <!-- ID -->

                                    <td class="witness-donation-id">

                                        #<?= (int)$donation['id']; ?>

                                    </td>


                                    <!-- AMOUNT -->

                                    <td>

                                        <strong class="witness-donation-table-amount">

                                            ৳<?= number_format(
                                                (float)(
                                                    $donation[
                                                        'amount'
                                                    ]
                                                    ?? 0
                                                ),
                                                2
                                            ); ?>

                                        </strong>

                                    </td>


                                    <!-- TYPE -->

                                    <td>

                                        <?= htmlspecialchars(
                                            ucfirst(
                                                $donation[
                                                    'donation_type'
                                                ]
                                                ?? ''
                                            ),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>

                                    </td>


                                    <!-- PAYMENT -->

                                    <td>

                                        <span class="witness-payment-badge">

                                            <?= htmlspecialchars(
                                                $paymentLabel,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- TRANSACTION -->

                                    <td>

                                        <span class="witness-transaction-code">

                                            <?= htmlspecialchars(
                                                $donation[
                                                    'transaction_id'
                                                ]
                                                ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- MESSAGE -->

                                    <td class="witness-donation-message">

                                        <?php if (
                                            !empty(
                                                $donation[
                                                    'message'
                                                ]
                                            )
                                        ): ?>

                                            <?= htmlspecialchars(
                                                $donation[
                                                    'message'
                                                ],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        <?php else: ?>

                                            <span class="witness-muted-text">
                                                No message
                                            </span>

                                        <?php endif; ?>

                                    </td>


                                    <!-- STATUS -->

                                    <td>

                                        <span
                                            class="
                                                witness-donation-status
                                                witness-donation-<?= htmlspecialchars(
                                                    $status,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>
                                            "
                                        >

                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $status
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                        </span>

                                    </td>


                                    <!-- CREATED -->

                                    <td class="witness-donation-date">

                                        <?php if (
                                            !empty(
                                                $donation[
                                                    'created_at'
                                                ]
                                            )
                                        ): ?>

                                            <?= htmlspecialchars(
                                                date(
                                                    'd M Y',
                                                    strtotime(
                                                        $donation[
                                                            'created_at'
                                                        ]
                                                    )
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>

                                            <small>

                                                <?= htmlspecialchars(
                                                    date(
                                                        'h:i A',
                                                        strtotime(
                                                            $donation[
                                                                'created_at'
                                                            ]
                                                        )
                                                    ),
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </small>

                                        <?php else: ?>

                                            —

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>