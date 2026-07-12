<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Graphic;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Graphic>
 */
class GetGraphicRequest extends Request
{
    public function __construct(public int $graphic_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/graphics/%d/', $this->graphic_id);
    }

    public function createDto(Response $response, mixed $data): Graphic
    {
        return Graphic::hydrate($data);
    }
}
