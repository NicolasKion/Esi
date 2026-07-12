<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareCharacterLeaderboard;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FactionWarfareCharacterLeaderboard>
 */
class GetFactionWarfareCharacterLeaderboardsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/leaderboards/characters';
    }

    public function createDto(Response $response, mixed $data): FactionWarfareCharacterLeaderboard
    {
        return FactionWarfareCharacterLeaderboard::hydrate($data);
    }
}
