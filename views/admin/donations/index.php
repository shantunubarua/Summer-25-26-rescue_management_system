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
                Donation Monitoring
            </h1>

            <p>
                View and monitor donations submitted by witnesses.
            </p>

        </div>

    </div>


    <?php if (!empty($error)): ?>

        <div class="alert alert-danger">

            <?= htmlspecialchars(
                $error
            ); ?>

        </div>

    <?php endif; ?>


    <div class="card">

        <form
            method="GET"
            action="index.php"
        >

            <input
                type="hidden"
                name="page"
                value="admin-donations"
            >


            <div class="form-group">

                <label for="search">
                    Search Donations
                </label>

                <input
                    type="text"
                    id="search"
                    name="search"
                    maxlength="100"
                    value="<?= htmlspecialchars(
                        $search
                    ); ?>"
                    placeholder="Witness, email, transaction ID, type, payment method or status"
                >

            </div>


            <button
                type="submit"
                class="btn btn-primary"
            >
                Search
            </button>


            <?php if ($search !== ''): ?>

                <a
                    href="index.php?page=admin-donations"
                    class="btn"
                >
                    Clear Search
                </a>

            <?php endif; ?>

        </form>

    </div>


    <div class="card">

        <h2>
            Donation Records
        </h2>


        <p>
            Total Results:
            <strong>
                <?= count($donations); ?>
            </strong>
        </p>


        <?php if (empty($donations)): ?>

            <p>
                No donation records found.
            </p>

        <?php else: ?>

            <div style="overflow-x: auto;">

                <table
                    border="1"
                    cellpadding="10"
                    cellspacing="0"
                    width="100%"
                >

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

                            <tr>

                                <td>

                                    #<?= (int)$donation['id']; ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $donation['witness_name']
                                        ?? 'N/A'
                                    ); ?>

                                    <br>

                                    <small>

                                        <?= htmlspecialchars(
                                            $donation['witness_email']
                                            ?? ''
                                        ); ?>

                                    </small>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        ucfirst(
                                            $donation['donation_type']
                                            ?? 'N/A'
                                        )
                                    ); ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        number_format(
                                            (float)(
                                                $donation['amount']
                                                ?? 0
                                            ),
                                            2
                                        )
                                    ); ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        ucfirst(
                                            $donation['payment_method']
                                            ?? 'N/A'
                                        )
                                    ); ?>

                                </td>


                                <td>

                                    <?= htmlspecialchars(
                                        $donation['transaction_id']
                                        ?? 'N/A'
                                    ); ?>

                                </td>


                                <td>

                                    <span class="status-badge">

                                        <?= htmlspecialchars(
                                            ucfirst(
                                                $donation['status']
                                                ?? 'N/A'
                                            )
                                        ); ?>

                                    </span>

                                </td>


                                <td>

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

                                </td>


                                <td>

                                    <a
                                        href="index.php?page=admin-donation-view&id=<?= (int)$donation['id']; ?>"
                                        class="btn"
                                    >
                                        View
                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php endif; ?>

    </div>

</div>

<?php

require_once
    "views/partials/footer.php";

?>