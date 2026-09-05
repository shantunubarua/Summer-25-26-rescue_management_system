<?php

require_once "models/FeedbackModel.php";

function loadAllFeedback($conn)
{
    return getAllFeedback($conn);
}

function handleUpdateFeedbackStatus($conn)
{
    $id = isset($_POST['id'])
        ? (int)$_POST['id']
        : 0;

    $status = trim($_POST['status'] ?? '');

    if ($id <= 0) {
        return "Invalid feedback ID.";
    }

    if (
        !updateFeedbackStatus(
            $conn,
            $id,
            $status
        )
    ) {
        return "Failed to update feedback status.";
    }

    return '';
}
function handleDeleteFeedback($conn)
{
    require_once "models/FeedbackModel.php";

    $feedback_id =
        (int)($_POST['id'] ?? 0);

    if ($feedback_id <= 0) {
        die("Invalid feedback ID.");
    }

    $deleted = deleteFeedback(
        $conn,
        $feedback_id
    );

    if (!$deleted) {
        die("Failed to delete feedback.");
    }

    header("Location: index.php?page=feedback");
    exit;
}
function handleCreateFeedback($conn)
{
    $help_seeker_id = (int)(
        $_SESSION['user']['id'] ?? 0
    );

    $rescue_request_id = (int)(
        $_POST['rescue_request_id'] ?? 0
    );

    $message = trim(
        $_POST['message'] ?? ''
    );

    if ($help_seeker_id <= 0) {
        return "Invalid help seeker.";
    }

    if ($rescue_request_id <= 0) {
        return "Invalid emergency request.";
    }

    if ($message === '') {
        return "Feedback message is required.";
    }

    if (strlen($message) > 1000) {
        return "Feedback message is too long.";
    }

    if (
        createFeedback(
            $conn,
            $help_seeker_id,
            $rescue_request_id,
            $message
        )
    ) {
        header(
            "Location: index.php?page=helpseeker-requests"
        );
        exit;
    }

    return "Failed to submit feedback.";
}