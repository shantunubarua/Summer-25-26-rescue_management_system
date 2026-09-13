<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<?php
$currentAmount =
    $_POST['amount']
    ?? '';

$currentType =
    $_POST['donation_type']
    ?? '';

$currentMessage =
    $_POST['message']
    ?? '';
?>

<div class="content">

    <div class="witness-form-page">


        <!-- PAGE HEADER -->

        <div class="witness-page-header">

            <div>

                <p class="eyebrow">
                    RESCUE CONTRIBUTION
                </p>

                <h1>
                    Make a Donation
                </h1>

                <p class="page-subtitle">
                    Support rescue and relief activities
                    by making a contribution.
                </p>

            </div>


            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=donations"
                    class="secondary-action"
                >
                    My Donations
                </a>

                <a
                    href="index.php?page=witness-dashboard"
                    class="secondary-action"
                >
                    Dashboard
                </a>

            </div>

        </div>


        <!-- PHP ERROR -->

        <?php if (!empty($error)): ?>

            <div class="alert alert-error">

                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>

            </div>

        <?php endif; ?>


        <!-- FLOW INFORMATION -->

        <div class="witness-donation-flow">

            <div class="witness-donation-flow-number">
                1
            </div>

            <div>

                <strong>
                    Enter Donation Details
                </strong>

                <p>
                    Enter the amount and donation type here.
                    You will choose the payment method and
                    confirm the donation on the next page.
                </p>

            </div>

        </div>


        <!-- FORM CARD -->

        <div class="witness-form-card">

            <div class="witness-form-card-header">

                <div>

                    <span>
                        DONATION INFORMATION
                    </span>

                    <h2>
                        Contribution Details
                    </h2>

                    <p>
                        Fields marked with * are required.
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="index.php?page=donation-create"
                class="witness-modern-form"
            >

                <?= csrfField(); ?>


                <div class="witness-form-grid">


                    <!-- AMOUNT -->

                    <div class="witness-form-group">

                        <label for="amount">
                            Donation Amount
                            <span class="required-mark">*</span>
                        </label>

                        <div class="witness-money-input">

                            <span>
                                ৳
                            </span>

                            <input
                                type="number"
                                id="amount"
                                name="amount"
                                min="0.01"
                                step="0.01"
                                required
                                placeholder="Example: 500"
                                value="<?= htmlspecialchars(
                                    $currentAmount,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>"
                            >

                        </div>

                        <small>
                            Enter an amount greater than 0.
                        </small>

                    </div>


                    <!-- DONATION TYPE -->

                    <div class="witness-form-group">

                        <label for="donation_type">
                            Donation Type
                            <span class="required-mark">*</span>
                        </label>

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
                                <?= $currentType === 'money'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Money
                            </option>

                            <option
                                value="food"
                                <?= $currentType === 'food'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Food
                            </option>

                            <option
                                value="medicine"
                                <?= $currentType === 'medicine'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medicine
                            </option>

                            <option
                                value="clothes"
                                <?= $currentType === 'clothes'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Clothes
                            </option>

                            <option
                                value="water"
                                <?= $currentType === 'water'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Water
                            </option>

                            <option
                                value="other"
                                <?= $currentType === 'other'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Other
                            </option>

                        </select>

                        <small>
                            Select the category that best
                            represents your contribution.
                        </small>

                    </div>


                    <!-- MESSAGE -->

                    <div class="witness-form-group witness-form-full">

                        <label for="message">
                            Donation Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            placeholder="Add an optional note about your donation..."
                        ><?= htmlspecialchars(
                            $currentMessage,
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?></textarea>

                        <small>
                            This message is optional.
                        </small>

                    </div>

                </div>


                <!-- ACTIONS -->

                <div class="witness-form-actions">

                    <button
                        type="submit"
                        class="primary-action"
                    >
                        Continue to Payment
                    </button>

                    <a
                        href="index.php?page=witness-dashboard"
                        class="secondary-action"
                    >
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?php require_once "views/partials/footer.php"; ?>