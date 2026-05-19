<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\RaidableSkyhook;
use NicolasKion\Esi\Request;

class GetRaidableSkyhooksRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/skyhooks/raidable';
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(RaidableSkyhook::fromArray(...), $data['skyhooks'] ?? []);
    }
}
