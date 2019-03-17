<?php

$postPage = function ($user, $pdo) {
    require $_SERVER['DOCUMENT_ROOT'] . '/db/query/msg.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/post/message/section.php';

    // не прочитанные письма
    $msgId = $_GET['id'] ?? null;
    $message = findMessageDetail($msgId, $pdo);
    if (false === $message) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/messageNotFound.php';
    } else {
        if ((int)$message['toId'] === (int)$user['id']) {
            messageSetRead($msgId, $pdo);
        }
        extract($message);
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/message.php';
    }
};

require $_SERVER['DOCUMENT_ROOT'] . '/post/index.php';