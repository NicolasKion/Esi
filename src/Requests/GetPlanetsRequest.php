<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\PlanetColony;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, PlanetColony>>
 */
class GetPlanetsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/planets/', $this->character_id);
    }

    /**
     * @return array<int, PlanetColony>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return PlanetColony::hydrateList($data);
    }
}
