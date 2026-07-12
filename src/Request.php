<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;

/**
 * @template-covariant TData
 *
 * @implements Interfaces\Request<TData>
 */
abstract class Request implements Interfaces\Request
{
    abstract public function resolveEndpoint(): string;

    /**
     * @return TData
     */
    abstract public function createDto(Response $response, mixed $data): mixed;

    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    /**
     * @return array<string, mixed>
     */
    public function getHeaders(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        return [];
    }

    public function shouldRetry(Response $response): bool
    {
        if ($response->serverError()) {
            return true;
        }

        return false;
    }
}
