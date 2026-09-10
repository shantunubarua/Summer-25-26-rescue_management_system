<?php

require_once "models/RescueReportModel.php";


/*
|--------------------------------------------------------------------------
| ALLOWED RESCUE STATUSES
|--------------------------------------------------------------------------
*/

function isValidRescueReportStatus($status)
{
    $allowedStatuses = [
        'pending',
        'ongoing',
        'completed',
        'cancelled'
    ];

    return in_array(
        $status,
        $allowedStatuses,
        true
    );
}


/*
|--------------------------------------------------------------------------
| LOAD ALL RESCUE REPORTS
|--------------------------------------------------------------------------
*/

function loadAllRescueReports($conn)
{
    return getAllRescueReports($conn);
}


/*
|--------------------------------------------------------------------------
| UPDATE RESCUE REPORT STATUS
|--------------------------------------------------------------------------
*/

function handleUpdateRescueReportStatus($conn)
{
    $id =
        (int)($_POST['id'] ?? 0);

    $status =
        trim($_POST['rescue_status'] ?? '');


    if ($id <= 0) {
        return "Invalid rescue report ID.";
    }


    if (!isValidRescueReportStatus($status)) {
        return "Please select a valid rescue status.";
    }


    $report =
        getRescueReportById(
            $conn,
            $id
        );


    if (!$report) {
        return "Rescue report not found.";
    }


    $updated =
        updateRescueReportStatus(
            $conn,
            $id,
            $status
        );


    if (!$updated) {
        return "Failed to update rescue report status.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| CREATE RESCUE REPORT
|--------------------------------------------------------------------------
*/

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
    | CHECK REAL EMERGENCY REQUEST
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


    if (
        !isValidRescueReportStatus(
            $rescue_status
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


/*
|--------------------------------------------------------------------------
| EDIT RESCUE REPORT
|--------------------------------------------------------------------------
*/

function handleEditRescueReport(
    $conn,
    $report_id
) {

    $report_id =
        (int)$report_id;

    $rescue_status =
        trim($_POST['rescue_status'] ?? '');

    $description =
        trim($_POST['description'] ?? '');


    if ($report_id <= 0) {
        return "Invalid rescue report ID.";
    }


    $report =
        getRescueReportById(
            $conn,
            $report_id
        );


    if (!$report) {
        return "Rescue report not found.";
    }


    if (
        !isValidRescueReportStatus(
            $rescue_status
        )
    ) {
        return "Please select a valid rescue status.";
    }


    if ($description === '') {
        return "Please enter report description.";
    }


    $updated =
        updateRescueReport(
            $conn,
            $report_id,
            $rescue_status,
            $description
        );


    if (!$updated) {
        return "Failed to update rescue report.";
    }


    header(
        "Location: index.php?page=rescue-reports"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE RESCUE REPORT
|--------------------------------------------------------------------------
*/

function handleDeleteRescueReport($conn)
{
    $report_id =
        (int)($_POST['id'] ?? 0);


    if ($report_id <= 0) {

        die(
            "Invalid rescue report ID."
        );
    }


    $report =
        getRescueReportById(
            $conn,
            $report_id
        );


    if (!$report) {

        die(
            "Rescue report not found."
        );
    }


    $deleted =
        deleteRescueReport(
            $conn,
            $report_id
        );


    if (!$deleted) {

        die(
            "Failed to delete rescue report."
        );
    }


    header(
        "Location: index.php?page=rescue-reports"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| VIEW DETAILED RESCUE REPORT
|--------------------------------------------------------------------------
*/

function showDetailedRescueReport(
    $conn,
    $report_id
) {

    $report_id =
        (int)$report_id;


    if ($report_id <= 0) {

        die(
            "Invalid rescue report ID."
        );
    }


    $report =
        getDetailedRescueReportById(
            $conn,
            $report_id
        );


    if (!$report) {

        die(
            "Rescue report not found."
        );
    }


    require_once
        "views/admin/rescue_reports/view.php";
}


/*
|--------------------------------------------------------------------------
| CREATE PAGE DATA
|--------------------------------------------------------------------------
*/

function loadRescueReportCreatePageData($conn)
{
    return getEmergencyRequestsForRescueReport(
        $conn
    );
}