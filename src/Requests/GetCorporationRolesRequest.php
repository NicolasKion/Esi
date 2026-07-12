<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationRoles;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CorporationRoles>>
 */
class GetCorporationRolesRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/roles/', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationRoles>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationRoles::hydrateList($data);
    }
}
