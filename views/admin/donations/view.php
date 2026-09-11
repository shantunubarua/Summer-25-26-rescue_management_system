<?php

require_once
    "views/partials/header.php";

require_once
    "views/partials/sidebar.php";

?>

<div class="content">

    <div class="page-header">

        <div>

            <h1>
                Donation Details
            </h1>

            <p>
                Review complete witness donation and transaction information.
            </p>

        </div>


        <div>

            <a
                href="index.php?page=admin-donations"
                class="btn"
            >
                Back to Donations
            </a>

        </div>

    </div>


    <div class="card">

        <h2>
            Donation Information
        </h2>


        <p>

            <strong>
                Donation ID:
            </strong>

            #<?= (int)$donation['id']; ?>

        </p>


        <p>

            <strong>
                Donation Type:
            </strong>

            <?= htmlspecialchars(
                ucfirst(
                    $donation['donation_type']
                    ?? 'N/A'
                )
            ); ?>

        </p>


        <p>

            <strong>
                Amount:
            </strong>

            <?= htmlspecialchars(
                number_format(
                    (float)(
                        $donation['amount']
                        ?? 0
                    ),
                    2
                )
            ); ?>

        </p>


        <p>

            <strong>
                Status:
            </strong>

            <span class="status-badge">

                <?= htmlspecialchars(
                    ucfirst(
                        $donation['status']
                        ?? 'N/A'
                    )
                ); ?>

            </span>

        </p>


        <p>

            <strong>
                Created At:
            </strong>

            <?php

            $createdAt =
                $donation['created_at']
                ?? '';


            echo $createdAt
                ? htmlspecialchars(
                    date(
                        'd M Y, h:i A',
                        strtotime(
                            $createdAt
                        )
                    )
                )
                : 'N/A';

            ?>

        </p>

    </div>


    <div class="card">

        <h2>
            Witness Information
        </h2>


        <p>

            <strong>
                Name:
            </strong>

            <?= htmlspecialchars(
                $donation['witness_name']
                ?? 'N/A'
            ); ?>

        </p>


        <p>

            <strong>
                Username:
            </strong>

            <?= htmlspecialchars(
                $donation['witness_username']
                ?? 'N/A'
            ); ?>

        </p>


        <p>

            <strong>
                Email:
            </strong>

            <?= htmlspecialchars(
                $donation['witness_email']
                ?? 'N/A'
            ); ?>

        </p>


        <p>

            <strong>
                Phone:
            </strong>

            <?= htmlspecialchars(
                $donation['witness_phone']
                ?? 'N/A'
            ); ?>

        </p>

    </div>


    <div class="card">

        <h2>
            Payment Information
        </h2>


        <p>

            <strong>
                Payment Method:
            </strong>

            <?= htmlspecialchars(
                ucfirst(
                    $donation['payment_method']
                    ?? 'N/A'
                )
            ); ?>

        </p>


        <p>

            <strong>
                Transaction ID:
            </strong>

            <?= htmlspecialchars(
                $donation['transaction_id']
                ?? 'N/A'
            ); ?>

        </p>

    </div>


    <div class="card">

        <h2>
            Donation Message
        </h2>


        <?php if (!empty($donation['message'])): ?>

            <p>

                <?= nl2br(
                    htmlspecialchars(
                        $donation['message']
                    )
                ); ?>

            </p>

        <?php else: ?>

            <p>
                No message was provided.
            </p>

        <?php endif; ?>

    </div>

</div>

<?php

require_once
    "views/partials/footer.php";

?>