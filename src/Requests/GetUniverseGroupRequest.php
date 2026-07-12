<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\UniverseGroup;
use NicolasKion\Esi\Request;

/**
 * @extends Request<UniverseGroup>
 */
class GetUniverseGroupRequest extends Request
{
    public function __construct(public int $group_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/groups/%d/', $this->group_id);
    }

    public function createDto(Response $response, mixed $data): UniverseGroup
    {
        return UniverseGroup::hydrate($data);
    }
}
