<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\DogmaAttribute;
use NicolasKion\Esi\Request;

/**
 * @extends Request<DogmaAttribute>
 */
class GetDogmaAttributeRequest extends Request
{
    public function __construct(public int $attribute_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/dogma/attributes/%d', $this->attribute_id);
    }

    public function createDto(Response $response, mixed $data): DogmaAttribute
    {
        return DogmaAttribute::hydrate($data);
    }
}
