<?php

function createEmergencyRequest(
    $conn,
    $help_seeker_id,
    $emergency_type,
    $location,
    $description,
    $priority,
    $victim_type,
    $victim_information,
    $victim_count,
    $contact_information
) {
    $sql = "INSERT INTO emergency_requests
            (
                help_seeker_id,
                emergency_type,
                location,
                description,
                priority,
                victim_type,
                victim_information,
                victim_count,
                contact_information
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "issssssis",
        $help_seeker_id,
        $emergency_type,
        $location,
        $description,
        $priority,
        $victim_type,
        $victim_information,
        $victim_count,
        $contact_information
    );

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function getHelpSeekerRequests(
    $conn,
    $help_seeker_id
) {
    $sql = "SELECT *
            FROM emergency_requests
            WHERE help_seeker_id = ?
            ORDER BY id DESC";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $help_seeker_id
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $requests = [];

    while (
        $row =
        mysqli_fetch_assoc($result)
    ) {
        $requests[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $requests;
}


function getHelpSeekerRequestById(
    $conn,
    $request_id,
    $help_seeker_id
) {
    $sql = "SELECT *
            FROM emergency_requests
            WHERE id = ?
            AND help_seeker_id = ?
            LIMIT 1";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $request_id,
        $help_seeker_id
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $request =
        mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $request;
}


function updateEmergencyRequest(
    $conn,
    $request_id,
    $help_seeker_id,
    $emergency_type,
    $location,
    $description,
    $priority,
    $victim_type,
    $victim_information,
    $victim_count,
    $contact_information
) {
    $sql = "UPDATE emergency_requests
            SET
                emergency_type = ?,
                location = ?,
                description = ?,
                priority = ?,
                victim_type = ?,
                victim_information = ?,
                victim_count = ?,
                contact_information = ?
            WHERE id = ?
            AND help_seeker_id = ?";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssisii",
        $emergency_type,
        $location,
        $description,
        $priority,
        $victim_type,
        $victim_information,
        $victim_count,
        $contact_information,
        $request_id,
        $help_seeker_id
    );

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function deleteEmergencyRequest(
    $conn,
    $request_id,
    $help_seeker_id
) {
    $sql = "DELETE FROM emergency_requests
            WHERE id = ?
            AND help_seeker_id = ?
            AND status = 'pending'";

    $stmt = mysqli_prepare(
        $conn,
        $sql
    );

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $request_id,
        $help_seeker_id
    );

    $success =
        mysqli_stmt_execute($stmt);

    $affectedRows =
        mysqli_stmt_affected_rows($stmt);

    mysqli_stmt_close($stmt);

    return (
        $success &&
        $affectedRows === 1
    );
}
function searchHelpSeekerRequests(
    $conn,
    $help_seeker_id,
    $keyword
) {
    $keyword =
        trim($keyword);

    $search =
        '%' . $keyword . '%';

    $sql = "SELECT *
            FROM emergency_requests
            WHERE help_seeker_id = ?
            AND (
                emergency_type LIKE ?
                OR location LIKE ?
                OR description LIKE ?
                OR priority LIKE ?
                OR victim_type LIKE ?
                OR victim_information LIKE ?
                OR contact_information LIKE ?
                OR status LIKE ?
            )
            ORDER BY id DESC";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "issssssss",
        $help_seeker_id,
        $search,
        $search,
        $search,
        $search,
        $search,
        $search,
        $search,
        $search
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $requests = [];

    while (
        $row =
        mysqli_fetch_assoc($result)
    ) {
        $requests[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $requests;
}