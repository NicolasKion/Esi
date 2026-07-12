<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Starbase;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Starbase>>
 *
 * @implements WithPagination<array<int, Starbase>>
 */
class GetCorporationStarbasesRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/starbases/', $this->corporation_id);
    }

    /**
     * @return array<int, Starbase>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Starbase::hydrateList($data);
    }
}
