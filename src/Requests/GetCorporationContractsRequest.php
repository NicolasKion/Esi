<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterContract;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, CharacterContract>>
 *
 * @implements WithPagination<array<int, CharacterContract>>
 */
class GetCorporationContractsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/contracts/', $this->corporation_id);
    }

    /**
     * @return array<int, CharacterContract>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CharacterContract::hydrateList($data);
    }
}
