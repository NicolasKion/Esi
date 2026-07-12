<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\UniverseType;
use NicolasKion\Esi\Request;

/**
 * @extends Request<UniverseType>
 */
class GetUniverseTypeRequest extends Request
{
    public function __construct(public int $type_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/types/%d/', $this->type_id);
    }

    public function createDto(Response $response, mixed $data): UniverseType
    {
        return UniverseType::hydrate($data);
    }
}
