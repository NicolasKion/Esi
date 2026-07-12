<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MarketOrder;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MarketOrder>>
 *
 * @implements WithPagination<array<int, MarketOrder>>
 */
class GetStructureMarketOrdersRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $structure_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/markets/structures/%d', $this->structure_id);
    }

    /**
     * @return array<int, MarketOrder>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MarketOrder::hydrateList($data);
    }
}
