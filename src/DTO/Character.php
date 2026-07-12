<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Character extends Dto
{
    public function __construct(
        public ?int $alliance_id,
        public string $birthday,
        public int $bloodline_id,
        public int $corporation_id,
        public ?string $description,
        public string $gender,
        public string $name,
        public int $race_id,
        public ?float $security_status,
        public ?string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            alliance_id: $data->integer('alliance_id'),
            birthday: $data->string('birthday', ''),
            bloodline_id: $data->integer('bloodline_id', 0),
            corporation_id: $data->integer('corporation_id', 0),
            description: $data->string('description'),
            gender: $data->string('gender', ''),
            name: $data->string('name', ''),
            race_id: $data->integer('race_id', 0),
            security_status: $data->float('security_status'),
            // ESI renamed this field from `title` to `corporation_title`.
            title: $data->string('corporation_title', $data->string('title')),
        );
    }
}
