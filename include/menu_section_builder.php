<?php

function cropMenuItemTitle ($in, int $limitLength, int $length) {
    return mb_strlen($in) > $limitLength ? mb_substr($in, 0, $length) . '...' : $in;
}

function buildMenuSectionItems(
    array $menu,
    array $itemCssClass = [],
    array $activeSection = []
): array
{
    $sections = [];
    foreach ($menu as $item) {
        $cssClass = $itemCssClass;
        if ($activeSection['path'] === $item['path']) {
            $cssClass[] = 'menu-item-active';
        }
        $item['cssClass'] = implode(' ', $cssClass);
        $item['title'] = cropMenuItemTitle($item['title'], 15, 12);
        $sections[] = $item;
    }
    return $sections;
}
