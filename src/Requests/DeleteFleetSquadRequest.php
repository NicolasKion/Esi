<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class DeleteFleetSquadRequest extends Request
{
    public function __construct(
        public int $fleet_id,
        public int $squad_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/squads/%d/', $this->fleet_id, $this->squad_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::DELETE;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
