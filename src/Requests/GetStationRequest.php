<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Station;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Station>
 */
class GetStationRequest extends Request
{
    public function __construct(public int $station_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/stations/%d/', $this->station_id);
    }

    public function createDto(Response $response, mixed $data): Station
    {
        return Station::hydrate($data);
    }
}
