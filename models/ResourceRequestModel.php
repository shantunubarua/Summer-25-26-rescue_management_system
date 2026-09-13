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
    $volunteer_id = (int)$volunteer_id;
    $quantity = (int)$quantity;

    if (
        $volunteer_id <= 0 ||
        $quantity <= 0
    ) {
        return false;
    }

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
    $volunteer_id =
        (int)$volunteer_id;

    if ($volunteer_id <= 0) {
        return [];
    }

    $sql = "
        SELECT
            id,
            volunteer_id,
            resource_type,
            quantity,
            description,
            status,
            created_at,
            updated_at
        FROM resource_requests
        WHERE volunteer_id = ?
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
    $request_id =
        (int)$request_id;

    $volunteer_id =
        (int)$volunteer_id;

    if (
        $request_id <= 0 ||
        $volunteer_id <= 0
    ) {
        return null;
    }

    $sql = "
        SELECT
            id,
            volunteer_id,
            resource_type,
            quantity,
            description,
            status,
            created_at,
            updated_at
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
    $request_id =
        (int)$request_id;

    $volunteer_id =
        (int)$volunteer_id;

    $quantity =
        (int)$quantity;

    if (
        $request_id <= 0 ||
        $volunteer_id <= 0 ||
        $quantity <= 0
    ) {
        return false;
    }

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
    $request_id =
        (int)$request_id;

    $volunteer_id =
        (int)$volunteer_id;

    if (
        $request_id <= 0 ||
        $volunteer_id <= 0
    ) {
        return false;
    }

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
    $volunteer_id =
        (int)$volunteer_id;

    $keyword =
        trim($keyword);

    if ($volunteer_id <= 0) {
        return [];
    }

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
            created_at,
            updated_at
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


/*
|--------------------------------------------------------------------------
| ADMIN - GET ALL RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

function getAllResourceRequestsForAdmin(
    $conn
) {
    $sql = "
        SELECT
            rr.id,
            rr.volunteer_id,
            rr.resource_type,
            rr.quantity,
            rr.description,
            rr.status,
            rr.created_at,
            rr.updated_at,

            u.name AS volunteer_name,
            u.email AS volunteer_email,
            u.phone AS volunteer_phone,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS availability_status,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS volunteer_availability,

            vp.address AS volunteer_address,
            vp.blood_group AS volunteer_blood_group,
            vp.experience AS volunteer_experience,
            vp.skills AS volunteer_skills,
            vp.emergency_contact
                AS volunteer_emergency_contact

        FROM resource_requests AS rr

        INNER JOIN users AS u
            ON rr.volunteer_id = u.id

        LEFT JOIN volunteer_profiles AS vp
            ON u.id = vp.user_id

        WHERE u.role = 'volunteer'

        ORDER BY
            CASE rr.status
                WHEN 'pending' THEN 1
                WHEN 'approved' THEN 2
                WHEN 'rejected' THEN 3
                WHEN 'completed' THEN 4
                ELSE 5
            END,
            rr.created_at DESC,
            rr.id DESC
    ";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return [];
    }

    if (!mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        return [];
    }

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
| ADMIN - GET SINGLE RESOURCE REQUEST
|--------------------------------------------------------------------------
*/

function getResourceRequestForAdminById(
    $conn,
    $request_id
) {
    $request_id =
        (int)$request_id;

    if ($request_id <= 0) {
        return null;
    }

    $sql = "
        SELECT
            rr.id,
            rr.volunteer_id,
            rr.resource_type,
            rr.quantity,
            rr.description,
            rr.status,
            rr.created_at,
            rr.updated_at,

            u.name AS volunteer_name,
            u.email AS volunteer_email,
            u.phone AS volunteer_phone,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS availability_status,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS volunteer_availability,

            vp.address AS volunteer_address,
            vp.blood_group AS volunteer_blood_group,
            vp.experience AS volunteer_experience,
            vp.skills AS volunteer_skills,
            vp.emergency_contact
                AS volunteer_emergency_contact

        FROM resource_requests AS rr

        INNER JOIN users AS u
            ON rr.volunteer_id = u.id

        LEFT JOIN volunteer_profiles AS vp
            ON u.id = vp.user_id

        WHERE rr.id = ?
        AND u.role = 'volunteer'

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
        "i",
        $request_id
    );

    if (!mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        return null;
    }

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
    $request_id =
        (int)$request_id;

    $status =
        trim($status);

    $allowedStatuses = [
        'pending',
        'approved',
        'rejected',
        'completed'
    ];

    if (
        $request_id <= 0 ||
        !in_array(
            $status,
            $allowedStatuses,
            true
        )
    ) {
        return false;
    }

    $sql = "
        UPDATE resource_requests
        SET status = ?
        WHERE id = ?
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
        "si",
        $status,
        $request_id
    );

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    return $success;
}


/*
|--------------------------------------------------------------------------
| ADMIN - SEARCH RESOURCE REQUESTS
|--------------------------------------------------------------------------
*/

function searchResourceRequestsForAdmin(
    $conn,
    $keyword
) {
    $keyword =
        trim($keyword);

    if ($keyword === '') {

        return getAllResourceRequestsForAdmin(
            $conn
        );
    }

    $search =
        '%' . $keyword . '%';

    $sql = "
        SELECT
            rr.id,
            rr.volunteer_id,
            rr.resource_type,
            rr.quantity,
            rr.description,
            rr.status,
            rr.created_at,
            rr.updated_at,

            u.name AS volunteer_name,
            u.email AS volunteer_email,
            u.phone AS volunteer_phone,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS availability_status,

            COALESCE(
                vp.availability_status,
                'unavailable'
            ) AS volunteer_availability,

            vp.address AS volunteer_address,
            vp.blood_group AS volunteer_blood_group,
            vp.experience AS volunteer_experience,
            vp.skills AS volunteer_skills,
            vp.emergency_contact
                AS volunteer_emergency_contact

        FROM resource_requests AS rr

        INNER JOIN users AS u
            ON rr.volunteer_id = u.id

        LEFT JOIN volunteer_profiles AS vp
            ON u.id = vp.user_id

        WHERE u.role = 'volunteer'

        AND
        (
            u.name LIKE ?
            OR u.email LIKE ?
            OR u.phone LIKE ?
            OR rr.resource_type LIKE ?
            OR rr.description LIKE ?
            OR rr.status LIKE ?
            OR vp.availability_status LIKE ?
        )

        ORDER BY
            CASE rr.status
                WHEN 'pending' THEN 1
                WHEN 'approved' THEN 2
                WHEN 'rejected' THEN 3
                WHEN 'completed' THEN 4
                ELSE 5
            END,
            rr.created_at DESC,
            rr.id DESC
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
        "sssssss",
        $search,
        $search,
        $search,
        $search,
        $search,
        $search,
        $search
    );

    if (!mysqli_stmt_execute($stmt)) {

        mysqli_stmt_close($stmt);

        return [];
    }

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