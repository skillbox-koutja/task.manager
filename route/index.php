<?php

function findActiveSectionIndex(array $menu, string $path)
{
    $index = array_search($path, array_column($menu, 'path'));
    return $index === false ? 0 : $index;
}

function setActiveSection(array $menu, int $index)
{
    $menu[$index]['active'] = true;
    return $menu;
}

function getActiveSectionTitle(array $menu, int $index)
{
    return $menu[$index]['title'];
}