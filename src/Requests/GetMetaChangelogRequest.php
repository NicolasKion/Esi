<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MetaChangelog;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MetaChangelog>
 */
class GetMetaChangelogRequest extends Request
{
    public function resolveEndpoint(): string
    {
        return '/meta/changelog';
    }

    public function createDto(Response $response, mixed $data): MetaChangelog
    {
        return MetaChangelog::hydrate($data);
    }
}
