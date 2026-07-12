<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Corporation;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Corporation>
 */
class GetCorporationRequest extends Request
{
    public function __construct(
        public int $corporation_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/', $this->corporation_id);
    }

    public function createDto(Response $response, mixed $data): Corporation
    {
        return Corporation::hydrate($data);
    }
}
