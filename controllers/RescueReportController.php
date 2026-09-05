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
    require_once "models/RescueReportModel.php";

    $emergency_request_id =
        (int)($_POST['emergency_request_id'] ?? 0);

    $rescue_status =
        trim($_POST['rescue_status'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    $admin_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($emergency_request_id <= 0) {
        return "Please enter a valid emergency request ID.";
    }

    if ($rescue_status === '') {
        return "Please select rescue status.";
    }

    if ($description === '') {
        return "Please enter report description.";
    }

    if ($admin_id <= 0) {
        return "Invalid admin account.";
    }

    $created = createRescueReport(
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