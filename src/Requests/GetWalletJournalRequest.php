<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\WalletJournalEntry;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, WalletJournalEntry>>
 *
 * @implements WithPagination<array<int, WalletJournalEntry>>
 */
class GetWalletJournalRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $character_id
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/wallet/journal/', $this->character_id);
    }

    /**
     * @return array<int, WalletJournalEntry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return WalletJournalEntry::hydrateList($data);
    }
}
