<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareFactionStats;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, FactionWarfareFactionStats>>
 */
class GetFactionWarfareStatsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/stats';
    }

    /**
     * @return array<int, FactionWarfareFactionStats>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FactionWarfareFactionStats::hydrateList($data);
    }
}
