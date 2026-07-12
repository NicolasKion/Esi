<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\FittingItem;
use NicolasKion\Esi\Enums\RequestMethod;
use NicolasKion\Esi\Interfaces\WithBody;
use NicolasKion\Esi\Request;
use NicolasKion\Esi\Support\Data;

/**
 * @extends Request<int>
 */
class CreateFittingRequest extends Request implements WithBody
{
    /**
     * @param  array<int, FittingItem>  $items
     */
    public function __construct(
        public int $character_id,
        public string $name,
        public string $description,
        public int $ship_type_id,
        public array $items,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function getBody(): array
    {
        return [
            'description' => $this->description,
            'items' => array_map(static fn (FittingItem $item): array => $item->__serialize(), $this->items),
            'name' => $this->name,
            'ship_type_id' => $this->ship_type_id,
        ];
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/fittings/', $this->character_id);
    }

    public function getMethod(): RequestMethod
    {
        return RequestMethod::POST;
    }

    public function createDto(Response $response, mixed $data): int
    {
        return Data::of($data)->integer('fitting_id', 0);
    }

    public function shouldRetry(Response $response): bool
    {
        return false;
    }
}
