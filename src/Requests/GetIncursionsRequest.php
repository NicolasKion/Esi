<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Incursion;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Incursion>>
 */
class GetIncursionsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/incursions';
    }

    /**
     * @return array<int, Incursion>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Incursion::hydrateList($data);
    }
}
