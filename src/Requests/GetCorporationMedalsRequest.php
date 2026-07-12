<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationMedal;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, CorporationMedal>>
 *
 * @implements WithPagination<array<int, CorporationMedal>>
 */
class GetCorporationMedalsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/medals/', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationMedal>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationMedal::hydrateList($data);
    }
}
