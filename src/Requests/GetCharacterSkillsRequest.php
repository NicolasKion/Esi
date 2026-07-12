<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterSkills;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CharacterSkills>
 */
class GetCharacterSkillsRequest extends Request
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/skills/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): CharacterSkills
    {
        return CharacterSkills::hydrate($data);
    }
}
