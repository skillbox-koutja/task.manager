<?php

$postPage = function ($user, $pdo) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/query/msg.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/post/message/section.php';

    // не прочитанные письма
    $messages = findAllReceivedMessageUser($user, $pdo, false);

    $sections = findAllSections($pdo);
    $sections = createSectionTree($sections);
    $sections = createSelectionOptions($sections);
    foreach ($messages as $id => $message) {
        foreach ($sections as $section) {
            if ((int)$message['sectionId'] === (int)$section['id']) {
                $message['section'] = $section;
                break;
            }
        }
        $messages[$id] = $message;
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/include/post/messageList.php';
};

require $_SERVER['DOCUMENT_ROOT'] . '/post/index.php';