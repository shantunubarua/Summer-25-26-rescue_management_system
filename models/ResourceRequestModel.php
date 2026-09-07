<?php

function createResourceRequest(
    $conn,
    $volunteer_id,
    $resource_type,
    $quantity,
    $description
) {
    $sql = "INSERT INTO resource_requests
            (
                volunteer_id,
                resource_type,
                quantity,
                description
            )
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "isis",
        $volunteer_id,
        $resource_type,
        $quantity,
        $description
    );

    $success = mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


function getVolunteerResourceRequests(
    $conn,
    $volunteer_id
) {
    $sql = "SELECT *
            FROM resource_requests
            WHERE volunteer_id = ?
            ORDER BY id DESC";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $volunteer_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return [];
    }

    $result = mysqli_stmt_get_result($stmt);

    $requests = [];

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $requests[] = $row;
        }
    }

    mysqli_stmt_close($stmt);

    return $requests;
}


function getResourceRequestById(
    $conn,
    $request_id,
    $volunteer_id
) {
    $sql = "SELECT *
            FROM resource_requests
            WHERE id = ?
            AND volunteer_id = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $request_id,
        $volunteer_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return null;
    }

    $result = mysqli_stmt_get_result($stmt);

    $request = null;

    if ($result) {
        $request = mysqli_fetch_assoc($result);
    }

    mysqli_stmt_close($stmt);

    return $request;
}
/*
|--------------------------------------------------------------------------
| ADMIN - GET ALL RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

function getAllResourceRequestsForAdmin($conn)
{
    $sql = "
        SELECT
            rr.*,

            u.name AS volunteer_name,
            u.email AS volunteer_email,
            u.phone AS volunteer_phone,

            vp.address AS volunteer_address,
            vp.availability_status

        FROM resource_requests AS rr

        INNER JOIN users AS u
            ON rr.volunteer_id = u.id

        LEFT JOIN volunteer_profiles AS vp
            ON rr.volunteer_id = vp.user_id

        WHERE u.role = 'volunteer'

        ORDER BY
            CASE rr.status
                WHEN 'pending' THEN 1
                WHEN 'approved' THEN 2
                WHEN 'completed' THEN 3
                WHEN 'rejected' THEN 4
                ELSE 5
            END,
            rr.created_at DESC
    ";


    $result = mysqli_query(
        $conn,
        $sql
    );


    if (!$result) {
        return [];
    }


    $requests = [];


    while ($row = mysqli_fetch_assoc($result)) {

        $requests[] = $row;
    }


    return $requests;
}


/*
|--------------------------------------------------------------------------
| ADMIN - GET SINGLE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function getResourceRequestForAdminById(
    $conn,
    $request_id
) {

    $sql = "
        SELECT
            rr.*,

            u.name AS volunteer_name,
            u.email AS volunteer_email,
            u.phone AS volunteer_phone,

            vp.address AS volunteer_address,
            vp.blood_group,
            vp.experience,
            vp.skills,
            vp.emergency_contact,
            vp.availability_status

        FROM resource_requests AS rr

        INNER JOIN users AS u
            ON rr.volunteer_id = u.id

        LEFT JOIN volunteer_profiles AS vp
            ON rr.volunteer_id = vp.user_id

        WHERE rr.id = ?
        AND u.role = 'volunteer'

        LIMIT 1
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return null;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $request_id
    );


    mysqli_stmt_execute($stmt);


    $result =
        mysqli_stmt_get_result($stmt);


    $request =
        mysqli_fetch_assoc($result);


    mysqli_stmt_close($stmt);


    return $request ?: null;
}


/*
|--------------------------------------------------------------------------
| ADMIN - UPDATE RESOURCE REQUEST STATUS
|--------------------------------------------------------------------------
*/

function updateResourceRequestStatusByAdmin(
    $conn,
    $request_id,
    $status
) {

    $sql = "
        UPDATE resource_requests

        SET status = ?

        WHERE id = ?
    ";


    $stmt = mysqli_prepare(
        $conn,
        $sql
    );


    if (!$stmt) {
        return false;
    }


    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $status,
        $request_id
    );


    $success =
        mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);


    return $success;
}