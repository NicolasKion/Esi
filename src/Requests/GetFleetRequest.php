<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Fleet;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Fleet>
 */
class GetFleetRequest extends Request
{
    public function __construct(
        public int $fleet_id
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/', $this->fleet_id);
    }

    public function createDto(Response $response, mixed $data): Fleet
    {
        return Fleet::hydrate($data);
    }
}
