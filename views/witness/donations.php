<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>My Donations</h1>

    <p>
        View your submitted donations and their status.
    </p>

    <p>
        <a href="index.php?page=donation-create">
            Make a New Donation
        </a>
    </p>


    <?php if (empty($donations)): ?>

        <p>
            You have not made any donations yet.
        </p>

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

                </tr>

            </thead>


            <tbody>

                <?php foreach ($donations as $donation): ?>

                    <tr>

                        <td>
                            <?php
                            echo (int)$donation['id'];
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['amount']
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $donation['donation_type']
                                )
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $donation['payment_method']
                                )
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['message'] ?? ''
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $donation['status']
                                    ?? 'pending'
                                )
                            );
                            ?>
                        </td>


                        <td>
                            <?php
                            echo htmlspecialchars(
                                $donation['created_at']
                            );
                            ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

<?php require_once "views/partials/footer.php"; ?>