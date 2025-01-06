<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

readonly class Character
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?int    $alliance_id,
        public string  $birthday,
        public int     $bloodline_id,
        public int     $corporation_id,
        public ?string $description,
        public string  $gender,
        public string  $name,
        public int     $race_id,
        public ?float  $security_status,
        public ?string $title,
    )
    {

    }

    public static function fromArray(array $data): self
    {
        return new self(
            alliance_id: $data['alliance_id'] ?? null,
            birthday: $data['birthday'],
            bloodline_id: $data['bloodline_id'],
            corporation_id: $data['corporation_id'],
            description: $data['description'] ?? null,
            gender: $data['gender'],
            name: $data['name'],
            race_id: $data['race_id'],
            security_status: $data['security_status'] ?? null,
            title: $data['title'] ?? null,
        );
    }
}
