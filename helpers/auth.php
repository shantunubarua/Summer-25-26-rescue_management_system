<?php

/*
|--------------------------------------------------------------------------
| SESSION SECURITY SETTINGS
|--------------------------------------------------------------------------
|
| Must be configured before session_start().
|
*/

if (session_status() === PHP_SESSION_NONE) {

    ini_set(
        'session.use_strict_mode',
        '1'
    );

    ini_set(
        'session.use_only_cookies',
        '1'
    );

    $secureCookie =
        !empty($_SERVER['HTTPS']) &&
        $_SERVER['HTTPS'] !== 'off';

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $secureCookie,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}


/*
|--------------------------------------------------------------------------
| SESSION TIMEOUT
|--------------------------------------------------------------------------
|
| 30 minutes of inactivity.
|
*/

define(
    'SESSION_TIMEOUT_SECONDS',
    1800
);


/*
|--------------------------------------------------------------------------
| LOGIN CHECK
|--------------------------------------------------------------------------
*/

function isLoggedIn()
{
    return (
        isset($_SESSION['user']) &&
        is_array($_SESSION['user']) &&
        !empty($_SESSION['user']['id']) &&
        !empty($_SESSION['user']['role'])
    );
}


/*
|--------------------------------------------------------------------------
| REQUIRE LOGIN
|--------------------------------------------------------------------------
*/

function requireLogin()
{
    if (!isLoggedIn()) {

        header(
            "Location: index.php?page=login"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CHECK INACTIVITY TIMEOUT
    |--------------------------------------------------------------------------
    */

    $lastActivity =
        (int)(
            $_SESSION['last_activity']
            ?? 0
        );


    if (
        $lastActivity > 0 &&
        (
            time() - $lastActivity
        ) > SESSION_TIMEOUT_SECONDS
    ) {

        logoutUser();

        header(
            "Location: index.php?page=login&expired=1"
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE LAST ACTIVITY
    |--------------------------------------------------------------------------
    */

    $_SESSION['last_activity'] =
        time();
}


/*
|--------------------------------------------------------------------------
| ROLE - ADMIN
|--------------------------------------------------------------------------
*/

function requireAdmin()
{
    requireLogin();

    if (
        ($_SESSION['user']['role'] ?? '')
        !== 'admin'
    ) {

        http_response_code(403);

        die(
            "Access denied."
        );
    }
}


/*
|--------------------------------------------------------------------------
| ROLE - WITNESS
|--------------------------------------------------------------------------
*/

function requireWitness()
{
    requireLogin();

    if (
        ($_SESSION['user']['role'] ?? '')
        !== 'witness'
    ) {

        http_response_code(403);

        die(
            "Access denied."
        );
    }
}


/*
|--------------------------------------------------------------------------
| ROLE - HELP SEEKER
|--------------------------------------------------------------------------
*/

function requireHelpSeeker()
{
    requireLogin();

    if (
        ($_SESSION['user']['role'] ?? '')
        !== 'help_seeker'
    ) {

        http_response_code(403);

        die(
            "Access denied."
        );
    }
}


/*
|--------------------------------------------------------------------------
| ROLE - VOLUNTEER
|--------------------------------------------------------------------------
*/

function requireVolunteer()
{
    requireLogin();

    if (
        ($_SESSION['user']['role'] ?? '')
        !== 'volunteer'
    ) {

        http_response_code(403);

        die(
            "Access denied."
        );
    }
}


/*
|--------------------------------------------------------------------------
| LOGOUT USER
|--------------------------------------------------------------------------
*/

function logoutUser()
{
    /*
    |--------------------------------------------------------------------------
    | REMOVE SESSION DATA
    |--------------------------------------------------------------------------
    */

    $_SESSION = [];


    /*
    |--------------------------------------------------------------------------
    | REMOVE SESSION COOKIE
    |--------------------------------------------------------------------------
    */

    if (
        ini_get(
            "session.use_cookies"
        )
    ) {

        $params =
            session_get_cookie_params();


        setcookie(
            session_name(),
            '',
            [
                'expires' =>
                    time() - 42000,

                'path' =>
                    $params['path']
                    ?? '/',

                'domain' =>
                    $params['domain']
                    ?? '',

                'secure' =>
                    $params['secure']
                    ?? false,

                'httponly' =>
                    $params['httponly']
                    ?? true,

                'samesite' =>
                    $params['samesite']
                    ?? 'Lax'
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY SESSION
    |--------------------------------------------------------------------------
    */

    session_destroy();
}


/*
|--------------------------------------------------------------------------
| CSRF TOKEN
|--------------------------------------------------------------------------
*/

function getCsrfToken()
{
    if (
        empty($_SESSION['csrf_token']) ||
        !is_string(
            $_SESSION['csrf_token']
        )
    ) {

        $_SESSION['csrf_token'] =
            bin2hex(
                random_bytes(32)
            );
    }


    return
        $_SESSION['csrf_token'];
}


/*
|--------------------------------------------------------------------------
| CSRF HIDDEN INPUT
|--------------------------------------------------------------------------
*/

function csrfField()
{
    $token =
        getCsrfToken();


    return
        '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(
            $token,
            ENT_QUOTES,
            'UTF-8'
        ) .
        '">';
}


/*
|--------------------------------------------------------------------------
| VALIDATE CSRF TOKEN
|--------------------------------------------------------------------------
*/

function validateCsrfToken()
{
    $sessionToken =
        $_SESSION['csrf_token']
        ?? '';


    $submittedToken =
        $_POST['csrf_token']
        ?? '';


    if (
        !is_string($sessionToken) ||
        !is_string($submittedToken) ||
        $sessionToken === '' ||
        $submittedToken === ''
    ) {

        return false;
    }


    return hash_equals(
        $sessionToken,
        $submittedToken
    );
}


/*
|--------------------------------------------------------------------------
| REQUIRE VALID CSRF TOKEN
|--------------------------------------------------------------------------
*/

function requireValidCsrfToken()
{
    if (
        !validateCsrfToken()
    ) {

        http_response_code(403);

        die(
            "Invalid or expired form request."
        );
    }
}