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
class GetUniverseTypesRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function resolveEndpoint(): string
    {
        return '/universe/types/';
    }

    /**
     * @return array<int, int>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Data::integerList($data);
    }
}
