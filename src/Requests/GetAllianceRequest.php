<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Alliance;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Alliance>
 */
class GetAllianceRequest extends Request
{
    public function __construct(
        public int $alliance_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/alliances/%d/', $this->alliance_id);
    }

    public function createDto(Response $response, mixed $data): Alliance
    {
        return Alliance::hydrate($data);
    }
}
