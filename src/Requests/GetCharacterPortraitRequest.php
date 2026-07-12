<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterPortrait;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CharacterPortrait>
 */
class GetCharacterPortraitRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/portrait/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): CharacterPortrait
    {
        return CharacterPortrait::hydrate($data);
    }
}
