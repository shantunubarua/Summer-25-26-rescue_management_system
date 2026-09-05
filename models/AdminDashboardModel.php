<?php

function getAdminDashboardCounts($conn)
{
    $counts = [
        'notifications' => 0,
        'feedback' => 0,
        'rescue_reports' => 0,
        'emergency_requests' => 0
    ];

    $sql = "SELECT COUNT(*) AS total
            FROM notifications";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $counts['notifications'] = (int)$row['total'];
    }


    $sql = "SELECT COUNT(*) AS total
            FROM feedback";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $counts['feedback'] = (int)$row['total'];
    }


    $sql = "SELECT COUNT(*) AS total
            FROM rescue_reports";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $counts['rescue_reports'] = (int)$row['total'];
    }


    $sql = "SELECT COUNT(*) AS total
            FROM emergency_requests";

    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        $counts['emergency_requests'] = (int)$row['total'];
    }


    return $counts;
}