<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;

/**
 * @extends Request<int>
 */
class CreateMailLabelRequest extends Request implements WithBody
{
    public function __construct(
        public int $character_id,
        public string $name,
        public ?string $color = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        $data = [
            'name' => $this->name,
        ];

        if ($this->color !== null) {
            $data['color'] = $this->color;
        }

        return $data;
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/labels/', $this->character_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): int
    {
        return is_numeric($data) ? (int) $data : 0;
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
