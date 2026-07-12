<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationStructure;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, CorporationStructure>>
 *
 * @implements WithPagination<array<int, CorporationStructure>>
 */
class GetCorporationStructuresRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationStructure>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationStructure::hydrateList($data);
    }
}
