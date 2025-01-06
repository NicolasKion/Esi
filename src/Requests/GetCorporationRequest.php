<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetCorporationRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $corporation_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/', $this->corporation_id);
    }

    public function createDtoFromResponse(Response $response): Corporation
    {
        return Corporation::fromArray($response->json());
    }
}
