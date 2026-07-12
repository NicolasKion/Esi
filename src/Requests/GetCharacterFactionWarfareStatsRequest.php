<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterFactionWarfareStats;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CharacterFactionWarfareStats>
 */
class GetCharacterFactionWarfareStatsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/fw/stats', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): CharacterFactionWarfareStats
    {
        return CharacterFactionWarfareStats::hydrate($data);
    }
}
