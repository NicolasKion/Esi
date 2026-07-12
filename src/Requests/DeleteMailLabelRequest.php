<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class DeleteMailLabelRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $label_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/labels/%d/', $this->character_id, $this->label_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::DELETE;
    }

    public function createDto(Response $response, mixed $data): null
    {
        return null;
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
