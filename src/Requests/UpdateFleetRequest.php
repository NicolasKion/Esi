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
class UpdateFleetRequest extends Request implements WithBody
{
    public function __construct(
        public int $fleet_id,
        public ?bool $is_free_move = null,
        public ?string $motd = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        $data = [];

        if ($this->is_free_move !== null) {
            $data['is_free_move'] = $this->is_free_move;
        }

        if ($this->motd !== null) {
            $data['motd'] = $this->motd;
        }

        return $data;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/fleets/%d/', $this->fleet_id);
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
