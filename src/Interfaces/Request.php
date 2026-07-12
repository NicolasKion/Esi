<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Interfaces;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;

/**
 * @template-covariant TData
 */
interface Request
{
    public function resolveEndpoint(): string;

    public function getMethod(): RequestMethod;

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array;

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array;

    public function shouldRetry(Response $response): bool;

    /**
     * @return TData
     */
    public function createDto(Response $response, mixed $data): mixed;
}
