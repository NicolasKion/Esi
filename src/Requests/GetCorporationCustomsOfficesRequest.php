<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CustomsOffice;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, CustomsOffice>>
 *
 * @implements WithPagination<array<int, CustomsOffice>>
 */
class GetCorporationCustomsOfficesRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/customs_offices/', $this->corporation_id);
    }

    /**
     * @return array<int, CustomsOffice>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CustomsOffice::hydrateList($data);
    }
}
