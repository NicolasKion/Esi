<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Traits;

use Illuminate\Http\Client\Response;

trait BasicPagination
{
    public function hasMorePages(int $page, Response $response): bool
    {
        $totalPages = (int)($response->header('X-Pages') ?? 1);

        return $page < $totalPages;
    }
}
