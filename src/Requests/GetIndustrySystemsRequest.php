<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\IndustrySystem;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, IndustrySystem>>
 */
class GetIndustrySystemsRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/industry/systems';
    }

    /**
     * @return array<int, IndustrySystem>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return IndustrySystem::hydrateList($data);
    }
}
