<?php

require_once "models/ResourceRequestModel.php";


/*
|--------------------------------------------------------------------------
| GET VOLUNTEER RESOURCE REQUEST FORM DATA
|--------------------------------------------------------------------------
*/

function getVolunteerResourceRequestFormData()
{
    return [
        'resource_type' =>
            trim(
                $_POST['resource_type']
                ?? ''
            ),

        'quantity' =>
            trim(
                $_POST['quantity']
                ?? ''
            ),

        'description' =>
            trim(
                $_POST['description']
                ?? ''
            )
    ];
}


/*
|--------------------------------------------------------------------------
| VALIDATE VOLUNTEER RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function validateVolunteerResourceRequestData(
    $data
) {
    $resource_type =
        $data['resource_type']
        ?? '';

    $quantity =
        $data['quantity']
        ?? '';

    $description =
        $data['description']
        ?? '';


    if (
        $resource_type === '' ||
        $quantity === ''
    ) {

        return
            "Please complete all required fields.";
    }


    if (
        strlen($resource_type) < 2 ||
        strlen($resource_type) > 100
    ) {

        return
            "Resource type must be between 2 and 100 characters.";
    }


    if (
        !preg_match(
            '/^\d+$/',
            $quantity
        )
    ) {

        return
            "Quantity must be a whole number.";
    }


    $quantity =
        (int)$quantity;


    if (
        $quantity < 1 ||
        $quantity > 100000
    ) {

        return
            "Quantity must be between 1 and 100000.";
    }


    if (
        strlen($description) > 1000
    ) {

        return
            "Description must not exceed 1000 characters.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| CREATE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function handleCreateResourceRequest($conn)
{
    if (
        $_SERVER['REQUEST_METHOD']
        !== 'POST'
    ) {

        return
            "Invalid request method.";
    }


    $volunteer_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if ($volunteer_id <= 0) {

        return
            "Invalid volunteer account.";
    }


    $data =
        getVolunteerResourceRequestFormData();


    $validationError =
        validateVolunteerResourceRequestData(
            $data
        );


    if ($validationError !== '') {

        return
            $validationError;
    }


    $success =
        createResourceRequest(
            $conn,
            $volunteer_id,
            $data['resource_type'],
            (int)$data['quantity'],
            $data['description']
        );


    if (!$success) {

        return
            "Failed to submit resource request.";
    }


    header(
        "Location: index.php?page=volunteer-resource-requests"
    );

    exit;
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
    $request_id =
        (int)$request_id;


    $volunteer_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if (
        $request_id <= 0 ||
        $volunteer_id <= 0
    ) {

        return
            "Invalid request.";
    }


    $existingRequest =
        getVolunteerResourceRequestById(
            $conn,
            $request_id,
            $volunteer_id
        );


    if (!$existingRequest) {

        return
            "Resource request not found.";
    }


    if (
        (
            $existingRequest['status']
            ?? ''
        ) !== 'pending'
    ) {

        return
            "Only pending resource requests can be edited.";
    }


    $data =
        getVolunteerResourceRequestFormData();


    $validationError =
        validateVolunteerResourceRequestData(
            $data
        );


    if ($validationError !== '') {

        return
            $validationError;
    }


    $success =
        updateResourceRequest(
            $conn,
            $request_id,
            $volunteer_id,
            $data['resource_type'],
            (int)$data['quantity'],
            $data['description']
        );


    if (!$success) {

        return
            "Unable to update this resource request.";
    }


    header(
        "Location: index.php?page=volunteer-resource-requests"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| DELETE / CANCEL RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function handleCancelResourceRequest(
    $conn,
    $request_id
) {
    $request_id =
        (int)$request_id;


    $volunteer_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if (
        $volunteer_id <= 0 ||
        $request_id <= 0
    ) {

        die(
            "Invalid resource request."
        );
    }


    $request =
        getVolunteerResourceRequestById(
            $conn,
            $request_id,
            $volunteer_id
        );


    if (!$request) {

        die(
            "Resource request not found."
        );
    }


    if (
        (
            $request['status']
            ?? ''
        ) !== 'pending'
    ) {

        die(
            "Only pending resource requests can be deleted."
        );
    }


    if (
        !cancelResourceRequest(
            $conn,
            $request_id,
            $volunteer_id
        )
    ) {

        die(
            "Unable to delete this resource request."
        );
    }


    header(
        "Location: index.php?page=volunteer-resource-requests"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| VOLUNTEER - AJAX RESOURCE REQUEST SEARCH
|--------------------------------------------------------------------------
*/

function handleVolunteerResourceRequestSearch(
    $conn
) {
    header(
        'Content-Type: application/json; charset=utf-8'
    );


    if (
        $_SERVER['REQUEST_METHOD']
        !== 'GET'
    ) {

        http_response_code(405);

        echo json_encode([
            'success' => false,
            'message' =>
                'Invalid request method.',
            'data' => []
        ]);

        exit;
    }


    $volunteer_id =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if ($volunteer_id <= 0) {

        http_response_code(401);

        echo json_encode([
            'success' => false,
            'message' =>
                'Invalid volunteer account.',
            'data' => []
        ]);

        exit;
    }


    $search =
        trim(
            $_GET['search']
            ?? ''
        );


    if (
        strlen($search) > 100
    ) {

        http_response_code(422);

        echo json_encode([
            'success' => false,
            'message' =>
                'Search text must not exceed 100 characters.',
            'data' => []
        ]);

        exit;
    }


    $requests =
        searchVolunteerResourceRequests(
            $conn,
            $volunteer_id,
            $search
        );


    echo json_encode([
        'success' => true,
        'count' =>
            count($requests),
        'data' =>
            $requests
    ]);


    exit;
}


/*
|--------------------------------------------------------------------------
| ADMIN - RESOURCE REQUEST LIST
|--------------------------------------------------------------------------
*/

function showAdminResourceRequests($conn)
{
    $requests =
        getAllResourceRequestsForAdmin(
            $conn
        );

    require_once
        "views/admin/resource_requests/index.php";
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
    $request_id =
        (int)$request_id;


    if ($request_id <= 0) {

        die(
            "Invalid resource request ID."
        );
    }


    $request =
        getResourceRequestForAdminById(
            $conn,
            $request_id
        );


    if (!$request) {

        die(
            "Resource request not found."
        );
    }


    require_once
        "views/admin/resource_requests/view.php";
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
    if (
        $_SERVER['REQUEST_METHOD']
        !== 'POST'
    ) {

        return
            "Invalid request method.";
    }


    $request_id =
        (int)$request_id;


    $status =
        trim(
            $_POST['status']
            ?? ''
        );


    if ($request_id <= 0) {

        return
            "Invalid resource request ID.";
    }


    $allowedStatuses = [
        'pending',
        'approved',
        'rejected',
        'completed'
    ];


    if (
        $status === '' ||
        !in_array(
            $status,
            $allowedStatuses,
            true
        )
    ) {

        return
            "Please select a valid request status.";
    }


    $request =
        getResourceRequestForAdminById(
            $conn,
            $request_id
        );


    if (!$request) {

        return
            "Resource request not found.";
    }


    $updated =
        updateResourceRequestStatusByAdmin(
            $conn,
            $request_id,
            $status
        );


    if (!$updated) {

        return
            "Failed to update resource request status.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| ADMIN - AJAX RESOURCE REQUEST SEARCH
|--------------------------------------------------------------------------
*/

function handleAdminResourceRequestSearch($conn)
{
    if (
        $_SERVER['REQUEST_METHOD']
        !== 'GET'
    ) {

        header(
            'Content-Type: application/json'
        );


        echo json_encode([
            'success' => false,
            'message' =>
                'Invalid request method.',
            'data' => []
        ]);


        exit;
    }


    $search =
        trim(
            $_GET['search']
            ?? ''
        );


    if (
        strlen($search) > 100
    ) {

        header(
            'Content-Type: application/json'
        );


        echo json_encode([
            'success' => false,
            'message' =>
                'Search text is too long.',
            'data' => []
        ]);


        exit;
    }


    if ($search === '') {

        $requests =
            getAllResourceRequestsForAdmin(
                $conn
            );

    } else {

        $requests =
            searchResourceRequestsForAdmin(
                $conn,
                $search
            );
    }


    header(
        'Content-Type: application/json; charset=utf-8'
    );


    echo json_encode([
        'success' => true,
        'count' =>
            count($requests),
        'data' =>
            $requests
    ]);


    exit;
}