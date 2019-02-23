<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/include/menu_section_builder.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/sorter/sorter.php';

$headerMenu = $mainMenu;
usort($headerMenu, createSorterComparison(ASC_SORTER_DIRECTION, 'sort'));
$headerMenuSections = buildMenuSectionItems(
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
            <?php foreach ($headerMenuSections as $item): ?>
                <li class="<?= $item['cssClass'] ?>">
                    <a href="<?= $item['path'] ?>">
                        <span><?= $item['title'] ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</header>
