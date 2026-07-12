<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\System;
use NicolasKion\Esi\Request;

/**
 * @extends Request<System>
 */
class GetSystemRequest extends Request
{
    public function __construct(public int $system_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/systems/%d/', $this->system_id);
    }

    public function createDto(Response $response, mixed $data): System
    {
        return System::hydrate($data);
    }
}
