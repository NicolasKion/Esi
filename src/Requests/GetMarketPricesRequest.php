<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MarketPrice;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, MarketPrice>>
 */
class GetMarketPricesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/markets/prices';
    }

    /**
     * @return array<int, MarketPrice>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MarketPrice::hydrateList($data);
    }
}
