<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContractBid;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, ContractBid>>
 *
 * @implements WithPagination<array<int, ContractBid>>
 */
class GetCorporationContractBidsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $corporation_id,
        public int $contract_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/contracts/%d/bids/', $this->corporation_id, $this->contract_id);
    }

    /**
     * @return array<int, ContractBid>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContractBid::hydrateList($data);
    }
}
