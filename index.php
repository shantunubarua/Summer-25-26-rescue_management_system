<?php

require_once "config/database.php";
require_once "helpers/auth.php";

$page = $_GET['page'] ?? 'login';


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

if ($page === 'login') {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        require_once "controllers/AuthController.php";

        $error = loginUser();
    }

    require_once "views/auth/login.php";


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

} elseif ($page === 'admin-dashboard') {

    requireAdmin();

    require_once "models/AdminDashboardModel.php";

    $dashboardCounts = getAdminDashboardCounts($conn);

    require_once "views/admin/dashboard.php";


/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'logout') {

    logoutUser();

    header("Location: index.php?page=login");
    exit;


/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'notifications') {

    requireAdmin();

    require_once "models/NotificationModel.php";

    $notifications = getAllNotifications($conn);

    require_once "views/admin/notifications/index.php";


/*
|--------------------------------------------------------------------------
| FEEDBACK
|--------------------------------------------------------------------------
*/

} elseif ($page === 'feedback') {

    requireAdmin();

    require_once "controllers/FeedbackController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleUpdateFeedbackStatus($conn);
    }

    $feedback = loadAllFeedback($conn);

    require_once "views/admin/feedback/index.php";


/*
|--------------------------------------------------------------------------
| FEEDBACK DELETE
|--------------------------------------------------------------------------
*/

} elseif ($page === 'feedback-delete') {

    requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Invalid request method.");
    }

    require_once "controllers/FeedbackController.php";

    handleDeleteFeedback($conn);


/*
|--------------------------------------------------------------------------
| RESCUE REPORTS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'rescue-reports') {

    requireAdmin();

    require_once "controllers/RescueReportController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleUpdateRescueReportStatus($conn);
    }

    $reports = loadAllRescueReports($conn);

    require_once "views/admin/rescue_reports/index.php";


/*
|--------------------------------------------------------------------------
| CREATE RESCUE REPORT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'rescue-report-create') {

    requireAdmin();

    require_once "controllers/RescueReportController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateRescueReport($conn);
    }

    require_once "views/admin/rescue_reports/create.php";


/*
|--------------------------------------------------------------------------
| EDIT RESCUE REPORT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'rescue-report-edit') {

    requireAdmin();

    require_once "models/RescueReportModel.php";
    require_once "controllers/RescueReportController.php";

    $id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    if ($id <= 0) {
        die("Invalid rescue report ID.");
    }

    $report = getRescueReportById(
        $conn,
        $id
    );

    if (!$report) {
        die("Rescue report not found.");
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleEditRescueReport(
            $conn,
            $id
        );

        if ($error !== '') {

            $report['rescue_status'] =
                $_POST['rescue_status']
                ?? $report['rescue_status'];

            $report['description'] =
                $_POST['description']
                ?? $report['description'];
        }
    }

    require_once "views/admin/rescue_reports/edit.php";


/*
|--------------------------------------------------------------------------
| DELETE RESCUE REPORT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'rescue-report-delete') {

    requireAdmin();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Invalid request method.");
    }

    require_once "controllers/RescueReportController.php";

    handleDeleteRescueReport($conn);


/*
|--------------------------------------------------------------------------
| CREATE NOTIFICATION
|--------------------------------------------------------------------------
*/

} elseif ($page === 'notification-create') {

    requireAdmin();

    require_once "controllers/NotificationController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateNotification($conn);
    }

    require_once "views/admin/notifications/create.php";


/*
|--------------------------------------------------------------------------
| EDIT NOTIFICATION
|--------------------------------------------------------------------------
*/

} elseif ($page === 'notification-edit') {

    requireAdmin();

    require_once "models/NotificationModel.php";
    require_once "controllers/NotificationController.php";

    $id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    if ($id <= 0) {
        die("Invalid notification ID.");
    }

    $notification = getNotificationById(
        $conn,
        $id
    );

    if (!$notification) {
        die("Notification not found.");
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleUpdateNotification(
            $conn,
            $id
        );

        if ($error !== '') {

            $notification['title'] =
                $_POST['title']
                ?? $notification['title'];

            $notification['message'] =
                $_POST['message']
                ?? $notification['message'];

            $notification['alert_type'] =
                $_POST['alert_type']
                ?? $notification['alert_type'];

            $notification['status'] =
                $_POST['status']
                ?? $notification['status'];
        }
    }

    require_once "views/admin/notifications/edit.php";


/*
|--------------------------------------------------------------------------
| DELETE NOTIFICATION
|--------------------------------------------------------------------------
*/

} elseif ($page === 'notification-delete') {

    requireAdmin();

    require_once "models/NotificationModel.php";
    require_once "controllers/NotificationController.php";

    $id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    if ($id <= 0) {
        die("Invalid notification ID.");
    }

    handleDeleteNotification(
        $conn,
        $id
    );


/*
|--------------------------------------------------------------------------
| WITNESS DASHBOARD
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-dashboard') {

    requireWitness();

    require_once "models/WitnessDashboardModel.php";


    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);


    if ($witness_id <= 0) {

        die("Invalid witness account.");
    }


    /*
     * Dashboard Overview
     */

    $dashboardCounts =
        getWitnessDashboardCounts(
            $conn,
            $witness_id
        );


    /*
     * Recent Reports
     */

    $recentReports =
        getRecentWitnessReports(
            $conn,
            $witness_id,
            5
        );


    /*
     * Recent Donations
     */

    $recentDonations =
        getRecentWitnessDonations(
            $conn,
            $witness_id,
            5
        );


    require_once "views/witness/dashboard.php";



/*
|--------------------------------------------------------------------------
| WITNESS CREATE DONATION
|--------------------------------------------------------------------------
*/

} elseif ($page === 'donation-create') {

    requireWitness();

    require_once "controllers/DonationController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateDonation($conn);
    }

    require_once "views/witness/create_donation.php";


/*
|--------------------------------------------------------------------------
| WITNESS DONATION PAYMENT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'donation-payment') {

    requireWitness();

    require_once "controllers/DonationController.php";

    $error = '';

    /*
     * Payment page should only open
     * when a pending donation exists.
     */

    if (
        empty($_SESSION['pending_donation']) ||
        !is_array($_SESSION['pending_donation'])
    ) {

        header(
            "Location: index.php?page=donation-create"
        );

        exit;
    }


    /*
     * Confirm Payment
     */

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleConfirmDonation($conn);
    }


    require_once "views/witness/donation_payment.php";


/*
|--------------------------------------------------------------------------
| WITNESS DONATIONS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'donations') {

    requireWitness();

    require_once "models/DonationModel.php";

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($witness_id <= 0) {

        die("Invalid witness account.");
    }


    $donations = getWitnessDonations(
        $conn,
        $witness_id
    );


    require_once "views/witness/donations.php";

    /*
|--------------------------------------------------------------------------
| VOLUNTEER DASHBOARD
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-dashboard') {

    requireVolunteer();

    require_once "views/volunteer/dashboard.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER ACTIVITIES
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-activities') {

    requireVolunteer();

    require_once "views/volunteer/activities.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER UPDATE RESCUE STATUS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-update-status') {

    requireVolunteer();

    require_once "models/VolunteerModel.php";

    $request_id =
        (int)($_POST['request_id'] ?? 0);

    $status =
        $_POST['status'] ?? '';

    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if (
        $request_id <= 0 ||
        $volunteer_id <= 0
    ) {
        die("Invalid request.");
    }

    updateRescueActivityStatus(
        $conn,
        $request_id,
        $volunteer_id,
        $status
    );

    header(
        "Location: index.php?page=volunteer-activities"
    );

    exit;


/*
|--------------------------------------------------------------------------
| VOLUNTEER AVAILABILITY
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-availability') {

    requireVolunteer();

    require_once "views/volunteer/availability.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER RESOURCE REQUEST FORM
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-resource-request') {

    requireVolunteer();

    require_once "controllers/ResourceRequestController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateResourceRequest($conn);
    }

    require_once "views/volunteer/resource_request.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER MY RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-resource-requests') {

    requireVolunteer();

    require_once "models/ResourceRequestModel.php";

    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($volunteer_id <= 0) {
        die("Invalid volunteer account.");
    }

    $requests = getVolunteerResourceRequests(
        $conn,
        $volunteer_id
    );

    require_once "views/volunteer/resource_request.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER ACCEPT EMERGENCY REQUEST
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-accept-request') {

    requireVolunteer();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Invalid request method.");
    }

    require_once "models/VolunteerModel.php";

    $request_id =
        (int)($_POST['request_id'] ?? 0);

    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if (
        $request_id <= 0 ||
        $volunteer_id <= 0
    ) {
        die("Invalid request.");
    }

    $accepted = acceptEmergencyRequest(
        $conn,
        $request_id,
        $volunteer_id
    );

    if (!$accepted) {

        die(
            "This emergency request is no longer available."
        );
    }

    header(
        "Location: index.php?page=volunteer-activities"
    );

    exit;


/*
|--------------------------------------------------------------------------
| VOLUNTEER EMERGENCY REQUESTS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-emergency-requests') {

    requireVolunteer();

    require_once "views/volunteer/emergency_requests.php";


/*
|--------------------------------------------------------------------------
| VOLUNTEER PROFILE
|--------------------------------------------------------------------------
*/

} elseif ($page === 'volunteer-profile') {

    requireVolunteer();

    require_once "views/volunteer/profile.php";


/*
|--------------------------------------------------------------------------
| HELP SEEKER DASHBOARD
|--------------------------------------------------------------------------
*/

} elseif ($page === 'helpseeker-dashboard') {

    requireHelpSeeker();

    require_once "views/helpseeker/dashboard.php";


/*
|--------------------------------------------------------------------------
| HELP SEEKER CREATE EMERGENCY REQUEST
|--------------------------------------------------------------------------
*/

} elseif ($page === 'helpseeker-request-create') {

    requireHelpSeeker();

    require_once "controllers/HelpSeekerController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateEmergencyRequest($conn);
    }

    require_once "views/helpseeker/create_request.php";


/*
|--------------------------------------------------------------------------
| HELP SEEKER REQUESTS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'helpseeker-requests') {

    requireHelpSeeker();

    require_once "models/HelpSeekerModel.php";

    $help_seeker_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($help_seeker_id <= 0) {
        die("Invalid help seeker account.");
    }

    $requests = getHelpSeekerRequests(
        $conn,
        $help_seeker_id
    );

    require_once "views/helpseeker/requests.php";


/*
|--------------------------------------------------------------------------
| HELP SEEKER REQUEST VIEW
|--------------------------------------------------------------------------
*/

} elseif ($page === 'helpseeker-request-view') {

    requireHelpSeeker();

    require_once "models/HelpSeekerModel.php";

    $request_id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    $help_seeker_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($request_id <= 0) {
        die("Invalid emergency request ID.");
    }

    if ($help_seeker_id <= 0) {
        die("Invalid help seeker account.");
    }

    $request = getHelpSeekerRequestById(
        $conn,
        $request_id,
        $help_seeker_id
    );

    if (!$request) {
        die("Emergency request not found.");
    }

    require_once "views/helpseeker/view_request.php";


/*
|--------------------------------------------------------------------------
| HELP SEEKER FEEDBACK
|--------------------------------------------------------------------------
*/

} elseif ($page === 'helpseeker-feedback') {

    requireHelpSeeker();

    require_once "models/HelpSeekerModel.php";
    require_once "controllers/FeedbackController.php";

    $request_id = isset($_GET['id'])
        ? (int)$_GET['id']
        : (int)($_POST['rescue_request_id'] ?? 0);

    $help_seeker_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($request_id <= 0) {
        die("Invalid emergency request ID.");
    }

    if ($help_seeker_id <= 0) {
        die("Invalid help seeker account.");
    }

    $request = getHelpSeekerRequestById(
        $conn,
        $request_id,
        $help_seeker_id
    );

    if (!$request) {
        die("Emergency request not found.");
    }

    if (($request['status'] ?? '') !== 'completed') {

        die(
            "Feedback can only be submitted after the rescue is completed."
        );
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateFeedback($conn);
    }

    require_once "views/helpseeker/feedback.php";


/*
|--------------------------------------------------------------------------
| WITNESS CREATE REPORT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-report-create') {

    requireWitness();

    require_once "controllers/WitnessController.php";

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleCreateWitnessReport($conn);
    }

    require_once "views/witness/create_report.php";


/*
|--------------------------------------------------------------------------
| WITNESS REPORTS
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-reports') {

    requireWitness();

    require_once "models/WitnessModel.php";

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($witness_id <= 0) {
        die("Invalid witness account.");
    }

    $reports = getWitnessReports(
        $conn,
        $witness_id
    );

    require_once "views/witness/reports.php";


/*
|--------------------------------------------------------------------------
| WITNESS REPORT VIEW
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-report-view') {

    requireWitness();

    require_once "models/WitnessModel.php";

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);

    $report_id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    if ($witness_id <= 0) {
        die("Invalid witness account.");
    }

    if ($report_id <= 0) {
        die("Invalid report ID.");
    }

    $report = getWitnessReportById(
        $conn,
        $report_id,
        $witness_id
    );

    if (!$report) {
        die("Report not found.");
    }

    require_once "views/witness/view_report.php";


/*
|--------------------------------------------------------------------------
| WITNESS REPORT EDIT
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-report-edit') {

    requireWitness();

    require_once "models/WitnessModel.php";
    require_once "controllers/WitnessController.php";

    $id = isset($_GET['id'])
        ? (int)$_GET['id']
        : 0;

    if ($id <= 0) {
        die("Invalid report ID.");
    }

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);

    if ($witness_id <= 0) {
        die("Invalid witness account.");
    }

    $report = getWitnessReportById(
        $conn,
        $id,
        $witness_id
    );

    if (!$report) {
        die("Report not found.");
    }

    $error = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $error = handleEditWitnessReport(
            $conn,
            $id,
            $witness_id
        );

        if ($error === '') {

            header(
                "Location: index.php?page=witness-reports"
            );

            exit;
        }

        $report['title'] =
            $_POST['title']
            ?? $report['title'];

        $report['description'] =
            $_POST['description']
            ?? $report['description'];

        $report['damage_level'] =
            $_POST['damage_level']
            ?? $report['damage_level'];

        $report['incident_type'] =
            $_POST['incident_type']
            ?? $report['incident_type'];

        $report['location'] =
            $_POST['location']
            ?? $report['location'];

        $report['incident_date'] =
            $_POST['incident_date']
            ?? $report['incident_date'];
    }

    require_once "views/witness/edit_report.php";


/*
|--------------------------------------------------------------------------
| WITNESS REPORT DELETE
|--------------------------------------------------------------------------
*/

} elseif ($page === 'witness-report-delete') {

    requireWitness();

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        die("Invalid request method.");
    }

    require_once "models/WitnessModel.php";

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);

    $report_id =
        (int)($_POST['id'] ?? 0);

    if ($witness_id <= 0) {
        die("Invalid witness account.");
    }

    if ($report_id <= 0) {
        die("Invalid report ID.");
    }

    $deleted = deleteWitnessReport(
        $conn,
        $report_id,
        $witness_id
    );

    if (!$deleted) {
        die("Failed to delete report.");
    }

    header(
        "Location: index.php?page=witness-reports"
    );

    exit;


/*
|--------------------------------------------------------------------------
| PAGE NOT FOUND
|--------------------------------------------------------------------------
*/

} else {

    http_response_code(404);

    echo "Page not found.";
}

?>