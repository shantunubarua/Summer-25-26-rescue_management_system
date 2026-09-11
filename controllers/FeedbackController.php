<?php

require_once "models/FeedbackModel.php";


/*
|--------------------------------------------------------------------------
| LOAD ALL FEEDBACK
|--------------------------------------------------------------------------
*/

function loadAllFeedback($conn)
{
    return
        getAllFeedback(
            $conn
        );
}


/*
|--------------------------------------------------------------------------
| ADMIN - UPDATE FEEDBACK STATUS
|--------------------------------------------------------------------------
*/

function handleUpdateFeedbackStatus($conn)
{
    $id =
        isset($_POST['id'])
            ? (int)$_POST['id']
            : 0;


    $status =
        trim(
            $_POST['status']
            ?? ''
        );


    if ($id <= 0) {

        return
            "Invalid feedback ID.";
    }


    if (
        !updateFeedbackStatus(
            $conn,
            $id,
            $status
        )
    ) {

        return
            "Failed to update feedback status.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| ADMIN - DELETE FEEDBACK
|--------------------------------------------------------------------------
*/

function handleDeleteFeedback($conn)
{
    $feedbackId =
        (int)(
            $_POST['id']
            ?? 0
        );


    if ($feedbackId <= 0) {

        die(
            "Invalid feedback ID."
        );
    }


    $deleted =
        deleteFeedback(
            $conn,
            $feedbackId
        );


    if (!$deleted) {

        die(
            "Failed to delete feedback."
        );
    }


    header(
        "Location: index.php?page=feedback"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| HELP SEEKER - CREATE FEEDBACK
|--------------------------------------------------------------------------
*/

function handleCreateFeedback(
    $conn,
    $rescueRequestId
) {

    $helpSeekerId =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    $rescueRequestId =
        (int)$rescueRequestId;


    $message =
        trim(
            $_POST['message']
            ?? ''
        );


    if ($helpSeekerId <= 0) {

        return
            "Invalid help seeker account.";
    }


    if ($rescueRequestId <= 0) {

        return
            "Invalid emergency request.";
    }


    if ($message === '') {

        return
            "Feedback message is required.";
    }


    if (
        strlen($message) > 1000
    ) {

        return
            "Feedback message must not exceed 1000 characters.";
    }


    $created =
        createFeedback(
            $conn,
            $helpSeekerId,
            $rescueRequestId,
            $message
        );


    if (!$created) {

        return
            "Failed to submit feedback.";
    }


    header(
        "Location: index.php?page=helpseeker-requests"
    );

    exit;
}