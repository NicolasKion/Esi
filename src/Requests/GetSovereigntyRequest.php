<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Sovereignty;
use NicolasKion\Esi\Request;

class GetSovereigntyRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/sovereignty/map/';
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(Sovereignty::fromArray(...), $data);
    }
}
