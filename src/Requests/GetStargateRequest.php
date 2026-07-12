<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Stargate;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Stargate>
 */
class GetStargateRequest extends Request
{
    public function __construct(public int $stargate_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/stargates/%d/', $this->stargate_id);
    }

    public function createDto(Response $response, mixed $data): Stargate
    {
        return Stargate::hydrate($data);
    }
}
