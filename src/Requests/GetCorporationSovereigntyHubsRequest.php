<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SovereigntyHub;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, SovereigntyHub>>
 */
class GetCorporationSovereigntyHubsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/sovereignty-hubs', $this->corporation_id);
    }

    /**
     * @return array<int, SovereigntyHub>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return SovereigntyHub::hydrateList(Data::of($data)->raw('sovereignty_hubs'));
    }
}
