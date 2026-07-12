<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterMedal extends Dto
{
    /**
     * @param  array<int, MedalGraphic>  $graphics
     */
    public function __construct(
        public int $corporation_id,
        public string $date,
        public string $description,
        public array $graphics,
        public int $issuer_id,
        public int $medal_id,
        public string $reason,
        public string $status,
        public string $title,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            corporation_id: $data->integer('corporation_id', 0),
            date: $data->string('date', ''),
            description: $data->string('description', ''),
            graphics: $data->list('graphics', MedalGraphic::fromData(...)),
            issuer_id: $data->integer('issuer_id', 0),
            medal_id: $data->integer('medal_id', 0),
            reason: $data->string('reason', ''),
            status: $data->string('status', ''),
            title: $data->string('title', ''),
        );
    }
}
