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
class GetCorporationWalletJournalRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $corporation_id,
        public int $division,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/wallets/%d/journal/', $this->corporation_id, $this->division);
    }

    /**
     * @return array<int, WalletJournalEntry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return WalletJournalEntry::hydrateList($data);
    }
}
