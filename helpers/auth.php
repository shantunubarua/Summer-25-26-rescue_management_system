<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn()
{
    return isset($_SESSION['user']);
}

function requireLogin()
{
    if (!isLoggedIn()) {
        header("Location: index.php?page=login");
        exit;
    }
}

function requireAdmin()
{
    requireLogin();

    if ($_SESSION['user']['role'] !== 'admin') {
        die("Access denied.");
    }
}

function logoutUser()
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();

        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    
    }

    session_destroy();

}

function requireWitness()
{
    requireLogin();

    if ($_SESSION['user']['role'] !== 'witness') {
        die("Access denied.");
    }
}
function requireHelpSeeker()
{
    requireLogin();

    if ($_SESSION['user']['role'] !== 'help_seeker') {
        die("Access denied.");
    }
}
function requireVolunteer()
{
    requireLogin();

    if ($_SESSION['user']['role'] !== 'volunteer') {
        die("Access denied.");
    }
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
        !is_string($_SESSION['csrf_token'])
    ) {

        $_SESSION['csrf_token'] =
            bin2hex(
                random_bytes(32)
            );
    }

    return $_SESSION['csrf_token'];
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
    if (!validateCsrfToken()) {

        http_response_code(403);

        die(
            "Invalid or expired form request."
        );
    }
}