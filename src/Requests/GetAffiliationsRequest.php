<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\CharacterAffiliation;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<array<int, CharacterAffiliation>>
 */
class GetAffiliationsRequest extends Request implements WithBody
{
    /**
     * @param  array<int, int>  $ids
     */
    public function __construct(public array $ids) {}

    public function resolveEndpoint(): string
    {
        return '/characters/affiliation/';
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
     * @return array<int, CharacterAffiliation>
     */
    public function createDto(Response $response, mixed $data): array
    {
        return CharacterAffiliation::hydrateList($data);
    }
}
