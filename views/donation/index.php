<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>My Donations</h1>

    <p>
        View the donations you have submitted.
    </p>

    <p>
        <a href="index.php?page=donation-create">
            Make New Donation
        </a>
    </p>


    <?php if (empty($donations)): ?>

        <div class="card">

            <h3>No Donations</h3>

            <p>
                You have not made any donations yet.
            </p>

            <p>
                <a href="index.php?page=donation-create">
                    Make a Donation
                </a>
            </p>

        </div>

    <?php else: ?>

        <table border="1" cellpadding="10">

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Donation Type</th>
                    <th>Payment Method</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

                <?php foreach ($donations as $donation): ?>

                    <tr>

                        <!-- ID -->

                        <td>
                            <?php
                            echo (int)$donation['id'];
                            ?>
                        </td>


                        <!-- Amount -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['amount']
                            );
                            ?>
                        </td>


                        <!-- Donation Type -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $donation['donation_type']
                                )
                            );
                            ?>
                        </td>


                        <!-- Payment Method -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $donation['payment_method']
                                )
                            );
                            ?>
                        </td>


                        <!-- Message -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['message'] ?? ''
                            );
                            ?>
                        </td>


                        <!-- Status -->

                        <td>

                            <?php

                            $status =
                                $donation['status']
                                ?? 'pending';

                            ?>

                            <span
                                class="status-<?php echo htmlspecialchars($status); ?>"
                            >
                                <?php
                                echo htmlspecialchars(
                                    ucfirst($status)
                                );
                                ?>
                            </span>

                        </td>


                        <!-- Created At -->

                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['created_at'] ?? ''
                            );
                            ?>
                        </td>


                        <!-- Action -->

                        <td>

                            <a
                                href="index.php?page=donation-view&id=<?php echo (int)$donation['id']; ?>"
                            >
                                View
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>


<style>

.status-pending {
    color: #856404;
    background-color: #fff3cd;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-approved {
    color: #155724;
    background-color: #d4edda;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-completed {
    color: #155724;
    background-color: #c3e6cb;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

.status-rejected {
    color: #721c24;
    background-color: #f8d7da;
    padding: 5px 10px;
    border-radius: 5px;
    font-weight: bold;
}

</style>


<?php require_once "views/partials/footer.php"; ?>