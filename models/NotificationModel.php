<?php

/*
|--------------------------------------------------------------------------
| CREATE NOTIFICATION
|--------------------------------------------------------------------------
*/

function createNotification(
    $conn,
    $created_by,
    $title,
    $message,
    $alert_type,
    $target_audience,
    $status
) {
    $sql = "INSERT INTO notifications
            (
                created_by,
                title,
                message,
                alert_type,
                target_audience,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isssss",
        $created_by,
        $title,
        $message,
        $alert_type,
        $target_audience,
        $status
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| GET ALL NOTIFICATIONS
|--------------------------------------------------------------------------
*/

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

    if (!$result) {
        return [];
    }

    $notifications = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }

    return $notifications;
}


/*
|--------------------------------------------------------------------------
| GET SINGLE NOTIFICATION
|--------------------------------------------------------------------------
*/

function getNotificationById($conn, $id)
{
    $sql = "SELECT *
            FROM notifications
            WHERE id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $notification =
        mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $notification ?: null;
}


/*
|--------------------------------------------------------------------------
| UPDATE NOTIFICATION
|--------------------------------------------------------------------------
*/

function updateNotification(
    $conn,
    $id,
    $title,
    $message,
    $alert_type,
    $target_audience,
    $status
) {
    $sql = "UPDATE notifications

            SET
                title = ?,
                message = ?,
                alert_type = ?,
                target_audience = ?,
                status = ?

            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssssi",
        $title,
        $message,
        $alert_type,
        $target_audience,
        $status,
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| DELETE NOTIFICATION
|--------------------------------------------------------------------------
*/

function deleteNotification($conn, $id)
{
    $sql = "DELETE FROM notifications
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
/*
|--------------------------------------------------------------------------
| GET ACTIVE NOTIFICATIONS FOR A USER ROLE
|--------------------------------------------------------------------------
*/

function getActiveNotificationsForRole(
    $conn,
    $role
) {
    $sql = "
        SELECT
            id,
            title,
            message,
            alert_type,
            target_audience,
            status,
            created_at

        FROM notifications

        WHERE status = 'active'

        AND (
            target_audience = 'all'
            OR target_audience = ?
        )

        ORDER BY
            CASE alert_type
                WHEN 'emergency' THEN 1
                WHEN 'important' THEN 2
                WHEN 'normal' THEN 3
                ELSE 4
            END,
            id DESC
    ";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $role
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $notifications = [];

    while (
        $result &&
        $row = mysqli_fetch_assoc($result)
    ) {
        $notifications[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $notifications;
}
/*
|--------------------------------------------------------------------------
| SEARCH NOTIFICATIONS
|--------------------------------------------------------------------------
*/

function searchNotifications(
    $conn,
    $keyword
) {
    $keyword = trim($keyword);

    $search =
        '%' . $keyword . '%';

    $sql = "SELECT
                notifications.*,
                users.name AS admin_name

            FROM notifications

            INNER JOIN users
                ON notifications.created_by = users.id

            WHERE
                notifications.title LIKE ?
                OR notifications.message LIKE ?
                OR notifications.alert_type LIKE ?
                OR notifications.target_audience LIKE ?
                OR notifications.status LIKE ?
                OR users.name LIKE ?

            ORDER BY notifications.id DESC";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $search,
        $search,
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $notifications = [];

    while (
        $result &&
        $row = mysqli_fetch_assoc($result)
    ) {
        $notifications[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $notifications;
}