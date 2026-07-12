<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MiningLedgerEntry;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MiningLedgerEntry>>
 *
 * @implements WithPagination<array<int, MiningLedgerEntry>>
 */
class GetCharacterMiningRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mining', $this->character_id);
    }

    /**
     * @return array<int, MiningLedgerEntry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MiningLedgerEntry::hydrateList($data);
    }
}
