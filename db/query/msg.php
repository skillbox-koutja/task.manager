<?php

function findAllSections(PDO $pdo)
{
    $stmt = $pdo->prepare(
        'select 
       ms.id "id", 
       ms.caption "caption",
       ms.created_at "createdAt",
       ms.created_by "createdBy",
       ms.color_id "colorId",
       ms.parent_id "parentId",
       msp.caption "parentCaption",
       msc.hex_value "colorHex"
from msg_section ms
left join msg_section_color msc on ms.color_id = msc.id
left join msg_section msp on msp.id = ms.parent_id
order by msp.caption, ms.caption');
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findAllReceivedMessageUser($user, PDO $pdo, bool $isRead = null)
{
    $params = [
        'toId' => $user['id'] ?? $user,
    ];
    $sql = 'select 
       m.id "id",
       m.subject "subject",
       ms.id "sectionId"
from msg m
left join msg_section_assoc msa on m.id = msa.msg_id
left join msg_section ms on msa.section_id = ms.id
where m.to_id = :toId';
    if (is_bool($isRead)) {
        $sql .= ' and m.is_read = :isRead';
        $params['isRead'] = $isRead;
    }
    $sql .= ' order by m.created_at desc';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function findMessageDetail($msg, PDO $pdo)
{
    $stmt = $pdo->prepare(
        'select 
       m.id "id", 
       m.subject "subject", 
       m.body "body",
       m.created_at "createdAt",
       m.to_id "toId",
       author.email "authorEmail",
       author.first_name "authorFirstName",
       author.last_name "authorLastName",
       author.middle_name "authorMiddleName"
from msg m
left join msg_section_assoc msa on m.id = msa.msg_id
left join msg_section ms on msa.section_id = ms.id
left join app_user author on m.from_id = author.id
where m.id = :msgId');
    $stmt->execute([
        'msgId' => $msg['id'] ?? $msg
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function messageSetRead($msg, PDO $pdo)
{
    $sql = 'update msg set is_read = :isRead where id = :msgId';
    $query = $pdo->prepare($sql);
    return $query->execute([
        'msgId' => $msg['id'] ?? $msg,
        'isRead' => true,
    ]);
}

function saveMessage($data, PDO $pdo): bool
{
    $sql = "INSERT INTO msg (subject, body, created_at, from_id, to_id, is_read)
  VALUES (:subject, :body, :createdAt, :fromId, :toId, 0)";
    $query = $pdo->prepare($sql);
    return $query->execute($data);
}

function saveMessageSection($data, PDO $pdo): bool
{
    $sql = 'INSERT INTO msg_section_assoc (msg_id, section_id)
  VALUES (:msgId, :sectionId)';
    $query = $pdo->prepare($sql);
    return $query->execute($data);
}

function createNewMessageRecord($data)
{
    $msgKeys = ['subject', 'body', 'createdAt', 'fromId', 'toId'];
    $record = array_filter($data, function ($key) use ($msgKeys) {
        return (array_search($key, $msgKeys) !== false);
    }, ARRAY_FILTER_USE_KEY);
    return $record;
}

function createNewMessageSectionRecord($sectionId, $msg, PDO $pdo)
{
    $sql = 'select m.id 
from msg m
left join msg_section_assoc msa on m.id = msa.msg_id
left join msg_section ms on msa.section_id = ms.id
where to_id = :toId and from_id = :fromId and ms.id is null 
';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'fromId' => $msg['fromId'],
        'toId' => $msg['toId'],
    ]);
    return [
        'sectionId' => $sectionId,
        'msgId' => $stmt->fetchColumn(),
    ];
}

function newMessageBySection($sectionId, $data, PDO $pdo): bool
{
    $pdo->beginTransaction();
    $msg = createNewMessageRecord($data);
    $result = saveMessage($msg, $pdo);
    if ($result) {
        $messageSection = createNewMessageSectionRecord($sectionId, $msg, $pdo);
        $result = saveMessageSection($messageSection, $pdo);
    }
    if ($result) {
        $pdo->commit();
    } else {
        $pdo->rollBack();
    }
    return $result;
}