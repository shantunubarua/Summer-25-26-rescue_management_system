<?php

function getAllRescueReports($conn)
{
    $sql = "SELECT
                id,
                emergency_request_id,
                admin_id,
                rescue_status,
                description,
                created_at,
                updated_at
            FROM rescue_reports
            ORDER BY id DESC";

    $result = mysqli_query($conn, $sql);

    $reports = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $reports[] = $row;
    }

    return $reports;
}


function getRescueReportById($conn, $id)
{
    $sql = "SELECT
                id,
                emergency_request_id,
                admin_id,
                rescue_status,
                description,
                created_at,
                updated_at
            FROM rescue_reports
            WHERE id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $report = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $report;
}


function updateRescueReportStatus($conn, $id, $status)
{
    $allowed_statuses = [
        'pending',
        'ongoing',
        'completed',
        'cancelled'
    ];

    if (!in_array($status, $allowed_statuses, true)) {
        return false;
    }

    $sql = "UPDATE rescue_reports
            SET rescue_status = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status,
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function createRescueReport(
    $conn,
    $emergency_request_id,
    $admin_id,
    $rescue_status,
    $description
) {
    $allowed_statuses = [
        'pending',
        'ongoing',
        'completed',
        'cancelled'
    ];

    if (!in_array($rescue_status, $allowed_statuses, true)) {
        return false;
    }

    $sql = "INSERT INTO rescue_reports (
                emergency_request_id,
                admin_id,
                rescue_status,
                description
            )
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiss",
        $emergency_request_id,
        $admin_id,
        $rescue_status,
        $description
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function updateRescueReport(
    $conn,
    $report_id,
    $rescue_status,
    $description
) {
    $allowed_statuses = [
        'pending',
        'ongoing',
        'completed',
        'cancelled'
    ];

    if (!in_array($rescue_status, $allowed_statuses, true)) {
        return false;
    }

    $sql = "UPDATE rescue_reports
            SET rescue_status = ?,
                description = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssi",
        $rescue_status,
        $description,
        $report_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function deleteRescueReport($conn, $report_id)
{
    $sql = "DELETE FROM rescue_reports
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $report_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
/*
|--------------------------------------------------------------------------
| GET DETAILED RESCUE REPORT
|--------------------------------------------------------------------------
*/

function getDetailedRescueReportById($conn, $report_id)
{
    $sql = "
        SELECT
            rr.id AS report_id,
            rr.emergency_request_id,
            rr.rescue_status,
            rr.description AS report_description,
            rr.created_at AS report_created_at,
            rr.updated_at AS report_updated_at,

            er.emergency_type,
            er.location,
            er.description AS emergency_description,
            er.priority,
            er.victim_type,
            er.victim_information,
            er.victim_count,
            er.contact_information,
            er.status AS emergency_status,
            er.created_at AS request_created_at,
            er.updated_at AS request_updated_at,
            er.volunteer_id,
            er.accepted_at,

            hs.name AS help_seeker_name,
            hs.email AS help_seeker_email,
            hs.phone AS help_seeker_phone,

            v.name AS volunteer_name,
            v.email AS volunteer_email,
            v.phone AS volunteer_phone,

            vp.address AS volunteer_address,
            vp.blood_group AS volunteer_blood_group,
            vp.experience AS volunteer_experience,
            vp.skills AS volunteer_skills,
            vp.emergency_contact AS volunteer_emergency_contact,
            vp.availability_status AS volunteer_availability,

            a.name AS admin_name,
            a.email AS admin_email

        FROM rescue_reports AS rr

        INNER JOIN emergency_requests AS er
            ON rr.emergency_request_id = er.id

        LEFT JOIN users AS hs
            ON er.help_seeker_id = hs.id
            AND hs.role = 'help_seeker'

        LEFT JOIN users AS v
            ON er.volunteer_id = v.id
            AND v.role = 'volunteer'

        LEFT JOIN volunteer_profiles AS vp
            ON er.volunteer_id = vp.user_id

        LEFT JOIN users AS a
            ON rr.admin_id = a.id
            AND a.role = 'admin'

        WHERE rr.id = ?

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