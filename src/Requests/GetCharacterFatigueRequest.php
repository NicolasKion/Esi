<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\JumpFatigue;
use NicolasKion\Esi\Request;

/**
 * @extends Request<JumpFatigue>
 */
class GetCharacterFatigueRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/fatigue/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): JumpFatigue
    {
        return JumpFatigue::hydrate($data);
    }
}
