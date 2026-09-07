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
/*
|--------------------------------------------------------------------------
| ADMIN - RESOURCE REQUEST LIST
|--------------------------------------------------------------------------
*/

function showAdminResourceRequests($conn)
{
    $requests = getAllResourceRequestsForAdmin($conn);

    require_once "views/admin/resource_requests/index.php";
}


/*
|--------------------------------------------------------------------------
| ADMIN - SINGLE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function showAdminResourceRequest(
    $conn,
    $request_id
) {
    $request_id = (int)$request_id;

    if ($request_id <= 0) {
        die("Invalid resource request ID.");
    }

    $request = getResourceRequestForAdminById(
        $conn,
        $request_id
    );

    if (!$request) {
        die("Resource request not found.");
    }

    require_once "views/admin/resource_requests/view.php";
}


/*
|--------------------------------------------------------------------------
| ADMIN - UPDATE RESOURCE REQUEST STATUS
|--------------------------------------------------------------------------
*/

function handleAdminResourceRequestStatus(
    $conn,
    $request_id
) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return "Invalid request method.";
    }

    $request_id = (int)$request_id;

    $status = trim(
        $_POST['status'] ?? ''
    );

    if ($request_id <= 0) {
        return "Invalid resource request ID.";
    }

    $allowedStatuses = [
        'pending',
        'approved',
        'rejected',
        'completed'
    ];

    /*
    |--------------------------------------------------------------------------
    | PHP SERVER-SIDE VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $status === '' ||
        !in_array(
            $status,
            $allowedStatuses,
            true
        )
    ) {
        return "Please select a valid request status.";
    }

    $request = getResourceRequestForAdminById(
        $conn,
        $request_id
    );

    if (!$request) {
        return "Resource request not found.";
    }

    $updated = updateResourceRequestStatusByAdmin(
        $conn,
        $request_id,
        $status
    );

    if (!$updated) {
        return "Failed to update resource request status.";
    }

    return '';
}