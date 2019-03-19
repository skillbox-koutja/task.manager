<?php

if (is_null($user)) {
    require $_SERVER['DOCUMENT_ROOT'] . '/include/accessDeny.php';
} else {
    $accessWriteMessage = accessWriteMessage($user);
    if ($accessWriteMessage) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/accessWriteMessage.php';
        if (isset($postPage)) {
            $postPage($user);
        }
    } else {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/denyWriteMessage.php';
    }
}