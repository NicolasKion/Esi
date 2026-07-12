<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\RoleHistory;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, RoleHistory>>
 *
 * @implements WithPagination<array<int, RoleHistory>>
 */
class GetCorporationRolesHistoryRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/roles/history/', $this->corporation_id);
    }

    /**
     * @return array<int, RoleHistory>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return RoleHistory::hydrateList($data);
    }
}
