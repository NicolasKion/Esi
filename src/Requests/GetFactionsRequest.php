<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Faction;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Faction>>
 */
class GetFactionsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/factions/';
    }

    /**
     * @return array<int, Faction>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Faction::hydrateList($data);
    }
}
