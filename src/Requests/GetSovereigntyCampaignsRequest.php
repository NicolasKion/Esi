<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SovereigntyCampaign;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, SovereigntyCampaign>>
 */
class GetSovereigntyCampaignsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/sovereignty/campaigns';
    }

    /**
     * @return array<int, SovereigntyCampaign>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return SovereigntyCampaign::hydrateList($data);
    }
}
