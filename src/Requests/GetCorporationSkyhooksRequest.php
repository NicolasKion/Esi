<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Skyhook;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, Skyhook>>
 */
class GetCorporationSkyhooksRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/skyhooks', $this->corporation_id);
    }

    /**
     * @return array<int, Skyhook>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Skyhook::hydrateList(Data::of($data)->raw('skyhooks'));
    }
}
