<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CorporationIcons;
use NicolasKion\Esi\Request;

/**
 * @extends Request<CorporationIcons>
 */
class GetCorporationIconsRequest extends Request
{
    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/icons/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): CorporationIcons
    {
        return CorporationIcons::hydrate($data);
    }
}
