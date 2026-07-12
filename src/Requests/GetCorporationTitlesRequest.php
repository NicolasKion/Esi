<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationTitle;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CorporationTitle>>
 */
class GetCorporationTitlesRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/titles/', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationTitle>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationTitle::hydrateList($data);
    }
}
