<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Ancestry;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Ancestry>>
 */
class GetAncestriesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/ancestries/';
    }

    /**
     * @return array<int, Ancestry>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Ancestry::hydrateList($data);
    }
}
