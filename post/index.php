<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bootstrap.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/db/query/user.php';

$groups = findGroupsByUser($user, $pdo);

require $_SERVER['DOCUMENT_ROOT'] . '/security/accessWriteMessage.php';

$accessWriteMessage = accessWriteMessage($groups);

require $_SERVER['DOCUMENT_ROOT'] . '/include/header.php';

require $_SERVER['DOCUMENT_ROOT'] . '/include/post/page.php';

require $_SERVER['DOCUMENT_ROOT'] . '/include/footer.php';

