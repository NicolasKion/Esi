<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FleetWing;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, FleetWing>>
 */
class GetFleetWingsRequest extends Request
{
    public function __construct(
        public int $fleet_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/wings/', $this->fleet_id);
    }

    /**
     * @return array<int, FleetWing>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FleetWing::hydrateList($data);
    }
}
