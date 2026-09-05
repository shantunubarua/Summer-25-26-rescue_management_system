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