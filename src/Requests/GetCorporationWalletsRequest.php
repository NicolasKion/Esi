<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationWallet;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CorporationWallet>>
 */
class GetCorporationWalletsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/wallets/', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationWallet>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationWallet::hydrateList($data);
    }
}
