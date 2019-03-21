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
    return !isset($_SESSION['user']);
}

function resetLoginCookie($email)
{
    return setcookie('email', $email, time() + LIFETIME_LOGIN_COOKIE);
}

if (filter_var($_GET['logout'] ?? false, FILTER_VALIDATE_BOOLEAN)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
}

$successAuth = $failureAuth = false;
$user = null;

if (isset($_POST['submit_auth'])) {
    $password = $email = $emailErr = $passwordErr = null;
    if (isset($_POST['email'])) {
        $email = testInput($_POST['email']);
        $user = findUserByLogin($email);
    }
    if (isset($_POST['password'])) {
        $password = testInput($_POST['password']);
    }
    $successAuth = $user && $user['password'] === $password;
    if ($successAuth) {
        $user['groups'] = findGroupsByUser($user);
    }
    $failureAuth = !$successAuth;
} else {
    $email = null;
    $password = null;
    // сессия истекла
    if (isExpiredSession()) {
        // но есть кука
        if (isset($_COOKIE['email'])) {
            $email = $_COOKIE['email'];
            resetLoginCookie($email);
            $user = findUserByLogin($email);
            $user['groups'] = findGroupsByUser($user);
            require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
        }
    } else {
        $user = $_SESSION['user'];
        $successAuth = true;
    }
}

if ($successAuth) {
    unset($user['password']);
    $_SESSION['user'] = $user;
    resetLoginCookie($user['email']);
    $email = $password = null;
}

// избавляем глобальную область видимости от переменной $user
$user = null;

function getUser()
{
    static $user;
    if (isset($user)) {
        return $user;
    } else {
        $user = $_SESSION['user'] ?? null;
        return $user;
    }
}

