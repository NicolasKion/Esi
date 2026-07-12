<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MiningObserver;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MiningObserver>>
 *
 * @implements WithPagination<array<int, MiningObserver>>
 */
class GetCorporationMiningObserversRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    /**
     * Note: ESI uses the singular "/corporation/" prefix for mining endpoints,
     * unlike the plural "/corporations/" used elsewhere in the API.
     */
    public function resolveEndpoint(): string
    {
        return sprintf('/corporation/%d/mining/observers', $this->corporation_id);
    }

    /**
     * @return array<int, MiningObserver>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MiningObserver::hydrateList($data);
    }
}
