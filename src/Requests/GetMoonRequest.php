<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Moon;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Moon>
 */
class GetMoonRequest extends Request
{
    public function __construct(public int $moon_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/moons/%d/', $this->moon_id);
    }

    public function createDto(Response $response, mixed $data): Moon
    {
        return Moon::hydrate($data);
    }
}
