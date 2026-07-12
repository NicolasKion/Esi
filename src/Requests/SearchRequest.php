<?php

declare(strict_types=1);

namespace NicolasKion\Esi\Requests;

use Illuminate\Http\Client\Response;
use NicolasKion\Esi\DTO\SearchResult;
use NicolasKion\Esi\Request;

/**
 * @extends Request<SearchResult>
 */
class SearchRequest extends Request
{
    /**
     * @param  array<int, string>  $categories
     */
    public function __construct(
        public int $character_id,
        public array $categories,
        public string $search,
        public bool $strict = false,
    ) {}

    public function resolveEndpoint(): string
    {
        return sprintf('/characters/%d/search', $this->character_id);
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuery(): array
    {
        return [
            'categories' => implode(',', $this->categories),
            'search' => $this->search,
            'strict' => $this->strict,
        ];
    }

    public function createDto(Response $response, mixed $data): SearchResult
    {
        return SearchResult::hydrate($data);
    }
}
