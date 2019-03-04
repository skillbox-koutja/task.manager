<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/checkAuth.php';

function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isExpiredSession()
{
    return (time() - $_SESSION['lastAccess']) > LIFETIME_SESSION;
}

if (filter_var($_GET['logout'], FILTER_VALIDATE_BOOLEAN)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
}

$successAuth = $failureAuth = false;

if (isset($_POST['submit_auth'])) {
    $password = $login = $loginErr = $passwordErr = null;
    if (isset($_POST['login'])) {
        $login = testInput($_POST['login']);
    }
    if (isset($_POST['password'])) {
        $password = testInput($_POST['password']);
    }
    $failureAuth = true;
} else {
    $password = null;
    if (isset($_SESSION['lastAccess']) && isExpiredSession()) {
        $password = $_SESSION['password'] ?? null;
        require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
    }
    $login = $_SESSION['login'] ?? null;
    $password = $_SESSION['password'] ?? $password;
}

$successAuth = checkAuth($login, $password);
if ($successAuth) {
    $_SESSION['lastAccess'] = time();
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    $login = $password = null;
    $failureAuth = false;
}