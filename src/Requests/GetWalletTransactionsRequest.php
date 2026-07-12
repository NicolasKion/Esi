<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\WalletTransaction;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, WalletTransaction>>
 */
class GetWalletTransactionsRequest extends Request
{
    public function __construct(
        public int $character_id,
        public ?int $from_id = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/wallet/transactions/', $this->character_id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        $query = [];

        if ($this->from_id !== null) {
            $query['from_id'] = $this->from_id;
        }

        return $query;
    }

    /**
     * @return array<int, WalletTransaction>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return WalletTransaction::hydrateList($data);
    }
}
