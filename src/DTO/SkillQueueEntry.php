<?php

declare(strict_types=1);

namespace NicolasKion\Esi\DTO;

use NicolasKion\Esi\Support\Data;

readonly class SkillQueueEntry extends Dto
{
    public function __construct(
        public int $skill_id,
        public int $finished_level,
        public int $queue_position,
        public ?string $finish_date,
        public ?int $level_end_sp,
        public ?int $level_start_sp,
        public ?string $start_date,
        public ?int $training_start_sp,
    ) {}

    public static function fromData(Data $data): self
    {
        return new self(
            skill_id: $data->integer('skill_id', 0),
            finished_level: $data->integer('finished_level', 0),
            queue_position: $data->integer('queue_position', 0),
            finish_date: $data->string('finish_date'),
            level_end_sp: $data->integer('level_end_sp'),
            level_start_sp: $data->integer('level_start_sp'),
            start_date: $data->string('start_date'),
            training_start_sp: $data->integer('training_start_sp'),
        );
    }
}
