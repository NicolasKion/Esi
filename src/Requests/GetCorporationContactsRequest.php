<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Contact;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetCorporationContactsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/contacts/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(Contact::fromArray(...), $data);
    }
}
