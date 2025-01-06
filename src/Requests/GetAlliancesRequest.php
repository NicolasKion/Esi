<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetAlliancesRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function resolveEndpoint(): string
    {
        return '/alliances/';
    }

    /**
     * @return int[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return $response->json();
    }
}
