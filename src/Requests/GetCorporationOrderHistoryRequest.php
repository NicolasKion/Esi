<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PersonalMarketOrderHistory;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, PersonalMarketOrderHistory>>
 *
 * @implements WithPagination<array<int, PersonalMarketOrderHistory>>
 */
class GetCorporationOrderHistoryRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/orders/history/', $this->corporation_id);
    }

    /**
     * @return array<int, PersonalMarketOrderHistory>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PersonalMarketOrderHistory::hydrateList($data);
    }
}
