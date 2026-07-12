<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationFactionWarfareStats;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CorporationFactionWarfareStats>
 */
class GetCorporationFactionWarfareStatsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/fw/stats', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): CorporationFactionWarfareStats
    {
        return CorporationFactionWarfareStats::hydrate($data);
    }
}
