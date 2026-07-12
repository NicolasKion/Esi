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
class SendMailRequest extends Request implements WithBody
{
    /**
     * @param  array<int, array<string, mixed>>  $recipients
     */
    public function __construct(public int $sender_id, public array $recipients, public string $subject, public string $body) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        return [
            'approved_cost' => 0,
            'body' => $this->body,
            'recipients' => $this->recipients,
            'subject' => $this->subject,
        ];
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/mail/', $this->sender_id);
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
