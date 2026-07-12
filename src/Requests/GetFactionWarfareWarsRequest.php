<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareWar;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, FactionWarfareWar>>
 */
class GetFactionWarfareWarsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/wars';
    }

    /**
     * @return array<int, FactionWarfareWar>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FactionWarfareWar::hydrateList($data);
    }
}
