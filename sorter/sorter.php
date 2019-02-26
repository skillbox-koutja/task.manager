<?php

function createSorterComparison($direction = SORT_ASC, $property = null)
{
    switch ($direction) {
        case SORT_ASC:
            $sorter = function ($a, $b) {
                return $a <=> $b;
            };
            break;
        case SORT_DESC:
            $sorter = function ($a, $b) {
                return $b <=> $a;
            };
            break;
        default:
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid sort direction "%s". Allowed list: %s',
                    $direction,
                    '"' . implode('", "', ['SORT_ASC', 'SORT_DESC']) .'"'
                )
            );
    }

    if ($property) {
        $sorter = function ($a, $b) use ($sorter, $property) {
            return $sorter($a[$property], $b[$property]);
        };
    }
    return $sorter;
}

function arraySort(array $array, $key = 'sort', $sort = SORT_ASC)
{
    usort($array, createSorterComparison($sort, $key));
    return $array;
}