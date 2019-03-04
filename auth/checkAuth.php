<?php

function checkAuth($login, $password)
{
    $loginStore = require $_SERVER['DOCUMENT_ROOT'] . '/auth/data/loginStore.php';
    $passwordStore = require $_SERVER['DOCUMENT_ROOT'] . '/auth/data/passwordStore.php';
    $index = array_search($login, $loginStore, true);
    return $index !== false && $password === $passwordStore[$index];
}

function getPasswordByLogin($login)
{
    $loginStore = require $_SERVER['DOCUMENT_ROOT'] . '/auth/data/loginStore.php';
    $passwordStore = require $_SERVER['DOCUMENT_ROOT'] . '/auth/data/passwordStore.php';
    $index = array_search($login, $loginStore, true);
    return $passwordStore[$index];
}