<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Fitting;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Fitting>>
 */
class GetFittingsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/fittings/', $this->character_id);
    }

    /**
     * @return array<int, Fitting>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Fitting::hydrateList($data);
    }
}
