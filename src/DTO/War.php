<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Interfaces\FromArray;

readonly class War implements FromArray
{
    public function __construct(
        public Aggressor $aggressor,
        public array $allies,
        public string $declared,
        public Defender $defender,
        public ?bool $finished,
        public int $id,
        public bool $mutual,
        public bool $open_for_allies,
        public ?string $retracted,
        public ?string $started
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            aggressor: Aggressor::fromArray($data['aggressor']),
            allies: array_map(fn (array $ally) => Ally::fromArray($ally), $data['allies'] ?? []),
            declared: $data['declared'],
            defender: Defender::fromArray($data['defender']),
            finished: $data['finished'] ?? null,
            id: $data['id'],
            mutual: $data['mutual'],
            open_for_allies: $data['open_for_allies'],
            retracted: $data['retracted'] ?? null,
            started: $data['started'] ?? null,
        );
    }
}
