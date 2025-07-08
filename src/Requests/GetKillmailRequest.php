<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\Killmail;
use NicolasKion\Esi\Request;

class GetKillmailRequest extends Request
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $killmail_id,
        public string $killmail_hash,
    ) {
        //
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/killmails/%d/%s/', $this->killmail_id, $this->killmail_hash);
    }

    public function createDtoFromResponse(Response $response): Killmail
    {
        return Killmail::fromArray($response->json());
    }
}
