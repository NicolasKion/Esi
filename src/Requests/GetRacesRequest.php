<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Race;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Race>>
 */
class GetRacesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/races/';
    }

    /**
     * @return array<int, Race>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Race::hydrateList($data);
    }
}
