<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MailLabels;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MailLabels>
 */
class GetMailLabelsRequest extends Request
{
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/labels/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): MailLabels
    {
        return MailLabels::hydrate($data);
    }
}
