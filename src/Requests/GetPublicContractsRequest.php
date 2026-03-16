<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PublicContract;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetPublicContractsRequest extends Request implements WithPagination
{
    use BasicPagination;

    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $region_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/contracts/public/%d/', $this->region_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(PublicContract::fromArray(...), $data);
    }
}
