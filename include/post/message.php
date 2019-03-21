<div class="message-detail">
    <p class="message-detail__label">Тема:</p>
    <p class="message-detail__value"><?= $title ?></p>
    <p class="message-detail__label">Дата отправки:</p>
    <p class="message-detail__value"><?= $createdAt ?></p>
    <p class="message-detail__label">От кого: </p>
    <p class="message-detail__value"><?= $authorLastName;?> <?=$authorFirstName;?> <?=$authorMiddleName;?> (<?= $authorEmail ?>)</p>
    <p class="message-detail__label">Текст:</p>
    <p class="message-detail__value"><?= $body;?></p>
</div>