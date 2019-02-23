<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/checkAuth.php';

function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$login = $password = '';
$successAuth = $failureAuth = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginErr = $passwordErr = '';
    if (isset($_POST['login'])) {
        $login = testInput($_POST['login']);
    }
    if (isset($_POST['password'])) {
        $password = testInput($_POST['password']);
    }
    $successAuth = checkAuth($login, $password);
    if ($successAuth) {
        $login = $password = '';
    } else {
        $failureAuth = true;
    }
}