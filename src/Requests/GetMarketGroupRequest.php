<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MarketGroup;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MarketGroup>
 */
class GetMarketGroupRequest extends Request
{
    public function __construct(public int $market_group_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/markets/groups/%d', $this->market_group_id);
    }

    public function createDto(Response $response, mixed $data): MarketGroup
    {
        return MarketGroup::hydrate($data);
    }
}
