<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Constellation;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Constellation>
 */
class GetConstellationRequest extends Request
{
    public function __construct(public int $constellation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/constellations/%d/', $this->constellation_id);
    }

    public function createDto(Response $response, mixed $data): Constellation
    {
        return Constellation::hydrate($data);
    }
}
