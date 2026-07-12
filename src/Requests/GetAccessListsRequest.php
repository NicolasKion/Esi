<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AccessList;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<array<int, AccessList>>
 */
class GetAccessListsRequest extends Request
{
    public function __construct(public int $character_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/access-lists', $this->character_id);
    }

    /**
     * @return array<int, AccessList>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return AccessList::hydrateList(Data::of($data)->raw('access_lists'));
    }
}
