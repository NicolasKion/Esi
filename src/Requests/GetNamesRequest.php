<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class GetNamesRequest extends Request implements WithBody
{
    public function __construct(public array $ids) {}

    public function resolveEndpoint(): string
    {
        return '/universe/names/';
    }

    public function getBody(): array
    {
        return $this->ids;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDtoFromResponse(Response $response): array
    {
        $names = [];

        foreach ($response->json() as $name) {
            $names[] = Name::fromArray($name);
        }

        return $names;
    }
}
