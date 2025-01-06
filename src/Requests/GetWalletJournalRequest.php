<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetWalletJournalRequest extends Request implements WithPagination
{
    use BasicPagination;

    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $character_id
    )
    {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/wallet/journal/', $this->character_id);
    }


    public function createDtoFromResponse(Response $response): array
    {
        $items = [];

        foreach ($response->json() as $item) {
            $items[] = WalletJournalEntry::fromArray($item);
        }

        return $items;
    }
}
