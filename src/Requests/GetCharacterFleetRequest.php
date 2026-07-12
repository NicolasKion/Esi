<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FleetInfo;
use NicolasKion\Esi\Request;

/**
 * @extends Request<FleetInfo>
 */
class GetCharacterFleetRequest extends Request
{
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/fleet/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): FleetInfo
    {
        return FleetInfo::hydrate($data);
    }
}
