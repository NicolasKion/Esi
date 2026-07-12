<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SovereigntyHub;
use NicolasKion\Esi\Request;

/**
 * @extends Request<SovereigntyHub>
 */
class GetCorporationSovereigntyHubRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public int $sovereignty_hub_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/sovereignty-hubs/%d', $this->corporation_id, $this->sovereignty_hub_id);
    }

    public function createDto(Response $response, mixed $data): SovereigntyHub
    {
        return SovereigntyHub::hydrate($data);
    }
}
