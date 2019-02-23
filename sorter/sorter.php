<?php

const ASC_SORTER_DIRECTION = 'asc';
const DESC_SORTER_DIRECTION = 'desc';

function createSorterComparison(string $direction = ASC_SORTER_DIRECTION, $property = null)
{
    $direction = strtolower($direction);
    switch ($direction) {
        case ASC_SORTER_DIRECTION:
            $sorter = function ($a, $b) {
                return $a <=> $b;
            };
            break;
        case DESC_SORTER_DIRECTION:
            $sorter = function ($a, $b) {
                return $b <=> $a;
            };
            break;
        default:
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid sort direction "%s". Allowed list: %s',
                    $direction,
                    '"' . implode('", "', [ASC_SORTER_DIRECTION, DESC_SORTER_DIRECTION]) .'"'
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