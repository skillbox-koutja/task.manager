<div class="<?= $menu['class']; ?>">
    <ul>
        <?php foreach ($menu['items'] as $item): ?>
            <li class="<?= $item['class'] ?>">
                <a href="<?= $item['path'] ?>">
                    <span><?= $item['title'] ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>