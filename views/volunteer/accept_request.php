<?php

require_once "models/VolunteerModel.php";


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    die("Invalid request method.");

}


$request_id = (int)(
    $_POST['request_id'] ?? 0
);

$volunteer_id = (int)(
    $_SESSION['user']['id'] ?? 0
);


if (
    $request_id <= 0 ||
    $volunteer_id <= 0
) {

    die("Invalid request.");

}


$accepted = acceptEmergencyRequest(
    $conn,
    $request_id,
    $volunteer_id
);


if (!$accepted) {

    die(
        "This emergency request is no longer available."
    );

}


header(
    "Location: index.php?page=volunteer-emergency-requests"
);

exit;