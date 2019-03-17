<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/constants/cookie.php';
require $_SERVER['DOCUMENT_ROOT'] . '/db/query/user.php';

function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function isExpiredSession()
{
    return !isset($_SESSION['email']);
}

function resetLoginCookie($email)
{
    return setcookie('email', $email, time() + LIFETIME_LOGIN_COOKIE);
}

if (filter_var($_GET['logout'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
}

$successAuth = $failureAuth = false;

if (isset($_POST['submit_auth'])) {
    $password = $email = $emailErr = $passwordErr = null;
    if (isset($_POST['email'])) {
        $email = testInput($_POST['email']);
    }
    if (isset($_POST['password'])) {
        $password = testInput($_POST['password']);
    }
    $failureAuth = true;
} else {
    $email = null;
    if (isExpiredSession() && isset($_COOKIE['email'])) {
        $email = $_COOKIE['email'];
        resetLoginCookie($email);
        require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
    }
    $email = $_SESSION['email'] ?? $email;
    $password = $_SESSION['password'] ?? null;
}

$user = findUserByLoginAndPassword($email, $password, $pdo);
if ($user) {
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    resetLoginCookie($email);
    $email = $password = null;
    $successAuth = true;
    $failureAuth = false;
}


