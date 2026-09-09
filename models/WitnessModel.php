<?php


/*
|--------------------------------------------------------------------------
| CREATE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function createWitnessReport(
    $conn,
    $witness_id,
    $title,
    $description,
    $damage_level,
    $incident_type,
    $location,
    $incident_date,
    $evidence_file
) {

    $sql = "INSERT INTO witness_reports
            (
                witness_id,
                title,
                description,
                damage_level,
                incident_type,
                location,
                incident_date,
                evidence_file
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "isssssss",
        $witness_id,
        $title,
        $description,
        $damage_level,
        $incident_type,
        $location,
        $incident_date,
        $evidence_file
    );


    $success =
        mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);


    return $success;
}



/*
|--------------------------------------------------------------------------
| GET WITNESS REPORTS
|--------------------------------------------------------------------------
*/

function getWitnessReports(
    $conn,
    $witness_id
) {

    $sql = "SELECT *
            FROM witness_reports
            WHERE witness_id = ?
            ORDER BY id DESC";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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
        $row =
        mysqli_fetch_assoc($result)
    ) {

        $reports[] = $row;
    }


    mysqli_stmt_close($stmt);


    return $reports;
}



/*
|--------------------------------------------------------------------------
| GET SINGLE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function getWitnessReportById(
    $conn,
    $report_id,
    $witness_id
) {

    $sql = "SELECT *
            FROM witness_reports
            WHERE id = ?
            AND witness_id = ?
            LIMIT 1";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return null;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $report_id,
        $witness_id
    );


    mysqli_stmt_execute($stmt);


    $result =
        mysqli_stmt_get_result($stmt);


    $report =
        mysqli_fetch_assoc($result);


    mysqli_stmt_close($stmt);


    return $report;
}



/*
|--------------------------------------------------------------------------
| UPDATE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function updateWitnessReport(
    $conn,
    $report_id,
    $witness_id,
    $title,
    $description,
    $damage_level,
    $incident_type,
    $location,
    $incident_date
) {

    $sql = "UPDATE witness_reports
            SET
                title = ?,
                description = ?,
                damage_level = ?,
                incident_type = ?,
                location = ?,
                incident_date = ?
            WHERE id = ?
            AND witness_id = ?";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ssssssii",
        $title,
        $description,
        $damage_level,
        $incident_type,
        $location,
        $incident_date,
        $report_id,
        $witness_id
    );


    $success =
        mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);


    return $success;
}



/*
|--------------------------------------------------------------------------
| DELETE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function deleteWitnessReport(
    $conn,
    $report_id,
    $witness_id
) {

    $sql = "DELETE FROM witness_reports
            WHERE id = ?
            AND witness_id = ?";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $report_id,
        $witness_id
    );


    $success =
        mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);


    return $success;
}



/*
|--------------------------------------------------------------------------
| ADMIN - GET ALL WITNESS REPORTS
|--------------------------------------------------------------------------
*/

function getAllWitnessReportsForAdmin($conn)
{
    $sql = "
        SELECT
            wr.*,
            u.name AS witness_name,
            u.email AS witness_email,
            u.phone AS witness_phone

        FROM witness_reports AS wr

        INNER JOIN users AS u
            ON wr.witness_id = u.id

        WHERE u.role = 'witness'

        ORDER BY
            CASE wr.status
                WHEN 'pending' THEN 1
                WHEN 'reviewed' THEN 2
                WHEN 'approved' THEN 3
                WHEN 'rejected' THEN 4
                ELSE 5
            END,
            wr.created_at DESC
    ";


    $result = mysqli_query(
        $conn,
        $sql
    );


    if (!$result) {
        return [];
    }


    $reports = [];


    while ($row = mysqli_fetch_assoc($result)) {

        $reports[] = $row;
    }


    return $reports;
}



/*
|--------------------------------------------------------------------------
| ADMIN - GET SINGLE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function getWitnessReportForAdminById(
    $conn,
    $report_id
) {

    $sql = "
        SELECT
            wr.*,
            u.name AS witness_name,
            u.email AS witness_email,
            u.phone AS witness_phone

        FROM witness_reports AS wr

        INNER JOIN users AS u
            ON wr.witness_id = u.id

        WHERE wr.id = ?
        AND u.role = 'witness'

        LIMIT 1
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return null;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $report_id
    );


    mysqli_stmt_execute($stmt);


    $result =
        mysqli_stmt_get_result($stmt);


    $report =
        mysqli_fetch_assoc($result);


    mysqli_stmt_close($stmt);


    return $report ?: null;
}



/*
|--------------------------------------------------------------------------
| ADMIN - UPDATE WITNESS REPORT STATUS
|--------------------------------------------------------------------------
*/

function updateWitnessReportStatusByAdmin(
    $conn,
    $report_id,
    $status
) {

    $sql = "
        UPDATE witness_reports

        SET status = ?

        WHERE id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status,
        $report_id
    );


    $success =
        mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);


    return $success;
}



/*
|--------------------------------------------------------------------------
| WITNESS DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/

function getWitnessDashboardCounts(
    $conn,
    $witness_id
) {

    $dashboardCounts = [
        'total_reports' => 0,
        'critical_reports' => 0,
        'total_donations' => 0,
        'total_donated_amount' => 0
    ];


    /*
    |--------------------------------------------------------------------------
    | Total Reports
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT COUNT(*) AS total
        FROM witness_reports
        WHERE witness_id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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


        $dashboardCounts['total_reports'] =
            (int)($row['total'] ?? 0);


        mysqli_stmt_close($stmt);
    }


    /*
    |--------------------------------------------------------------------------
    | Critical Reports
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT COUNT(*) AS total
        FROM witness_reports
        WHERE witness_id = ?
        AND damage_level = 'critical'
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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


        $dashboardCounts['critical_reports'] =
            (int)($row['total'] ?? 0);


        mysqli_stmt_close($stmt);
    }


    /*
    |--------------------------------------------------------------------------
    | Total Donations + Donated Amount
    |--------------------------------------------------------------------------
    */

    $sql = "
        SELECT
            COUNT(*) AS total,
            COALESCE(
                SUM(amount),
                0
            ) AS total_amount

        FROM donations

        WHERE witness_id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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


        $dashboardCounts['total_donations'] =
            (int)($row['total'] ?? 0);


        $dashboardCounts['total_donated_amount'] =
            (float)($row['total_amount'] ?? 0);


        mysqli_stmt_close($stmt);
    }


    return $dashboardCounts;
}



/*
|--------------------------------------------------------------------------
| WITNESS DASHBOARD - RECENT REPORTS
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
            incident_date,
            status

        FROM witness_reports

        WHERE witness_id = ?

        ORDER BY id DESC

        LIMIT $limit
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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
        $row =
        mysqli_fetch_assoc($result)
    ) {

        $reports[] = $row;
    }


    mysqli_stmt_close($stmt);


    return $reports;
}



/*
|--------------------------------------------------------------------------
| WITNESS DASHBOARD - RECENT DONATIONS
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


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


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
        $row =
        mysqli_fetch_assoc($result)
    ) {

        $donations[] = $row;
    }


    mysqli_stmt_close($stmt);


    return $donations;
}