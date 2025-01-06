<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PublicContractItem;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetPublicContractItemsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $contract_id
    )
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/contracts/public/items/%d/', $this->contract_id);
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
