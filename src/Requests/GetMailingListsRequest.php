<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MailingList;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, MailingList>>
 */
class GetMailingListsRequest extends Request
{
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/lists/', $this->character_id);
    }

    /**
     * @return array<int, MailingList>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MailingList::hydrateList($data);
    }
}
