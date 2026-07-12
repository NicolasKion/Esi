<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, int>>
 *
 * @implements WithPagination<array<int, int>>
 */
class GetMarketTypesRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $region_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/markets/%d/types', $this->region_id);
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList($data);
    }
}
