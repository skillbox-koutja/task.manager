<div class="message-list">
    <ul>
        <?php if (empty($messages)): ?>
            Нет сообщений.
        <?php else: ?>
            <?php foreach ($messages as $message): ?>
                <li>
                    <a href="/post/message?id=<?= $message['id'] ?>">
                        <?= $message['title']; ?> (<?= $message['section']['caption']; ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>