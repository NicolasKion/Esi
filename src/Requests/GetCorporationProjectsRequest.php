<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationProject;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, CorporationProject>>
 */
class GetCorporationProjectsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/projects', $this->corporation_id);
    }

    /**
     * @return array<int, CorporationProject>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CorporationProject::hydrateList(Data::of($data)->raw('projects'));
    }
}
