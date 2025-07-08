<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Ship;
use NicolasKion\Esi\Request;

class GetShipRequest extends Request
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
        return sprintf('/characters/%d/ship/', $this->character_id);
    }

    public function createDtoFromResponse(Response $response): Ship
    {
        return Ship::fromArray($response->json());
    }
}
