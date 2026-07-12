<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Blueprint;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Blueprint>>
 *
 * @implements WithPagination<array<int, Blueprint>>
 */
class GetCharacterBlueprintsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/blueprints/', $this->character_id);
    }

    /**
     * @return array<int, Blueprint>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Blueprint::hydrateList($data);
    }
}
