<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Standing;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Standing>>
 *
 * @implements WithPagination<array<int, Standing>>
 */
class GetCorporationStandingsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/standings/', $this->corporation_id);
    }

    /**
     * @return array<int, Standing>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Standing::hydrateList($data);
    }
}
