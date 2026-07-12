<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\LoyaltyOffer;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, LoyaltyOffer>>
 */
class GetLoyaltyOffersRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/loyalty/stores/%d/offers', $this->corporation_id);
    }

    /**
     * @return array<int, LoyaltyOffer>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return LoyaltyOffer::hydrateList($data);
    }
}
