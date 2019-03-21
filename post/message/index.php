<?php

$postPage = function ($user) {
    require $_SERVER['DOCUMENT_ROOT'] . '/db/query/msg.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/post/message/section.php';

    function isRead($message) {
        return false === filter_var($message['isRead'], FILTER_VALIDATE_BOOLEAN);
    }
    // не прочитанные письма
    $msgId = $_GET['id'] ?? null;
    $message = findMessageDetail($msgId);
    if (false === $message || (int)$message['toId'] !== (int)$user['id']) {
        // нельзя читать чужую переписку
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/messageNotFound.php';
    } else {
        if (isRead($message)) {
            messageSetRead($message);
        }
        extract($message);
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/message.php';
    }
};

require $_SERVER['DOCUMENT_ROOT'] . '/post/index.php';