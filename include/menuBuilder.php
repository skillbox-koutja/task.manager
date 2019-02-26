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
        $item['cssClass'] = implode(' ', $cssClass);
        $item['title'] = cropMenuItemTitle($item['title'], 15, 12);
        $result[] = $item;
    }
    return $result;
}


function createHtmlMenuItems($items)
{
    $result = [];
    foreach ($items as $item) {
        $result[] = sprintf(
            '<li class="%s"><a href="%s"><span>%s</span></a></li>',
            $item['cssClass'],
            $item['path'],
            $item['title']
        );
    }
    return $result;
}
function createHtmlMenu(array $array, $class = '', $sort = SORT_ASC)
{
    $items = arraySort($array, 'sort', $sort);
    $menuItems = buildMenuItems(
        $items,
        ['menu-item']
    );

    return sprintf('<div class="%s"><ul>%s</ul></div>',
        implode(' ', ['menu', $class]),
        implode('', createHtmlMenuItems($menuItems))
    );
}