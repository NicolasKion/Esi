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

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(EveMail::fromArray(...), $data ?? []);
    }
}
