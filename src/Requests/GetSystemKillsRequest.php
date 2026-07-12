<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SystemKills;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, SystemKills>>
 */
class GetSystemKillsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/system_kills/';
    }

    /**
     * @return array<int, SystemKills>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return SystemKills::hydrateList($data);
    }
}
