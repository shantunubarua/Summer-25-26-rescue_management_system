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

    $_SESSION['last_activity'] =
    time();

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
/*
|--------------------------------------------------------------------------
| VALIDATE PASSWORD RESET TOKEN
|--------------------------------------------------------------------------
*/

function isValidPasswordResetToken($token)
{
    $token =
        trim($token);


    if ($token === '') {
        return false;
    }


    $resetData =
        $_SESSION['password_reset']
        ?? null;


    if (
        !is_array($resetData) ||
        empty($resetData['user_id']) ||
        empty($resetData['token_hash']) ||
        empty($resetData['expires_at'])
    ) {
        return false;
    }


    if (
        time() >
        (int)$resetData['expires_at']
    ) {

        unset(
            $_SESSION['password_reset']
        );

        return false;
    }


    $submittedHash =
        hash(
            'sha256',
            $token
        );


    return hash_equals(
        $resetData['token_hash'],
        $submittedHash
    );
}


/*
|--------------------------------------------------------------------------
| FORGOT PASSWORD
|--------------------------------------------------------------------------
*/

function handleForgotPassword($conn)
{
    $login =
        trim(
            $_POST['login']
            ?? ''
        );


    $phone =
        trim(
            $_POST['phone']
            ?? ''
        );


    if (
        $login === '' ||
        $phone === ''
    ) {

        return [
            'error' =>
                'Username/email and registered phone number are required.',

            'token' => ''
        ];
    }


    if (
        strlen($login) > 150 ||
        strlen($phone) > 20
    ) {

        return [
            'error' =>
                'The provided account information could not be verified.',

            'token' => ''
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY ACCOUNT
    |--------------------------------------------------------------------------
    */

    $sql =
        "SELECT
            id,
            username,
            email,
            phone
         FROM users
         WHERE
            (email = ? OR username = ?)
            AND phone = ?
         LIMIT 1";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        return [
            'error' =>
                'Unable to process password reset request.',

            'token' => ''
        ];
    }


    mysqli_stmt_bind_param(
        $stmt,
        "sss",
        $login,
        $login,
        $phone
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


    if (!$user) {

        return [
            'error' =>
                'The provided account information could not be verified.',

            'token' => ''
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ONE-TIME TOKEN
    |--------------------------------------------------------------------------
    */

    $token =
        bin2hex(
            random_bytes(32)
        );


    $_SESSION['password_reset'] = [

        'user_id' =>
            (int)$user['id'],

        'token_hash' =>
            hash(
                'sha256',
                $token
            ),

        'expires_at' =>
            time() + 600
    ];


    return [
        'error' => '',
        'token' => $token
    ];
}


/*
|--------------------------------------------------------------------------
| RESET PASSWORD
|--------------------------------------------------------------------------
*/

function handleResetPassword(
    $conn,
    $token
) {

    $password =
        $_POST['password']
        ?? '';


    $confirmPassword =
        $_POST['confirm_password']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | TOKEN VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        !isValidPasswordResetToken(
            $token
        )
    ) {

        return
            'Invalid or expired password reset link.';
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD VALIDATION
    |--------------------------------------------------------------------------
    */

    if (
        strlen($password) < 8
    ) {

        return
            'Password must be at least 8 characters.';
    }


    if (
        $password !==
        $confirmPassword
    ) {

        return
            'Passwords do not match.';
    }


    $resetData =
        $_SESSION['password_reset'];


    $user_id =
        (int)$resetData['user_id'];


    if ($user_id <= 0) {

        return
            'Invalid password reset request.';
    }


    /*
    |--------------------------------------------------------------------------
    | HASH NEW PASSWORD
    |--------------------------------------------------------------------------
    */

    $hashedPassword =
        password_hash(
            $password,
            PASSWORD_DEFAULT
        );


    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    $sql =
        "UPDATE users
         SET
            password = ?,
            updated_at = NOW()
         WHERE id = ?";


    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );


    if (!$stmt) {

        return
            'Unable to reset password.';
    }


    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $hashedPassword,
        $user_id
    );


    $success =
        mysqli_stmt_execute(
            $stmt
        );


    $affectedRows =
        mysqli_stmt_affected_rows(
            $stmt
        );


    mysqli_stmt_close(
        $stmt
    );


    if (
        !$success ||
        $affectedRows !== 1
    ) {

        return
            'Unable to reset password.';
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY ONE-TIME RESET TOKEN
    |--------------------------------------------------------------------------
    */

    unset(
        $_SESSION['password_reset']
    );


    unset(
        $_SESSION['csrf_token']
    );


    session_regenerate_id(
        true
    );


    header(
        "Location: index.php?page=login&reset=1"
    );

    exit;
}
/*
|--------------------------------------------------------------------------
| CHANGE PASSWORD
|--------------------------------------------------------------------------
*/

function handleChangePassword($conn)
{
    $userId =
        (int)(
            $_SESSION['user']['id']
            ?? 0
        );

    $currentPassword =
        $_POST['current_password']
        ?? '';

    $newPassword =
        $_POST['new_password']
        ?? '';

    $confirmPassword =
        $_POST['confirm_password']
        ?? '';


    /*
    |--------------------------------------------------------------------------
    | BASIC VALIDATION
    |--------------------------------------------------------------------------
    */

    if ($userId <= 0) {
        return "Invalid user account.";
    }

    if (
        $currentPassword === '' ||
        $newPassword === '' ||
        $confirmPassword === ''
    ) {
        return "All password fields are required.";
    }

    if (strlen($newPassword) < 8) {
        return "New password must be at least 8 characters.";
    }

    if ($newPassword !== $confirmPassword) {
        return "New passwords do not match.";
    }


    /*
    |--------------------------------------------------------------------------
    | GET CURRENT PASSWORD FROM DATABASE
    |--------------------------------------------------------------------------
    */

    $sql =
        "SELECT password
         FROM users
         WHERE id = ?
         LIMIT 1";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return "Unable to change password.";
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $userId
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


    if (!$user || empty($user['password'])) {
        return "User account not found.";
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY CURRENT PASSWORD
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | Password update MUST NOT happen unless this passes.
    |
    */

    $currentPasswordValid =
        password_verify(
            $currentPassword,
            $user['password']
        );


    if ($currentPasswordValid !== true) {
        return "Current password is incorrect.";
    }


    /*
    |--------------------------------------------------------------------------
    | NEW PASSWORD MUST BE DIFFERENT
    |--------------------------------------------------------------------------
    */

    if (
        password_verify(
            $newPassword,
            $user['password']
        )
    ) {
        return "New password must be different from your current password.";
    }


    /*
    |--------------------------------------------------------------------------
    | HASH NEW PASSWORD
    |--------------------------------------------------------------------------
    */

    $newPasswordHash =
        password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

    if ($newPasswordHash === false) {
        return "Unable to change password.";
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    $sql =
        "UPDATE users
         SET password = ?
         WHERE id = ?";

    $stmt =
        mysqli_prepare(
            $conn,
            $sql
        );

    if (!$stmt) {
        return "Unable to change password.";
    }

    mysqli_stmt_bind_param(
        $stmt,
        "si",
        $newPasswordHash,
        $userId
    );

    $success =
        mysqli_stmt_execute(
            $stmt
        );

    mysqli_stmt_close(
        $stmt
    );


    if (!$success) {
        return "Unable to change password.";
    }


    /*
    |--------------------------------------------------------------------------
    | SESSION SECURITY
    |--------------------------------------------------------------------------
    */

    session_regenerate_id(
        true
    );

    $_SESSION['last_activity'] =
        time();


    header(
        "Location: index.php?page=change-password&changed=1"
    );

    exit;
}