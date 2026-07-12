<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<int>
 */
class CreateFleetSquadRequest extends Request
{
    public function __construct(
        public int $fleet_id,
        public int $wing_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/wings/%d/squads/', $this->fleet_id, $this->wing_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): int
    {
        return Data::of($data)->integer('squad_id', 0);
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
