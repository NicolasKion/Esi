<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PublicContractBid;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, PublicContractBid>>
 *
 * @implements WithPagination<array<int, PublicContractBid>>
 */
class GetPublicContractBidsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $contract_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/contracts/public/bids/%d/', $this->contract_id);
    }

    /**
     * @return array<int, PublicContractBid>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PublicContractBid::hydrateList($data);
    }
}
