<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\WalletTransaction;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, WalletTransaction>>
 */
class GetCorporationWalletTransactionsRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public int $division,
        public ?int $from_id = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/wallets/%d/transactions/', $this->corporation_id, $this->division);
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
