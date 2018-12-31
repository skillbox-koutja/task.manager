<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menu_section_builder.php';

$footerMenu = $mainMenu;
usort($footerMenu, function ($a, $b) {
    if ($a === $b) {
        return 0;
    }
    return ($a['sort'] > $b['sort']) ? -1 : 1;
});
$footerMenuSections = buildMenuSectionItems(
    $footerMenu,
    ['menu-item', 'footer-menu-item'],
    $activeSection
);
?>
<footer>
    <div style="clear: both"></div>
    <div id='footer-menu' class="menu">
        <ul>
            <?php foreach ($footerMenuSections as $item): ?>
                <li class="<?= $item['cssClass'] ?>">
                    <a href="<?= $item['path'] ?>">
                        <span><?= $item['title'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>&copy;&nbsp;<nobr>2018</nobr>
    Project.
    <div class="logo">
        <img src="/i/logo.png" width="68" height="23" alt="Project"/>
    </div>
</footer>