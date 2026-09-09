<?php require_once "views/partials/header.php"; ?>
<?php require_once "views/partials/sidebar.php"; ?>

<?php
$pendingDonation = $_SESSION['pending_donation'] ?? null;
$selectedPayment = $_POST['payment_method'] ?? '';
?>

<div class="content">

    <div class="payment-page">

        <!-- Page Heading -->
        <div class="payment-heading">
            <h1>Complete Your Donation</h1>

            <p>
                Review your donation and choose a payment method.
            </p>
        </div>


        <?php if (!empty($error)): ?>

            <div class="payment-error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <?php if (!$pendingDonation): ?>

            <div class="empty-payment">
                <h3>No Pending Donation</h3>

                <p>
                    Please create a donation before proceeding to payment.
                </p>

                <a href="index.php?page=donation-create">
                    Make a Donation
                </a>
            </div>

        <?php else: ?>


            <!-- Donation Summary -->
            <div class="donation-summary">

                <div class="summary-title">
                    <div>
                        <span class="section-label">DONATION SUMMARY</span>
                        <h2>Your Donation</h2>
                    </div>

                    <span class="summary-status">
                        Pending Payment
                    </span>
                </div>


                <div class="summary-grid">

                    <div class="summary-item">
                        <span>Amount</span>

                        <strong>
                            ৳<?php
                            echo number_format(
                                (float)$pendingDonation['amount'],
                                2
                            );
                            ?>
                        </strong>
                    </div>


                    <div class="summary-item">
                        <span>Donation Type</span>

                        <strong>
                            <?php
                            echo htmlspecialchars(
                                ucfirst(
                                    $pendingDonation['donation_type']
                                )
                            );
                            ?>
                        </strong>
                    </div>


                    <?php if (!empty($pendingDonation['message'])): ?>

                        <div class="summary-item summary-message">
                            <span>Message</span>

                            <strong>
                                <?php
                                echo htmlspecialchars(
                                    $pendingDonation['message']
                                );
                                ?>
                            </strong>
                        </div>

                    <?php endif; ?>

                </div>

            </div>


            <!-- Payment Section -->
            <div class="payment-box">

                <div class="payment-box-header">

                    <div>
                        <span class="section-label">
                            PAYMENT
                        </span>

                        <h2>Select Payment Method</h2>

                        <p>
                            Choose one of the available payment options.
                        </p>
                    </div>

                </div>


                <form
                    method="POST"
                    action="index.php?page=donation-payment"
                    id="paymentForm"
                >

                    <div class="payment-grid">


                        <!-- Credit Card -->
                        <label
                            class="payment-card <?php echo $selectedPayment === 'card' ? 'selected' : ''; ?>"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="card"
                                <?php echo $selectedPayment === 'card' ? 'checked' : ''; ?>
                                required
                            >

                            <div class="payment-card-top">
                                <span class="payment-icon">
                                    CARD
                                </span>

                                <span class="radio-indicator"></span>
                            </div>

                            <div class="payment-card-content">
                                <strong>Credit Card</strong>
                                <small>Visa / Mastercard</small>
                            </div>

                        </label>


                        <!-- bKash -->
                        <label
                            class="payment-card <?php echo $selectedPayment === 'bkash' ? 'selected' : ''; ?>"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="bkash"
                                <?php echo $selectedPayment === 'bkash' ? 'checked' : ''; ?>
                                required
                            >

                            <div class="payment-card-top">
                                <span class="payment-icon">
                                    bK
                                </span>

                                <span class="radio-indicator"></span>
                            </div>

                            <div class="payment-card-content">
                                <strong>bKash</strong>
                                <small>Mobile payment</small>
                            </div>

                        </label>


                        <!-- Nagad -->
                        <label
                            class="payment-card <?php echo $selectedPayment === 'nagad' ? 'selected' : ''; ?>"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="nagad"
                                <?php echo $selectedPayment === 'nagad' ? 'checked' : ''; ?>
                                required
                            >

                            <div class="payment-card-top">
                                <span class="payment-icon">
                                    NG
                                </span>

                                <span class="radio-indicator"></span>
                            </div>

                            <div class="payment-card-content">
                                <strong>Nagad</strong>
                                <small>Mobile payment</small>
                            </div>

                        </label>


                        <!-- Bank Transfer -->
                        <label
                            class="payment-card <?php echo $selectedPayment === 'bank' ? 'selected' : ''; ?>"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="bank"
                                <?php echo $selectedPayment === 'bank' ? 'checked' : ''; ?>
                                required
                            >

                            <div class="payment-card-top">
                                <span class="payment-icon">
                                    BANK
                                </span>

                                <span class="radio-indicator"></span>
                            </div>

                            <div class="payment-card-content">
                                <strong>Bank Transfer</strong>
                                <small>Direct bank payment</small>
                            </div>

                        </label>


                        <!-- Cash -->
                        <label
                            class="payment-card <?php echo $selectedPayment === 'cash' ? 'selected' : ''; ?>"
                        >

                            <input
                                type="radio"
                                name="payment_method"
                                value="cash"
                                <?php echo $selectedPayment === 'cash' ? 'checked' : ''; ?>
                                required
                            >

                            <div class="payment-card-top">
                                <span class="payment-icon">
                                    CASH
                                </span>

                                <span class="radio-indicator"></span>
                            </div>

                            <div class="payment-card-content">
                                <strong>Cash</strong>
                                <small>Offline payment</small>
                            </div>

                        </label>

                    </div>


                    <!-- Bottom Area -->
                    <div class="payment-footer">

                        <div class="transaction-note">
                            <strong>Transaction Reference</strong>

                            <span>
                                A unique transaction ID will be generated
                                after confirmation.
                            </span>
                        </div>


                        <div class="payment-actions">

                            <a
                                href="index.php?page=donation-create"
                                class="back-button"
                            >
                                Back
                            </a>

                            <button
                                type="submit"
                                class="confirm-button"
                            >
                                Confirm Donation
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        <?php endif; ?>

    </div>

</div>


<style>

.payment-page {
    max-width: 1050px;
    margin: 0 auto;
    padding: 10px 5px 40px;
}


/* Heading */

.payment-heading {
    margin-bottom: 25px;
}

.payment-heading h1 {
    margin: 0 0 7px;
    font-size: 30px;
    color: #1f2937;
}

.payment-heading p {
    margin: 0;
    color: #6b7280;
    font-size: 15px;
}


/* Common Card */

.donation-summary,
.payment-box {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
}


/* Summary */

.donation-summary {
    padding: 24px;
    margin-bottom: 24px;
}

.summary-title {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    padding-bottom: 18px;
    border-bottom: 1px solid #eeeeee;
}

.section-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.3px;
    color: #6b7280;
    margin-bottom: 5px;
}

.summary-title h2,
.payment-box-header h2 {
    margin: 0;
    color: #1f2937;
    font-size: 21px;
}

.summary-status {
    background: #fff7e6;
    color: #9a6700;
    border: 1px solid #f3d28b;
    padding: 7px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
    padding-top: 20px;
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.summary-item span {
    color: #6b7280;
    font-size: 13px;
}

.summary-item strong {
    color: #111827;
    font-size: 17px;
}

.summary-message {
    grid-column: 1 / -1;
}


/* Payment Box */

.payment-box {
    padding: 26px;
}

.payment-box-header {
    margin-bottom: 22px;
}

.payment-box-header p {
    margin: 7px 0 0;
    color: #6b7280;
    font-size: 14px;
}


/* Payment Cards */

.payment-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.payment-card {
    position: relative;
    min-height: 125px;
    padding: 18px;
    background: #ffffff;
    border: 1.5px solid #dfe3e8;
    border-radius: 12px;
    cursor: pointer;
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease,
        border-color 0.2s ease,
        background 0.2s ease;
}

.payment-card:hover {
    transform: translateY(-2px);
    border-color: #64748b;
    box-shadow: 0 7px 18px rgba(0, 0, 0, 0.08);
}

.payment-card.selected {
    border-color: #334155;
    background: #f8fafc;
    box-shadow: 0 0 0 2px rgba(51, 65, 85, 0.10);
}

.payment-card input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.payment-card-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.payment-icon {
    height: 32px;
    min-width: 42px;
    padding: 0 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #334155;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.4px;
}

.radio-indicator {
    width: 18px;
    height: 18px;
    border: 2px solid #cbd5e1;
    border-radius: 50%;
    position: relative;
}

.payment-card.selected .radio-indicator {
    border-color: #334155;
}

.payment-card.selected .radio-indicator::after {
    content: "";
    position: absolute;
    width: 8px;
    height: 8px;
    background: #334155;
    border-radius: 50%;
    top: 3px;
    left: 3px;
}

.payment-card-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.payment-card-content strong {
    font-size: 16px;
    color: #111827;
}

.payment-card-content small {
    font-size: 12px;
    color: #6b7280;
}


/* Bottom */

.payment-footer {
    margin-top: 28px;
    padding-top: 22px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.transaction-note {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.transaction-note strong {
    font-size: 13px;
    color: #374151;
}

.transaction-note span {
    font-size: 12px;
    color: #6b7280;
}

.payment-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

.back-button,
.confirm-button {
    padding: 11px 20px;
    border-radius: 7px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
}

.back-button {
    background: #ffffff;
    color: #374151;
    border: 1px solid #d1d5db;
}

.back-button:hover {
    background: #f9fafb;
}

.confirm-button {
    border: none;
    background: #26384d;
    color: #ffffff;
}

.confirm-button:hover {
    background: #172536;
}


/* Error */

.payment-error {
    margin-bottom: 20px;
    padding: 12px 15px;
    background: #fff1f1;
    border: 1px solid #f0b8b8;
    border-radius: 8px;
    color: #b42318;
}


/* Empty */

.empty-payment {
    padding: 40px;
    text-align: center;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
}

.empty-payment a {
    display: inline-block;
    margin-top: 10px;
}


/* Responsive */

@media (max-width: 900px) {

    .payment-grid {
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 600px) {

    .payment-grid,
    .summary-grid {
        grid-template-columns: 1fr;
    }

    .payment-footer {
        flex-direction: column;
        align-items: stretch;
    }

    .payment-actions {
        width: 100%;
    }

    .back-button,
    .confirm-button {
        flex: 1;
        text-align: center;
    }

}

</style>


<script>

const paymentCards =
    document.querySelectorAll('.payment-card');

paymentCards.forEach(function(card) {

    const radio =
        card.querySelector('input[type="radio"]');

    card.addEventListener('click', function() {

        paymentCards.forEach(function(item) {
            item.classList.remove('selected');
        });

        card.classList.add('selected');

        radio.checked = true;

    });

});

</script>


<?php require_once "views/partials/footer.php"; ?>