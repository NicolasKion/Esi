<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MetaStatus;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MetaStatus>
 */
class GetMetaStatusRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/meta/status';
    }

    public function createDto(Response $response, mixed $data): MetaStatus
    {
        return MetaStatus::hydrate($data);
    }
}
