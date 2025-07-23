<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\Request;

class GetEveMailsRequest extends Request
{
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/', $this->character_id);
    }

    public function createDtoFromResponse(Response $response): array
    {
        $items = [];

        foreach ($response->json() ?? [] as $item) {
            $items[] = EveMail::fromArray($item);
        }

        return $items;
    }
}
