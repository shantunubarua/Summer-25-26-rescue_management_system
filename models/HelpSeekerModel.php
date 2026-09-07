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

    $stmt = mysqli_prepare($conn, $sql);

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

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function getHelpSeekerRequests($conn, $help_seeker_id)
{
    $sql = "SELECT *
            FROM emergency_requests
            WHERE help_seeker_id = ?
            ORDER BY id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $help_seeker_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $requests = [];

    while ($row = mysqli_fetch_assoc($result)) {
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

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $request_id,
        $help_seeker_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $request = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $request;
}