<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Status;
use NicolasKion\Esi\Request;

class GetStatusRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/status';
    }

    public function createDtoFromResponse(Response $response): Status
    {
        return Status::fromArray($response->json());
    }
}
