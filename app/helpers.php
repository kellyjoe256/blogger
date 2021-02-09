<?php

/**
 * Return publication date column sort direction based on query string
 *
 * @param string $query_string_sort
 * @return string
 */
function publication_date_sort_direction(string $query_string_sort): string
{
    $sort = [
        'oldest' => 'asc',
        'newest' => 'desc',
    ];

    return $sort[$query_string_sort] ?? 'desc';
}
