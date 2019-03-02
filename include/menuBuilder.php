<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/sorter/sorter.php';

function cropMenuItemTitle($in, int $limitLength, int $length)
{
    return mb_strlen($in) > $limitLength ? mb_substr($in, 0, $length) . '...' : $in;
}

function buildMenuItems(
    array $items,
    array $itemCssClass = []
): array
{
    $result = [];
    foreach ($items as $item) {
        $cssClass = $itemCssClass;
        if ($item['active'] ?? false) {
            $cssClass[] = 'menu-item-active';
        }
        $item['class'] = implode(' ', $cssClass);
        $item['title'] = cropMenuItemTitle($item['title'], 15, 12);
        $result[] = $item;
    }
    return $result;
}

function renderMenu(array $array, $class = '', $sort = SORT_ASC)
{
    $items = arraySort($array, 'sort', $sort);
    $menu = [
        'class' => implode(' ', ['menu', $class]),
        'items' => buildMenuItems(
            $items,
            ['menu-item']
        )
    ];

    return require $_SERVER['DOCUMENT_ROOT'] . '/views/menu.php';
}