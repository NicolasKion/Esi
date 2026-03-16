<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Character;
use NicolasKion\Esi\Request;

class GetCharacterRequest extends Request
{
    public function __construct(public int $id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/', $this->id);
    }

    public function createDto(Response $response, mixed $data): Character
    {
        return Character::fromArray($data);
    }
}
