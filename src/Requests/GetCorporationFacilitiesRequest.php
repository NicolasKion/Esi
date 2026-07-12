<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Facility;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Facility>>
 */
class GetCorporationFacilitiesRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/facilities/', $this->corporation_id);
    }

    /**
     * @return array<int, Facility>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Facility::hydrateList($data);
    }
}
