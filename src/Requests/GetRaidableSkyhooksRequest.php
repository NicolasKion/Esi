<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\RaidableSkyhook;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, RaidableSkyhook>>
 */
class GetRaidableSkyhooksRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/skyhooks/raidable';
    }

    /**
     * @return array<int, RaidableSkyhook>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return RaidableSkyhook::hydrateList(Data::of($data)->raw('skyhooks'));
    }
}
