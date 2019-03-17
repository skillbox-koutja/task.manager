<?php

function findUserByLoginAndPassword($email, $password, PDO $pdo)
{
    if (empty($email) || empty($password)) {
        return null;
    }
    $stmt = $pdo->prepare(
        'select 
       id "id", 
       email "email",
       is_enabled "isEnabled", 
       recv_email "recvEmail", 
       phone "phone", 
       first_name "firstName", 
       last_name "lastName", 
       middle_name "middleName"
from app_user au
where au.email = :email
and au.password = :passwd
');
    $stmt->execute([
        'email' => $email,
        'passwd' => $password,
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function findGroupsByUser($user, PDO $pdo)
{
    if (empty($user)) {
        return null;
    }

    $stmt = $pdo->prepare(
        'select
       ag.id "id",
       ag.caption "caption",
       ag.description "description"
from app_group ag
inner join app_user_groups aug on ag.id = aug.group_id
where aug.user_id = ?
');
    $stmt->execute([$user['id']]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findReceivers(PDO $pdo)
{
    $stmt = $pdo->prepare(
        'select
       au.id "id",
       au.email "email",
       au.is_enabled "isEnabled",
       au.recv_email "recvEmail",
       au.phone "phone",
       au.first_name "firstName",
       au.last_name "lastName",
       au.middle_name "middleName"
from app_user au
left join app_user_groups aug on au.id = aug.user_id
left join app_group ag on aug.group_id = ag.id
where au.recv_email = :recv_email
and ag.caption = :recv_group
');
    $stmt->execute([
        'recv_email' => true,
        'recv_group' => 'access_write_message',
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}