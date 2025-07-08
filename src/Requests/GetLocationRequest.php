<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Location;
use NicolasKion\Esi\Request;

class GetLocationRequest extends Request
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
        return sprintf('/characters/%d/location/', $this->character_id);
    }

    public function createDtoFromResponse(Response $response): Location
    {
        return Location::fromArray($response->json());
    }
}
