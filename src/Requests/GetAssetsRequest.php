<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Asset;
use NicolasKion\Esi\Interfaces\WithPagination;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Traits\BasicPagination;

class GetAssetsRequest extends Request implements WithPagination
{
    use BasicPagination;

    public function __construct(
        public int $character_id,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/assets/', $this->character_id);
    }

    public function createDto(Response $response, mixed $data): array
    {
        return array_map(Asset::fromArray(...), $data);
    }
}
