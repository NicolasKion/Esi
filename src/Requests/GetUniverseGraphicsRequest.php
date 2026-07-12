<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, int>>
 */
class GetUniverseGraphicsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/graphics/';
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList($data);
    }
}
