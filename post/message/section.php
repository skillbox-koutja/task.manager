<?php

function hasChildren($rows, int $id)
{
    foreach ($rows as $row) {
        $parentId = (int)($row['parentId'] ?? 0);
        if ($parentId == $id)
            return true;
    }
    return false;
}

function createSectionTree($sections, int $rootId = 0)
{
    $sectionTree = [];
    foreach ($sections as $section) {
        $parentId = (int)($section['parentId'] ?? 0);
        if ($parentId === $rootId) {
            $root = $section;
            $id = $section['id'];
            if (hasChildren($sections, $id)) {
                $root['items'] = createSectionTree($sections, $id);
            }
            $sectionTree[] = $root;
        }
    }
    return $sectionTree;
}

function createSelectionOptionsByItem($item, $captions = null)
{
    $selectionOptions = [];
    $captions = is_null($captions) ? [] : $captions;
    $captions[] = $item['caption'];
    $selectionOptions[] = [
        'bg-color' => '#' . $item['colorHex'],
        'id' => $item['id'],
        'caption' => implode('/', $captions),
    ];
    if (isset($item['items'])) {
        foreach ($item['items'] as $i) {
            $selectionOptions = array_merge(
                $selectionOptions,
                createSelectionOptionsByItem($i, $captions)
            );
        }
    }
    return $selectionOptions;
}

;

function createSelectionOptions($sectionTree)
{
    $selectionOptions = [];
    foreach ($sectionTree as $item) {
        $selectionOptions = array_merge(
            $selectionOptions,
            createSelectionOptionsByItem($item)
        );
    }
    return $selectionOptions;
}