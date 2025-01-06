<?php

declare(strict_types=1);

namespace NicolasKion\Esi;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;

abstract class Request implements Interfaces\Request
{
    public abstract function resolveEndpoint(): string;

    public function getMethod(): RequestMethod
    {
        return RequestMethod::GET;
    }

    public function getHeaders(): array
    {
        return [];
    }

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

    abstract public function createDtoFromResponse(Response $response): mixed;
}
