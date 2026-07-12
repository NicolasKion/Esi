<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AsteroidBelt;
use NicolasKion\Esi\Request;

/**
 * @extends Request<AsteroidBelt>
 */
class GetAsteroidBeltRequest extends Request
{
    public function __construct(public int $asteroid_belt_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/asteroid_belts/%d/', $this->asteroid_belt_id);
    }

    public function createDto(Response $response, mixed $data): AsteroidBelt
    {
        return AsteroidBelt::hydrate($data);
    }
}
