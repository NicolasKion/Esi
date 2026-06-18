<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

class EditCharacterContactsRequest extends Request implements WithBody
{
    /**
     * @param  int[]  $contact_ids
     * @param  int[]|null  $label_ids
     */
    public function __construct(
        public int $character_id,
        public array $contact_ids,
        public float $standing,
        public ?array $label_ids = null,
        public bool $watched = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/contacts/', $this->character_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::PUT;
    }

    public function getQuery(): array
    {
        $query = [
            'standing' => $this->standing,
            'watched' => $this->watched,
        ];

        if ($this->label_ids !== null && $this->label_ids !== []) {
            $query['label_ids'] = implode(',', $this->label_ids);
        }

        return $query;
    }

    public function getBody(): mixed
    {
        return $this->contact_ids;
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
