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
                    0777,
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