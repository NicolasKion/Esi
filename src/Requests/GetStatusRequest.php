<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Status;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Status>
 */
class GetStatusRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/status';
    }

    public function createDto(Response $response, mixed $data): Status
    {
        return Status::hydrate($data);
    }
}
