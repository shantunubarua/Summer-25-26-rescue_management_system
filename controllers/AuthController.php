<?php

require_once "config/database.php";
require_once "helpers/auth.php";


/*
|--------------------------------------------------------------------------
| REMEMBER EMAIL COOKIE
|--------------------------------------------------------------------------
*/

function updateRememberEmailCookie($email)
{
    $rememberEmail =
        isset($_POST['remember_email']) &&
        $_POST['remember_email'] === '1';


    /*
    |--------------------------------------------------------------------------
    | COOKIE SECURITY
    |--------------------------------------------------------------------------
    */

    $secureCookie =
        !empty($_SERVER['HTTPS']) &&
        $_SERVER['HTTPS'] !== 'off';


    if ($rememberEmail) {

        /*
        |--------------------------------------------------------------------------
        | REMEMBER EMAIL FOR 30 DAYS
        |--------------------------------------------------------------------------
        */

        setcookie(
            'remember_email',
            $email,
            [
                'expires' =>
                    time() + (60 * 60 * 24 * 30),

                'path' => '/',

                'secure' =>
                    $secureCookie,

                'httponly' =>
                    true,

                'samesite' =>
                    'Lax'
            ]
        );

    } else {

        /*
        |--------------------------------------------------------------------------
        | REMOVE EXISTING REMEMBER EMAIL COOKIE
        |--------------------------------------------------------------------------
        */

        setcookie(
            'remember_email',
            '',
            [
                'expires' =>
                    time() - 3600,

                'path' => '/',

                'secure' =>
                    $secureCookie,

                'httponly' =>
                    true,

                'samesite' =>
                    'Lax'
            ]
        );
    }
}


/*
|--------------------------------------------------------------------------
| LOGIN USER
|--------------------------------------------------------------------------
*/

function loginUser()
{
    global $conn;


    $login =
        trim(
            $_POST['login']
            ?? $_POST['email']
            ?? ''
        );


    $password =
        $_POST['password']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | REQUIRED VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        $login === '' ||
        $password === ''
    ) {

        return
            "Username or email and password are required.";
    }


    /*
    |--------------------------------------------------------------------------
    | FIND USER BY USERNAME OR EMAIL
    |--------------------------------------------------------------------------
    */

    $sql =
        "SELECT
            id,
            name,
            username,
            email,
            password,
            role
         FROM users
         WHERE email = ?
            OR username = ?
         LIMIT 1";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        return
            "Unable to process login.";
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $login,
        $login
    );


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    $user =
        mysqli_fetch_assoc(
            $result
        );


    mysqli_stmt_close(
        $stmt
    );


    /*
    |--------------------------------------------------------------------------
    | VERIFY LOGIN
    |--------------------------------------------------------------------------
    */

    if (
        !$user ||
        !password_verify(
            $password,
            $user['password']
        )
    ) {

        return
            "Invalid username/email or password.";
    }


    /*
    |--------------------------------------------------------------------------
    | VALID ROLE CHECK
    |--------------------------------------------------------------------------
    */

    $allowedRoles = [
        'admin',
        'volunteer',
        'witness',
        'help_seeker'
    ];


    if (
        !in_array(
            $user['role'],
            $allowedRoles,
            true
        )
    ) {

        return
            "Invalid role.";
    }


    /*
    |--------------------------------------------------------------------------
    | REMEMBER EMAIL COOKIE
    |--------------------------------------------------------------------------
    |
    | Even if the user logged in using username,
    | the real account email is stored.
    |
    */

    updateRememberEmailCookie(
        $user['email']
    );


    /*
    |--------------------------------------------------------------------------
    | CREATE SECURE SESSION
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(
        true
    );


    unset(
        $user['password']
    );


    $_SESSION['user'] =
        $user;


    /*
    |--------------------------------------------------------------------------
    | ROLE REDIRECT
    |--------------------------------------------------------------------------
    */

    if (
        $user['role'] === 'admin'
    ) {

        header(
            "Location: index.php?page=admin-dashboard"
        );

        exit;
    }


    if (
        $user['role'] === 'witness'
    ) {

        header(
            "Location: index.php?page=witness-dashboard"
        );

        exit;
    }


    if (
        $user['role'] === 'help_seeker'
    ) {

        header(
            "Location: index.php?page=helpseeker-dashboard"
        );

        exit;
    }


    if (
        $user['role'] === 'volunteer'
    ) {

        header(
            "Location: index.php?page=volunteer-dashboard"
        );

        exit;
    }


    return
        "Invalid role.";
}


/*
|--------------------------------------------------------------------------
| REGISTER USER
|--------------------------------------------------------------------------
*/

function registerUser()
{
    global $conn;


    $name =
        trim(
            $_POST['name']
            ?? ''
        );


    $username =
        strtolower(
            trim(
                $_POST['username']
                ?? ''
            )
        );


    $email =
        trim(
            $_POST['email']
            ?? ''
        );


    $phone =
        trim(
            $_POST['phone']
            ?? ''
        );


    $password =
        $_POST['password']
        ?? '';


    $confirmPassword =
        $_POST['confirm_password']
        ?? '';


    $role =
        trim(
            $_POST['role']
            ?? ''
        );


    /*
    |--------------------------------------------------------------------------
    | REQUIRED FIELDS
    |--------------------------------------------------------------------------
    */

    if (
        $name === '' ||
        $username === '' ||
        $email === '' ||
        $password === '' ||
        $confirmPassword === '' ||
        $role === ''
    ) {

        return
            "All required fields must be completed.";
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

        return
            "Name must be between 2 and 100 characters.";
    }


    /*
    |--------------------------------------------------------------------------
    | USERNAME VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !preg_match(
            '/^[a-zA-Z0-9_]{3,30}$/',
            $username
        )
    ) {

        return
            "Username must be 3-30 characters and contain only letters, numbers, and underscore.";
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

        return
            "Please enter a valid email address.";
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

        return
            "Please enter a valid phone number.";
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        strlen(
            $password
        ) < 8
    ) {

        return
            "Password must be at least 8 characters.";
    }


    if (
        $password !==
        $confirmPassword
    ) {

        return
            "Passwords do not match.";
    }


    /*
    |--------------------------------------------------------------------------
    | PUBLIC ROLE VALIDATION
    |--------------------------------------------------------------------------
    |
    | Admin registration is intentionally blocked.
    |
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

        return
            "Invalid registration role.";
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK DUPLICATE EMAIL
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

        return
            "Unable to create account.";
    }


    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $email
    );


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    if (
        mysqli_fetch_assoc(
            $result
        )
    ) {

        mysqli_stmt_close(
            $stmt
        );

        return
            "Email address is already registered.";
    }


    mysqli_stmt_close(
        $stmt
    );


    /*
    |--------------------------------------------------------------------------
    | CHECK DUPLICATE USERNAME
    |--------------------------------------------------------------------------
    */

    $sql =
        "SELECT id
         FROM users
         WHERE username = ?
         LIMIT 1";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        return
            "Unable to create account.";
    }


    mysqli_stmt_bind_param(
        $stmt,
        "s",
        $username
    );


    mysqli_stmt_execute(
        $stmt
    );


    $result =
        mysqli_stmt_get_result(
            $stmt
        );


    if (
        mysqli_fetch_assoc(
            $result
        )
    ) {

        mysqli_stmt_close(
            $stmt
        );

        return
            "Username is already taken.";
    }


    mysqli_stmt_close(
        $stmt
    );


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


    /*
    |--------------------------------------------------------------------------
    | CREATE USER
    |--------------------------------------------------------------------------
    */

    $sql =
        "INSERT INTO users
        (
            name,
            username,
            email,
            phone,
            password,
            role
        )
        VALUES (?, ?, ?, ?, ?, ?)";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        return
            "Unable to create account.";
    }


    mysqli_stmt_bind_param(
        $stmt,
        "ssssss",
        $name,
        $username,
        $email,
        $phone,
        $hashedPassword,
        $role
    );


    $success =
        mysqli_stmt_execute(
            $stmt
        );


    mysqli_stmt_close(
        $stmt
    );


    if (!$success) {

        return
            "Unable to create account.";
    }


    return '';
}