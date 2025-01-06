<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetCharacterContractsRequest extends Request implements WithPagination
{
    use BasicPagination;

    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $character_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contracts/', $this->character_id);
    }

    public function createDtoFromResponse(Response $response): array
    {
        $contracts = [];

        foreach ($response->json() as $contract) {
            $contracts[] = CharacterContract::fromArray($contract);
        }

        return $contracts;
    }
}
