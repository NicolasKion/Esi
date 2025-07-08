<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Online;
use NicolasKion\Esi\Request;

class GetOnlineRequest extends Request
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
        return sprintf('/characters/%d/online/', $this->character_id);
    }

    public function createDtoFromResponse(Response $response): Online
    {
        return Online::fromArray($response->json());
    }
}
