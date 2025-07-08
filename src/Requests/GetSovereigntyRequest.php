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

    public function createDtoFromResponse(Response $response): array
    {
        $data = [];

        foreach ($response->json() as $item) {
            $data[] = Sovereignty::fromArray($item);
        }

        return $data;
    }
}
