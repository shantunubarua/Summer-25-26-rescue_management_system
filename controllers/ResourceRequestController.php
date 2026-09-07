<?php

require_once "models/ResourceRequestModel.php";


/*
|--------------------------------------------------------------------------
| CREATE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function handleCreateResourceRequest($conn)
{
    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);

    $resource_type =
        trim($_POST['resource_type'] ?? '');

    $quantity =
        (int)($_POST['quantity'] ?? 0);

    $description =
        trim($_POST['description'] ?? '');


    if (
        $volunteer_id <= 0 ||
        $resource_type === '' ||
        $quantity <= 0
    ) {
        return "Please fill in all required fields correctly.";
    }


    if (
        createResourceRequest(
            $conn,
            $volunteer_id,
            $resource_type,
            $quantity,
            $description
        )
    ) {

        header(
            "Location: index.php?page=volunteer-resource-requests"
        );

        exit;
    }


    return "Failed to submit resource request.";
}


/*
|--------------------------------------------------------------------------
| EDIT RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function handleEditResourceRequest(
    $conn,
    $request_id
) {
    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);

    $resource_type =
        trim($_POST['resource_type'] ?? '');

    $quantity =
        (int)($_POST['quantity'] ?? 0);

    $description =
        trim($_POST['description'] ?? '');


    if (
        $volunteer_id <= 0 ||
        $request_id <= 0
    ) {
        return "Invalid request.";
    }


    if ($resource_type === '') {
        return "Resource type is required.";
    }


    if ($quantity <= 0) {
        return "Quantity must be greater than 0.";
    }


    if (
        updateResourceRequest(
            $conn,
            $request_id,
            $volunteer_id,
            $resource_type,
            $quantity,
            $description
        )
    ) {

        header(
            "Location: index.php?page=volunteer-resource-requests"
        );

        exit;
    }


    return "Unable to update this request. It may already have been processed.";
}


/*
|--------------------------------------------------------------------------
| CANCEL RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function handleCancelResourceRequest(
    $conn,
    $request_id
) {
    $volunteer_id =
        (int)($_SESSION['user']['id'] ?? 0);


    if (
        $volunteer_id <= 0 ||
        $request_id <= 0
    ) {
        die("Invalid request.");
    }


    if (
        !cancelResourceRequest(
            $conn,
            $request_id,
            $volunteer_id
        )
    ) {

        die(
            "Unable to cancel this request. It may already have been processed."
        );
    }


    header(
        "Location: index.php?page=volunteer-resource-requests"
    );

    exit;
}