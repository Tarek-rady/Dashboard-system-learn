<?php

namespace App\Support;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationHelpers
{
    public static function meta($paginator): array
    {
        if ($paginator instanceof CursorPaginator) {
            return [
                'type' => 'cursor',
                'per_page' => $paginator->perPage(),
                'next_cursor' => optional($paginator->nextCursor())->encode(),
                'prev_cursor' => optional($paginator->previousCursor())->encode(),
                'has_more_pages' => $paginator->hasMorePages(),
            ];
        }

        if ($paginator instanceof Paginator) {
            return [
                'type' => 'simple',
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
            ];
        }

        if ($paginator instanceof LengthAwarePaginator) {
            return [
                'type' => 'full',
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
            ];
        }

        return [];
    }
}
