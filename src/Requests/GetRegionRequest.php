<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Region;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Region>
 */
class GetRegionRequest extends Request
{
    public function __construct(public int $region_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/regions/%d/', $this->region_id);
    }

    public function createDto(Response $response, mixed $data): Region
    {
        return Region::hydrate($data);
    }
}
