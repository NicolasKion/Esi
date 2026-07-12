<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FleetMember;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, FleetMember>>
 */
class GetFleetMembersRequest extends Request
{
    public function __construct(
        public int $fleet_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/members/', $this->fleet_id);
    }

    /**
     * @return array<int, FleetMember>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FleetMember::hydrateList($data);
    }
}
