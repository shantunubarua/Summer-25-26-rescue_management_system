<?php

require_once "models/WitnessModel.php";


function handleCreateWitnessReport($conn)
{
    $title =
        trim($_POST['title'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    $damage_level =
        trim($_POST['damage_level'] ?? '');

    $incident_type =
        trim($_POST['incident_type'] ?? '');

    $location =
        trim($_POST['location'] ?? '');

    $incident_date =
        trim($_POST['incident_date'] ?? '');


    /*
     * Required fields validation
     */

    if (
        $title === '' ||
        $description === '' ||
        $damage_level === '' ||
        $incident_type === '' ||
        $location === '' ||
        $incident_date === ''
    ) {

        return "All required fields must be completed.";
    }


    /*
     * Damage Level validation
     */

    $allowed_damage_levels = [
        'low',
        'medium',
        'high',
        'critical'
    ];


    if (
        !in_array(
            $damage_level,
            $allowed_damage_levels,
            true
        )
    ) {

        return "Invalid damage level.";
    }


    /*
     * Incident Type validation
     */

    $allowed_types = [
        'accident',
        'fire',
        'flood',
        'medical',
        'other'
    ];


    if (
        !in_array(
            $incident_type,
            $allowed_types,
            true
        )
    ) {

        return "Invalid incident type.";
    }


    /*
     * Get logged-in witness ID
     */

    $witness_id =
        (int)(
            $_SESSION['user']['id'] ?? 0
        );


    if ($witness_id <= 0) {

        return "Invalid witness account.";
    }


    /*
     * Evidence file upload
     */

    $evidence_file = null;


    if (
        isset($_FILES['evidence_file']) &&
        $_FILES['evidence_file']['error']
            !== UPLOAD_ERR_NO_FILE
    ) {

        if (
            $_FILES['evidence_file']['error']
            !== UPLOAD_ERR_OK
        ) {

            return "Failed to upload evidence file.";
        }


        $file =
            $_FILES['evidence_file'];


        /*
         * Allowed evidence extensions
         */

        $allowed_extensions = [
            'jpg',
            'jpeg',
            'png',
            'pdf'
        ];


        $extension =
            strtolower(
                pathinfo(
                    $file['name'],
                    PATHINFO_EXTENSION
                )
            );


        if (
            !in_array(
                $extension,
                $allowed_extensions,
                true
            )
        ) {

            return "Invalid evidence file type. Allowed: JPG, JPEG, PNG, PDF.";
        }

/*
 * Validate actual MIME type
 */

$finfo =
    finfo_open(
        FILEINFO_MIME_TYPE
    );


if (!$finfo) {

    return "Unable to validate evidence file.";
}


$mime_type =
    finfo_file(
        $finfo,
        $file['tmp_name']
    );


finfo_close(
    $finfo
);


$allowed_mime_types = [
    'image/jpeg',
    'image/png',
    'application/pdf'
];


if (
    !in_array(
        $mime_type,
        $allowed_mime_types,
        true
    )
) {

    return "Invalid evidence file content.";
}


        /*
         * Maximum file size: 5 MB
         */

        if (
            $file['size'] >
            5 * 1024 * 1024
        ) {

            return "Evidence file must be less than 5 MB.";
        }


        /*
         * Create upload directory
         */

        $upload_dir =
            "uploads/witness/";


        if (!is_dir($upload_dir)) {

            if (
                !mkdir(
                    $upload_dir,
                    0755,
                    true
                )
            ) {

                return "Failed to create upload directory.";
            }
        }


        /*
         * Generate unique filename
         */

        $new_filename =
            'witness_' .
            $witness_id .
            '_' .
            time() .
            '_' .
            uniqid() .
            '.' .
            $extension;


        $upload_path =
            $upload_dir .
            $new_filename;


        /*
         * Move uploaded evidence
         */

        if (
            !move_uploaded_file(
                $file['tmp_name'],
                $upload_path
            )
        ) {

            return "Failed to save evidence file.";
        }


        $evidence_file =
            $upload_path;
    }


    /*
     * Save witness report
     */

    if (
        createWitnessReport(
            $conn,
            $witness_id,
            $title,
            $description,
            $damage_level,
            $incident_type,
            $location,
            $incident_date,
            $evidence_file
        )
    ) {

        header(
            "Location: index.php?page=witness-reports"
        );

        exit;
    }


    /*
     * If database insert fails,
     * remove uploaded evidence
     */

    if (
        $evidence_file !== null &&
        file_exists($evidence_file)
    ) {

        unlink($evidence_file);
    }


    return "Failed to create witness report.";
}



/*
 * Edit Witness Report
 */

function handleEditWitnessReport(
    $conn,
    $report_id,
    $witness_id
) {

    $title =
        trim($_POST['title'] ?? '');

    $description =
        trim($_POST['description'] ?? '');

    $damage_level =
        trim($_POST['damage_level'] ?? '');

    $incident_type =
        trim($_POST['incident_type'] ?? '');

    $location =
        trim($_POST['location'] ?? '');

    $incident_date =
        trim($_POST['incident_date'] ?? '');


    /*
     * Required fields validation
     */

    if (
        $title === '' ||
        $description === '' ||
        $damage_level === '' ||
        $incident_type === '' ||
        $location === '' ||
        $incident_date === ''
    ) {

        return "All required fields must be completed.";
    }


    /*
     * Damage Level validation
     */

    $allowed_damage_levels = [
        'low',
        'medium',
        'high',
        'critical'
    ];


    if (
        !in_array(
            $damage_level,
            $allowed_damage_levels,
            true
        )
    ) {

        return "Invalid damage level.";
    }


    /*
     * Incident Type validation
     */

    $allowed_types = [
        'accident',
        'fire',
        'flood',
        'medical',
        'other'
    ];


    if (
        !in_array(
            $incident_type,
            $allowed_types,
            true
        )
    ) {

        return "Invalid incident type.";
    }


    /*
     * Update report
     */

    if (
        updateWitnessReport(
            $conn,
            $report_id,
            $witness_id,
            $title,
            $description,
            $damage_level,
            $incident_type,
            $location,
            $incident_date
        )
    ) {

        return '';
    }


    return "Failed to update witness report.";
}

/*
|--------------------------------------------------------------------------
| WITNESS - AJAX INCIDENT REPORT SEARCH
|--------------------------------------------------------------------------
*/

function handleWitnessReportSearch($conn)
{
    /*
    |--------------------------------------------------------------------------
    | Logged-in Witness
    |--------------------------------------------------------------------------
    */

    $witness_id =
        (int)($_SESSION['user']['id'] ?? 0);


    /*
    |--------------------------------------------------------------------------
    | Search Keyword
    |--------------------------------------------------------------------------
    */

    $keyword =
        trim($_GET['q'] ?? '');


    /*
    |--------------------------------------------------------------------------
    | JSON Response Header
    |--------------------------------------------------------------------------
    */

    header(
        'Content-Type: application/json; charset=utf-8'
    );


    /*
    |--------------------------------------------------------------------------
    | Validate Witness
    |--------------------------------------------------------------------------
    */

    if ($witness_id <= 0) {

        echo json_encode([
            'success' => false,
            'count'   => 0,
            'data'    => [],
            'message' => 'Invalid witness account.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Search Reports
    |--------------------------------------------------------------------------
    */

    $reports =
        searchWitnessReports(
            $conn,
            $witness_id,
            $keyword
        );


    /*
    |--------------------------------------------------------------------------
    | Return JSON
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'count'   => count($reports),
        'data'    => $reports
    ]);


    exit;
}

/*
|--------------------------------------------------------------------------
| WITNESS PROFILE UPDATE
|--------------------------------------------------------------------------
*/

function handleUpdateWitnessProfile(
    $conn,
    $witness_id
) {

    $witness_id =
        (int)$witness_id;


    /*
    |--------------------------------------------------------------------------
    | Validate Witness
    |--------------------------------------------------------------------------
    */

    if ($witness_id <= 0) {

        return "Invalid witness account.";
    }


    /*
    |--------------------------------------------------------------------------
    | Get Form Data
    |--------------------------------------------------------------------------
    */

    $name =
        trim(
            $_POST['name'] ?? ''
        );

    $email =
        trim(
            $_POST['email'] ?? ''
        );

    $phone =
        trim(
            $_POST['phone'] ?? ''
        );


    /*
    |--------------------------------------------------------------------------
    | Required Fields
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $email === ''
    ) {

        return "Name and email are required.";
    }


    /*
    |--------------------------------------------------------------------------
    | Name Validation
    |--------------------------------------------------------------------------
    */

    if (
        strlen($name) < 2 ||
        strlen($name) > 100
    ) {

        return "Name must be between 2 and 100 characters.";
    }


    /*
    |--------------------------------------------------------------------------
    | Email Validation
    |--------------------------------------------------------------------------
    */

    if (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {

        return "Please enter a valid email address.";
    }


    /*
    |--------------------------------------------------------------------------
    | Phone Validation
    |--------------------------------------------------------------------------
    |
    | Phone is optional.
    |
    */

    if (
        $phone !== '' &&
        !preg_match(
            '/^[0-9+\-\s]{7,20}$/',
            $phone
        )
    ) {

        return "Please enter a valid phone number.";
    }


    /*
    |--------------------------------------------------------------------------
    | Duplicate Email Check
    |--------------------------------------------------------------------------
    */

    if (
        witnessEmailExistsForOtherUser(
            $conn,
            $email,
            $witness_id
        )
    ) {

        return "This email address is already in use.";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Profile
    |--------------------------------------------------------------------------
    */

    $success =
        updateWitnessProfile(
            $conn,
            $witness_id,
            $name,
            $email,
            $phone
        );


    if (!$success) {

        return "Failed to update profile.";
    }


    /*
    |--------------------------------------------------------------------------
    | Update Current Session Data
    |--------------------------------------------------------------------------
    */

    $_SESSION['user']['name'] =
        $name;

    $_SESSION['user']['email'] =
        $email;

    $_SESSION['user']['phone'] =
        $phone;


    return '';
}