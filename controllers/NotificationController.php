<?php

require_once "models/NotificationModel.php";


/*
|--------------------------------------------------------------------------
| CREATE NOTIFICATION
|--------------------------------------------------------------------------
*/

function handleCreateNotification($conn)
{
    $title =
        trim($_POST['title'] ?? '');

    $message =
        trim($_POST['message'] ?? '');

    $alert_type =
        $_POST['alert_type'] ?? 'normal';

    $target_audience =
        $_POST['target_audience'] ?? 'all';

    $status =
        $_POST['status'] ?? 'active';


    /*
    |--------------------------------------------------------------------------
    | PHP VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $title === '' ||
        $message === ''
    ) {
        return "Title and message are required.";
    }


    $allowed_types = [
        'normal',
        'important',
        'emergency'
    ];


    $allowed_audiences = [
        'all',
        'volunteer',
        'witness',
        'help_seeker'
    ];


    $allowed_statuses = [
        'active',
        'inactive'
    ];


    if (
        !in_array(
            $alert_type,
            $allowed_types,
            true
        )
    ) {
        return "Invalid alert type.";
    }


    if (
        !in_array(
            $target_audience,
            $allowed_audiences,
            true
        )
    ) {
        return "Invalid target audience.";
    }


    if (
        !in_array(
            $status,
            $allowed_statuses,
            true
        )
    ) {
        return "Invalid notification status.";
    }


    $created_by =
        (int)($_SESSION['user']['id'] ?? 0);


    if ($created_by <= 0) {
        return "Invalid admin account.";
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    if (
        createNotification(
            $conn,
            $created_by,
            $title,
            $message,
            $alert_type,
            $target_audience,
            $status
        )
    ) {

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
    $id = (int)$id;


    if ($id <= 0) {
        return "Invalid notification ID.";
    }


    $title =
        trim($_POST['title'] ?? '');

    $message =
        trim($_POST['message'] ?? '');

    $alert_type =
        $_POST['alert_type'] ?? '';

    $target_audience =
        $_POST['target_audience'] ?? '';

    $status =
        $_POST['status'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | PHP VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $title === '' ||
        $message === ''
    ) {
        return "Title and message are required.";
    }


    $allowed_types = [
        'normal',
        'important',
        'emergency'
    ];


    $allowed_audiences = [
        'all',
        'volunteer',
        'witness',
        'help_seeker'
    ];


    $allowed_statuses = [
        'active',
        'inactive'
    ];


    if (
        !in_array(
            $alert_type,
            $allowed_types,
            true
        )
    ) {
        return "Invalid alert type.";
    }


    if (
        !in_array(
            $target_audience,
            $allowed_audiences,
            true
        )
    ) {
        return "Invalid target audience.";
    }


    if (
        !in_array(
            $status,
            $allowed_statuses,
            true
        )
    ) {
        return "Invalid notification status.";
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    if (
        updateNotification(
            $conn,
            $id,
            $title,
            $message,
            $alert_type,
            $target_audience,
            $status
        )
    ) {

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
    $id = (int)$id;


    if ($id <= 0) {
        return "Invalid notification ID.";
    }


    if (
        deleteNotification(
            $conn,
            $id
        )
    ) {

        header(
            "Location: index.php?page=notifications"
        );

        exit;
    }


    return "Failed to delete notification.";
}