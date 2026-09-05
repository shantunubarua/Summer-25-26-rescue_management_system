<?php

require_once "models/NotificationModel.php";

function handleCreateNotification($conn)
{
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $alert_type = $_POST['alert_type'] ?? 'normal';
    $status = $_POST['status'] ?? 'active';

    if ($title === '' || $message === '') {
        return "Title and message are required.";
    }

    $allowed_types = ['normal', 'important', 'emergency'];
    $allowed_statuses = ['active', 'inactive'];

    if (!in_array($alert_type, $allowed_types)) {
        return "Invalid alert type.";
    }

    if (!in_array($status, $allowed_statuses)) {
        return "Invalid notification status.";
    }

    $created_by = $_SESSION['user']['id'];

    if (
        createNotification(
            $conn,
            $created_by,
            $title,
            $message,
            $alert_type,
            $status
        )
    ) {
        header("Location: index.php?page=notifications");
        exit;
    }

    return "Failed to create notification.";
}
function handleUpdateNotification($conn, $id)
{
    $title = trim($_POST['title'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $alert_type = $_POST['alert_type'] ?? '';
    $status = $_POST['status'] ?? '';

    if ($title === '' || $message === '') {
        return "Title and message are required.";
    }

    $allowed_types = [
        'normal',
        'important',
        'emergency'
    ];

    $allowed_statuses = [
        'active',
        'inactive'
    ];

    if (!in_array($alert_type, $allowed_types)) {
        return "Invalid alert type.";
    }

    if (!in_array($status, $allowed_statuses)) {
        return "Invalid notification status.";
    }

    if (
        updateNotification(
            $conn,
            $id,
            $title,
            $message,
            $alert_type,
            $status
        )
    ) {
        header("Location: index.php?page=notifications");
        exit;
    }

    return "Failed to update notification.";
}


function handleDeleteNotification($conn, $id)
{
    if (deleteNotification($conn, $id)) {
        header("Location: index.php?page=notifications");
        exit;
    }

    return "Failed to delete notification.";
}