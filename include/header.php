<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menu_section_builder.php';

$headerMenu = $mainMenu;
usort($headerMenu, function ($a, $b){
    if ($a === $b) {
        return 0;
    }
    return ($a['sort'] < $b['sort']) ? -1 : 1;
});
$footerMenuSections = buildMenuSectionItems(
    $headerMenu,
    ['menu-item', 'header-menu-item'],
    $activeSection
);
?>
<header>
    <div class="logo">
        <img src="/i/logo.png" width="68" height="23" alt="Project"/>
    </div>
    <div style="clear: both"></div>
    <div id='header-menu' class="menu top-menu">
        <ul>
            <?php foreach ($footerMenuSections as $item): ?>
                <li class="<?= $item['cssClass'] ?>">
                    <a href="<?= $item['path'] ?>">
                        <span><?= $item['title'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</header>
