<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AllianceIcons;
use NicolasKion\Esi\Request;

/**
 * @extends Request<AllianceIcons>
 */
class GetAllianceIconsRequest extends Request
{
    public function __construct(public int $alliance_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/alliances/%d/icons', $this->alliance_id);
    }

    public function createDto(Response $response, mixed $data): AllianceIcons
    {
        return AllianceIcons::hydrate($data);
    }
}
