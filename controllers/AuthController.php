<?php

require_once "config/database.php";
require_once "helpers/auth.php";

function loginUser()
{
    global $conn;

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        return "Email and password are required.";
    }

    $sql = "SELECT id, name, email, password, role
            FROM users
            WHERE email = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $user = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if (!$user) {
        return "Invalid email or password.";
    }

    if (!password_verify($password, $user['password'])) {
        return "Invalid email or password.";
    }

    session_regenerate_id(true);

    unset($user['password']);

    $_SESSION['user'] = $user;

   if ($user['role'] === 'admin') {

    header("Location: index.php?page=admin-dashboard");
    exit;

} elseif ($user['role'] === 'witness') {

    header("Location: index.php?page=witness-dashboard");
    exit;

}
elseif ($user['role'] === 'help_seeker') {

    header("Location: index.php?page=helpseeker-dashboard");
    exit;

}
elseif ($user['role'] === 'volunteer') {

    header("Location: index.php?page=volunteer-dashboard");
    exit;

}

    return "Invalid role.";
}