<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;


use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetPublicStructuresRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function resolveEndpoint(): string
    {
        return '/universe/structures/';
    }

    /**
     * @returns int[]
     */
    public function createDtoFromResponse(Response $response): array
    {
        return $response->json();
    }
}
