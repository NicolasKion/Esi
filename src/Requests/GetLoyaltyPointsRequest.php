<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\LoyaltyPoints;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, LoyaltyPoints>>
 */
class GetLoyaltyPointsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/loyalty/points/', $this->character_id);
    }

    /**
     * @return array<int, LoyaltyPoints>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return LoyaltyPoints::hydrateList($data);
    }
}
