<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareLeaderboard;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FactionWarfareLeaderboard>
 */
class GetFactionWarfareLeaderboardsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/leaderboards';
    }

    public function createDto(Response $response, mixed $data): FactionWarfareLeaderboard
    {
        return FactionWarfareLeaderboard::hydrate($data);
    }
}
