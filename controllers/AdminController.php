<?php

require_once "models/AdminDashboardModel.php";
require_once "models/WitnessModel.php";


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

function showAdminDashboard($conn)
{
    $dashboardCounts = getAdminDashboardCounts($conn);

    require_once "views/admin/dashboard.php";
}
/*
|--------------------------------------------------------------------------
| ADMIN - WITNESS REPORTS LIST
|--------------------------------------------------------------------------
*/

function showAdminWitnessReports($conn)
{
    $reports = getAllWitnessReportsForAdmin($conn);

    require_once "views/admin/witness_reports/index.php";
}


/*
|--------------------------------------------------------------------------
| ADMIN - SINGLE WITNESS REPORT
|--------------------------------------------------------------------------
*/

function showAdminWitnessReport(
    $conn,
    $report_id
) {

    $report_id = (int)$report_id;


    if ($report_id <= 0) {

        die("Invalid witness report ID.");
    }


    $report = getWitnessReportForAdminById(
        $conn,
        $report_id
    );


    if (!$report) {

        die("Witness report not found.");
    }


    require_once "views/admin/witness_reports/view.php";
}


/*
|--------------------------------------------------------------------------
| ADMIN - UPDATE WITNESS REPORT STATUS
|--------------------------------------------------------------------------
*/

function handleAdminWitnessReportStatus(
    $conn,
    $report_id
) {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        return "Invalid request method.";
    }


    $report_id = (int)$report_id;

    $status = trim(
        $_POST['status'] ?? ''
    );


    if ($report_id <= 0) {

        return "Invalid witness report ID.";
    }


    $allowedStatuses = [
        'pending',
        'reviewed',
        'approved',
        'rejected'
    ];


    /*
    |--------------------------------------------------------------------------
    | PHP SERVER-SIDE VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $status === '' ||
        !in_array(
            $status,
            $allowedStatuses,
            true
        )
    ) {

        return "Please select a valid report status.";
    }


    $report =
        getWitnessReportForAdminById(
            $conn,
            $report_id
        );


    if (!$report) {

        return "Witness report not found.";
    }


    $updated =
        updateWitnessReportStatusByAdmin(
            $conn,
            $report_id,
            $status
        );


    if (!$updated) {

        return "Failed to update report status.";
    }


    return '';
}