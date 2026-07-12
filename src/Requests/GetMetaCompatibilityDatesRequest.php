<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MetaCompatibilityDates;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MetaCompatibilityDates>
 */
class GetMetaCompatibilityDatesRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/meta/compatibility-dates';
    }

    public function createDto(Response $response, mixed $data): MetaCompatibilityDates
    {
        return MetaCompatibilityDates::hydrate($data);
    }
}
