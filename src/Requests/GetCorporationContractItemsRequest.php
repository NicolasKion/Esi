<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, PublicContractItem>>
 */
class GetCorporationContractItemsRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public int $contract_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/contracts/%d/items/', $this->corporation_id, $this->contract_id);
    }

    /**
     * @return array<int, PublicContractItem>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PublicContractItem::hydrateList($data);
    }
}
