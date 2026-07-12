<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Skyhook;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Skyhook>
 */
class GetCorporationSkyhookRequest extends Request
{
    public function __construct(
        public int $corporation_id,
        public int $skyhook_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/structures/skyhooks/%d', $this->corporation_id, $this->skyhook_id);
    }

    public function createDto(Response $response, mixed $data): Skyhook
    {
        return Skyhook::hydrate($data);
    }
}
