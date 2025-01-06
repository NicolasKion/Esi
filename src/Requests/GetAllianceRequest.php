<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;


use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetAllianceRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $alliance_id,
    )
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/alliances/%d/', $this->alliance_id);
    }

    public function createDtoFromResponse(Response $response): Alliance
    {
        return Alliance::fromArray($response->json());
    }
}
