<?php

function findUserByLogin($email)
{
    if (empty($email)) {
        return null;
    }
    $stmt = db()->prepare(
        'select 
       id "id", 
       email "email",
       pw "password",
       is_enabled "isEnabled", 
       recv_email "recvEmail", 
       phone "phone", 
       first_name "firstName", 
       last_name "lastName", 
       middle_name "middleName"
from users au
where au.email = :email
');
    $stmt->execute([
        'email' => $email,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findGroupsByUser($user)
{
    if (empty($user)) {
        return null;
    }

    $stmt = db()->prepare(
        'select
       ag.id "id",
       ag.caption "caption",
       ag.description "description"
from groups ag
inner join group_user aug on ag.id = aug.group_id
where aug.user_id = ?
');
    $stmt->execute([$user['id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findReceivers()
{
    $stmt = db()->prepare(
        'select
       au.id "id",
       au.email "email",
       au.is_enabled "isEnabled",
       au.recv_email "recvEmail",
       au.phone "phone",
       au.first_name "firstName",
       au.last_name "lastName",
       au.middle_name "middleName"
from users au
left join group_user aug on au.id = aug.user_id
left join groups ag on aug.group_id = ag.id
where au.recv_email = :recv_email
and ag.caption = :recv_group
');
    $stmt->execute([
        'recv_email' => true,
        'recv_group' => 'access_write_message',
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}