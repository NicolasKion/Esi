<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MiningObserverEntry;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MiningObserverEntry>>
 *
 * @implements WithPagination<array<int, MiningObserverEntry>>
 */
class GetCorporationMiningObserverRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $corporation_id,
        public int $observer_id,
    ) {}

    /**
     * Note: ESI uses the singular "/corporation/" prefix for mining endpoints,
     * unlike the plural "/corporations/" used elsewhere in the API.
     */
    public function resolveEndpoint(): string
    {
        return sprintf('/corporation/%d/mining/observers/%d', $this->corporation_id, $this->observer_id);
    }

    /**
     * @return array<int, MiningObserverEntry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MiningObserverEntry::hydrateList($data);
    }
}
