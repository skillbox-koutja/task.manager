<?php

function accessWriteMessage(array $groups = null)
{
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