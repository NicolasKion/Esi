<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterTitle;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CharacterTitle>>
 */
class GetCharacterTitlesRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/titles/', $this->character_id);
    }

    /**
     * @return array<int, CharacterTitle>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CharacterTitle::hydrateList($data);
    }
}
