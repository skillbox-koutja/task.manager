<?php

function createSorterComparison($k = 'sort', $sort = SORT_ASC)
{
    return $sort === SORT_DESC ? function ($a, $b) use ($k) {
        return $a[$k] <=> $b[$k];
    } : function ($b, $a) use ($k) {
        return $a[$k] <=> $b[$k];
    };
}

function arraySort(array $array, $key = 'sort', $sort = SORT_ASC)
{
    usort($array, createSorterComparison( $key, $sort));
    return $array;
}