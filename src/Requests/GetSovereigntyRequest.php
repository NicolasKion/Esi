<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Sovereignty;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, Sovereignty>>
 */
class GetSovereigntyRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/sovereignty/systems';
    }

    /**
     * @return array<int, Sovereignty>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Sovereignty::hydrateList(Data::of($data)->raw('solar_systems'));
    }
}
