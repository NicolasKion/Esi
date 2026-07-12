<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\UniverseCategory;
use NicolasKion\Esi\Request;

/**
 * @extends Request<UniverseCategory>
 */
class GetUniverseCategoryRequest extends Request
{
    public function __construct(public int $category_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/categories/%d/', $this->category_id);
    }

    public function createDto(Response $response, mixed $data): UniverseCategory
    {
        return UniverseCategory::hydrate($data);
    }
}
