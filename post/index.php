<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

$user = getUser();

if (isset($user)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/security/accessWriteMessage.php';
    $accessWriteMessage = accessWriteMessage($user);
    if ($accessWriteMessage) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/accessWriteMessage.php';
        if (isset($postPage)) {
            $postPage($user);
        }
        require $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/denyWriteMessage.php';
    }
} else {
    require $_SERVER['DOCUMENT_ROOT'] . '/include/accessDeny.php';
}
