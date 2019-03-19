<?php

/**
 * @return PDO
 */
function db(): PDO
{
    static $pdo;
    if (isset($pdo)) {
        return $pdo;
    } else {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/constants/db.php';
        $pdo = new PDO(DATA_BASE_DSN, DATA_BASE_USER, DATA_BASE_PASSWORD);
        return $pdo;
    }
}