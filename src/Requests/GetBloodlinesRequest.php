<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Bloodline;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Bloodline>>
 */
class GetBloodlinesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/universe/bloodlines/';
    }

    /**
     * @return array<int, Bloodline>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Bloodline::hydrateList($data);
    }
}
