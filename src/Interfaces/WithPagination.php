<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

use Illuminate\Http\Client\Response;

interface WithPagination extends Request
{
    public function hasMorePages(int $page, Response $response): bool;
}
