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

function registerUser()
{
    global $conn;

    $name =
        trim($_POST['name'] ?? '');

    $email =
        trim($_POST['email'] ?? '');

    $phone =
        trim($_POST['phone'] ?? '');

    $password =
        $_POST['password'] ?? '';

    $confirmPassword =
        $_POST['confirm_password'] ?? '';

    $role =
        $_POST['role'] ?? '';


    /*
    |--------------------------------------------------------------------------
    | REQUIRED FIELDS
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $email === '' ||
        $password === '' ||
        $confirmPassword === '' ||
        $role === ''
    ) {
        return "Please complete all required fields.";
    }


    /*
    |--------------------------------------------------------------------------
    | NAME VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        strlen($name) < 2 ||
        strlen($name) > 100
    ) {
        return "Name must be between 2 and 100 characters.";
    }


    /*
    |--------------------------------------------------------------------------
    | EMAIL VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !filter_var(
            $email,
            FILTER_VALIDATE_EMAIL
        )
    ) {
        return "Please enter a valid email address.";
    }


    /*
    |--------------------------------------------------------------------------
    | PHONE VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $phone !== '' &&
        !preg_match(
            '/^[0-9+\-\s]{7,20}$/',
            $phone
        )
    ) {
        return "Please enter a valid phone number.";
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD VALIDATION
    |--------------------------------------------------------------------------
    */

    if (strlen($password) < 8) {
        return "Password must be at least 8 characters.";
    }

    if ($password !== $confirmPassword) {
        return "Password and confirm password do not match.";
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE VALIDATION
    |--------------------------------------------------------------------------
    | Admin registration is NEVER allowed publicly.
    |--------------------------------------------------------------------------
    */

    $allowedRoles = [
        'volunteer',
        'witness',
        'help_seeker'
    ];

    if (
        !in_array(
            $role,
            $allowedRoles,
            true
        )
    ) {
        return "Invalid registration role.";
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK EMAIL ALREADY EXISTS
    |--------------------------------------------------------------------------
    */

    $sql =
        "SELECT id
         FROM users
         WHERE email = ?
         LIMIT 1";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return "Unable to process registration.";
    }

    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );

    mysqli_stmt_execute($stmt);

    $result =
        mysqli_stmt_get_result($stmt);

    $existingUser =
        mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    if ($existingUser) {
        return "This email address is already registered.";
    }


    /*
    |--------------------------------------------------------------------------
    | HASH PASSWORD
    |--------------------------------------------------------------------------
    */

    $hashedPassword =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );

    if ($hashedPassword === false) {
        return "Unable to process password.";
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    $sql =
        "INSERT INTO users
        (
            name,
            email,
            phone,
            password,
            role
        )
        VALUES (?, ?, ?, ?, ?)";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return "Unable to create account.";
    }

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $name,
        $email,
        $phone,
        $hashedPassword,
        $role
    );

    $success =
        mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

    if (!$success) {
        return "Unable to create account.";
    }


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    return '';
}