<?php

function checkAuth($login, $password)
{
    $loginStore = require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/data/loginStore.php';
    $passwordStore = require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/data/passwordStore.php';
    $index = array_search($login, $loginStore, true);
    return $index !== false && $password === $passwordStore[$index];
}