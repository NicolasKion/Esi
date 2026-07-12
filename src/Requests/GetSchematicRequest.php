<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Schematic;
use NicolasKion\Esi\Request;

/**
 * @extends Request<Schematic>
 */
class GetSchematicRequest extends Request
{
    public function __construct(public int $schematic_id) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/universe/schematics/%d/', $this->schematic_id);
    }

    public function createDto(Response $response, mixed $data): Schematic
    {
        return Schematic::hydrate($data);
    }
}
