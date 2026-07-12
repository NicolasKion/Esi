<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterRoles;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CharacterRoles>
 */
class GetCharacterRolesRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/roles/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): CharacterRoles
    {
        return CharacterRoles::hydrate($data);
    }
}
