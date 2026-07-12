<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class CharacterAttributes extends Dto
{
    public function __construct(
        public int $charisma,
        public int $intelligence,
        public int $memory,
        public int $perception,
        public int $willpower,
        public ?string $accrued_remap_cooldown_date,
        public ?int $bonus_remaps,
        public ?string $last_remap_date,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            charisma: $data->integer('charisma', 0),
            intelligence: $data->integer('intelligence', 0),
            memory: $data->integer('memory', 0),
            perception: $data->integer('perception', 0),
            willpower: $data->integer('willpower', 0),
            accrued_remap_cooldown_date: $data->string('accrued_remap_cooldown_date'),
            bonus_remaps: $data->integer('bonus_remaps'),
            last_remap_date: $data->string('last_remap_date'),
        );
    }
}
