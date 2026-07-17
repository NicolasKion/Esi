<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MetaName;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MetaName>
 */
class GetMetaNameRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/meta/name';
    }

    public function createDto(Response $response, mixed $data): MetaName
    {
        return MetaName::hydrate($data);
    }
}
