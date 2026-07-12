<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PlanetLayout;
use NicolasKion\Esi\Request;

/**
 * @extends Request<PlanetLayout>
 */
class GetPlanetLayoutRequest extends Request
{
    public function __construct(public int $character_id, public int $planet_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/planets/%d/', $this->character_id, $this->planet_id);
    }

    public function createDto(Response $response, mixed $data): PlanetLayout
    {
        return PlanetLayout::hydrate($data);
    }
}
