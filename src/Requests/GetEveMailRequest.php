<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\EveMail;
use NicolasKion\Esi\Request;

class GetEveMailRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $eve_mail_id
    )
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/%d/', $this->character_id, $this->eve_mail_id);
    }

    public function createDtoFromResponse(Response $response): EveMail
    {
        return EveMail::fromArray($response->json());
    }
}
