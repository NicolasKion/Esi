<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareCorporationLeaderboard;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FactionWarfareCorporationLeaderboard>
 */
class GetFactionWarfareCorporationLeaderboardsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/leaderboards/corporations';
    }

    public function createDto(Response $response, mixed $data): FactionWarfareCorporationLeaderboard
    {
        return FactionWarfareCorporationLeaderboard::hydrate($data);
    }
}
