<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PersonalMarketOrder;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, PersonalMarketOrder>>
 *
 * @implements WithPagination<array<int, PersonalMarketOrder>>
 */
class GetCorporationOrdersRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/orders/', $this->corporation_id);
    }

    /**
     * @return array<int, PersonalMarketOrder>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PersonalMarketOrder::hydrateList($data);
    }
}
