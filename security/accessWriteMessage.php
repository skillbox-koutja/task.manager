<?php

function accessWriteMessage($user)
{
    $groups = $user['groups'] ?? [];
    if (empty($groups)) {
        return false;
    }
    foreach ($groups as $group) {
        if ('access_write_message' === $group['caption']) {
            return true;
        }
    }
    return false;
}