<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Planet;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Planet>
 */
class GetPlanetRequest extends Request
{
    public function __construct(public int $planet_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/planets/%d/', $this->planet_id);
    }

    public function createDto(Response $response, mixed $data): Planet
    {
        return Planet::hydrate($data);
    }
}
