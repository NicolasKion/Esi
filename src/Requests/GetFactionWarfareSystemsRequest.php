<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FactionWarfareSystem;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, FactionWarfareSystem>>
 */
class GetFactionWarfareSystemsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/fw/systems';
    }

    /**
     * @return array<int, FactionWarfareSystem>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return FactionWarfareSystem::hydrateList($data);
    }
}
