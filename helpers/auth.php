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