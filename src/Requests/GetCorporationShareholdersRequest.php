<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Shareholder;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

/**
 * @extends Request<array<int, Shareholder>>
 *
 * @implements WithPagination<array<int, Shareholder>>
 */
class GetCorporationShareholdersRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(public int $corporation_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/corporations/%d/shareholders/', $this->corporation_id);
    }

    /**
     * @return array<int, Shareholder>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Shareholder::hydrateList($data);
    }
}
