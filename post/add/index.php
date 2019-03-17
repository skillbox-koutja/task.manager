<?php

$postPage = function ($user, $pdo) {
    require $_SERVER['DOCUMENT_ROOT'] . '/db/query/msg.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/post/message/section.php';

    function isValidFormData($data) {
        $fields = [
            'toId',
            'fromId',
            'body',
            'subject',
            'sectionId'
        ];
        foreach ($fields as $field) {
            $value = $data[$field] ?? null;
            if (empty($value)) {
                return false;
            }
        }
        return true;
    }
    $data = [
        'toId' => null,
        'fromId' => null,
        'body' => null,
        'subject' => null,
        'sectionId' => null,
        'createdAt' => null
    ];
    $validMessageData = null;
    $addSuccess = null;
    if (isset($_POST['add_message-submit'])) {
        $data = $_POST;
        $data['fromId'] = $user['id'];
        $data['createdAt'] = date('Y-m-d H:i:s');
        $validMessageData = isValidFormData($data);
        if ($validMessageData) {
            $addSuccess = newMessageBySection($data['sectionId'], $data, $pdo);
        }
    }

    $receivers = findReceivers($pdo);
    $sections = findAllSections($pdo);
    $sections = createSectionTree($sections);
    $sections = createSelectionOptions($sections);

    if ($addSuccess && $validMessageData) {
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/messageSentSuccess.php';
    } else {
        if (false === $validMessageData) {
            require $_SERVER['DOCUMENT_ROOT'] . '/include/post/invalidMessageData.php';
        }
        if (false === $addSuccess) {
            require $_SERVER['DOCUMENT_ROOT'] . '/include/post/messageSentFailure.php';
        }
        require $_SERVER['DOCUMENT_ROOT'] . '/include/post/addMessageForm.php';
    }
};

require_once $_SERVER['DOCUMENT_ROOT'] . '/post/index.php';

