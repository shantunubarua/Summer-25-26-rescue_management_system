<?php

function createNotification($conn, $created_by, $title, $message, $alert_type, $status)
{
    $sql = "INSERT INTO notifications
            (created_by, title, message, alert_type, status)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "issss",
        $created_by,
        $title,
        $message,
        $alert_type,
        $status
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function getAllNotifications($conn)
{
    $sql = "SELECT
                notifications.*,
                users.name AS admin_name
            FROM notifications
            INNER JOIN users
                ON notifications.created_by = users.id
            ORDER BY notifications.id DESC";

    $result = mysqli_query($conn, $sql);

    $notifications = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }

    return $notifications;
}

function getNotificationById($conn, $id)
{
    $sql = "SELECT *
            FROM notifications
            WHERE id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $notification = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $notification;
}


function updateNotification(
    $conn,
    $id,
    $title,
    $message,
    $alert_type,
    $status
) {
    $sql = "UPDATE notifications
            SET title = ?,
                message = ?,
                alert_type = ?,
                status = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssi",
        $title,
        $message,
        $alert_type,
        $status,
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function deleteNotification($conn, $id)
{
    $sql = "DELETE FROM notifications
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}