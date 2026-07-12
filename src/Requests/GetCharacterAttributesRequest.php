<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterAttributes;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CharacterAttributes>
 */
class GetCharacterAttributesRequest extends Request
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
        return sprintf('/characters/%d/attributes/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): CharacterAttributes
    {
        return CharacterAttributes::hydrate($data);
    }
}
