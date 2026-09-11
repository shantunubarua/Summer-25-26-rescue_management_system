<?php

require_once "models/HelpSeekerModel.php";


/*
|--------------------------------------------------------------------------
| GET EMERGENCY REQUEST FORM DATA
|--------------------------------------------------------------------------
*/

function getEmergencyRequestFormData()
{
    $victimCountRaw =
        trim(
            (string)(
                $_POST['victim_count']
                ?? ''
            )
        );


    $victimCount =
        filter_var(
            $victimCountRaw,
            FILTER_VALIDATE_INT,
            [
                'options' => [
                    'min_range' => 1
                ]
            ]
        );


    if ($victimCount === false) {
        $victimCount = 0;
    }


    return [

        'emergency_type' =>
            trim(
                $_POST['emergency_type']
                ?? ''
            ),

        'location' =>
            trim(
                $_POST['location']
                ?? ''
            ),

        'description' =>
            trim(
                $_POST['description']
                ?? ''
            ),

        'priority' =>
            trim(
                $_POST['priority']
                ?? ''
            ),

        'victim_type' =>
            trim(
                $_POST['victim_type']
                ?? ''
            ),

        'victim_information' =>
            trim(
                $_POST['victim_information']
                ?? ''
            ),

        'victim_count' =>
            (int)$victimCount,

        'contact_information' =>
            trim(
                $_POST['contact_information']
                ?? ''
            )
    ];
}


/*
|--------------------------------------------------------------------------
| VALIDATE EMERGENCY REQUEST DATA
|--------------------------------------------------------------------------
*/

function validateEmergencyRequestData($data)
{
    if (
        $data['emergency_type'] === '' ||
        $data['location'] === '' ||
        $data['description'] === '' ||
        $data['priority'] === '' ||
        $data['victim_type'] === '' ||
        $data['contact_information'] === ''
    ) {

        return
            "All required fields must be completed.";
    }


    $allowedTypes = [
        'accident',
        'fire',
        'flood',
        'medical',
        'other'
    ];


    if (
        !in_array(
            $data['emergency_type'],
            $allowedTypes,
            true
        )
    ) {

        return
            "Invalid emergency type.";
    }


    $allowedPriorities = [
        'low',
        'medium',
        'high',
        'critical'
    ];


    if (
        !in_array(
            $data['priority'],
            $allowedPriorities,
            true
        )
    ) {

        return
            "Invalid priority.";
    }


    $allowedVictimTypes = [
        'self',
        'other'
    ];


    if (
        !in_array(
            $data['victim_type'],
            $allowedVictimTypes,
            true
        )
    ) {

        return
            "Invalid victim type.";
    }


    if (
        strlen(
            $data['location']
        ) > 255
    ) {

        return
            "Location must not exceed 255 characters.";
    }


    if (
        strlen(
            $data['contact_information']
        ) > 150
    ) {

        return
            "Contact information must not exceed 150 characters.";
    }


    if (
        $data['victim_count'] < 1
    ) {

        return
            "Victim count must be a valid number of at least 1.";
    }


    if (
        $data['victim_type'] === 'other' &&
        $data['victim_information'] === ''
    ) {

        return
            "Please provide information about the victim.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| CREATE EMERGENCY REQUEST
|--------------------------------------------------------------------------
*/

function handleCreateEmergencyRequest($conn)
{
    $helpSeekerId =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if ($helpSeekerId <= 0) {

        return
            "Invalid help seeker account.";
    }


    $data =
        getEmergencyRequestFormData();


    $error =
        validateEmergencyRequestData(
            $data
        );


    if ($error !== '') {
        return $error;
    }


    if (
        $data['victim_type']
        === 'self'
    ) {

        $data['victim_information'] =
            null;
    }


    $created =
        createEmergencyRequest(
            $conn,
            $helpSeekerId,
            $data['emergency_type'],
            $data['location'],
            $data['description'],
            $data['priority'],
            $data['victim_type'],
            $data['victim_information'],
            $data['victim_count'],
            $data['contact_information']
        );


    if (!$created) {

        return
            "Failed to submit emergency request.";
    }


    header(
        "Location: index.php?page=helpseeker-requests"
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| UPDATE EMERGENCY REQUEST
|--------------------------------------------------------------------------
*/

function handleUpdateEmergencyRequest(
    $conn,
    $requestId,
    $helpSeekerId
) {

    $requestId =
        (int)$requestId;

    $helpSeekerId =
        (int)$helpSeekerId;


    if (
        $requestId <= 0 ||
        $helpSeekerId <= 0
    ) {

        return
            "Invalid emergency request.";
    }


    $data =
        getEmergencyRequestFormData();


    $error =
        validateEmergencyRequestData(
            $data
        );


    if ($error !== '') {
        return $error;
    }


    if (
        $data['victim_type']
        === 'self'
    ) {

        $data['victim_information'] =
            null;
    }


    $updated =
        updateEmergencyRequest(
            $conn,
            $requestId,
            $helpSeekerId,
            $data['emergency_type'],
            $data['location'],
            $data['description'],
            $data['priority'],
            $data['victim_type'],
            $data['victim_information'],
            $data['victim_count'],
            $data['contact_information']
        );


    if (!$updated) {

        return
            "Failed to update emergency request.";
    }


    return '';
}


/*
|--------------------------------------------------------------------------
| HELP SEEKER REQUEST AJAX SEARCH
|--------------------------------------------------------------------------
*/

function handleHelpSeekerRequestSearch($conn)
{
    header(
        'Content-Type: application/json; charset=UTF-8'
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


    $helpSeekerId =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );


    if ($helpSeekerId <= 0) {

        http_response_code(401);

        echo json_encode([
            'success' => false,
            'message' =>
                'Invalid help seeker account.',
            'data' => []
        ]);

        exit;
    }


    $keyword =
        trim(
            $_GET['q']
            ?? ''
        );


    if (
        strlen($keyword) > 100
    ) {

        http_response_code(422);

        echo json_encode([
            'success' => false,
            'message' =>
                'Search text is too long.',
            'data' => []
        ]);

        exit;
    }


    $requests =
        searchHelpSeekerRequests(
            $conn,
            $helpSeekerId,
            $keyword
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
| UPDATE HELP SEEKER PROFILE
|--------------------------------------------------------------------------
*/

function handleUpdateHelpSeekerProfile(
    $conn,
    $help_seeker_id
) {
    $help_seeker_id =
        (int)$help_seeker_id;


    $name =
        trim(
            $_POST['name']
            ?? ''
        );


    $email =
        trim(
            $_POST['email']
            ?? ''
        );


    $phone =
        trim(
            $_POST['phone']
            ?? ''
        );


    /*
    |--------------------------------------------------------------------------
    | ACCOUNT VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($help_seeker_id <= 0) {

        return
            "Invalid help seeker account.";
    }


    /*
    |--------------------------------------------------------------------------
    | NAME VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($name === '') {

        return
            "Name is required.";
    }


    if (
        strlen($name) < 2 ||
        strlen($name) > 100
    ) {

        return
            "Name must be between 2 and 100 characters.";
    }


    /*
    |--------------------------------------------------------------------------
    | EMAIL VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($email === '') {

        return
            "Email address is required.";
    }


    if (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        return
            "Please enter a valid email address.";
    }


    if (
        helpSeekerEmailExistsForAnotherUser(
            $conn,
            $email,
            $help_seeker_id
        )
    ) {

        return
            "Email address is already being used by another account.";
    }


    /*
    |--------------------------------------------------------------------------
    | PHONE VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $phone !== '' &&
        !preg_match(
            '/^[0-9+\-\s]{7,20}$/',
            $phone
        )
    ) {

        return
            "Please enter a valid phone number.";
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */

    $updated =
        updateHelpSeekerProfile(
            $conn,
            $help_seeker_id,
            $name,
            $email,
            $phone
        );


    if (!$updated) {

        return
            "Failed to update profile.";
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE SESSION COPY
    |--------------------------------------------------------------------------
    */

    $_SESSION['user']['name'] =
        $name;

    $_SESSION['user']['email'] =
        $email;


    return '';
}


/*
|--------------------------------------------------------------------------
| LOAD NEARBY AVAILABLE VOLUNTEERS
|--------------------------------------------------------------------------
*/

function loadNearbyVolunteersForHelpSeeker(
    $conn,
    $area
) {
    require_once
        "models/VolunteerModel.php";


    $area =
        trim($area);


    if (
        strlen($area) > 100
    ) {

        return [
            'error' =>
                'Search location must not exceed 100 characters.',

            'volunteers' =>
                []
        ];
    }


    $volunteers =
        getNearbyAvailableVolunteers(
            $conn,
            $area
        );


    return [
        'error' => '',
        'volunteers' =>
            $volunteers
    ];
}