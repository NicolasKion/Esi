<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Contact>>
 *
 * @implements WithPagination<array<int, Contact>>
 */
class GetCharacterContactsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contacts/', $this->character_id);
    }

    /**
     * @return array<int, Contact>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Contact::hydrateList($data);
    }
}
