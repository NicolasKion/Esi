<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\UniverseIds;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class GetIdsRequest extends Request implements WithBody
{
    public function __construct(public array $names) {}

    public function resolveEndpoint(): string
    {
        return '/universe/ids/';
    }

    public function getBody(): array
    {
        return $this->names;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): UniverseIds
    {
        return UniverseIds::fromArray($data);
    }
}
