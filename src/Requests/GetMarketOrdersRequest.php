<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MarketOrder;
use NicolasKion\Esi\Enums\MarketOrderType;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MarketOrder>>
 *
 * @implements WithPagination<array<int, MarketOrder>>
 */
class GetMarketOrdersRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $region_id,
        public MarketOrderType $order_type = MarketOrderType::All,
        public ?int $type_id = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/markets/%d/orders', $this->region_id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        $query = ['order_type' => $this->order_type->value];

        if ($this->type_id !== null) {
            $query['type_id'] = $this->type_id;
        }

        return $query;
    }

    /**
     * @return array<int, MarketOrder>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MarketOrder::hydrateList($data);
    }
}
