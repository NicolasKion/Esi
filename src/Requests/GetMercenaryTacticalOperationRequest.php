<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\MercenaryTacticalOperation;
use NicolasKion\Esi\Request;

/**
 * @extends Request<MercenaryTacticalOperation>
 */
class GetMercenaryTacticalOperationRequest extends Request
{
    public function __construct(
        public int $character_id,
        public string $operation_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mercenary-tactical-operations/%s', $this->character_id, $this->operation_id);
    }

    public function createDto(Response $response, mixed $data): MercenaryTacticalOperation
    {
        return MercenaryTacticalOperation::hydrate($data);
    }
}
