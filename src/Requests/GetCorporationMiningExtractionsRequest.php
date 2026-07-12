<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MiningExtraction;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, MiningExtraction>>
 *
 * @implements WithPagination<array<int, MiningExtraction>>
 */
class GetCorporationMiningExtractionsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    /**
     * Note: ESI uses the singular "/corporation/" prefix for mining endpoints,
     * unlike the plural "/corporations/" used elsewhere in the API.
     */
    public function resolveEndpoint(): string
    {
        return sprintf('/corporation/%d/mining/extractions', $this->corporation_id);
    }

    /**
     * @return array<int, MiningExtraction>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return MiningExtraction::hydrateList($data);
    }
}
