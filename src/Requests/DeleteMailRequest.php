<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

/**
 * @extends Request<null>
 */
class DeleteMailRequest extends Request
{
    public function __construct(
        public int $character_id,
        public int $mail_id,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/%d/', $this->character_id, $this->mail_id);
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
