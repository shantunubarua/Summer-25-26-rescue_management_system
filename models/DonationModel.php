<?php

/*
|--------------------------------------------------------------------------
| Create Donation
|--------------------------------------------------------------------------
*/

function createDonation(
    $conn,
    $witness_id,
    $amount,
    $donation_type,
    $payment_method,
    $message
) {
    $sql = "INSERT INTO donations
            (
                witness_id,
                amount,
                donation_type,
                payment_method,
                message,
                status
            )
            VALUES (?, ?, ?, ?, ?, 'pending')";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "idsss",
        $witness_id,
        $amount,
        $donation_type,
        $payment_method,
        $message
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| Get All Donations of Logged-in Witness
|--------------------------------------------------------------------------
*/

function getWitnessDonations(
    $conn,
    $witness_id
) {
    $sql = "SELECT
                id,
                witness_id,
                amount,
                donation_type,
                payment_method,
                message,
                status,
                created_at
            FROM donations
            WHERE witness_id = ?
            ORDER BY id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $witness_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $donations = [];

    if ($result) {

        while ($row = mysqli_fetch_assoc($result)) {
            $donations[] = $row;
        }
    }

    mysqli_stmt_close($stmt);

    return $donations;
}


/*
|--------------------------------------------------------------------------
| Get Single Donation By ID
|--------------------------------------------------------------------------
*/

function getDonationById(
    $conn,
    $donation_id,
    $witness_id
) {
    $sql = "SELECT
                id,
                witness_id,
                amount,
                donation_type,
                payment_method,
                message,
                status,
                created_at
            FROM donations
            WHERE id = ?
            AND witness_id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $donation_id,
        $witness_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $donation = null;

    if ($result) {
        $donation = mysqli_fetch_assoc($result);
    }

    mysqli_stmt_close($stmt);

    return $donation;
}