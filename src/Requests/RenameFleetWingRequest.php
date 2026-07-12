<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class RenameFleetWingRequest extends Request implements WithBody
{
    public function __construct(
        public int $fleet_id,
        public int $wing_id,
        public string $name,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        return [
            'name' => $this->name,
        ];
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/wings/%d/', $this->fleet_id, $this->wing_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::PUT;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return true;
    }
}
