<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SystemJumps;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, SystemJumps>>
 */
class GetSystemJumpsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/system_jumps/';
    }

    /**
     * @return array<int, SystemJumps>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return SystemJumps::hydrateList($data);
    }
}
