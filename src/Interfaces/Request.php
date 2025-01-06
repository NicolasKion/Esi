<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;

interface Request
{
    public function resolveEndpoint(): string;

    public function getMethod(): RequestMethod;

    public function getHeaders(): array;

    public function getQuery(): array;

    public function shouldRetry(Response $response): bool;

    public function createDtoFromResponse(Response $response): mixed;
}
