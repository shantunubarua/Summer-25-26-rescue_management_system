<?php

/*
|--------------------------------------------------------------------------
| VOLUNTEER - CREATE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function createResourceRequest(
    $conn,
    $volunteer_id,
    $resource_type,
    $quantity,
    $description
) {
    $sql = "
        INSERT INTO resource_requests
        (
            volunteer_id,
            resource_type,
            quantity,
            description,
            status
        )
        VALUES (?, ?, ?, ?, 'pending')
    ";

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

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| VOLUNTEER - GET OWN RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

function getVolunteerResourceRequests(
    $conn,
    $volunteer_id
) {
    $sql = "
        SELECT
            id,
            volunteer_id,
            resource_type,
            quantity,
            description,
            status,
            created_at
        FROM resource_requests
        WHERE volunteer_id = ?
        ORDER BY id DESC
    ";

    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        return [];
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $volunteer_id
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


/*
|--------------------------------------------------------------------------
| VOLUNTEER - GET SINGLE OWN RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function getVolunteerResourceRequestById(
    $conn,
    $request_id,
    $volunteer_id
) {
    $sql = "
        SELECT
            id,
            volunteer_id,
            resource_type,
            quantity,
            description,
            status,
            created_at
        FROM resource_requests
        WHERE id = ?
        AND volunteer_id = ?
        LIMIT 1
    ";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return null;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $request_id,
        $volunteer_id
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
| VOLUNTEER - UPDATE OWN PENDING RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function updateResourceRequest(
    $conn,
    $request_id,
    $volunteer_id,
    $resource_type,
    $quantity,
    $description
) {
    $sql = "
        UPDATE resource_requests
        SET
            resource_type = ?,
            quantity = ?,
            description = ?
        WHERE id = ?
        AND volunteer_id = ?
        AND status = 'pending'
    ";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return false;
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sisii",
        $resource_type,
        $quantity,
        $description,
        $request_id,
        $volunteer_id
    );

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| VOLUNTEER - DELETE OWN PENDING RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function cancelResourceRequest(
    $conn,
    $request_id,
    $volunteer_id
) {
    $sql = "
        DELETE FROM resource_requests
        WHERE id = ?
        AND volunteer_id = ?
        AND status = 'pending'
    ";

    $stmt =
        mysqli_prepare(
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
        $volunteer_id
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


/*
|--------------------------------------------------------------------------
| VOLUNTEER - SEARCH OWN RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

function searchVolunteerResourceRequests(
    $conn,
    $volunteer_id,
    $keyword
) {
    $keyword = trim($keyword);

    if ($keyword === '') {

        return getVolunteerResourceRequests(
            $conn,
            $volunteer_id
        );
    }

    $search =
        '%' . $keyword . '%';

    $sql = "
        SELECT
            id,
            volunteer_id,
            resource_type,
            quantity,
            description,
            status,
            created_at
        FROM resource_requests
        WHERE volunteer_id = ?
        AND
        (
            resource_type LIKE ?
            OR description LIKE ?
            OR status LIKE ?
        )
        ORDER BY id DESC
    ";

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
        "isss",
        $volunteer_id,
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