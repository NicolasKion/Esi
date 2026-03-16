<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MarketHistory;
use NicolasKion\Esi\Request;

class GetMarketHistoryRequest extends Request
{
    public function __construct(
        public int $region_id,
        public int $type_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/markets/%d/history/?type_id=%d', $this->region_id, $this->type_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(MarketHistory::fromArray(...), $data);
    }
}
