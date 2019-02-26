<?php

function createSorterComparison($k = 'sort', $sort = SORT_ASC)
{
    if ($sort === SORT_ASC) {
        return function ($a, $b) use ($k) {
            return $a[$k] <=> $b[$k];
        };
    } else if ($sort === SORT_DESC) {
        return function ($b, $a) use ($k) {
            return $a[$k] <=> $b[$k];
        };
    } else {
        throw new \InvalidArgumentException(
            sprintf(
                'Invalid sort direction. Allowed list: %s',
                '"' . implode('", "', ['SORT_ASC', 'SORT_DESC']) . '"'
            )
        );
    }
}

function arraySort(array $array, $key = 'sort', $sort = SORT_ASC)
{
    usort($array, createSorterComparison( $key, $sort));
    return $array;
}