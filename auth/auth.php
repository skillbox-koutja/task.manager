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
    return !isset($_SESSION['login']);
}

function resetLoginCookie($login)
{
    return setcookie('login', $login, time() + LIFETIME_LOGIN_COOKIE);
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
    $login = null;
    if (isExpiredSession() && isset($_COOKIE['login'])) {
        $login = $_COOKIE['login'];
        resetLoginCookie($login);
        require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
    }
    $login = $_SESSION['login'] ?? $login;
    $password = $_SESSION['password'] ?? null;
}

$successAuth = checkAuth($login, $password);
if ($successAuth) {
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    resetLoginCookie($login);
    $login = $password = null;
    $failureAuth = false;
}


