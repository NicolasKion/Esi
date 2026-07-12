<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Name;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, Name>>
 */
class GetNamesRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $ids
     */
    public function __construct(public array $ids) {}

    public function resolveEndpoint(): string
    {
        return '/universe/names/';
    }

    /**
     * @return array<int, int>
     */
    public function getBody(): array
    {
        return $this->ids;
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    /**
     * @return array<int, Name>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return Name::hydrateList($data);
    }
}
