<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class Skill extends Dto
{
    public function __construct(
        public int $skill_id,
        public int $active_skill_level,
        public int $skillpoints_in_skill,
        public int $trained_skill_level,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            skill_id: $data->integer('skill_id', 0),
            active_skill_level: $data->integer('active_skill_level', 0),
            skillpoints_in_skill: $data->integer('skillpoints_in_skill', 0),
            trained_skill_level: $data->integer('trained_skill_level', 0),
        );
    }
}
