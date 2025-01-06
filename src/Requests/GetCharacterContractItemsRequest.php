<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetCharacterContractItemsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $character_id,
        public int $contract_id
    )
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contracts/%d/items/', $this->character_id, $this->contract_id);
    }

    public function createDtoFromResponse(Response $response): array
    {
        $items = [];

        foreach ($response->json() ?? [] as $item) {
            $items[] = PublicContractItem::fromArray($item);
        }

        return $items;
    }
}
