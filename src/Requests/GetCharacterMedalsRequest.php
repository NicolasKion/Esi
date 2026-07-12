<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterMedal;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CharacterMedal>>
 */
class GetCharacterMedalsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/medals/', $this->character_id);
    }

    /**
     * @return array<int, CharacterMedal>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CharacterMedal::hydrateList($data);
    }
}
