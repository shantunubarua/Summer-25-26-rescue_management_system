<?php require_once "views/partials/header.php"; ?>

<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <h1>Make a Donation</h1>

    <?php if (!empty($error)): ?>

        <p style="color: red;">
            <?php echo htmlspecialchars($error); ?>
        </p>

    <?php endif; ?>


    <form
        method="POST"
        action="index.php?page=donation-create"
    >

        <!-- Amount -->
        <div>

            <label for="amount">
                Amount *
            </label>

            <br>

            <input
                type="number"
                id="amount"
                name="amount"
                min="0.01"
                step="0.01"
                required
                value="<?php
                    echo htmlspecialchars(
                        $_POST['amount'] ?? ''
                    );
                ?>"
            >

        </div>

        <br>


        <!-- Donation Type -->
        <div>

            <label for="donation_type">
                Donation Type *
            </label>

            <br>

            <select
                id="donation_type"
                name="donation_type"
                required
            >

                <option value="">
                    Select donation type
                </option>

                <option
                    value="money"
                    <?php
                    echo (
                        ($_POST['donation_type'] ?? '')
                        === 'money'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Money
                </option>

                <option
                    value="food"
                    <?php
                    echo (
                        ($_POST['donation_type'] ?? '')
                        === 'food'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Food
                </option>

                <option
                    value="medicine"
                    <?php
                    echo (
                        ($_POST['donation_type'] ?? '')
                        === 'medicine'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Medicine
                </option>

                <option
                    value="clothes"
                    <?php
                    echo (
                        ($_POST['donation_type'] ?? '')
                        === 'clothes'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Clothes
                </option>

                <option
                    value="other"
                    <?php
                    echo (
                        ($_POST['donation_type'] ?? '')
                        === 'other'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Other
                </option>

            </select>

        </div>

        <br>


        <!-- Payment Method -->
        <div>

            <label for="payment_method">
                Payment Method *
            </label>

            <br>

            <select
                id="payment_method"
                name="payment_method"
                required
            >

                <option value="">
                    Select payment method
                </option>

                <option
                    value="cash"
                    <?php
                    echo (
                        ($_POST['payment_method'] ?? '')
                        === 'cash'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Cash
                </option>

                <option
                    value="card"
                    <?php
                    echo (
                        ($_POST['payment_method'] ?? '')
                        === 'card'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Card
                </option>

                <option
                    value="bkash"
                    <?php
                    echo (
                        ($_POST['payment_method'] ?? '')
                        === 'bkash'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    bKash
                </option>

                <option
                    value="bank"
                    <?php
                    echo (
                        ($_POST['payment_method'] ?? '')
                        === 'bank'
                    )
                        ? 'selected'
                        : '';
                    ?>
                >
                    Bank
                </option>

            </select>

        </div>

        <br>


        <!-- Message -->
        <div>

            <label for="message">
                Message
            </label>

            <br>

            <textarea
                id="message"
                name="message"
                rows="5"
            ><?php
                echo htmlspecialchars(
                    $_POST['message'] ?? ''
                );
            ?></textarea>

        </div>

        <br>


        <!-- Submit -->
        <button type="submit">
            Submit Donation
        </button>

    </form>

</div>

<?php require_once "views/partials/footer.php"; ?>