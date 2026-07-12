<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Blueprint;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Blueprint>>
 *
 * @implements WithPagination<array<int, Blueprint>>
 */
class GetCorporationBlueprintsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/blueprints/', $this->corporation_id);
    }

    /**
     * @return array<int, Blueprint>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Blueprint::hydrateList($data);
    }
}
