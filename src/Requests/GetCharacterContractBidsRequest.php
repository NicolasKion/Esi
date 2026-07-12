<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\ContractBid;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, ContractBid>>
 */
class GetCharacterContractBidsRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $contract_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contracts/%d/bids/', $this->character_id, $this->contract_id);
    }

    /**
     * @return array<int, ContractBid>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return ContractBid::hydrateList($data);
    }
}
