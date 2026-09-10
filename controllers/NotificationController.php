<?php

require_once "models/NotificationModel.php";


/*
|--------------------------------------------------------------------------
| NOTIFICATION VALIDATION HELPERS
|--------------------------------------------------------------------------
*/

function isValidNotificationAlertType($alert_type)
{
    $allowed_types = [
        'normal',
        'important',
        'emergency'
    ];

    return in_array(
        $alert_type,
        $allowed_types,
        true
    );
}


function isValidNotificationAudience($target_audience)
{
    $allowed_audiences = [
        'all',
        'volunteer',
        'witness',
        'help_seeker'
    ];

    return in_array(
        $target_audience,
        $allowed_audiences,
        true
    );
}


function isValidNotificationStatus($status)
{
    $allowed_statuses = [
        'active',
        'inactive'
    ];

    return in_array(
        $status,
        $allowed_statuses,
        true
    );
}


/*
|--------------------------------------------------------------------------
| CREATE NOTIFICATION
|--------------------------------------------------------------------------
*/

function handleCreateNotification($conn)
{
    /*
    |--------------------------------------------------------------------------
    | Get Form Data
    |--------------------------------------------------------------------------
    */

    $title =
        trim($_POST['title'] ?? '');

    $message =
        trim($_POST['message'] ?? '');

    $alert_type =
        trim($_POST['alert_type'] ?? 'normal');

    $target_audience =
        trim($_POST['target_audience'] ?? 'all');

    $status =
        trim($_POST['status'] ?? 'active');


    /*
    |--------------------------------------------------------------------------
    | PHP Validation
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        return "Notification title is required.";
    }


    if ($message === '') {

        return "Notification message is required.";
    }


    if (
        !isValidNotificationAlertType(
            $alert_type
        )
    ) {

        return "Invalid alert type.";
    }


    if (
        !isValidNotificationAudience(
            $target_audience
        )
    ) {

        return "Invalid target audience.";
    }


    if (
        !isValidNotificationStatus(
            $status
        )
    ) {

        return "Invalid notification status.";
    }


    /*
    |--------------------------------------------------------------------------
    | Get Logged-in Admin ID
    |--------------------------------------------------------------------------
    */

    $created_by =
        (int)($_SESSION['user']['id'] ?? 0);


    if ($created_by <= 0) {

        return "Invalid admin account.";
    }


    /*
    |--------------------------------------------------------------------------
    | Create Notification
    |--------------------------------------------------------------------------
    */

    $created =
        createNotification(
            $conn,
            $created_by,
            $title,
            $message,
            $alert_type,
            $target_audience,
            $status
        );


    if ($created) {

        header(
            "Location: index.php?page=notifications"
        );

        exit;
    }


    return "Failed to create notification.";
}


/*
|--------------------------------------------------------------------------
| UPDATE NOTIFICATION
|--------------------------------------------------------------------------
*/

function handleUpdateNotification(
    $conn,
    $id
) {

    /*
    |--------------------------------------------------------------------------
    | Validate Notification ID
    |--------------------------------------------------------------------------
    */

    $id = (int)$id;


    if ($id <= 0) {

        return "Invalid notification ID.";
    }


    /*
    |--------------------------------------------------------------------------
    | Get Form Data
    |--------------------------------------------------------------------------
    */

    $title =
        trim($_POST['title'] ?? '');

    $message =
        trim($_POST['message'] ?? '');

    $alert_type =
        trim($_POST['alert_type'] ?? '');

    $target_audience =
        trim($_POST['target_audience'] ?? '');

    $status =
        trim($_POST['status'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | PHP Validation
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        return "Notification title is required.";
    }


    if ($message === '') {

        return "Notification message is required.";
    }


    if (
        !isValidNotificationAlertType(
            $alert_type
        )
    ) {

        return "Invalid alert type.";
    }


    if (
        !isValidNotificationAudience(
            $target_audience
        )
    ) {

        return "Invalid target audience.";
    }


    if (
        !isValidNotificationStatus(
            $status
        )
    ) {

        return "Invalid notification status.";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Notification
    |--------------------------------------------------------------------------
    */

    $updated =
        updateNotification(
            $conn,
            $id,
            $title,
            $message,
            $alert_type,
            $target_audience,
            $status
        );


    if ($updated) {

        header(
            "Location: index.php?page=notifications"
        );

        exit;
    }


    return "Failed to update notification.";
}


/*
|--------------------------------------------------------------------------
| DELETE NOTIFICATION
|--------------------------------------------------------------------------
*/

function handleDeleteNotification(
    $conn,
    $id
) {

    /*
    |--------------------------------------------------------------------------
    | Validate Notification ID
    |--------------------------------------------------------------------------
    */

    $id = (int)$id;


    if ($id <= 0) {

        return "Invalid notification ID.";
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Notification
    |--------------------------------------------------------------------------
    */

    $deleted =
        deleteNotification(
            $conn,
            $id
        );


    if ($deleted) {

        header(
            "Location: index.php?page=notifications"
        );

        exit;
    }


    return "Failed to delete notification.";
}


/*
|--------------------------------------------------------------------------
| LOAD ACTIVE NOTIFICATIONS FOR ROLE DASHBOARD
|--------------------------------------------------------------------------
*/

function loadRoleDashboardNotifications(
    $conn,
    $role
) {

    /*
    |--------------------------------------------------------------------------
    | Validate Role
    |--------------------------------------------------------------------------
    */

    $role =
        trim($role);


    $allowed_roles = [
        'volunteer',
        'witness',
        'help_seeker'
    ];


    if (
        !in_array(
            $role,
            $allowed_roles,
            true
        )
    ) {

        return [];
    }


    /*
    |--------------------------------------------------------------------------
    | Load Notifications
    |--------------------------------------------------------------------------
    */

    return getActiveNotificationsForRole(
        $conn,
        $role
    );
}
/*
|--------------------------------------------------------------------------
| HANDLE NOTIFICATION SEARCH
|--------------------------------------------------------------------------
*/

function handleNotificationSearch($conn)
{
    header(
        'Content-Type: application/json; charset=UTF-8'
    );

    $keyword =
        trim(
            $_GET['q'] ?? ''
        );

    $notifications =
        searchNotifications(
            $conn,
            $keyword
        );

    echo json_encode([
        'success' => true,
        'count' => count($notifications),
        'data' => $notifications
    ]);

    exit;
}