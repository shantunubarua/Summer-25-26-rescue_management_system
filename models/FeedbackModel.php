<?php

function getAllFeedback($conn)
{
    $sql = "SELECT
                f.id,
                f.help_seeker_id,
                f.rescue_request_id,
                f.message,
                f.status,
                f.created_at,
                f.updated_at,
                u.name AS help_seeker_name
            FROM feedback f
            INNER JOIN users u
                ON f.help_seeker_id = u.id
            ORDER BY f.id DESC";

    $result = mysqli_query($conn, $sql);

    $feedback = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $feedback[] = $row;
    }

    return $feedback;
}


function getFeedbackById($conn, $id)
{
    $sql = "SELECT
                f.id,
                f.help_seeker_id,
                f.rescue_request_id,
                f.message,
                f.status,
                f.created_at,
                f.updated_at,
                u.name AS help_seeker_name
            FROM feedback f
            INNER JOIN users u
                ON f.help_seeker_id = u.id
            WHERE f.id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $feedback = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $feedback;
}
function updateFeedbackStatus($conn, $id, $status)
{
    $allowed_statuses = [
        'pending',
        'reviewed',
        'resolved'
    ];

    if (!in_array($status, $allowed_statuses, true)) {
        return false;
    }

    $sql = "UPDATE feedback
            SET status = ?
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status,
        $id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function deleteFeedback($conn, $feedback_id)
{
    $sql = "DELETE FROM feedback
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $feedback_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function createFeedback(
    $conn,
    $help_seeker_id,
    $rescue_request_id,
    $message
) {
    $sql = "INSERT INTO feedback
            (
                help_seeker_id,
                rescue_request_id,
                message,
                status
            )
            VALUES (?, ?, ?, 'pending')";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "iis",
        $help_seeker_id,
        $rescue_request_id,
        $message
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}