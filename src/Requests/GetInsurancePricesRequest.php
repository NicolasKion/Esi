<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\InsurancePrice;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, InsurancePrice>>
 */
class GetInsurancePricesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/insurance/prices';
    }

    /**
     * @return array<int, InsurancePrice>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return InsurancePrice::hydrateList($data);
    }
}
