<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationStructure;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetCorporationStructuresRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(CorporationStructure::fromArray(...), $data);
    }
}
