<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\IssuedMedal;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, IssuedMedal>>
 *
 * @implements WithPagination<array<int, IssuedMedal>>
 */
class GetCorporationIssuedMedalsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/medals/issued/', $this->corporation_id);
    }

    /**
     * @return array<int, IssuedMedal>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return IssuedMedal::hydrateList($data);
    }
}
