<?php
$data = $data ?? [];
$receivers = $receivers ?? [];
$sections = $sections ?? [];
?>
<form action="/post/add/"
      class="add_message-form"
      method="post"
      width="100%"
      border="0"
      cellspacing="0"
      cellpadding="0">
    <label for="add_message-subject">Заголовок:</label>
    <input type="text" id="add_message-subject"
           name="subject"
           value="<?= $data['subject'] ?? '' ?>"
    >
    <label for="add_message-body">Текст сообщения:</label>
    <textarea id="add_message-body"
            name="body"
    ><?= $data['body'] ?? '' ?></textarea>
    <label for="add_message-to">Кому: </label>
    <select id="add_message-to"
            name="toId">
        <option disabled
            <?= isset($data['toId']) ? '' : 'selected'; ?>
        >Выберите пользователя</option>
        <?php foreach ($receivers as $user): ?>
            <option
                <?= ($data['toId'] === $user['id']) ? 'selected' : ''; ?>
                    value="<?= $user['id']; ?>"
            ><?= $user['lastName']; ?> <?= $user['firstName']; ?> <?= $user['middleName']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label for="add_message-section">Раздел:</label>
    <select id="add_message-section"
            name="sectionId">
        <option disabled
            <?= isset($data['sectionId']) ? '' : 'selected'; ?>
        >Выберите раздел
        </option>
        <?php foreach ($sections as $section): ?>
            <option style="background-color: <?= $section['bg-color']; ?>"
                <?= ($data['sectionId'] === $section['id']) ? 'selected' : ''; ?>
                    value="<?= $section['id']; ?>"
            ><?= $section['caption']; ?>
            </option>
        <?php endforeach; ?>
    </select>
    <br><br>
    <input type="submit" name="add_message-submit" value="Отправить">
</form>