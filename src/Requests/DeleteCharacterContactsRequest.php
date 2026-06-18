<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Request;

class DeleteCharacterContactsRequest extends Request
{
    /**
     * @param  int[]  $contact_ids
     */
    public function __construct(
        public int $character_id,
        public array $contact_ids,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contacts/', $this->character_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::DELETE;
    }

    public function getQuery(): array
    {
        return [
            'contact_ids' => implode(',', $this->contact_ids),
        ];
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
