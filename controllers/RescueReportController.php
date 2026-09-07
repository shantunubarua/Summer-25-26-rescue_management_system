<?php

require_once "models/RescueReportModel.php";

function loadAllRescueReports($conn)
{
    return getAllRescueReports($conn);
}

function handleUpdateRescueReportStatus($conn)
{
    $id = isset($_POST['id'])
        ? (int)$_POST['id']
        : 0;

    $status = trim($_POST['rescue_status'] ?? '');

    if ($id <= 0) {
        return "Invalid rescue report ID.";
    }

    if (
        !updateRescueReportStatus(
            $conn,
            $id,
            $status
        )
    ) {
        return "Failed to update rescue report status.";
    }

    return '';
}
function handleCreateRescueReport($conn)
{
    $emergency_request_id =
        (int)($_POST['emergency_request_id'] ?? 0);

    $rescue_status =
        trim($_POST['rescue_status'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    $admin_id =
        (int)($_SESSION['user']['id'] ?? 0);


    if ($admin_id <= 0) {
        return "Invalid admin account.";
    }


    if ($emergency_request_id <= 0) {
        return "Please select a valid emergency request.";
    }


    /*
    |--------------------------------------------------------------------------
    | PHP VALIDATION - CHECK REAL EMERGENCY REQUEST
    |--------------------------------------------------------------------------
    */

    if (
        !emergencyRequestExistsForRescueReport(
            $conn,
            $emergency_request_id
        )
    ) {
        return "Selected emergency request does not exist.";
    }


    $allowedStatuses = [
        'pending',
        'ongoing',
        'completed',
        'cancelled'
    ];


    if (
        $rescue_status === '' ||
        !in_array(
            $rescue_status,
            $allowedStatuses,
            true
        )
    ) {
        return "Please select a valid rescue status.";
    }


    if ($description === '') {
        return "Report description is required.";
    }


    $created =
        createRescueReport(
            $conn,
            $emergency_request_id,
            $admin_id,
            $rescue_status,
            $description
        );


    if (!$created) {
        return "Failed to create rescue report.";
    }


    header(
        "Location: index.php?page=rescue-reports"
    );

    exit;
}
function handleEditRescueReport($conn, $report_id)
{
    require_once "models/RescueReportModel.php";

    $rescue_status =
        trim($_POST['rescue_status'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    if ($report_id <= 0) {
        return "Invalid report ID.";
    }

    if ($rescue_status === '') {
        return "Please select rescue status.";
    }

    if ($description === '') {
        return "Please enter report description.";
    }

    $updated = updateRescueReport(
        $conn,
        $report_id,
        $rescue_status,
        $description
    );

    if (!$updated) {
        return "Failed to update rescue report.";
    }

    header("Location: index.php?page=rescue-reports");
    exit;
}
function handleDeleteRescueReport($conn)
{
    require_once "models/RescueReportModel.php";

    $report_id = (int)($_POST['id'] ?? 0);

    if ($report_id <= 0) {
        die("Invalid rescue report ID.");
    }

    $deleted = deleteRescueReport(
        $conn,
        $report_id
    );

    if (!$deleted) {
        die("Failed to delete rescue report.");
    }

    header("Location: index.php?page=rescue-reports");
    exit;
}
/*
|--------------------------------------------------------------------------
| ADMIN - VIEW DETAILED RESCUE REPORT
|--------------------------------------------------------------------------
*/

function showDetailedRescueReport(
    $conn,
    $report_id
) {

    $report_id = (int)$report_id;


    if ($report_id <= 0) {

        die("Invalid rescue report ID.");
    }


    $report = getDetailedRescueReportById(
        $conn,
        $report_id
    );


    if (!$report) {

        die("Rescue report not found.");
    }


    require_once "views/admin/rescue_reports/view.php";
}
function loadRescueReportCreatePageData($conn)
{
    return getEmergencyRequestsForRescueReport($conn);
}