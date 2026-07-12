<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\IndustryFacility;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, IndustryFacility>>
 */
class GetIndustryFacilitiesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/industry/facilities';
    }

    /**
     * @return array<int, IndustryFacility>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return IndustryFacility::hydrateList($data);
    }
}
