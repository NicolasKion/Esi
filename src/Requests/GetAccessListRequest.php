<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\AccessList;
use NicolasKion\Esi\Request;

/**
 * @extends Request<AccessList>
 */
class GetAccessListRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $access_list_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/access-lists/%d', $this->character_id, $this->access_list_id);
    }

    public function createDto(Response $response, mixed $data): AccessList
    {
        return AccessList::hydrate($data);
    }
}
