<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<div class="content">

    <div class="witness-page donation-form-shell">

        <div class="witness-page-header">

            <div>
                <p class="eyebrow">
                    WITNESS CONTRIBUTION
                </p>

                <h1>
                    Make a Donation
                </h1>

                <p class="page-subtitle">
                    Support rescue and relief activities by
                    contributing funds or essential items.
                </p>
            </div>

            <div class="witness-page-header-actions">

                <a
                    href="index.php?page=donations"
                    class="secondary-action"
                >
                    My Donations
                </a>

            </div>

        </div>


        <?php if (!empty($error)): ?>

            <div class="alert alert-error">
                <?= htmlspecialchars(
                    $error,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>
            </div>

        <?php endif; ?>


        <div class="donation-note">

            <div>
                <strong>
                    How donation works
                </strong>

                Enter your donation information here.
                On the next screen, you will review the
                donation and choose a payment method.
            </div>

        </div>


        <div class="form-card donation-form-card">

            <form
                method="POST"
                action="index.php?page=donation-create"
                class="modern-form"
            >

                <?= csrfField(); ?>


                <div class="form-grid">

                    <div class="form-group">

                        <label for="amount">
                            Donation Amount
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="number"
                            id="amount"
                            name="amount"
                            min="0.01"
                            step="0.01"
                            required
                            placeholder="Example: 500"
                            value="<?= htmlspecialchars(
                                $_POST['amount'] ?? '',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                        >

                        <small class="form-help">
                            Enter an amount greater than 0.
                        </small>

                    </div>


                    <div class="form-group">

                        <label for="donation_type">
                            Donation Type
                            <span class="required-mark">*</span>
                        </label>

                        <?php
                        $selectedType =
                            $_POST['donation_type']
                            ?? '';
                        ?>

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
                                <?= $selectedType === 'money'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Money
                            </option>

                            <option
                                value="food"
                                <?= $selectedType === 'food'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Food
                            </option>

                            <option
                                value="medicine"
                                <?= $selectedType === 'medicine'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Medicine
                            </option>

                            <option
                                value="clothes"
                                <?= $selectedType === 'clothes'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Clothes
                            </option>

                            <option
                                value="water"
                                <?= $selectedType === 'water'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Water
                            </option>

                            <option
                                value="other"
                                <?= $selectedType === 'other'
                                    ? 'selected'
                                    : ''; ?>
                            >
                                Other
                            </option>

                        </select>

                        <small class="form-help">
                            Select the category that best describes
                            your contribution.
                        </small>

                    </div>


                    <div class="form-group form-group-full">

                        <label for="message">
                            Message
                        </label>

                        <textarea
                            id="message"
                            name="message"
                            rows="5"
                            maxlength="1000"
                            placeholder="Optional note about your donation..."
                        ><?= htmlspecialchars(
                            $_POST['message'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        ); ?></textarea>

                        <small class="form-help">
                            Optional donation note.
                        </small>

                    </div>

                </div>


                <div class="form-actions">

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