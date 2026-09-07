<?php

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD COUNTS
|--------------------------------------------------------------------------
*/

function getAdminDashboardCounts($conn)
{
    $counts = [
        'notifications' => 0,
        'feedback' => 0,
        'rescue_reports' => 0,
        'emergency_requests' => 0,

        'volunteers' => 0,
        'witnesses' => 0,
        'help_seekers' => 0
    ];


    $sql = "
        SELECT

            (SELECT COUNT(*)
             FROM notifications)
             AS notifications,

            (SELECT COUNT(*)
             FROM feedback)
             AS feedback,

            (SELECT COUNT(*)
             FROM rescue_reports)
             AS rescue_reports,

            (SELECT COUNT(*)
             FROM emergency_requests)
             AS emergency_requests,

            (SELECT COUNT(*)
             FROM users
             WHERE role = 'volunteer')
             AS volunteers,

            (SELECT COUNT(*)
             FROM users
             WHERE role = 'witness')
             AS witnesses,

            (SELECT COUNT(*)
             FROM users
             WHERE role = 'help_seeker')
             AS help_seekers
    ";


    $result = mysqli_query(
        $conn,
        $sql
    );


    if (!$result) {

        return $counts;
    }


    $row = mysqli_fetch_assoc(
        $result
    );


    if ($row) {

        $counts['notifications'] =
            (int)($row['notifications'] ?? 0);

        $counts['feedback'] =
            (int)($row['feedback'] ?? 0);

        $counts['rescue_reports'] =
            (int)($row['rescue_reports'] ?? 0);

        $counts['emergency_requests'] =
            (int)($row['emergency_requests'] ?? 0);


        /*
        |--------------------------------------------------------------------------
        | REGISTERED USERS
        |--------------------------------------------------------------------------
        */

        $counts['volunteers'] =
            (int)($row['volunteers'] ?? 0);

        $counts['witnesses'] =
            (int)($row['witnesses'] ?? 0);

        $counts['help_seekers'] =
            (int)($row['help_seekers'] ?? 0);
    }


    return $counts;
}