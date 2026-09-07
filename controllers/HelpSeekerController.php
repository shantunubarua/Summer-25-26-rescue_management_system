<?php

require_once "models/HelpSeekerModel.php";

function handleCreateEmergencyRequest($conn)
{
    $emergency_type = trim($_POST['emergency_type'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $priority = trim($_POST['priority'] ?? '');
    $victim_type = trim($_POST['victim_type'] ?? '');
    $victim_information = trim($_POST['victim_information'] ?? '');
    $victim_count = isset($_POST['victim_count'])
        ? (int)$_POST['victim_count']
        : 1;

    $contact_information = trim(
        $_POST['contact_information'] ?? ''
    );

    if (
        $emergency_type === '' ||
        $location === '' ||
        $description === '' ||
        $priority === '' ||
        $victim_type === '' ||
        $contact_information === ''
    ) {
        return "All required fields must be completed.";
    }

    $allowed_types = [
        'accident',
        'fire',
        'flood',
        'medical',
        'other'
    ];

    if (!in_array($emergency_type, $allowed_types, true)) {
        return "Invalid emergency type.";
    }

    $allowed_priorities = [
        'low',
        'medium',
        'high',
        'critical'
    ];

    if (!in_array($priority, $allowed_priorities, true)) {
        return "Invalid priority.";
    }

    $allowed_victim_types = [
        'self',
        'other'
    ];

    if (!in_array($victim_type, $allowed_victim_types, true)) {
        return "Invalid victim type.";
    }

    if ($victim_count < 1) {
        return "Victim count must be at least 1.";
    }

    if (
        $victim_type === 'other' &&
        $victim_information === ''
    ) {
        return "Please provide information about the victim.";
    }

    if ($victim_type === 'self') {
        $victim_information = null;
    }

    $help_seeker_id = $_SESSION['user']['id'];

    if (
        createEmergencyRequest(
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
        )
    ) {
        header(
            "Location: index.php?page=helpseeker-requests"
        );
        exit;
    }

    return "Failed to submit emergency request.";
}