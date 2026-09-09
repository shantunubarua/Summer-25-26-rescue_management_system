<?php

/*
|--------------------------------------------------------------------------
| Witness Dashboard Counts
|--------------------------------------------------------------------------
*/

function getWitnessDashboardCounts($conn, $witness_id)
{
    $data = [
        'total_reports' => 0,
        'critical_reports' => 0,
        'total_donations' => 0,
        'total_donated_amount' => 0
    ];


    /*
     * Total Incident Reports
     */

    $sql = "
        SELECT COUNT(*) AS total
        FROM witness_reports
        WHERE witness_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $witness_id
        );

        mysqli_stmt_execute($stmt);

        $result =
            mysqli_stmt_get_result($stmt);

        $row =
            mysqli_fetch_assoc($result);

        $data['total_reports'] =
            (int)($row['total'] ?? 0);

        mysqli_stmt_close($stmt);
    }


    /*
     * Critical Reports
     */

    $sql = "
        SELECT COUNT(*) AS total
        FROM witness_reports
        WHERE witness_id = ?
        AND damage_level = 'critical'
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $witness_id
        );

        mysqli_stmt_execute($stmt);

        $result =
            mysqli_stmt_get_result($stmt);

        $row =
            mysqli_fetch_assoc($result);

        $data['critical_reports'] =
            (int)($row['total'] ?? 0);

        mysqli_stmt_close($stmt);
    }


    /*
     * Total Donations
     */

    $sql = "
        SELECT
            COUNT(*) AS total,
            COALESCE(SUM(amount), 0) AS total_amount
        FROM donations
        WHERE witness_id = ?
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param(
            $stmt,
            "i",
            $witness_id
        );

        mysqli_stmt_execute($stmt);

        $result =
            mysqli_stmt_get_result($stmt);

        $row =
            mysqli_fetch_assoc($result);

        $data['total_donations'] =
            (int)($row['total'] ?? 0);

        $data['total_donated_amount'] =
            (float)($row['total_amount'] ?? 0);

        mysqli_stmt_close($stmt);
    }


    return $data;
}


/*
|--------------------------------------------------------------------------
| Recent Witness Reports
|--------------------------------------------------------------------------
*/

function getRecentWitnessReports(
    $conn,
    $witness_id,
    $limit = 5
) {
    $limit = (int)$limit;

    if ($limit <= 0) {
        $limit = 5;
    }

    $sql = "
        SELECT
            id,
            title,
            damage_level,
            incident_type,
            location,
            incident_date
        FROM witness_reports
        WHERE witness_id = ?
        ORDER BY id DESC
        LIMIT $limit
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $witness_id
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $reports = [];

    while (
        $row = mysqli_fetch_assoc($result)
    ) {
        $reports[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $reports;
}


/*
|--------------------------------------------------------------------------
| Recent Witness Donations
|--------------------------------------------------------------------------
*/

function getRecentWitnessDonations(
    $conn,
    $witness_id,
    $limit = 5
) {
    $limit = (int)$limit;

    if ($limit <= 0) {
        $limit = 5;
    }

    $sql = "
        SELECT
            id,
            amount,
            donation_type,
            payment_method,
            transaction_id,
            status,
            created_at
        FROM donations
        WHERE witness_id = ?
        ORDER BY id DESC
        LIMIT $limit
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $witness_id
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $donations = [];

    while (
        $row = mysqli_fetch_assoc($result)
    ) {
        $donations[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $donations;
}