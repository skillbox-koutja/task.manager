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
    var_dump(time() . ' ' . $_SESSION['lastAccess']);
    return (time() - $_SESSION['lastAccess']) > LIFETIME_SESSION;
}

if (filter_var($_GET['logout'], FILTER_VALIDATE_BOOLEAN)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/auth/logout.php';
}

$successAuth = $failureAuth = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginErr = $passwordErr = null;
    if (isset($_POST['login'])) {
        $login = testInput($_POST['login']);
    }
    if (isset($_POST['password'])) {
        $password = testInput($_POST['password']);
    }
    $failureAuth = true;
} else {
    var_dump(isset($_SESSION['lastAccess']) ? 'isset lastAccess' : 'not set lastAccess');
    if (isset($_SESSION['lastAccess']) && isExpiredSession()) {
        var_dump('isExpiredSession', $_SESSION);
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
var_dump('$_SESSION', $_SESSION);
var_dump('$password', $password);