<?php


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