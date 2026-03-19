<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationDivisions;
use NicolasKion\Esi\Request;

class GetCorporationDivisionsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/divisions/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): CorporationDivisions
    {
        return CorporationDivisions::fromArray($data);
    }
}
