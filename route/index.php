<?php

function getActiveSection(array $mainMenu, string $path)
{
    $activeSectionIndex = array_search($path, array_column($mainMenu, 'path'));
    if ($activeSectionIndex !== false) {
        $activeSection = $mainMenu[$activeSectionIndex];
    } else {
        $activeSection = $mainMenu[0];
    }
    return $activeSection;
}

$url = parse_url($_SERVER['REQUEST_URI']);
$mainMenu = require_once $_SERVER['DOCUMENT_ROOT'] . '/include/main_menu.php';
$activeSection = getActiveSection($mainMenu, $url['path']);