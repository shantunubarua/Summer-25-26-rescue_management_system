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
    $transaction_id,
    $message
) {

    $sql = "
        INSERT INTO donations
        (
            witness_id,
            amount,
            donation_type,
            payment_method,
            transaction_id,
            message,
            status
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            'completed'
        )
    ";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if ($stmt === false) {

        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "idssss",
        $witness_id,
        $amount,
        $donation_type,
        $payment_method,
        $transaction_id,
        $message
    );


    $success =
        mysqli_stmt_execute(
            $stmt
        );


    mysqli_stmt_close(
        $stmt
    );


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
                transaction_id,
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
                transaction_id,
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
/*
|--------------------------------------------------------------------------
| ADMIN - GET ALL DONATIONS
|--------------------------------------------------------------------------
*/

function getAllDonationsForAdmin(
    $conn,
    $search = ''
) {
    $search =
        trim($search);


    /*
    |--------------------------------------------------------------------------
    | NO SEARCH
    |--------------------------------------------------------------------------
    */

    if ($search === '') {

        $sql =
            "SELECT
                donations.id,
                donations.witness_id,
                donations.amount,
                donations.donation_type,
                donations.payment_method,
                donations.transaction_id,
                donations.message,
                donations.status,
                donations.created_at,

                users.name AS witness_name,
                users.username AS witness_username,
                users.email AS witness_email,
                users.phone AS witness_phone

             FROM donations

             INNER JOIN users
                ON donations.witness_id = users.id

             WHERE users.role = 'witness'

             ORDER BY donations.id DESC";


        $stmt =
            mysqli_prepare(
                $conn,
                $sql
            );


        if (!$stmt) {
            return [];
        }

    } else {

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        $sql =
            "SELECT
                donations.id,
                donations.witness_id,
                donations.amount,
                donations.donation_type,
                donations.payment_method,
                donations.transaction_id,
                donations.message,
                donations.status,
                donations.created_at,

                users.name AS witness_name,
                users.username AS witness_username,
                users.email AS witness_email,
                users.phone AS witness_phone

             FROM donations

             INNER JOIN users
                ON donations.witness_id = users.id

             WHERE users.role = 'witness'

             AND
             (
                users.name LIKE ?
                OR users.username LIKE ?
                OR users.email LIKE ?
                OR donations.transaction_id LIKE ?
                OR donations.donation_type LIKE ?
                OR donations.payment_method LIKE ?
                OR donations.status LIKE ?
             )

             ORDER BY donations.id DESC";


        $stmt =
            mysqli_prepare(
                $conn,
                $sql
            );


        if (!$stmt) {
            return [];
        }


        $keyword =
            '%' .
            $search .
            '%';


        mysqli_stmt_bind_param(
            $stmt,
            "sssssss",
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword
        );
    }


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    $donations = [];


    while (
        $row =
        mysqli_fetch_assoc(
            $result
        )
    ) {

        $donations[] =
            $row;
    }


    mysqli_stmt_close(
        $stmt
    );


    return $donations;
}


/*
|--------------------------------------------------------------------------
| ADMIN - GET SINGLE DONATION
|--------------------------------------------------------------------------
*/

function getDonationForAdminById(
    $conn,
    $donation_id
) {
    $donation_id =
        (int)$donation_id;


    if ($donation_id <= 0) {
        return null;
    }


    $sql =
        "SELECT
            donations.id,
            donations.witness_id,
            donations.amount,
            donations.donation_type,
            donations.payment_method,
            donations.transaction_id,
            donations.message,
            donations.status,
            donations.created_at,

            users.name AS witness_name,
            users.username AS witness_username,
            users.email AS witness_email,
            users.phone AS witness_phone

         FROM donations

         INNER JOIN users
            ON donations.witness_id = users.id

         WHERE donations.id = ?
         AND users.role = 'witness'

         LIMIT 1";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {
        return null;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $donation_id
    );


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    $donation =
        mysqli_fetch_assoc(
            $result
        );


    mysqli_stmt_close(
        $stmt
    );


    return $donation;
}