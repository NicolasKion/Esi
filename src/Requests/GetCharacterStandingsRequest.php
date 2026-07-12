<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Standing;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Standing>>
 */
class GetCharacterStandingsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/standings/', $this->character_id);
    }

    /**
     * @return array<int, Standing>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Standing::hydrateList($data);
    }
}
