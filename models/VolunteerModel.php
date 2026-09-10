<?php

function getVolunteerEmergencyRequests($conn)
{
    $sql = "SELECT *
            FROM emergency_requests
            WHERE status = 'pending'
            ORDER BY id DESC";

    $result = mysqli_query($conn, $sql);

    $requests = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $requests[] = $row;
    }

    return $requests;
}


function acceptEmergencyRequest($conn, $request_id, $volunteer_id)
{
    $sql = "UPDATE emergency_requests
            SET status = 'assigned',
                volunteer_id = ?,
                accepted_at = NOW()
            WHERE id = ?
            AND status = 'pending'";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $volunteer_id,
        $request_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function getVolunteerActivities($conn, $volunteer_id)
{
    $sql = "SELECT *
            FROM emergency_requests
            WHERE volunteer_id = ?
            AND status IN ('assigned', 'ongoing', 'completed')
            ORDER BY accepted_at DESC";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $volunteer_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $activities = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $activities[] = $row;
    }

    mysqli_stmt_close($stmt);

    return $activities;
}
function updateRescueActivityStatus(
    $conn,
    $request_id,
    $volunteer_id,
    $status
) {
    $allowed_statuses = ['ongoing', 'completed'];

    if (!in_array($status, $allowed_statuses)) {
        return false;
    }

    $sql = "UPDATE emergency_requests
            SET status = ?
            WHERE id = ?
            AND volunteer_id = ?
            AND status IN ('assigned', 'ongoing')";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "sii",
        $status,
        $request_id,
        $volunteer_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function getVolunteerAvailability($conn, $volunteer_id)
{
    $sql = "SELECT availability_status
            FROM volunteer_profiles
            WHERE user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $volunteer_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $profile = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $profile;
}


function updateVolunteerAvailability(
    $conn,
    $volunteer_id,
    $availability_status
) {
    $allowed_statuses = [
        'available',
        'unavailable',
        'currently_rescuing'
    ];

    if (!in_array($availability_status, $allowed_statuses)) {
        return false;
    }

    $sql = "UPDATE volunteer_profiles
            SET availability_status = ?
            WHERE user_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $availability_status,
        $volunteer_id
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}
function getVolunteerProfile($conn, $volunteer_id)
{
    $sql = "SELECT
                users.name,
                users.email,
                users.phone,
                volunteer_profiles.address,
                volunteer_profiles.blood_group,
                volunteer_profiles.experience,
                volunteer_profiles.skills,
                volunteer_profiles.emergency_contact,
                volunteer_profiles.availability_status
            FROM users
            LEFT JOIN volunteer_profiles
                ON users.id = volunteer_profiles.user_id
            WHERE users.id = ?
            AND users.role = 'volunteer'";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $volunteer_id
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $profile = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $profile;
}


function updateVolunteerProfile(
    $conn,
    $volunteer_id,
    $name,
    $phone,
    $address,
    $blood_group,
    $experience,
    $skills,
    $emergency_contact
) {
    $sqlUser = "UPDATE users
                SET name = ?, phone = ?
                WHERE id = ?
                AND role = 'volunteer'";

    $stmtUser = mysqli_prepare($conn, $sqlUser);

    mysqli_stmt_bind_param(
        $stmtUser,
        "ssi",
        $name,
        $phone,
        $volunteer_id
    );

    $userUpdated = mysqli_stmt_execute($stmtUser);

    mysqli_stmt_close($stmtUser);

    if (!$userUpdated) {
        return false;
    }

    $sqlProfile = "UPDATE volunteer_profiles
                   SET address = ?,
                       blood_group = ?,
                       experience = ?,
                       skills = ?,
                       emergency_contact = ?
                   WHERE user_id = ?";

    $stmtProfile = mysqli_prepare(
        $conn,
        $sqlProfile
    );

    mysqli_stmt_bind_param(
        $stmtProfile,
        "sssssi",
        $address,
        $blood_group,
        $experience,
        $skills,
        $emergency_contact,
        $volunteer_id
    );

    $profileUpdated =
        mysqli_stmt_execute($stmtProfile);

    mysqli_stmt_close($stmtProfile);

    return $profileUpdated;
}
