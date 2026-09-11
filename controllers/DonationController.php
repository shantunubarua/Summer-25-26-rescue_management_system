<?php

require_once "models/DonationModel.php";


/*
|--------------------------------------------------------------------------
| GENERATE TRANSACTION ID
|--------------------------------------------------------------------------
*/

function generateDonationTransactionId()
{
    return 'TXN' . substr(
        bin2hex(
            random_bytes(7)
        ),
        0,
        13
    );
}


/*
|--------------------------------------------------------------------------
| PREPARE DONATION
|--------------------------------------------------------------------------
|
| Step 1:
| Witness enters donation information.
|
| Donation is temporarily stored in session.
| It is saved to database after payment confirmation.
|
*/

function handleCreateDonation($conn)
{
    $amount =
        trim(
            $_POST['amount'] ?? ''
        );

    $donation_type =
        trim(
            $_POST['donation_type'] ?? ''
        );

    $message =
        trim(
            $_POST['message'] ?? ''
        );


    /*
    |--------------------------------------------------------------------------
    | Required Fields
    |--------------------------------------------------------------------------
    */

    if (
        $amount === '' ||
        $donation_type === ''
    ) {

        return "All required fields must be completed.";
    }


    /*
    |--------------------------------------------------------------------------
    | Amount Validation
    |--------------------------------------------------------------------------
    */

    if (
        !is_numeric($amount) ||
        (float)$amount <= 0
    ) {

        return "Donation amount must be greater than 0.";
    }


    $amount =
        (float)$amount;


    /*
    |--------------------------------------------------------------------------
    | Donation Type Validation
    |--------------------------------------------------------------------------
    */

    $allowed_types = [
        'money',
        'food',
        'medicine',
        'clothes',
        'water',
        'other'
    ];


    if (
        !in_array(
            $donation_type,
            $allowed_types,
            true
        )
    ) {

        return "Invalid donation type.";
    }


    /*
    |--------------------------------------------------------------------------
    | Logged-in Witness
    |--------------------------------------------------------------------------
    */

    $witness_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if ($witness_id <= 0) {

        return "Invalid witness account.";
    }


    /*
    |--------------------------------------------------------------------------
    | Store Donation Temporarily
    |--------------------------------------------------------------------------
    */

    $_SESSION['pending_donation'] = [

        'witness_id' =>
            $witness_id,

        'amount' =>
            $amount,

        'donation_type' =>
            $donation_type,

        'message' =>
            $message
    ];


    /*
    |--------------------------------------------------------------------------
    | Go To Payment Page
    |--------------------------------------------------------------------------
    */

    header(
        "Location: index.php?page=donation-payment"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| CONFIRM DONATION PAYMENT
|--------------------------------------------------------------------------
|
| Step 2:
| Witness selects payment method.
|
| Then:
| - Generate transaction ID
| - Save donation
| - Remove temporary session data
|
*/

function handleConfirmDonation($conn)
{
    /*
    |--------------------------------------------------------------------------
    | Check Pending Donation
    |--------------------------------------------------------------------------
    */

    if (
        empty(
            $_SESSION[
                'pending_donation'
            ]
        ) ||
        !is_array(
            $_SESSION[
                'pending_donation'
            ]
        )
    ) {

        return "No pending donation found.";
    }


    $pending =
        $_SESSION[
            'pending_donation'
        ];


    /*
    |--------------------------------------------------------------------------
    | Payment Method
    |--------------------------------------------------------------------------
    */

    $payment_method =
        trim(
            $_POST[
                'payment_method'
            ] ?? ''
        );


    if ($payment_method === '') {

        return "Please select a payment method.";
    }


    /*
    |--------------------------------------------------------------------------
    | Allowed Payment Methods
    |--------------------------------------------------------------------------
    */

    $allowed_payment_methods = [
        'card',
        'bkash',
        'nagad',
        'bank',
        'cash'
    ];


    if (
        !in_array(
            $payment_method,
            $allowed_payment_methods,
            true
        )
    ) {

        return "Invalid payment method.";
    }


    /*
    |--------------------------------------------------------------------------
    | Get Donation Information
    |--------------------------------------------------------------------------
    */

    $witness_id =
        (int)(
            $pending[
                'witness_id'
            ] ?? 0
        );


    $amount =
        (float)(
            $pending[
                'amount'
            ] ?? 0
        );


    $donation_type =
        trim(
            $pending[
                'donation_type'
            ] ?? ''
        );


    $message =
        trim(
            $pending[
                'message'
            ] ?? ''
        );


    if (
        $witness_id <= 0 ||
        $amount <= 0 ||
        $donation_type === ''
    ) {

        return "Invalid donation information.";
    }


    /*
    |--------------------------------------------------------------------------
    | Revalidate Donation Type
    |--------------------------------------------------------------------------
    */

    $allowed_types = [
        'money',
        'food',
        'medicine',
        'clothes',
        'water',
        'other'
    ];


    if (
        !in_array(
            $donation_type,
            $allowed_types,
            true
        )
    ) {

        unset(
            $_SESSION[
                'pending_donation'
            ]
        );

        return "Invalid donation type.";
    }


    /*
    |--------------------------------------------------------------------------
    | Security Check
    |--------------------------------------------------------------------------
    |
    | Current logged-in Witness must be
    | the same Witness who started donation.
    |
    */

    $logged_in_witness_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if (
        $logged_in_witness_id <= 0 ||
        $logged_in_witness_id
            !== $witness_id
    ) {

        unset(
            $_SESSION[
                'pending_donation'
            ]
        );


        return "Invalid witness account.";
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Transaction ID
    |--------------------------------------------------------------------------
    */

    $transaction_id =
        generateDonationTransactionId();


    /*
    |--------------------------------------------------------------------------
    | Save Donation
    |--------------------------------------------------------------------------
    */

    $success =
        createDonation(
            $conn,
            $witness_id,
            $amount,
            $donation_type,
            $payment_method,
            $transaction_id,
            $message
        );


    if (!$success) {

        return "Failed to complete donation.";
    }


    /*
    |--------------------------------------------------------------------------
    | Remove Temporary Donation
    |--------------------------------------------------------------------------
    */

    unset(
        $_SESSION[
            'pending_donation'
        ]
    );


    /*
    |--------------------------------------------------------------------------
    | Redirect To Donation History
    |--------------------------------------------------------------------------
    */

    header(
        "Location: index.php?page=donations"
    );

    exit;
}
/*
|--------------------------------------------------------------------------
| ADMIN - LOAD DONATIONS
|--------------------------------------------------------------------------
*/

function loadAdminDonations(
    $conn,
    $search = ''
) {
    $search =
        trim($search);


    if (
        strlen($search) > 100
    ) {

        return [
            'error' =>
                'Search text must not exceed 100 characters.',

            'donations' =>
                []
        ];
    }


    $donations =
        getAllDonationsForAdmin(
            $conn,
            $search
        );


    return [
        'error' => '',
        'donations' =>
            $donations
    ];
}


/*
|--------------------------------------------------------------------------
| ADMIN - LOAD DONATION DETAILS
|--------------------------------------------------------------------------
*/

function loadAdminDonationDetails(
    $conn,
    $donation_id
) {
    $donation_id =
        (int)$donation_id;


    if ($donation_id <= 0) {

        die(
            "Invalid donation ID."
        );
    }


    $donation =
        getDonationForAdminById(
            $conn,
            $donation_id
        );


    if (!$donation) {

        die(
            "Donation not found."
        );
    }


    return $donation;
}