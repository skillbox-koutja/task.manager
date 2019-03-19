<?php

function findAllSections()
{
    $stmt = db()->prepare(
        'select 
       ms.id "id", 
       ms.caption "caption",
       ms.created_at "createdAt",
       ms.created_by "createdBy",
       ms.color_id "colorId",
       ms.parent_id "parentId",
       msp.caption "parentCaption",
       msc.hex_value "colorHex"
from section ms
left join color msc on ms.color_id = msc.id
left join section msp on msp.id = ms.parent_id
order by msp.caption, ms.caption');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findAllReceivedMessageUser($user, bool $isRead = null)
{
    $params = [
        'toId' => $user['id'] ?? $user,
    ];
    $sql = 'select 
       m.id "id",
       m.title "title",
       ms.id "sectionId"
from msg m
left join section ms on m.section_id = ms.id
where m.to_id = :toId';
    if (is_bool($isRead)) {
        $sql .= ' and m.is_read = :isRead';
        $params['isRead'] = $isRead;
    }
    $sql .= ' order by m.created_at desc';
    $stmt = db()->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findMessageDetail($msg)
{
    $stmt = db()->prepare(
        'select 
       m.id "id", 
       m.title "title", 
       m.body "body",
       m.created_at "createdAt",
       m.to_id "toId",
       m.is_read "isRead",
       author.email "authorEmail",
       author.first_name "authorFirstName",
       author.last_name "authorLastName",
       author.middle_name "authorMiddleName"
from msg m
left join section ms on m.section_id = ms.id
left join app_user author on m.from_id = author.id
where m.id = :msgId');
    $stmt->execute([
        'msgId' => $msg['id'] ?? $msg
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function messageSetRead($msg)
{
    $sql = 'update msg set is_read = :isRead where id = :msgId';
    $query = db()->prepare($sql);
    return $query->execute([
        'msgId' => $msg['id'] ?? $msg,
        'isRead' => true,
    ]);
}

function saveMessage($data): bool
{
    $sql = "INSERT INTO msg (title, body, section_id, created_at, from_id, to_id, is_read)
  VALUES (:title, :body, :sectionId, :createdAt, :fromId, :toId, 0)";
    $query = db()->prepare($sql);
    return $query->execute($data);
}

function createNewMessageRecord($data)
{
    $msgKeys = ['title', 'body', 'sectionId', 'createdAt', 'fromId', 'toId'];
    $record = array_filter($data, function ($key) use ($msgKeys) {
        return array_search($key, $msgKeys) !== false;
    }, ARRAY_FILTER_USE_KEY);
    return $record;
}

function newMessage($data): bool
{
    $msg = createNewMessageRecord($data);
    $result = saveMessage($msg);
    return $result;
}